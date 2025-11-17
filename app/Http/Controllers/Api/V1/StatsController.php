<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\News;
use App\Models\Agenda;
use App\Models\Gallery;
use App\Models\Document;
use App\Models\OrganizationStructure;
use Illuminate\Http\JsonResponse;

class StatsController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/stats",
     *      operationId="getStats",
     *      tags={"Statistics"},
     *      summary="Get overall statistics",
     *      description="Returns statistics including total news, events, galleries, documents, and organization members",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Statistics retrieved successfully"),
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(property="news_count", type="integer", example=45, description="Total news articles"),
     *                  @OA\Property(property="published_news", type="integer", example=40, description="Published news count"),
     *                  @OA\Property(property="agenda_count", type="integer", example=12, description="Total agenda/events"),
     *                  @OA\Property(property="upcoming_events", type="integer", example=5, description="Upcoming events count"),
     *                  @OA\Property(property="gallery_count", type="integer", example=150, description="Total gallery photos"),
     *                  @OA\Property(property="document_count", type="integer", example=78, description="Total documents"),
     *                  @OA\Property(property="organization_members", type="integer", example=25, description="Organization structure members"),
     *                  @OA\Property(property="total_downloads", type="integer", example=3250, description="Total document downloads")
     *              )
     *          )
     *      )
     * )
     */
    public function index(): JsonResponse
    {
        $stats = [
            'news_count' => News::count(),
            'published_news' => News::where('is_published', true)->count(),
            'agenda_count' => Agenda::count(),
            'upcoming_events' => Agenda::where('start_date', '>=', now())->count(),
            'gallery_count' => Gallery::count(),
            'document_count' => Document::count(),
            'organization_members' => OrganizationStructure::count(),
            'total_downloads' => Document::sum('download_count'),
        ];

        return $this->success($stats, 'Statistics retrieved successfully');
    }

    /**
     * @OA\Get(
     *      path="/api/v1/stats/news",
     *      operationId="getNewsStats",
     *      tags={"Statistics"},
     *      summary="Get news statistics",
     *      description="Returns detailed news statistics including published and draft counts",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string"),
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(property="total_news", type="integer"),
     *                  @OA\Property(property="published", type="integer"),
     *                  @OA\Property(property="draft", type="integer"),
     *                  @OA\Property(
     *                      property="recent_news",
     *                      type="array",
     *                      @OA\Items(
     *                          @OA\Property(property="id", type="integer"),
     *                          @OA\Property(property="title", type="string"),
     *                          @OA\Property(property="slug", type="string"),
     *                          @OA\Property(property="is_published", type="boolean"),
     *                          @OA\Property(property="published_at", type="string")
     *                      )
     *                  )
     *              )
     *          )
     *      )
     * )
     */
    public function newsStats(): JsonResponse
    {
        $publishedCount = News::where('is_published', true)->count();
        $draftCount = News::where('is_published', false)->count();

        $recentNews = News::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($news) {
                return [
                    'id' => $news->id,
                    'title' => $news->title,
                    'slug' => $news->slug,
                    'is_published' => $news->is_published,
                    'published_at' => $news->published_at ? $news->published_at->toIso8601String() : null,
                ];
            });

        $data = [
            'total_news' => News::count(),
            'published' => $publishedCount,
            'draft' => $draftCount,
            'recent_news' => $recentNews,
        ];

        return $this->success($data, 'News statistics retrieved successfully');
    }

    /**
     * @OA\Get(
     *      path="/api/v1/stats/documents",
     *      operationId="getDocumentStats",
     *      tags={"Statistics"},
     *      summary="Get document statistics",
     *      description="Returns detailed document statistics by category and most downloaded documents",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean"),
     *              @OA\Property(property="message", type="string"),
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(property="total_documents", type="integer"),
     *                  @OA\Property(property="total_downloads", type="integer"),
     *                  @OA\Property(
     *                      property="by_category",
     *                      type="array",
     *                      @OA\Items(
     *                          @OA\Property(property="category", type="string"),
     *                          @OA\Property(property="count", type="integer"),
     *                          @OA\Property(property="total_downloads", type="integer")
     *                      )
     *                  ),
     *                  @OA\Property(
     *                      property="most_downloaded",
     *                      type="array",
     *                      @OA\Items(
     *                          @OA\Property(property="id", type="integer"),
     *                          @OA\Property(property="title", type="string"),
     *                          @OA\Property(property="category", type="string"),
     *                          @OA\Property(property="download_count", type="integer"),
     *                          @OA\Property(property="uploaded_at", type="string")
     *                      )
     *                  )
     *              )
     *          )
     *      )
     * )
     */
    public function documentStats(): JsonResponse
    {
        $categoryCounts = Document::where('is_active', true)
            ->select('category')
            ->selectRaw('count(*) as count')
            ->selectRaw('sum(download_count) as total_downloads')
            ->groupBy('category')
            ->get()
            ->map(function ($item) {
                return [
                    'category' => $item->category ?? 'Uncategorized',
                    'count' => $item->count,
                    'total_downloads' => (int) $item->total_downloads,
                ];
            });

        $topDownloaded = Document::where('is_active', true)
            ->orderBy('download_count', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($doc) {
                return [
                    'id' => $doc->id,
                    'title' => $doc->title,
                    'category' => $doc->category ?? 'Uncategorized',
                    'download_count' => $doc->download_count,
                    'uploaded_at' => $doc->created_at->toIso8601String(),
                ];
            });

        $data = [
            'total_documents' => Document::where('is_active', true)->count(),
            'total_downloads' => Document::sum('download_count'),
            'by_category' => $categoryCounts,
            'most_downloaded' => $topDownloaded,
        ];

        return $this->success($data, 'Document statistics retrieved successfully');
    }
}
