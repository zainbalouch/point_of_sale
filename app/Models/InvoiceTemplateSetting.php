<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class InvoiceTemplateSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key_name',
        'field_type',
        'company_id',
        'value_en',
        'value_ar',
    ];

    protected static function booted()
    {
        static::addGlobalScope('company', function (Builder $builder) {
            $user = Auth::user();
            if ($user && $user->company_id) {
                $builder->whereHas('company', function ($query) {
                    $query->where('is_active', true);
                })->where('company_id', $user->company_id);
            }
        });

        static::retrieved(function ($model) {
            $user = Auth::user();
            if ($user && $user->company_id) {
                if (!$model->company || !$model->company->is_active) {
                    abort(404);
                }
            }
        });

        static::updating(function ($model) {
            $user = Auth::user();
            if ($user && $user->company_id) {
                if (!$model->company || !$model->company->is_active) {
                    abort(403, 'Cannot update record for inactive company');
                }
            }
        });

        static::deleting(function ($model) {
            $user = Auth::user();
            if ($user && $user->company_id) {
                if (!$model->company || !$model->company->is_active) {
                    abort(403, 'Cannot delete record for inactive company');
                }
            }
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public static function get($key, $default = null, $company_id = null)
    {
        $query = self::where('key_name', $key);

        // If company_id is not provided, try to get it from auth user
        if ($company_id) {
            $query->where('company_id', $company_id);
        } elseif (Auth::check()) {
            $user = Auth::user();

            if ($user->company_id) {
                $company_id = $user->company_id;
            } elseif ($user->point_of_sale_id) {
                $company_id = $user->pointOfSale->company_id ?? null;
            }
        }

        // Only apply company_id condition if we have a valid company_id


        $templateSetting = $query->first();

        if ($templateSetting) {
            $locale = app()->getLocale();
            return $templateSetting->{'value_' . $locale} ?? $templateSetting->value_ar ?? $default;
        }

        return $default;
    }
}
