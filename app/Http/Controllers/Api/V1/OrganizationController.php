<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\OrganizationStructure;
use Illuminate\Http\JsonResponse;

class OrganizationController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/organization",
     *      operationId="getOrganizationStructure",
     *      tags={"Organization"},
     *      summary="Get organization structure",
     *      description="Returns complete organization structure grouped by hierarchy level",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Success"),
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="levels",
     *                      type="array",
     *                      @OA\Items(
     *                          @OA\Property(property="level", type="integer", example=1),
     *                          @OA\Property(
     *                              property="members",
     *                              type="array",
     *                              @OA\Items(
     *                                  @OA\Property(property="id", type="integer"),
     *                                  @OA\Property(property="name", type="string"),
     *                                  @OA\Property(property="nip", type="string"),
     *                                  @OA\Property(property="position", type="string"),
     *                                  @OA\Property(property="photo", type="string"),
     *                                  @OA\Property(property="order", type="integer")
     *                              )
     *                          )
     *                      )
     *                  ),
     *                  @OA\Property(property="total_members", type="integer", example=25)
     *              )
     *          )
     *      )
     * )
     */
    public function index(): JsonResponse
    {
        $structures = OrganizationStructure::where('is_active', true)
            ->orderBy('order', 'asc')
            ->get();

        // Group by hierarchy level (order)
        $grouped = $structures->groupBy('order')->map(function ($members, $level) {
            return [
                'level' => (int) $level,
                'members' => $members->map(function ($member) {
                    return [
                        'id' => $member->id,
                        'name' => $member->name,
                        'nip' => $member->nip,
                        'position' => $member->position,
                        'photo' => $member->photo ? asset('storage/' . $member->photo) : null,
                        'order' => $member->order,
                    ];
                })->values()
            ];
        })->values();

        $data = [
            'levels' => $grouped,
            'total_members' => $structures->count(),
        ];

        return $this->success($data, 'Organization structure retrieved successfully');
    }

    /**
     * @OA\Get(
     *      path="/api/v1/organization/{id}",
     *      operationId="getOrganizationMemberDetail",
     *      tags={"Organization"},
     *      summary="Get organization member detail",
     *      description="Returns detailed information of a specific organization member",
     *      @OA\Parameter(
     *          name="id",
     *          description="Member ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(response=200, description="Successful operation"),
     *      @OA\Response(response=404, description="Member not found")
     * )
     */
    public function show(int $id): JsonResponse
    {
        $member = OrganizationStructure::where('id', $id)
            ->where('is_active', true)
            ->first();

        if (!$member) {
            return $this->error('Organization member not found', 404);
        }

        // Count members at same level
        $sameLevelCount = OrganizationStructure::where('order', $member->order)
            ->where('is_active', true)
            ->count();

        $data = [
            'id' => $member->id,
            'name' => $member->name,
            'nip' => $member->nip,
            'position' => $member->position,
            'photo' => $member->photo ? asset('storage/' . $member->photo) : null,
            'order' => $member->order,
            'hierarchy_info' => [
                'level' => $member->order,
                'members_at_same_level' => $sameLevelCount,
            ],
            'created_at' => $member->created_at->toIso8601String(),
            'updated_at' => $member->updated_at->toIso8601String(),
        ];

        return $this->success($data, 'Organization member detail retrieved successfully');
    }
}
