<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'party_plot_id',
        'vendor_id',
        'user_id',
        'name',
        'email', // nullable
        'phone',
        'function_date',
        'message',
        'status',
        'source',
        'lead_price',
        'purchased_at',
        'vendor_notes',
        'admin_notes',
    ];

    protected $casts = [
        'function_date' => 'date',
        'purchased_at' => 'datetime',
        'lead_price' => 'decimal:2',
    ];

    /**
     * Get the party plot that this lead belongs to
     */
    public function partyPlot()
    {
        return $this->belongsTo(PartyPlot::class);
    }

    /**
     * Get the vendor (user) that owns the party plot
     */
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    /**
     * Get the user who submitted the lead (if logged in)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to filter by status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to filter by source
     */
    public function scopeSource($query, $source)
    {
        return $query->where('source', $source);
    }
}

