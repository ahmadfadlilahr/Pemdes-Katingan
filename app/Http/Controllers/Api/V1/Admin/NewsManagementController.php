<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Api\V1\Controller;
use App\Http\Requests\Api\StoreNewsRequest;
use App\Http\Requests\Api\UpdateNewsRequest;
use App\Http\Resources\NewsResource;
use App\Models\News;
use App\Traits\HandlesFileUpload;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsManagementController extends Controller
{
    use HandlesFileUpload;

    /**
     * @OA\Get(
     *      path="/api/v1/admin/news",
     *      operationId="adminGetNewsList",
     *      tags={"News Management"},
     *      summary="Get all news (Admin)",
     *      description="Returns paginated list of all news articles for admin with filters",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="page",
     *          in="query",
     *          required=false,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *          name="search",
     *          in="query",
     *          required=false,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="is_published",
     *          in="query",
     *          required=false,
     *          @OA\Schema(type="boolean")
     *      ),
     *      @OA\Response(response=200, description="Success"),
     *      @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->get('per_page', 15), 50);

        $query = News::with('user:id,name');

        // Search
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Filter by published status
        if ($request->has('is_published')) {
            $query->where('is_published', $request->boolean('is_published'));
        }

        $news = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return $this->successWithPagination(
            NewsResource::collection($news),
            'News list retrieved successfully'
        );
    }

    /**
     * @OA\Post(
     *      path="/api/v1/admin/news",
     *      operationId="adminCreateNews",
     *      tags={"News Management"},
     *      summary="Create new news article",
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"title", "content"},
     *                  @OA\Property(property="title", type="string"),
     *                  @OA\Property(property="content", type="string"),
     *                  @OA\Property(property="excerpt", type="string"),
     *                  @OA\Property(property="image", type="file"),
     *                  @OA\Property(property="is_published", type="boolean")
     *              )
     *          )
     *      ),
     *      @OA\Response(response=201, description="Created"),
     *      @OA\Response(response=422, description="Validation Error")
     * )
     */
    public function store(StoreNewsRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Auto generate slug
        $data['slug'] = Str::slug($request->title);

        // Ensure unique slug
        $originalSlug = $data['slug'];
        $count = 1;
        while (News::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $count++;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'news', 1200);
        }

        // Set author
        $data['user_id'] = $request->user()->id;

        // Set published_at if published
        if ($request->boolean('is_published') && !isset($data['published_at'])) {
            $data['published_at'] = now();
        }

        $news = News::create($data);

        return $this->success(
            new NewsResource($news->load('user')),
            'News created successfully',
            201
        );
    }

    /**
     * @OA\Get(
     *      path="/api/v1/admin/news/{id}",
     *      operationId="adminGetNewsDetail",
     *      tags={"News Management"},
     *      summary="Get news detail (Admin)",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(response=200, description="Success"),
     *      @OA\Response(response=404, description="Not Found")
     * )
     */
    public function show(int $id): JsonResponse
    {
        $news = News::with('user')->findOrFail($id);

        return $this->success(
            new NewsResource($news),
            'News detail retrieved successfully'
        );
    }

    /**
     * @OA\Post(
     *      path="/api/v1/admin/news/{id}",
     *      operationId="adminUpdateNews",
     *      tags={"News Management"},
     *      summary="Update news article",
     *      description="Using POST method to support multipart/form-data",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(property="title", type="string"),
     *                  @OA\Property(property="content", type="string"),
     *                  @OA\Property(property="excerpt", type="string"),
     *                  @OA\Property(property="image", type="file"),
     *                  @OA\Property(property="is_published", type="boolean"),
     *                  @OA\Property(property="_method", type="string", example="PUT")
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="Updated"),
     *      @OA\Response(response=404, description="Not Found")
     * )
     */
    public function update(UpdateNewsRequest $request, int $id): JsonResponse
    {
        $news = News::findOrFail($id);
        $data = $request->validated();

        // Update slug if title changed
        if ($request->has('title') && $request->title !== $news->title) {
            $data['slug'] = Str::slug($request->title);

            // Ensure unique slug
            $originalSlug = $data['slug'];
            $count = 1;
            while (News::where('slug', $data['slug'])->where('id', '!=', $id)->exists()) {
                $data['slug'] = $originalSlug . '-' . $count++;
            }
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            $this->deleteFile($news->image);

            // Upload new image
            $data['image'] = $this->uploadImage($request->file('image'), 'news', 1200);
        }

        // Update published_at if status changed
        if ($request->has('is_published')) {
            if ($request->boolean('is_published') && !$news->is_published) {
                $data['published_at'] = now();
            } elseif (!$request->boolean('is_published')) {
                $data['published_at'] = null;
            }
        }

        $news->update($data);

        return $this->success(
            new NewsResource($news->load('user')),
            'News updated successfully'
        );
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/admin/news/{id}",
     *      operationId="adminDeleteNews",
     *      tags={"News Management"},
     *      summary="Delete news article",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(response=200, description="Deleted"),
     *      @OA\Response(response=404, description="Not Found")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $news = News::findOrFail($id);

        // Delete image
        $this->deleteFile($news->image);

        $news->delete();

        return $this->success(null, 'News deleted successfully');
    }

    /**
     * @OA\Post(
     *      path="/api/v1/admin/news/{id}/toggle-publish",
     *      operationId="adminTogglePublishNews",
     *      tags={"News Management"},
     *      summary="Toggle publish status",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(response=200, description="Updated")
     * )
     */
    public function togglePublish(int $id): JsonResponse
    {
        $news = News::findOrFail($id);

        $news->is_published = !$news->is_published;
        $news->published_at = $news->is_published ? now() : null;
        $news->save();

        return $this->success(
            new NewsResource($news->load('user')),
            'News publish status updated successfully'
        );
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/admin/news/bulk-delete",
     *      operationId="adminBulkDeleteNews",
     *      tags={"News Management"},
     *      summary="Bulk delete news articles",
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"ids"},
     *              @OA\Property(property="ids", type="array", @OA\Items(type="integer"))
     *          )
     *      ),
     *      @OA\Response(response=200, description="Deleted")
     * )
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:news,id'
        ]);

        $news = News::whereIn('id', $request->ids)->get();

        foreach ($news as $item) {
            $this->deleteFile($item->image);
            $item->delete();
        }

        return $this->success(
            null,
            count($news) . ' news articles deleted successfully'
        );
    }
}
