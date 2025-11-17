<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Api\V1\Controller;
use App\Http\Resources\GalleryResource;
use App\Models\Gallery;
use App\Traits\HandlesFileUpload;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GalleryManagementController extends Controller
{
    use HandlesFileUpload;

    /**
     * @OA\Get(
     *      path="/api/v1/admin/gallery",
     *      operationId="adminGetGalleryList",
     *      tags={"Gallery Management"},
     *      summary="Get all gallery (Admin)",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="Success")
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->get('per_page', 15), 50);

        $query = Gallery::with('user:id,name');

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $gallery = $query->orderBy('order', 'asc')->paginate($perPage);

        return $this->successWithPagination(
            GalleryResource::collection($gallery),
            'Gallery list retrieved successfully'
        );
    }

    /**
     * @OA\Post(
     *      path="/api/v1/admin/gallery",
     *      operationId="adminCreateGallery",
     *      tags={"Gallery Management"},
     *      summary="Create new gallery",
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"title", "image"},
     *                  @OA\Property(property="title", type="string"),
     *                  @OA\Property(property="description", type="string"),
     *                  @OA\Property(property="image", type="file"),
     *                  @OA\Property(property="order", type="integer"),
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
            'image' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $data = $request->only(['title', 'description', 'order', 'is_active']);

        // Upload image
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'gallery', 1600);
        }

        $data['user_id'] = $request->user()->id;

        $gallery = Gallery::create($data);

        return $this->success(
            new GalleryResource($gallery->load('user')),
            'Gallery created successfully',
            201
        );
    }

    /**
     * @OA\Get(
     *      path="/api/v1/admin/gallery/{id}",
     *      operationId="adminGetGalleryDetail",
     *      tags={"Gallery Management"},
     *      summary="Get gallery detail (Admin)",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *      @OA\Response(response=200, description="Success")
     * )
     */
    public function show(int $id): JsonResponse
    {
        $gallery = Gallery::with('user')->findOrFail($id);

        return $this->success(
            new GalleryResource($gallery),
            'Gallery detail retrieved successfully'
        );
    }

    /**
     * @OA\Post(
     *      path="/api/v1/admin/gallery/{id}",
     *      operationId="adminUpdateGallery",
     *      tags={"Gallery Management"},
     *      summary="Update gallery",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *      @OA\Response(response=200, description="Updated")
     * )
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $gallery = Gallery::findOrFail($id);

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'order' => 'nullable|integer',
            'is_active' => 'boolean'
        ]);

        $data = $request->only(['title', 'description', 'order', 'is_active']);

        if ($request->hasFile('image')) {
            $this->deleteFile($gallery->image);
            $data['image'] = $this->uploadImage($request->file('image'), 'gallery', 1600);
        }

        $gallery->update($data);

        return $this->success(
            new GalleryResource($gallery->load('user')),
            'Gallery updated successfully'
        );
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/admin/gallery/{id}",
     *      operationId="adminDeleteGallery",
     *      tags={"Gallery Management"},
     *      summary="Delete gallery",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *      @OA\Response(response=200, description="Deleted")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $gallery = Gallery::findOrFail($id);

        $this->deleteFile($gallery->image);
        $gallery->delete();

        return $this->success(null, 'Gallery deleted successfully');
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/admin/gallery/bulk-delete",
     *      operationId="adminBulkDeleteGallery",
     *      tags={"Gallery Management"},
     *      summary="Bulk delete gallery",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="Deleted")
     * )
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:galleries,id'
        ]);

        $galleries = Gallery::whereIn('id', $request->ids)->get();

        foreach ($galleries as $gallery) {
            $this->deleteFile($gallery->image);
            $gallery->delete();
        }

        return $this->success(
            null,
            count($galleries) . ' galleries deleted successfully'
        );
    }
}
