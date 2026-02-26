<?php

namespace App\Models\Crm;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deal extends Model
{
    use SoftDeletes;

    protected $table = 'crm_deals';

    protected $fillable = [
        'deal_name', 'pipeline_id', 'status', 'deal_value', 'currency',
        'period', 'period_value', 'project', 'due_date', 'expected_closing_date',
        'follow_up_date', 'source', 'tags', 'priority', 'description',
    ];

    protected $casts = [
        'deal_value'   => 'decimal:2',
        'period_value' => 'decimal:2',
        'due_date'     => 'date',
        'expected_closing_date' => 'date',
        'follow_up_date'        => 'date',
    ];

    public function pipeline()
    {
        return $this->belongsTo(Pipeline::class, 'pipeline_id');
    }

    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'crm_deal_contact', 'deal_id', 'contact_id');
    }

    public function assignees()
    {
        return $this->belongsToMany(User::class, 'crm_deal_assignee', 'deal_id', 'user_id');
    }
}
