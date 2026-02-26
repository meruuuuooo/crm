<?php

namespace App\Models\Crm;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $table = 'crm_companies';

    protected $fillable = [
        'company_name', 'email', 'email_opt_out', 'phone_1', 'phone_2',
        'fax', 'website', 'reviews', 'owner_id', 'tags', 'source',
        'industry', 'currency', 'language', 'description',
        'street_address', 'country', 'state', 'city', 'zipcode',
        'facebook', 'skype', 'linkedin', 'twitter', 'whatsapp', 'instagram',
        'visibility', 'company_files',
    ];

    protected $casts = [
        'email_opt_out' => 'boolean',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'company_id');
    }

    public function deals()
    {
        return $this->hasManyThrough(Deal::class, Contact::class, 'company_id', 'id');
    }

    public function leads()
    {
        return $this->hasMany(Lead::class, 'company_id');
    }
}
