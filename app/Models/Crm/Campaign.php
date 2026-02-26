<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use SoftDeletes;

    protected $table = 'crm_campaigns';

    protected $fillable = [
        'name', 'campaign_type', 'deal_value', 'currency', 'period',
        'period_value', 'target_audience', 'description', 'attachment',
    ];

    protected $casts = [
        'deal_value'   => 'decimal:2',
        'period_value' => 'decimal:2',
    ];
}
