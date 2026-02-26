<?php

namespace App\Models\Crm;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pipeline extends Model
{
    use SoftDeletes;

    protected $table = 'crm_pipelines';

    protected $fillable = ['name', 'access_type', 'stages', 'selected_persons'];

    protected $casts = [
        'stages'           => 'array',
        'selected_persons' => 'array',
    ];

    public function deals()
    {
        return $this->hasMany(Deal::class, 'pipeline_id');
    }
}
