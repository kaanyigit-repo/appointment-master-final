<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Client;
use App\Http\Requests\AppointmentRequest;
use Carbon\Carbon;
use Google_Service_Exception;
use Illuminate\Http\Request;
use Spatie\GoogleCalendar\Event;

class AppointmentController extends Controller
{
    protected $casts = [
        'start_datetime' => 'datetime:Y-m-d H:i',
        'end_datetime' => 'datetime:Y-m-d H:i',
    ];

    public function index()
    {
        $clients = Client::all();
        return view('appointments.index', compact('clients'));
    }

    public function getAppointments()
    {
        return Appointment::all();
    }

    public function edit($id)
    {
        $appointment = Appointment::find($id);
        $clients = Client::all();
        return view('appointments.edit', compact(['appointment', 'clients']));
    }

    public function store(AppointmentRequest $request)
    {
        $googleEvent = $this->addAppointmentToGoogleCalendar($request);
        /*private function is called*/

        Appointment::create([ //a new appointment is created in the collection
            'title' =>  $request->title,
            'appointment_date' => $request->appointmentDate,
            'start_time' => $request->startTime,
            'end_time' => $request->endTime,
            'description' => $request->description,
            'google_calendar_id' => $googleEvent->id,
            'client_id' => $request->clientId
        ]);

        return redirect()->back();
    }

    public function update(AppointmentRequest $request)
    {
        $appointment = Appointment::find($request->appointmentId);
        //the specific appointment is found

        $is_client_attended = ($request->is_client_attended == 'on');
        $appointment->update([
            'title' =>  $request->title,
            'appointment_date' => $request->appointmentDate,
            'start_time' => $request->startTime,
            'end_time' => $request->endTime,
            'description' => $request->description,
            'is_client_attended' => $is_client_attended,
            'client_id' => $request->clientId
        ]);

        $this->updateAppointmentOnGoogleCalendar($appointment);
        /*private function is called*/

        return redirect()->route('appointments.index');
    }

    public function delete($id)
    {
        $appointment = Appointment::find($id); //appointment is found

        $this->deleteAppointmentFromGoogleCalendar($appointment);
        /*private function is called*/

        $appointment->delete();//appointment is deleted

        return redirect()->back();
    }

    private function addAppointmentToGoogleCalendar($appointment)
    {
        $event = Event::create([ //a Google event(appointment) is created ans stored in event collection
            'name' => $appointment->title,
            'startDateTime' => Carbon::createFromFormat('Y-m-d H:i', "$appointment->appointmentDate $appointment->startTime"),
            'endDateTime' => Carbon::createFromFormat('Y-m-d H:i', "$appointment->appointmentDate $appointment->endTime"),
            //title, staring time, and ending time of the appointment is fetched from user input
        ]);

        return $event;
    }

    private function updateAppointmentOnGoogleCalendar(Appointment $appointment)
    {
        $event = Event::find($appointment->google_calendar_id); //the specific Google event is found

        $event->update([ //title, staring time, and ending time of the appointment may be updated
            'name' => $appointment->title,
            'startDateTime' => Carbon::createFromFormat('Y-m-d H:i', "$appointment->appointment_date $appointment->start_time"),
            'endDateTime' => Carbon::createFromFormat('Y-m-d H:i', "$appointment->appointment_date $appointment->end_time"),
        ]);
    }

    private function deleteAppointmentFromGoogleCalendar(Appointment $appointment)
    {
        try {
            $event = Event::find($appointment->google_calendar_id);//the specific Google event is found

            $event->delete(); //event is deleted
        } catch (Google_Service_Exception $e) {
        }
    }
}
