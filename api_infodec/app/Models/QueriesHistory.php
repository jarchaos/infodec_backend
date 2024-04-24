<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueriesHistory extends Model
{
    use HasFactory;
    protected $table = 'queries_history';
    protected $fillable = ['country_id', 'city_id', 'budget', 'exchange_rate', 'converted_budget', 'date'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
