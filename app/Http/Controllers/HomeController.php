<?php

namespace App\Http\Controllers;

use App\Appointment;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $lastAppointment = Appointment::latest('appointment_date')->latest('start_time')->first();

        if ($lastAppointment) {
            if ($lastAppointment->start_datetime < now()) {
                $lastAppointment = null;
            }
        }

        return view('home', compact('lastAppointment'));
    }
}
