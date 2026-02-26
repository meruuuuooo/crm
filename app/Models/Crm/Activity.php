<?php

namespace App\Models\Crm;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use SoftDeletes;

    protected $table = 'crm_activities';

    protected $fillable = [
        'title', 'activity_type', 'due_date', 'time',
        'reminder_value', 'reminder_unit', 'owner_id',
        'description', 'deal_id', 'contact_id', 'company_id',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function guests()
    {
        return $this->belongsToMany(User::class, 'crm_activity_guest', 'activity_id', 'user_id');
    }

    public function deal()
    {
        return $this->belongsTo(Deal::class, 'deal_id');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
