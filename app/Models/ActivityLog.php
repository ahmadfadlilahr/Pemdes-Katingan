<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    /**
     * Disable updated_at timestamp (we only need created_at)
     */
    const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'action',
        'description',
        'model_type',
        'model_id',
        'ip_address',
        'user_agent',
        'properties',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'properties' => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * Get the user that performed the activity.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'System',
        ]);
    }

    /**
     * Get the model that the activity was performed on (polymorphic).
     */
    public function subject(): MorphTo
    {
        return $this->morphTo('model');
    }

    /**
     * Get formatted action name in Indonesian.
     */
    public function getActionNameAttribute(): string
    {
        return match($this->action) {
            'created' => 'Membuat',
            'updated' => 'Mengupdate',
            'deleted' => 'Menghapus',
            'login' => 'Login',
            'logout' => 'Logout',
            'restored' => 'Memulihkan',
            'viewed' => 'Melihat',
            default => ucfirst($this->action),
        };
    }

    /**
     * Get formatted model name in Indonesian.
     */
    public function getModelNameAttribute(): string
    {
        if (!$this->model_type) {
            return '-';
        }

        $modelName = class_basename($this->model_type);

        return match($modelName) {
            'News' => 'Berita',
            'Agenda' => 'Agenda',
            'Hero' => 'Hero/Slider',
            'Gallery' => 'Galeri',
            'Document' => 'Dokumen',
            'VisionMission' => 'Visi & Misi',
            'OrganizationStructure' => 'Struktur Organisasi',
            'User' => 'User',
            default => $modelName,
        };
    }

    /**
     * Get action badge color for UI.
     */
    public function getActionColorAttribute(): string
    {
        return match($this->action) {
            'created' => 'green',
            'updated' => 'blue',
            'deleted' => 'red',
            'login' => 'indigo',
            'logout' => 'gray',
            'restored' => 'yellow',
            'viewed' => 'purple',
            default => 'gray',
        };
    }

    /**
     * Get icon for action type.
     */
    public function getActionIconAttribute(): string
    {
        return match($this->action) {
            'created' => 'M12 4v16m8-8H4',
            'updated' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z',
            'deleted' => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16',
            'login' => 'M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1',
            'logout' => 'M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1',
            default => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        };
    }

    /**
     * Scope to filter by date range.
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Scope to filter by action.
     */
    public function scopeAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope to filter by user.
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to filter by model type.
     */
    public function scopeByModel($query, $modelType)
    {
        return $query->where('model_type', $modelType);
    }

    /**
     * Scope to search in description.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('description', 'like', "%{$search}%");
    }

    /**
     * Delete logs older than specified days.
     */
    public static function deleteOlderThan(int $days): int
    {
        return static::where('created_at', '<', now()->subDays($days))->delete();
    }
}
