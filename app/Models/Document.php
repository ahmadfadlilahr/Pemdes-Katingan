<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Document extends Model
{
    use LogsActivity;
    protected $fillable = [
        'title',
        'slug',
        'description',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'download_count',
        'category',
        'user_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'download_count' => 'integer',
        'file_size' => 'integer',
    ];

    protected $appends = [
        'file_size_formatted',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($document) {
            if (empty($document->slug)) {
                $document->slug = Str::slug($document->title);
            }
        });

        static::updating(function ($document) {
            if ($document->isDirty('title')) {
                $document->slug = Str::slug($document->title);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function getFileSizeFormattedAttribute()
    {
        if (!$this->file_size || $this->file_size <= 0) {
            return '0 KB';
        }

        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;

        while ($bytes > 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function incrementDownloadCount()
    {
        $this->increment('download_count');
    }
}
