<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Hero extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'title',
        'description',
        'image',
        'is_active',
        'show_title',
        'order_position',
        'button1_text',
        'button1_url',
        'button1_style',
        'button2_text',
        'button2_url',
        'button2_style',
        'user_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_title' => 'boolean',
        'order_position' => 'integer',
    ];

    /**
     * Get the user that owns the hero.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get active heroes ordered by position.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get heroes ordered by position.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order_position', 'asc')->orderBy('created_at', 'desc');
    }

    /**
     * Get the image URL.
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return Storage::url($this->image);
        }
        return null;
    }

    /**
     * Check if hero has button 1.
     */
    public function hasButton1()
    {
        return !empty($this->button1_text) && !empty($this->button1_url);
    }

    /**
     * Check if hero has button 2.
     */
    public function hasButton2()
    {
        return !empty($this->button2_text) && !empty($this->button2_url);
    }

    /**
     * Get button 1 CSS classes.
     */
    public function getButton1Classes()
    {
        return $this->button1_style === 'primary'
            ? 'bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white border border-transparent focus:ring-4 focus:ring-blue-300'
            : 'bg-white/90 hover:bg-white active:bg-gray-50 text-gray-900 border border-white/20 backdrop-blur-sm focus:ring-4 focus:ring-white/30';
    }

    /**
     * Get button 2 CSS classes.
     */
    public function getButton2Classes()
    {
        return $this->button2_style === 'primary'
            ? 'bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white border border-transparent focus:ring-4 focus:ring-blue-300'
            : 'bg-white/10 hover:bg-white/20 active:bg-white/30 text-white border border-white/40 backdrop-blur-sm focus:ring-4 focus:ring-white/30';
    }
}
