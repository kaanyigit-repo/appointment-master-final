@extends('layouts.app')

@section('css')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Edit Appointment</div>
                    <div class="card-body">
                        <form action="/appointment/update" method="POST" id="updateForm">
                            @csrf
                            <input type="text" name="appointmentId" value="{{ $appointment->id }}" hidden>

                            <div class="form-group">
                                <label for="clientId">Client</label>
                                <div class="input-group mb-3">
                                    <select class="custom-select" id="clientId" name="clientId">
                                        <option value="" selected>Choose Client</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}"
                                                {{ $client->id == $appointment->client_id ? 'selected' : '' }}>
                                                {{ $client->name_fee }}</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="inputGroupSelect02">Is client attended?</label>
                                        <div class="input-group-text">
                                            <input type="checkbox" name="is_client_attended"
                                                {{ $appointment->is_client_attended ? 'checked="checked"' : '' }}
                                                aria-label="Checkbox for following text input">
                                        </div>
                                    </div>
                                </div>
                                @error('clientId')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="userName">Title</label>
                                <input type="text" class="form-control" name="title" value="{{ $appointment->title }}">
                                @error('title')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Appointment Date</label>
                                <input type="date" class="form-control" name="appointmentDate" id="appointmentDate"
                                    value="{{ $appointment->appointment_date }}" aria-describedby="helpId" placeholder="">
                                @error('appointmentDate')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Start Time</label>
                                        <input type="time" class="form-control" name="startTime"
                                            value="{{ $appointment->start_time }}" aria-describedby="helpId" placeholder="">
                                        @error('startTime')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">End Time</label>
                                        <input type="time" class="form-control" id="endTime" name="endTime"
                                            value="{{ $appointment->end_time }}" aria-describedby="helpId" placeholder="">
                                        @error('endTime')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label> <h10> (Optional) </h10>
                                <div id="description">
                                    {!! $appointment->description !!}
                                </div>
                                <input type="hidden" name="description">
                                @error('description')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary float-right">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <!-- Core build with no theme, formatting, non-essential modules -->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        var quill = new Quill('#description', {
            theme: 'snow'
        });
        var quill = new Quill('#medications', {
            theme: 'snow'
        });
        var quill = new Quill('#conditions', {
            theme: 'snow'
        });

        // https://quilljs.com/playground/#form-submit
        // This is code implemented from the example above
        var form = document.querySelector('#updateForm');
        form.onsubmit = function() {
            // Populate hidden form on submit
            var description = document.querySelector('input[name=description]');
            description.value = document.querySelector('#description').querySelector('.ql-editor').innerHTML;

            var medications = document.querySelector('input[name=medications]');
            medications.value = document.querySelector('#medications').querySelector('.ql-editor').innerHTML;

            var conditions = document.querySelector('input[name=conditions]');
            conditions.value = document.querySelector('#conditions').querySelector('.ql-editor').innerHTML;
        };

    </script>
@endsection
