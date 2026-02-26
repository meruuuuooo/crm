<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use SoftDeletes;

    protected $table = 'crm_contracts';

    protected $fillable = [
        'subject', 'start_date', 'end_date', 'client_id',
        'contract_type', 'contract_value', 'attachment', 'description',
    ];

    protected $casts = [
        'start_date'     => 'date',
        'end_date'       => 'date',
        'contract_value' => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(Contact::class, 'client_id');
    }
}
