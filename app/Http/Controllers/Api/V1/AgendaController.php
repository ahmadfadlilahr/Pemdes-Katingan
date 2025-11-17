<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AgendaController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/agenda",
     *      operationId="getAgendaList",
     *      tags={"Agenda"},
     *      summary="Get list of active agenda",
     *      description="Returns paginated list of active agenda/events with optional date range filter",
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
     *          name="from_date",
     *          description="Filter from date (Y-m-d)",
     *          required=false,
     *          in="query",
     *          @OA\Schema(type="string", format="date")
     *      ),
     *      @OA\Parameter(
     *          name="to_date",
     *          description="Filter to date (Y-m-d)",
     *          required=false,
     *          in="query",
     *          @OA\Schema(type="string", format="date")
     *      ),
     *      @OA\Parameter(
     *          name="upcoming",
     *          description="Get only upcoming events (true/false)",
     *          required=false,
     *          in="query",
     *          @OA\Schema(type="boolean")
     *      ),
     *      @OA\Response(response=200, description="Successful operation")
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->get('per_page', 15), 50);

        $query = Agenda::where('is_active', true);

        // Date range filter
        if ($request->has('from_date')) {
            $query->where('start_date', '>=', $request->get('from_date'));
        }

        if ($request->has('to_date')) {
            $query->where('start_date', '<=', $request->get('to_date'));
        }

        // Upcoming events only
        if ($request->boolean('upcoming')) {
            $query->where('start_date', '>=', now()->toDateString());
        }

        $agenda = $query->orderBy('start_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->paginate($perPage);

        // Transform data
        $agenda->getCollection()->transform(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'description' => $item->description,
                'location' => $item->location,
                'start_date' => $item->start_date,
                'end_date' => $item->end_date,
                'start_time' => $item->start_time,
                'end_time' => $item->end_time,
                'is_full_day' => !$item->start_time,
                'created_at' => $item->created_at->toIso8601String(),
            ];
        });

        return $this->successWithPagination($agenda, 'Agenda retrieved successfully');
    }

    /**
     * @OA\Get(
     *      path="/api/v1/agenda/{id}",
     *      operationId="getAgendaDetail",
     *      tags={"Agenda"},
     *      summary="Get agenda detail",
     *      description="Returns detailed information of a specific agenda/event",
     *      @OA\Parameter(
     *          name="id",
     *          description="Agenda ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=404, description="Agenda not found")
     * )
     */
    public function show(int $id): JsonResponse
    {
        $agenda = Agenda::where('id', $id)
            ->where('is_active', true)
            ->first();

        if (!$agenda) {
            return $this->error('Agenda not found', 404);
        }

        $data = [
            'id' => $agenda->id,
            'title' => $agenda->title,
            'description' => $agenda->description,
            'location' => $agenda->location,
            'start_date' => $agenda->start_date,
            'end_date' => $agenda->end_date,
            'start_time' => $agenda->start_time,
            'end_time' => $agenda->end_time,
            'is_full_day' => !$agenda->start_time,
            'created_at' => $agenda->created_at->toIso8601String(),
            'updated_at' => $agenda->updated_at->toIso8601String(),
        ];

        return $this->success($data, 'Agenda detail retrieved successfully');
    }
}
