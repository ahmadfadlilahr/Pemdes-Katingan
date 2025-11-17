<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\News;
use App\Http\Resources\NewsResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NewsController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/news",
     *      operationId="getNewsList",
     *      tags={"News"},
     *      summary="Get list of published news",
     *      description="Returns paginated list of published news articles",
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
     *          description="Search in title and content",
     *          required=false,
     *          in="query",
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Success")
     *          )
     *      )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->get('per_page', 15), 50);

        $query = News::where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->with('user:id,name');

        // Search filter
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $news = $query->orderBy('published_at', 'desc')->paginate($perPage);

        return $this->successWithPagination(
            NewsResource::collection($news),
            'News retrieved successfully'
        );
    }

    /**
     * @OA\Get(
     *      path="/api/v1/news/{slug}",
     *      operationId="getNewsDetail",
     *      tags={"News"},
     *      summary="Get news detail by slug",
     *      description="Returns single news article with full content",
     *      @OA\Parameter(
     *          name="slug",
     *          description="News slug",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="News not found"
     *      )
     * )
     */
    public function show(string $slug): JsonResponse
    {
        $news = News::where('slug', $slug)
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->with('user:id,name')
            ->firstOrFail();

        return $this->success(
            new NewsResource($news),
            'News detail retrieved successfully'
        );
    }
}
