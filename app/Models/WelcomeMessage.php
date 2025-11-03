<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WelcomeMessage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'position',
        'message',
        'photo',
        'signature',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the active welcome message.
     *
     * @return \App\Models\WelcomeMessage|null
     */
    public static function getActive()
    {
        return self::where('is_active', true)->first();
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Ensure only one welcome message is active
        static::saving(function ($welcomeMessage) {
            if ($welcomeMessage->is_active) {
                self::where('id', '!=', $welcomeMessage->id)
                    ->update(['is_active' => false]);
            }
        });
    }
}
