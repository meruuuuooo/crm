<?php

namespace App\Models\Crm;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    protected $table = 'crm_contacts';

    protected $fillable = [
        'profile_image', 'first_name', 'last_name', 'job_title', 'company_id',
        'email', 'email_opt_out', 'phone_1', 'phone_2', 'fax',
        'date_of_birth', 'reviews', 'owner_id', 'tags', 'source',
        'industry', 'currency', 'language', 'description',
        'street_address', 'country', 'state', 'city', 'zipcode',
        'facebook', 'skype', 'linkedin', 'twitter', 'whatsapp', 'instagram',
        'visibility',
    ];

    protected $casts = [
        'email_opt_out' => 'boolean',
        'date_of_birth' => 'date',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function deals()
    {
        return $this->belongsToMany(Deal::class, 'crm_deal_contact', 'contact_id', 'deal_id');
    }
}
