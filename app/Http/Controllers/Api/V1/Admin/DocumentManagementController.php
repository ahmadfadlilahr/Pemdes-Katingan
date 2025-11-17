<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Api\V1\Controller;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use App\Traits\HandlesFileUpload;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DocumentManagementController extends Controller
{
    use HandlesFileUpload;

    /**
     * @OA\Get(
     *      path="/api/v1/admin/documents",
     *      operationId="adminGetDocumentsList",
     *      tags={"Documents Management"},
     *      summary="Get all documents (Admin)",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="Success")
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->get('per_page', 15), 50);

        $query = Document::with('user:id,name');

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->has('category')) {
            $query->where('category', $request->get('category'));
        }

        $documents = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return $this->successWithPagination(
            DocumentResource::collection($documents),
            'Documents list retrieved successfully'
        );
    }

    /**
     * @OA\Post(
     *      path="/api/v1/admin/documents",
     *      operationId="adminCreateDocument",
     *      tags={"Documents Management"},
     *      summary="Create new document",
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"title", "file"},
     *                  @OA\Property(property="title", type="string"),
     *                  @OA\Property(property="description", type="string"),
     *                  @OA\Property(property="category", type="string"),
     *                  @OA\Property(property="file", type="file"),
     *                  @OA\Property(property="is_active", type="boolean")
     *              )
     *          )
     *      ),
     *      @OA\Response(response=201, description="Created")
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar|max:10240',
            'is_active' => 'boolean'
        ]);

        $data = $request->only(['title', 'description', 'category', 'is_active']);

        // Generate slug
        $data['slug'] = Str::slug($request->title);

        $originalSlug = $data['slug'];
        $count = 1;
        while (Document::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $count++;
        }

        // Upload file
        if ($request->hasFile('file')) {
            $fileData = $this->uploadFile($request->file('file'), 'documents');
            $data['file_path'] = $fileData['path'];
            $data['file_name'] = $fileData['name'];
            $data['file_type'] = $fileData['type'];
            $data['file_size'] = $fileData['size'];
        }

        $data['user_id'] = $request->user()->id;

        $document = Document::create($data);

        return $this->success(
            new DocumentResource($document->load('user')),
            'Document created successfully',
            201
        );
    }

    /**
     * @OA\Get(
     *      path="/api/v1/admin/documents/{id}",
     *      operationId="adminGetDocumentDetail",
     *      tags={"Documents Management"},
     *      summary="Get document detail (Admin)",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *      @OA\Response(response=200, description="Success")
     * )
     */
    public function show(int $id): JsonResponse
    {
        $document = Document::with('user')->findOrFail($id);

        return $this->success(
            new DocumentResource($document),
            'Document detail retrieved successfully'
        );
    }

    /**
     * @OA\Post(
     *      path="/api/v1/admin/documents/{id}",
     *      operationId="adminUpdateDocument",
     *      tags={"Documents Management"},
     *      summary="Update document",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *      @OA\Response(response=200, description="Updated")
     * )
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $document = Document::findOrFail($id);

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar|max:10240',
            'is_active' => 'boolean'
        ]);

        $data = $request->only(['title', 'description', 'category', 'is_active']);

        // Update slug if title changed
        if ($request->has('title') && $request->title !== $document->title) {
            $data['slug'] = Str::slug($request->title);

            $originalSlug = $data['slug'];
            $count = 1;
            while (Document::where('slug', $data['slug'])->where('id', '!=', $id)->exists()) {
                $data['slug'] = $originalSlug . '-' . $count++;
            }
        }

        // Upload new file
        if ($request->hasFile('file')) {
            $this->deleteFile($document->file_path);

            $fileData = $this->uploadFile($request->file('file'), 'documents');
            $data['file_path'] = $fileData['path'];
            $data['file_name'] = $fileData['name'];
            $data['file_type'] = $fileData['type'];
            $data['file_size'] = $fileData['size'];
        }

        $document->update($data);

        return $this->success(
            new DocumentResource($document->load('user')),
            'Document updated successfully'
        );
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/admin/documents/{id}",
     *      operationId="adminDeleteDocument",
     *      tags={"Documents Management"},
     *      summary="Delete document",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *      @OA\Response(response=200, description="Deleted")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $document = Document::findOrFail($id);

        $this->deleteFile($document->file_path);
        $document->delete();

        return $this->success(null, 'Document deleted successfully');
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/admin/documents/bulk-delete",
     *      operationId="adminBulkDeleteDocuments",
     *      tags={"Documents Management"},
     *      summary="Bulk delete documents",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="Deleted")
     * )
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:documents,id'
        ]);

        $documents = Document::whereIn('id', $request->ids)->get();

        foreach ($documents as $document) {
            $this->deleteFile($document->file_path);
            $document->delete();
        }

        return $this->success(
            null,
            count($documents) . ' documents deleted successfully'
        );
    }

    /**
     * @OA\Get(
     *      path="/api/v1/admin/documents/categories",
     *      operationId="adminGetDocumentCategories",
     *      tags={"Documents Management"},
     *      summary="Get list of document categories",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="Success")
     * )
     */
    public function categories(): JsonResponse
    {
        $categories = Document::select('category')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return $this->success($categories, 'Categories retrieved successfully');
    }
}
