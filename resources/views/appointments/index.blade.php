@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.1.0/main.min.css">
@endsection
@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Create Appointment</div>
                    <div class="card-body">
                        <form action="{{ route('appointments.create') }}" method="POST">
                            @csrf
                            <div class="input-group mb-3">
                                <select class="custom-select" id="inputGroupSelect02" name="clientId">
                                    <option value="" selected>Choose Client</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name_fee }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <label class="input-group-text" for="inputGroupSelect02">Choose a Client</label>
                                </div>
                            </div>
                            @error('clientId')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label for="">Title</label>
                                <input type="text" name="title" id="" class="form-control" placeholder=""
                                    value="{{ old('title') }}" aria-describedby="helpId">
                                @error('title')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Appointment Date</label>
                                <input type="date" class="form-control" name="appointmentDate" id="appointmentDate" value="{{ old('appointmentDate') ??
                                        now()->startOfHour()->format('Y-m-d') }}" aria-describedby="helpId" placeholder="">
                                @error('appointmentDate')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Start Time</label>
                                        <input type="time" class="form-control" name="startTime" value="{{ old('startTime') ??
                                                now()->startOfHour()->format('H:i') }}" aria-describedby="helpId"
                                            placeholder="">
                                        @error('startTime')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">End Time</label>
                                        <input type="time" class="form-control" id="endTime" name="endTime"
                                            value="{{ old('endTime') ??
                                                    now()->addHour()->startOfHour()->format('H:i') }}"
                                            aria-describedby="helpId" placeholder="">
                                        @error('endTime')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="">Description</label><h8> <font:3>(Optional)  </h8>
                                <textarea class="form-control" name="description" id="" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary float-right">Create</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-9 mt-4 mt-md-0 mt-xl-0">
                <div class="card">
                    <div class="card-header">Calendar</div>
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>


                    <div id="calendarModal" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 id="modalTitle" class="modal-title"></h4>
                                    <button type="button" class="close" data-dismiss="modal"><span
                                            aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                                </div>
                                <div id="modalBody" class="modal-body">
                                </div>
                                <div class="modal-footer">
                                    <a class="btn btn-primary" href="#" id="eventUpdateUrl">Update</a>
                                    <a class="btn btn-danger" href="#" id="eventDeleteUrl">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.1.0/main.min.js" type=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendar

            fetch("{{ route('appointments.get') }}")
                .then(response => response.json())
                .then(data => {
                    data = data.map(row => {
                        return {
                            id: row.id,
                            title: row.title,
                            start: row.start_datetime,
                            end: row.end_datetime,
                            description: row.description,
                            url: "{{ url('/appointment/edit') }}" + '/' + row.id
                        }
                    });

                    var calendarEl = document.getElementById('calendar');
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        headerToolbar: {
                            left: 'dayGridMonth,timeGridWeek,timeGridDay',
                            center: 'title',
                            right: 'today,prevYear,prev,next,nextYear'
                        },
                        displayEventEnd: true,
                        events: data,
                        eventClick: function(event) {
                            // don't let the browser navigate
                            event.jsEvent.preventDefault();

                            $('#modalTitle').html(event.event.title);
                            $('#modalBody').html("This event starts at " + event.event.start);
                            $('#eventUpdateUrl').attr('href', '/appointment/edit/' + event.event
                                .id);
                            $('#eventDeleteUrl').attr('href', '/appointment/delete/' + event.event
                                .id);
                            $('#calendarModal').modal();
                            /* if (info.event.url) {
                                window.open(info.event.url);
                            } */
                        }
                    });
                    calendar.render();
                });
        });

    </script>
@endsection
