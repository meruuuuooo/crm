<?php

namespace App\Models\Crm;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proposal extends Model
{
    use SoftDeletes;

    protected $table = 'crm_proposals';

    protected $fillable = [
        'subject', 'date', 'open_till', 'client_id', 'project_id',
        'related_to', 'deal_id', 'currency', 'status',
        'attachment', 'tags', 'description',
    ];

    protected $casts = [
        'date'      => 'date',
        'open_till' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Contact::class, 'client_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function deal()
    {
        return $this->belongsTo(Deal::class, 'deal_id');
    }

    public function assignees()
    {
        return $this->belongsToMany(User::class, 'crm_proposal_assignee', 'proposal_id', 'user_id');
    }
}
