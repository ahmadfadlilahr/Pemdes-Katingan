<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GalleryController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/gallery",
     *      operationId="getGalleryList",
     *      tags={"Gallery"},
     *      summary="Get list of gallery images",
     *      description="Returns paginated list of active gallery images with optional search filter",
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
     *      @OA\Response(response=200, description="Successful operation")
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->get('per_page', 15), 50);

        $query = Gallery::where('is_active', true);

        // Search filter
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $gallery = $query->orderBy('created_at', 'desc')
            ->paginate($perPage);

        // Transform data
        $gallery->getCollection()->transform(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'description' => $item->description,
                'image' => $item->image ? asset('storage/' . $item->image) : null,
                'created_at' => $item->created_at->toIso8601String(),
            ];
        });

        return $this->successWithPagination($gallery, 'Gallery retrieved successfully');
    }

    /**
     * @OA\Get(
     *      path="/api/v1/gallery/{id}",
     *      operationId="getGalleryDetail",
     *      tags={"Gallery"},
     *      summary="Get gallery image detail",
     *      description="Returns detailed information of a specific gallery image",
     *      @OA\Parameter(
     *          name="id",
     *          description="Gallery ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=404, description="Gallery not found")
     * )
     */
    public function show(int $id): JsonResponse
    {
        $gallery = Gallery::where('id', $id)
            ->where('is_active', true)
            ->first();

        if (!$gallery) {
            return $this->error('Gallery not found', 404);
        }

        $data = [
            'id' => $gallery->id,
            'title' => $gallery->title,
            'description' => $gallery->description,
            'image' => $gallery->image ? asset('storage/' . $gallery->image) : null,
            'created_at' => $gallery->created_at->toIso8601String(),
            'updated_at' => $gallery->updated_at->toIso8601String(),
        ];

        return $this->success($data, 'Gallery detail retrieved successfully');
    }
}
