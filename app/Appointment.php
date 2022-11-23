<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_client_attended' => 'boolean',
    ];

    protected $appends = [
        'start_datetime',
        'end_datetime'
    ];

    public function client()
    {
        return $this->hasOne(Client::class, 'id', 'client_id');
    }

    public function getStartDatetimeAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i', "$this->appointment_date $this->start_time");
    }

    public function getEndDatetimeAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i', "$this->appointment_date $this->end_time");
    }

    public function getFeeAttribute()
    {
        return $this->client['hourly_fee'] * (Carbon::parse($this->start_time)->diffInMinutes($this->end_time) / 60);
    }
}
