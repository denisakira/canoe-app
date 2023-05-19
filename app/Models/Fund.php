<?php

namespace App\Models;

use App\Events\FundCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_year',
        'fund_manager_id',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::created(function (Fund $fund) {
            FundCreated::dispatch($fund);
        });
    }

    public function fundManager()
    {
        return $this->belongsTo(FundManager::class);
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'fund_company')->using(FundCompany::class);
    }

    public function aliases()
    {
        return $this->hasMany(FundAlias::class);
    }
}
