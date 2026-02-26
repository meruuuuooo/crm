<?php

namespace App\Models\Crm;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $table = 'crm_projects';

    protected $fillable = [
        'name', 'project_id_code', 'project_type', 'client_id',
        'category', 'project_timing', 'price',
        'start_date', 'due_date', 'priority', 'status', 'description',
    ];

    protected $casts = [
        'price'      => 'decimal:2',
        'start_date' => 'date',
        'due_date'   => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Contact::class, 'client_id');
    }

    public function responsiblePersons()
    {
        return $this->belongsToMany(User::class, 'crm_project_responsible', 'project_id', 'user_id');
    }

    public function teamLeaders()
    {
        return $this->belongsToMany(User::class, 'crm_project_leader', 'project_id', 'user_id');
    }
}
