<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Api\V1\Controller;
use App\Http\Requests\Api\StoreAgendaRequest;
use App\Http\Resources\AgendaResource;
use App\Models\Agenda;
use App\Traits\HandlesFileUpload;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AgendaManagementController extends Controller
{
    use HandlesFileUpload;

    /**
     * @OA\Get(
     *      path="/api/v1/admin/agenda",
     *      operationId="adminGetAgendaList",
     *      tags={"Agenda Management"},
     *      summary="Get all agenda (Admin)",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(name="page", in="query", @OA\Schema(type="integer")),
     *      @OA\Parameter(name="search", in="query", @OA\Schema(type="string")),
     *      @OA\Parameter(name="status", in="query", @OA\Schema(type="string")),
     *      @OA\Response(response=200, description="Success")
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->get('per_page', 15), 50);

        $query = Agenda::with('user:id,name');

        // Search
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->get('status'));
        }

        $agenda = $query->orderBy('start_date', 'desc')->paginate($perPage);

        return $this->successWithPagination(
            AgendaResource::collection($agenda),
            'Agenda list retrieved successfully'
        );
    }

    /**
     * @OA\Post(
     *      path="/api/v1/admin/agenda",
     *      operationId="adminCreateAgenda",
     *      tags={"Agenda Management"},
     *      summary="Create new agenda",
     *      security={{"sanctum":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  required={"title", "description", "start_date", "end_date"},
     *                  @OA\Property(property="title", type="string"),
     *                  @OA\Property(property="description", type="string"),
     *                  @OA\Property(property="start_date", type="date"),
     *                  @OA\Property(property="end_date", type="date"),
     *                  @OA\Property(property="start_time", type="string", format="time"),
     *                  @OA\Property(property="end_time", type="string", format="time"),
     *                  @OA\Property(property="location", type="string"),
     *                  @OA\Property(property="status", type="string"),
     *                  @OA\Property(property="image", type="file"),
     *                  @OA\Property(property="document", type="file"),
     *                  @OA\Property(property="is_active", type="boolean")
     *              )
     *          )
     *      ),
     *      @OA\Response(response=201, description="Created")
     * )
     */
    public function store(StoreAgendaRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'agenda', 1200);
        }

        // Handle document upload
        if ($request->hasFile('document')) {
            $fileData = $this->uploadFile($request->file('document'), 'agenda/documents');
            $data['document'] = $fileData['path'];
        }

        // Set author
        $data['user_id'] = $request->user()->id;

        $agenda = Agenda::create($data);

        return $this->success(
            new AgendaResource($agenda->load('user')),
            'Agenda created successfully',
            201
        );
    }

    /**
     * @OA\Get(
     *      path="/api/v1/admin/agenda/{id}",
     *      operationId="adminGetAgendaDetail",
     *      tags={"Agenda Management"},
     *      summary="Get agenda detail (Admin)",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *      @OA\Response(response=200, description="Success")
     * )
     */
    public function show(int $id): JsonResponse
    {
        $agenda = Agenda::with('user')->findOrFail($id);

        return $this->success(
            new AgendaResource($agenda),
            'Agenda detail retrieved successfully'
        );
    }

    /**
     * @OA\Post(
     *      path="/api/v1/admin/agenda/{id}",
     *      operationId="adminUpdateAgenda",
     *      tags={"Agenda Management"},
     *      summary="Update agenda",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(property="title", type="string"),
     *                  @OA\Property(property="description", type="string"),
     *                  @OA\Property(property="start_date", type="date"),
     *                  @OA\Property(property="end_date", type="date"),
     *                  @OA\Property(property="start_time", type="string"),
     *                  @OA\Property(property="end_time", type="string"),
     *                  @OA\Property(property="location", type="string"),
     *                  @OA\Property(property="status", type="string"),
     *                  @OA\Property(property="image", type="file"),
     *                  @OA\Property(property="document", type="file"),
     *                  @OA\Property(property="is_active", type="boolean"),
     *                  @OA\Property(property="_method", type="string", example="PUT")
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="Updated")
     * )
     */
    public function update(StoreAgendaRequest $request, int $id): JsonResponse
    {
        $agenda = Agenda::findOrFail($id);
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $this->deleteFile($agenda->image);
            $data['image'] = $this->uploadImage($request->file('image'), 'agenda', 1200);
        }

        // Handle document upload
        if ($request->hasFile('document')) {
            $this->deleteFile($agenda->document);
            $fileData = $this->uploadFile($request->file('document'), 'agenda/documents');
            $data['document'] = $fileData['path'];
        }

        $agenda->update($data);

        return $this->success(
            new AgendaResource($agenda->load('user')),
            'Agenda updated successfully'
        );
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/admin/agenda/{id}",
     *      operationId="adminDeleteAgenda",
     *      tags={"Agenda Management"},
     *      summary="Delete agenda",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *      @OA\Response(response=200, description="Deleted")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $agenda = Agenda::findOrFail($id);

        // Delete files
        $this->deleteFile($agenda->image);
        $this->deleteFile($agenda->document);

        $agenda->delete();

        return $this->success(null, 'Agenda deleted successfully');
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/admin/agenda/bulk-delete",
     *      operationId="adminBulkDeleteAgenda",
     *      tags={"Agenda Management"},
     *      summary="Bulk delete agenda",
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
            'ids.*' => 'integer|exists:agendas,id'
        ]);

        $agenda = Agenda::whereIn('id', $request->ids)->get();

        foreach ($agenda as $item) {
            $this->deleteFile($item->image);
            $this->deleteFile($item->document);
            $item->delete();
        }

        return $this->success(
            null,
            count($agenda) . ' agenda deleted successfully'
        );
    }
}
