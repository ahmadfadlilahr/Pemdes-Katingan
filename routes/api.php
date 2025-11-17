<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\NewsController;
use App\Http\Controllers\Api\V1\AgendaController;
use App\Http\Controllers\Api\V1\GalleryController;
use App\Http\Controllers\Api\V1\DocumentController;
use App\Http\Controllers\Api\V1\OrganizationController;
use App\Http\Controllers\Api\V1\InfoController;
use App\Http\Controllers\Api\V1\StatsController;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Admin\UserController;
use App\Http\Controllers\Api\V1\Admin\NewsManagementController;
use App\Http\Controllers\Api\V1\Admin\AgendaManagementController;
use App\Http\Controllers\Api\V1\Admin\GalleryManagementController;
use App\Http\Controllers\Api\V1\Admin\DocumentManagementController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// API Version 1
Route::prefix('v1')->middleware('throttle:60,1')->group(function () {

    // ============================================
    // PUBLIC ROUTES (No Authentication Required)
    // ============================================

    // News endpoints (Public Read-Only)
    Route::get('/news', [NewsController::class, 'index']);
    Route::get('/news/{slug}', [NewsController::class, 'show']);

    // Agenda endpoints (Public Read-Only)
    Route::get('/agenda', [AgendaController::class, 'index']);
    Route::get('/agenda/{id}', [AgendaController::class, 'show']);

    // Gallery endpoints (Public Read-Only)
    Route::get('/gallery', [GalleryController::class, 'index']);
    Route::get('/gallery/{id}', [GalleryController::class, 'show']);

    // Documents endpoints (Public Read-Only)
    Route::get('/documents', [DocumentController::class, 'index']);
    Route::get('/documents/categories', [DocumentController::class, 'categories']);
    Route::get('/documents/{id}', [DocumentController::class, 'show']);
    Route::post('/documents/{id}/download', [DocumentController::class, 'download']);

    // Organization structure endpoints (Public Read-Only)
    Route::get('/organization', [OrganizationController::class, 'index']);
    Route::get('/organization/{id}', [OrganizationController::class, 'show']);

    // Information endpoints (Public Read-Only)
    Route::get('/contact', [InfoController::class, 'contact']);
    Route::get('/vision-mission', [InfoController::class, 'visionMission']);
    Route::get('/welcome-message', [InfoController::class, 'welcomeMessage']);

    // Statistics endpoints (Public Read-Only)
    Route::get('/stats', [StatsController::class, 'index']);
    Route::get('/stats/news', [StatsController::class, 'newsStats']);
    Route::get('/stats/documents', [StatsController::class, 'documentStats']);

    // ============================================
    // AUTHENTICATION ROUTES
    // ============================================

    Route::prefix('auth')->group(function () {
        // Login (Public)
        Route::post('/login', [AuthController::class, 'login']);

        // Protected routes (require authentication)
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::post('/logout-all', [AuthController::class, 'logoutAll']);
            Route::get('/me', [AuthController::class, 'me']);
            Route::put('/update-profile', [AuthController::class, 'updateProfile']);
            Route::put('/change-password', [AuthController::class, 'changePassword']);
        });
    });

    // ============================================
    // ADMIN ROUTES (Require Authentication)
    // ============================================

    Route::middleware('auth:sanctum')->prefix('admin')->group(function () {

        // User Management (Super Admin only - will add middleware later)
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index']);
            Route::get('/{id}', [UserController::class, 'show']);
            Route::post('/', [UserController::class, 'store']);
            Route::put('/{id}', [UserController::class, 'update']);
            Route::delete('/{id}', [UserController::class, 'destroy']);
            Route::put('/{id}/reset-password', [UserController::class, 'resetPassword']);
            Route::post('/{id}/toggle-status', [UserController::class, 'toggleStatus']);
        });

        // News Management (Admin)
        Route::prefix('news')->group(function () {
            Route::get('/', [NewsManagementController::class, 'index']);
            Route::get('/{id}', [NewsManagementController::class, 'show']);
            Route::post('/', [NewsManagementController::class, 'store']);
            Route::post('/{id}', [NewsManagementController::class, 'update']); // POST for multipart/form-data
            Route::delete('/{id}', [NewsManagementController::class, 'destroy']);
            Route::post('/{id}/toggle-publish', [NewsManagementController::class, 'togglePublish']);
            Route::delete('/bulk-delete', [NewsManagementController::class, 'bulkDelete']);
        });

        // Agenda Management (Admin)
        Route::prefix('agenda')->group(function () {
            Route::get('/', [AgendaManagementController::class, 'index']);
            Route::get('/{id}', [AgendaManagementController::class, 'show']);
            Route::post('/', [AgendaManagementController::class, 'store']);
            Route::post('/{id}', [AgendaManagementController::class, 'update']); // POST for multipart/form-data
            Route::delete('/{id}', [AgendaManagementController::class, 'destroy']);
            Route::delete('/bulk-delete', [AgendaManagementController::class, 'bulkDelete']);
        });

        // Gallery Management (Admin)
        Route::prefix('gallery')->group(function () {
            Route::get('/', [GalleryManagementController::class, 'index']);
            Route::get('/{id}', [GalleryManagementController::class, 'show']);
            Route::post('/', [GalleryManagementController::class, 'store']);
            Route::post('/{id}', [GalleryManagementController::class, 'update']);
            Route::delete('/{id}', [GalleryManagementController::class, 'destroy']);
            Route::delete('/bulk-delete', [GalleryManagementController::class, 'bulkDelete']);
        });

        // Documents Management (Admin)
        Route::prefix('documents')->group(function () {
            Route::get('/', [DocumentManagementController::class, 'index']);
            Route::get('/{id}', [DocumentManagementController::class, 'show']);
            Route::get('/categories', [DocumentManagementController::class, 'categories']);
            Route::post('/', [DocumentManagementController::class, 'store']);
            Route::post('/{id}', [DocumentManagementController::class, 'update']);
            Route::delete('/{id}', [DocumentManagementController::class, 'destroy']);
            Route::delete('/bulk-delete', [DocumentManagementController::class, 'bulkDelete']);
        });
    });
});
