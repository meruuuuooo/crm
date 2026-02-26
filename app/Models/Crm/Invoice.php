<?php

namespace App\Models\Crm;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $table = 'crm_invoices';

    protected $fillable = [
        'client_id', 'bill_to', 'ship_to', 'project_id',
        'amount', 'currency', 'date', 'open_till',
        'payment_method', 'status', 'description',
        'line_items', 'notes', 'terms_conditions',
    ];

    protected $casts = [
        'amount'     => 'decimal:2',
        'date'       => 'date',
        'open_till'  => 'date',
        'line_items' => 'array',
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
