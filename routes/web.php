<?php

use App\Http\Controllers\HeroController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/berita', [PublicController::class, 'news'])->name('news');
Route::get('/berita/{slug}', [PublicController::class, 'newsShow'])->name('news.show');
Route::get('/agenda', [PublicController::class, 'agenda'])->name('agenda');
Route::get('/agenda/{id}', [PublicController::class, 'agendaShow'])->name('agenda.show');
Route::get('/dokumen', [PublicController::class, 'documents'])->name('documents');
Route::get('/dokumen/{id}', [PublicController::class, 'documentShow'])->name('documents.show');
Route::get('/dokumen/{id}/preview', [PublicController::class, 'documentPreview'])->name('documents.preview');
Route::get('/dokumen/{id}/download', [PublicController::class, 'documentDownload'])->name('documents.download');
Route::get('/galeri', [PublicController::class, 'gallery'])->name('gallery');
Route::get('/kontak', [PublicController::class, 'contact'])->name('contact');
Route::get('/visi-misi', [PublicController::class, 'visionMission'])->name('vision-mission');
Route::get('/struktur-organisasi', [PublicController::class, 'organizationStructure'])->name('organization-structure');
Route::get('/program', [PublicController::class, 'programs'])->name('programs');

// Admin Routes
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('news', NewsController::class);
        Route::post('news/bulk-publish', [NewsController::class, 'bulkPublish'])->name('news.bulk-publish');
        Route::post('news/bulk-draft', [NewsController::class, 'bulkDraft'])->name('news.bulk-draft');
        Route::post('news/bulk-delete', [NewsController::class, 'bulkDelete'])->name('news.bulk-delete');
        Route::post('news/bulk-action', [NewsController::class, 'bulkAction'])->name('news.bulk-action');

        Route::resource('heroes', HeroController::class);
        Route::patch('heroes/{hero}/toggle-status', [HeroController::class, 'toggleStatus'])->name('heroes.toggle-status');

        // Agenda Routes
        Route::resource('agenda', \App\Http\Controllers\Admin\AgendaController::class);
        Route::patch('agenda/{agenda}/toggle-status', [\App\Http\Controllers\Admin\AgendaController::class, 'toggleStatus'])->name('agenda.toggle-status');
        Route::patch('agenda/{agenda}/update-status', [\App\Http\Controllers\Admin\AgendaController::class, 'updateStatus'])->name('agenda.update-status');
        Route::post('agenda/update-positions', [\App\Http\Controllers\Admin\AgendaController::class, 'updatePositions'])->name('agenda.update-positions');
        Route::post('agenda/bulk-action', [\App\Http\Controllers\Admin\AgendaController::class, 'bulkAction'])->name('agenda.bulk-action');

        // Organization Structure Routes
        Route::resource('structures', \App\Http\Controllers\Admin\OrganizationStructureController::class);
        Route::post('structures/bulk-action', [\App\Http\Controllers\Admin\OrganizationStructureController::class, 'bulkAction'])->name('structures.bulk-action');

        // Gallery Routes
        Route::resource('gallery', \App\Http\Controllers\Admin\GalleryController::class);
        Route::patch('gallery/{gallery}/toggle-status', [\App\Http\Controllers\Admin\GalleryController::class, 'toggleStatus'])->name('gallery.toggle-status');
        Route::post('gallery/bulk-action', [\App\Http\Controllers\Admin\GalleryController::class, 'bulkAction'])->name('gallery.bulk-action');

        // Document Routes
        Route::resource('documents', \App\Http\Controllers\Admin\DocumentController::class);
        Route::get('documents/{document}/download', [\App\Http\Controllers\Admin\DocumentController::class, 'download'])->name('documents.download');
        Route::patch('documents/{document}/toggle-status', [\App\Http\Controllers\Admin\DocumentController::class, 'toggleStatus'])->name('documents.toggle-status');
        Route::post('documents/bulk-action', [\App\Http\Controllers\Admin\DocumentController::class, 'bulkAction'])->name('documents.bulk-action');

        // Vision Mission Routes
        Route::resource('vision-mission', \App\Http\Controllers\Admin\VisionMissionController::class);
        Route::patch('vision-mission/{visionMission}/toggle-status', [\App\Http\Controllers\Admin\VisionMissionController::class, 'toggleStatus'])->name('vision-mission.toggle-status');
        Route::post('vision-mission/bulk-delete', [\App\Http\Controllers\Admin\VisionMissionController::class, 'bulkDelete'])->name('vision-mission.bulk-delete');
        Route::post('vision-mission/bulk-activate', [\App\Http\Controllers\Admin\VisionMissionController::class, 'bulkActivate'])->name('vision-mission.bulk-activate');
        Route::post('vision-mission/bulk-deactivate', [\App\Http\Controllers\Admin\VisionMissionController::class, 'bulkDeactivate'])->name('vision-mission.bulk-deactivate');
    });
});

require __DIR__.'/auth.php';
