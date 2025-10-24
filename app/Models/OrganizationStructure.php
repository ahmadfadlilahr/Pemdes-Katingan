<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class OrganizationStructure extends Model
{
    protected $fillable = [
        'name',
        'nip',
        'position',
        'photo',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    /**
     * Scope for active structures
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered structures
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Get the next available order number
     */
    public static function getNextOrder(): int
    {
        $maxOrder = self::max('order');
        return $maxOrder ? $maxOrder + 1 : 1;
    }

    /**
     * Adjust orders when inserting at specific position
     */
    public static function adjustOrdersForInsert(int $newOrder): void
    {
        self::where('order', '>=', $newOrder)
            ->increment('order');
    }

    /**
     * Adjust orders when updating position
     */
    public static function adjustOrdersForUpdate(int $oldOrder, int $newOrder): void
    {
        if ($oldOrder < $newOrder) {
            // Moving down - decrement orders in between
            self::whereBetween('order', [$oldOrder + 1, $newOrder])
                ->decrement('order');
        } elseif ($oldOrder > $newOrder) {
            // Moving up - increment orders in between
            self::whereBetween('order', [$newOrder, $oldOrder - 1])
                ->increment('order');
        }
    }

    /**
     * Check if order number exists
     */
    public static function orderExists(int $order, ?int $excludeId = null): bool
    {
        $query = self::where('order', $order);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    /**
     * Get photo URL or default placeholder
     */
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo && file_exists(public_path('storage/' . $this->photo))) {
            return asset('storage/' . $this->photo);
        }

        // Return default placeholder image
        return asset('images/default-avatar.svg');
    }    /**
     * Get photo path for storage
     */
    public function getPhotoPathAttribute(): ?string
    {
        return $this->photo ? public_path('storage/' . $this->photo) : null;
    }

    /**
     * Delete photo file from storage
     */
    public function deletePhoto(): void
    {
        if ($this->photo && file_exists(public_path('storage/' . $this->photo))) {
            unlink(public_path('storage/' . $this->photo));
        }
    }
}
