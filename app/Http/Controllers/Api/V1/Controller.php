<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Dinas PMD Katingan API Documentation",
 *      description="RESTful API untuk Website Dinas Pemberdayaan Masyarakat dan Desa Kabupaten Katingan.
 *                   API ini menyediakan akses terhadap data berita, agenda, galeri, dokumen, dan struktur organisasi.",
 *      @OA\Contact(
 *          email="info@pmdkatingan.go.id",
 *          name="Dinas PMD Katingan"
 *      ),
 *      @OA\License(
 *          name="MIT",
 *          url="https://opensource.org/licenses/MIT"
 *      )
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="API Server (Configurable via .env)"
 * )
 *
 * @OA\SecurityScheme(
 *      securityScheme="sanctum",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT",
 *      description="Enter your Bearer token obtained from login endpoint"
 * )
 *
 * @OA\Tag(
 *     name="Authentication",
 *     description="Endpoints untuk login, logout, dan autentikasi"
 * )
 * @OA\Tag(
 *     name="User Management",
 *     description="Endpoints untuk kelola akun admin (Super Admin only)"
 * )
 * @OA\Tag(
 *     name="News",
 *     description="Endpoints untuk berita dan artikel"
 * )
 * @OA\Tag(
 *     name="Agenda",
 *     description="Endpoints untuk agenda dan kegiatan"
 * )
 * @OA\Tag(
 *     name="Gallery",
 *     description="Endpoints untuk galeri foto"
 * )
 * @OA\Tag(
 *     name="Documents",
 *     description="Endpoints untuk dokumen publik"
 * )
 * @OA\Tag(
 *     name="Organization",
 *     description="Endpoints untuk struktur organisasi"
 * )
 * @OA\Tag(
 *     name="Contact",
 *     description="Endpoints untuk informasi kontak"
 * )
 * @OA\Tag(
 *     name="Vision & Mission",
 *     description="Endpoints untuk visi dan misi"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Success response helper
     */
    protected function success($data = null, string $message = 'Success', int $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Error response helper
     */
    protected function error(string $message = 'Error', int $code = 400, $errors = null)
    {
        $response = [
            'success' => false,
            'message' => $message
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

    /**
     * Paginated response helper
     */
    protected function successWithPagination($data, string $message = 'Success')
    {
        // Check if data is a paginator or resource collection
        if (method_exists($data, 'resource')) {
            $paginator = $data->resource;
        } else {
            $paginator = $data;
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
            ],
            'links' => [
                'first' => $paginator->url(1),
                'last' => $paginator->url($paginator->lastPage()),
                'prev' => $paginator->previousPageUrl(),
                'next' => $paginator->nextPageUrl(),
            ]
        ]);
    }

    /**
     * Success response helper (alias)
     */
    protected function successResponse($data, string $message = 'Success', int $code = 200)
    {
        return $this->success($data, $message, $code);
    }

    /**
     * Error response helper (alias)
     */
    protected function errorResponse(string $message = 'Error', int $code = 400, $errors = null)
    {
        return $this->error($message, $code, $errors);
    }

    /**
     * Paginated response helper (alias)
     */
    protected function paginatedResponse($data, string $message = 'Success')
    {
        return $this->successWithPagination($data, $message);
    }
}
