<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;
class InvoiceStatus extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [
        'name_en',
        'name_ar',
        'color',
    ];

    // Relationships
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'invoice_status_id');
    }

    // Helper methods
    public function isDraft(): bool
    {
        return strtolower($this->name_en) === 'draft';
    }

    public function isPaid(): bool
    {
        return strtolower($this->name_en) === 'paid';
    }

    public function isOverdue(): bool
    {
        return strtolower($this->name_en) === 'overdue';
    }

    public function isCancelled(): bool
    {
        return strtolower($this->name_en) === 'cancelled';
    }

    public function isPartiallyPaid(): bool
    {
        return strtolower($this->name_en) === 'partially paid';
    }

    // Activity logging
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }
}
