<?php

namespace App\Models\Crm;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $table = 'crm_tasks';

    protected $fillable = [
        'title', 'category', 'start_date', 'due_date',
        'tags', 'priority', 'status', 'description',
    ];

    protected $casts = [
        'start_date' => 'date',
        'due_date'   => 'date',
    ];

    public function responsiblePersons()
    {
        return $this->belongsToMany(User::class, 'crm_task_responsible', 'task_id', 'user_id');
    }
}
