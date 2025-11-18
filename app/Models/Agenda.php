<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class Agenda extends Model
{
    use HasFactory, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image',
        'document',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'location',
        'status',
        'is_active',
        'order_position',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'is_active' => 'boolean',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($agenda) {
            if (is_null($agenda->order_position)) {
                $agenda->order_position = static::max('order_position') + 1;
            }

            // Auto-set status based on dates
            $agenda->status = $agenda->determineStatus();
        });

        static::updating(function ($agenda) {
            // Auto-update status when dates change
            if ($agenda->isDirty(['start_date', 'end_date', 'start_time', 'end_time'])) {
                $agenda->status = $agenda->determineStatus();
            }
        });
    }

    /**
     * Get the user that created the agenda.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for active agendas.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for agendas ordered by position and date.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order_position', 'asc')
                    ->orderBy('start_date', 'desc')
                    ->orderBy('start_time', 'asc');
    }

    /**
     * Scope for filtering by status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for upcoming agendas.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now()->toDateString())
                    ->whereIn('status', ['scheduled', 'ongoing']);
    }

    /**
     * Scope for ongoing agendas.
     */
    public function scopeOngoing($query)
    {
        $now = now();
        return $query->where('start_date', '<=', $now->toDateString())
                    ->where('end_date', '>=', $now->toDateString())
                    ->where('status', 'ongoing');
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
     * Get the document URL.
     */
    public function getDocumentUrlAttribute()
    {
        if ($this->document) {
            return Storage::url($this->document);
        }
        return null;
    }

    /**
     * Get formatted start datetime.
     */
    public function getStartDatetimeAttribute()
    {
        $time = $this->start_time ? $this->start_time->format('H:i:s') : '00:00:00';
        return Carbon::parse($this->start_date->format('Y-m-d') . ' ' . $time);
    }

    /**
     * Get formatted end datetime.
     */
    public function getEndDatetimeAttribute()
    {
        $time = $this->end_time ? $this->end_time->format('H:i:s') : '23:59:59';
        return Carbon::parse($this->end_date->format('Y-m-d') . ' ' . $time);
    }

    /**
     * Check if agenda is currently ongoing.
     */
    public function isOngoing()
    {
        $now = now();
        return $now >= $this->start_datetime && $now <= $this->end_datetime;
    }

    /**
     * Check if agenda is completed.
     */
    public function isCompleted()
    {
        return now() > $this->end_datetime;
    }

    /**
     * Check if agenda is upcoming.
     */
    public function isUpcoming()
    {
        return now() < $this->start_datetime;
    }

    /**
     * Determine status based on current date/time.
     */
    public function determineStatus()
    {
        if ($this->status === 'cancelled' || $this->status === 'draft') {
            return $this->status;
        }

        if ($this->isCompleted()) {
            return 'completed';
        }

        if ($this->isOngoing()) {
            return 'ongoing';
        }

        return 'scheduled';
    }

    /**
     * Get status badge color.
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'draft' => 'gray',
            'scheduled' => 'blue',
            'ongoing' => 'green',
            'completed' => 'purple',
            'cancelled' => 'red',
            default => 'gray',
        };
    }

    /**
     * Get status label.
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'draft' => 'Draft',
            'scheduled' => 'Terjadwal',
            'ongoing' => 'Berlangsung',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => 'Unknown',
        };
    }

    /**
     * Get duration in human readable format.
     */
    public function getDurationAttribute()
    {
        if (!$this->start_time || !$this->end_time) {
            return 'Seharian';
        }

        $start = Carbon::parse($this->start_time);
        $end = Carbon::parse($this->end_time);

        return $start->format('H:i') . ' - ' . $end->format('H:i');
    }

    /**
     * Get date range in human readable format.
     */
    public function getDateRangeAttribute()
    {
        if ($this->start_date->equalTo($this->end_date)) {
            return $this->start_date->format('d M Y');
        }

        return $this->start_date->format('d M Y') . ' - ' . $this->end_date->format('d M Y');
    }

    /**
     * Update agenda status automatically.
     */
    public static function updateStatuses()
    {
        // Update to ongoing
        static::where('status', 'scheduled')
            ->where('start_date', '<=', now()->toDateString())
            ->update(['status' => 'ongoing']);

        // Update to completed
        static::where('status', 'ongoing')
            ->where('end_date', '<', now()->toDateString())
            ->update(['status' => 'completed']);
    }
}
