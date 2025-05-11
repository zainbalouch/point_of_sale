<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceTemplateSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key_name',
        'company_id',
        'value_en',
        'value_ar',
    ];


    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
