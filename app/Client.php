<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = [];

    protected $appends = [
        'name_fee'
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'client_id', 'id');
    }


    public function getNameFeeAttribute()
    {
        return "$this->name ($this->hourly_fee TL/H)";
    }
}
