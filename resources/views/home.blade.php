@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">


                        <div class="row">
                            <div
                                class="col-md-4 h-25 d-flex flex-column justify-content-center align-items-center text-center">
                                <a href="/financial-report">
                                    <i class="fas fa-wallet fa-9x"></i>
                                    <h3 class="mt-2"><b>Finacial Management</b></h3>
                                </a>
                            </div>
                            <div
                                class="col-md-4 h-25 d-flex flex-column justify-content-center align-items-center text-center">
                                <a href="/appointments">
                                    <i class="far fa-calendar-alt fa-9x"></i>
                                    <h3 class="mt-2"><b>Appointment Calendar</b></h3>
                                </a>
                            </div>
                            <div
                                class="col-md-4 h-25 d-flex flex-column justify-content-center align-items-center text-center">
                                <a href="/clients">
                                    <i class="fas fa-users fa-9x"></i>
                                    <h3 class="mt-2"><b>Client Information</b></h3>
                                </a>
                            </div>
                        </div>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif



                        <h4 class="text-center mt-4">
                            {{ __('Welcome!') }}
                            @if (!is_null($lastAppointment))
                                Your next appointment is
                                {{ Carbon\Carbon::parse($lastAppointment->start_datetime)->diffForHumans(now()) }}
                            @else
What would you like to do today?                            @endif
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
