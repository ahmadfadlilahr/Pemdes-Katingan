<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DocumentController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/documents",
     *      operationId="getDocumentsList",
     *      tags={"Documents"},
     *      summary="Get list of documents",
     *      description="Returns paginated list of active documents with optional filters",
     *      @OA\Parameter(
     *          name="page",
     *          description="Page number",
     *          required=false,
     *          in="query",
     *          @OA\Schema(type="integer", default=1)
     *      ),
     *      @OA\Parameter(
     *          name="per_page",
     *          description="Items per page (max 50)",
     *          required=false,
     *          in="query",
     *          @OA\Schema(type="integer", default=15)
     *      ),
     *      @OA\Parameter(
     *          name="search",
     *          description="Search in title and description",
     *          required=false,
     *          in="query",
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="category",
     *          description="Filter by category",
     *          required=false,
     *          in="query",
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Response(response=200, description="Successful operation")
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->get('per_page', 15), 50);

        $query = Document::where('is_active', true);

        // Search filter
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->has('category')) {
            $query->where('category', $request->get('category'));
        }

        $documents = $query->orderBy('created_at', 'desc')
            ->paginate($perPage);

        // Transform data
        $documents->getCollection()->transform(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'description' => $item->description,
                'category' => $item->category,
                'file_url' => $item->file ? asset('storage/' . $item->file) : null,
                'file_size' => $item->file_size,
                'file_type' => $item->file_type,
                'download_count' => $item->download_count,
                'created_at' => $item->created_at->toIso8601String(),
            ];
        });

        return $this->successWithPagination($documents, 'Documents retrieved successfully');
    }

    /**
     * @OA\Get(
     *      path="/api/v1/documents/{id}",
     *      operationId="getDocumentDetail",
     *      tags={"Documents"},
     *      summary="Get document detail",
     *      description="Returns detailed information of a specific document",
     *      @OA\Parameter(
     *          name="id",
     *          description="Document ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=404, description="Document not found")
     * )
     */
    public function show(int $id): JsonResponse
    {
        $document = Document::where('id', $id)
            ->where('is_active', true)
            ->first();

        if (!$document) {
            return $this->error('Document not found', 404);
        }

        $data = [
            'id' => $document->id,
            'title' => $document->title,
            'description' => $document->description,
            'category' => $document->category,
            'file_url' => $document->file ? asset('storage/' . $document->file) : null,
            'file_size' => $document->file_size,
            'file_type' => $document->file_type,
            'download_count' => $document->download_count,
            'created_at' => $document->created_at->toIso8601String(),
            'updated_at' => $document->updated_at->toIso8601String(),
        ];

        return $this->success($data, 'Document detail retrieved successfully');
    }

    /**
     * @OA\Get(
     *      path="/api/v1/documents/categories",
     *      operationId="getDocumentCategories",
     *      tags={"Documents"},
     *      summary="Get list of document categories",
     *      description="Returns unique list of document categories",
     *      @OA\Response(response=200, description="Successful operation")
     * )
     */
    public function categories(): JsonResponse
    {
        $categories = Document::where('is_active', true)
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->values();

        return $this->success($categories, 'Categories retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/api/v1/documents/{id}/download",
     *      operationId="downloadDocument",
     *      tags={"Documents"},
     *      summary="Increment download counter",
     *      description="Increments the download count for a document",
     *      @OA\Parameter(
     *          name="id",
     *          description="Document ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(response=200, description="Success"),
     *      @OA\Response(response=404, description="Document not found")
     * )
     */
    public function download(int $id): JsonResponse
    {
        $document = Document::where('id', $id)
            ->where('is_active', true)
            ->first();

        if (!$document) {
            return $this->error('Document not found', 404);
        }

        // Increment download count
        $document->increment('download_count');

        return $this->success([
            'download_count' => $document->download_count
        ], 'Download count incremented');
    }
}
