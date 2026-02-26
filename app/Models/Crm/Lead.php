<?php

namespace App\Models\Crm;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use SoftDeletes;

    protected $table = 'crm_leads';

    protected $fillable = [
        'lead_name', 'lead_type', 'company_id', 'value', 'currency',
        'phone', 'phone_type', 'source', 'industry', 'tags',
        'description', 'visibility',
    ];

    protected $casts = [
        'value' => 'decimal:2',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function owners()
    {
        return $this->belongsToMany(User::class, 'crm_lead_owner', 'lead_id', 'user_id');
    }
}
