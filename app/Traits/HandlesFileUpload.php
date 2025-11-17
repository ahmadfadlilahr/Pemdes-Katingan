<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HandlesFileUpload
{
    /**
     * Upload image (simple version tanpa resize)
     */
    protected function uploadImage(UploadedFile $file, string $directory, int $maxWidth = 1200): string
    {
        $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $directory . '/' . $filename;

        Storage::disk('public')->put($path, file_get_contents($file));

        return $path;
    }

    /**
     * Upload file biasa (dokumen, pdf, dll)
     */
    protected function uploadFile(UploadedFile $file, string $directory): array
    {
        $originalName = $file->getClientOriginalName();
        $filename = uniqid() . '_' . time() . '_' . $originalName;
        $path = $file->storeAs($directory, $filename, 'public');

        return [
            'path' => $path,
            'name' => $originalName,
            'type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
        ];
    }

    /**
     * Delete file dari storage
     */
    protected function deleteFile(?string $path): bool
    {
        if ($path && Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }

        return false;
    }

    /**
     * Get full URL dari path
     */
    protected function getFileUrl(?string $path): ?string
    {
        return $path ? asset('storage/' . $path) : null;
    }
}
