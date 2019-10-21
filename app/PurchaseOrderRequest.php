<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderRequest extends Model
{
    protected $fillable = [
        'user_id', 'manager_id', 'approved_by_manager', 'approved_by_manager_on', 'senior_manager_id', 'approved_by_senior_manager', 'approved_by_senior_manager_on', 'admin_id', 'approved_by_admin', 'approved_by_admin_on', 'category', 'subcategory', 'request_details', 'amount', 'currency', 'expected_on'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
