<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

/**
 * Trait LogsActivity
 *
 * Automatically log CRUD operations for models.
 * Usage: Add 'use LogsActivity;' in your model class.
 */
trait LogsActivity
{
    /**
     * Boot the trait.
     */
    protected static function bootLogsActivity(): void
    {
        // Log when model is created
        static::created(function ($model) {
            $model->logActivity('created', 'membuat ' . $model->getLogDescription());
        });

        // Log when model is updated
        static::updated(function ($model) {
            $model->logActivity('updated', 'mengupdate ' . $model->getLogDescription(), [
                'old' => $model->getOriginal(),
                'new' => $model->getAttributes(),
            ]);
        });

        // Log when model is deleted
        static::deleted(function ($model) {
            $model->logActivity('deleted', 'menghapus ' . $model->getLogDescription());
        });
    }

    /**
     * Log an activity.
     */
    public function logActivity(string $action, string $description, array $properties = []): ActivityLog
    {
        return ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'description' => $description,
            'model_type' => get_class($this),
            'model_id' => $this->id ?? null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'properties' => $properties,
        ]);
    }

    /**
     * Get description for logging.
     * Override this method in your model for custom descriptions.
     */
    public function getLogDescription(): string
    {
        $modelName = class_basename($this);

        $indonesianNames = [
            'News' => 'berita',
            'Agenda' => 'agenda',
            'Hero' => 'hero/slider',
            'Gallery' => 'galeri',
            'Document' => 'dokumen',
            'VisionMission' => 'visi & misi',
            'OrganizationStructure' => 'struktur organisasi',
            'User' => 'user',
        ];

        $name = $indonesianNames[$modelName] ?? strtolower($modelName);

        // Try to get a meaningful identifier
        $identifier = $this->title ?? $this->name ?? $this->id ?? '';

        return "{$name} \"{$identifier}\"";
    }

    /**
     * Get all activity logs for this model.
     */
    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'model');
    }
}
