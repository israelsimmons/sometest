<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SharePurchase extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_name', 'instrument_name', 'quantity',
        'price', 'total_investment', 'certificate_number', 'user_id',
        'transaction_date'
    ];

    // Accessor for retrieving date in America/New_York tz
    public function getTransactionDateAttribute($value)
    {
        // die($value);
        $date = \Carbon\Carbon::parse($value);
        $result = $date->setTimezone('America/New_York');

        return $result->format('Y-m-d');
    }

    // Mutator for storing date un UTC
    public function setTransactionDateAttribute($value)
    {
        $date = \Carbon\Carbon::createFromFormat('Y-m-d', $value, 'America/New_York');
        $result = $date->timezone('UTC');

        $this->attributes['transaction_date'] = $result;
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag');
    }
}
