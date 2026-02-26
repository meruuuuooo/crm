<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estimation extends Model
{
    use SoftDeletes;

    protected $table = 'crm_estimations';

    protected $fillable = [
        'client_id', 'bill_to', 'ship_to', 'project_id',
        'estimate_by', 'amount', 'currency',
        'estimate_date', 'expiry_date', 'status',
        'tags', 'attachment', 'description',
    ];

    protected $casts = [
        'amount'        => 'decimal:2',
        'estimate_date' => 'date',
        'expiry_date'   => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Contact::class, 'client_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
