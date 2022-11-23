@extends('layouts.app')

@section('css')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('content')


    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Edit Client</div>

                    <div class="card-body">
                        <form action="/client/update" method="POST" id="updateForm" enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="id" value="{{ $client->id }}" hidden>
                            <div class="form-group">
                                <label for="userName">Client Name</label>
                                <input type="text" class="form-control" name="userName" value="{{ $client->name }}">
                                @error('userName')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="mail">Mail</label>
                                <input type="text" class="form-control" name="mail" value="{{ $client->mail }}">
                                @error('mail')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" name="phone" value="{{ $client->phone }}">
                                @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="hourlyFee">Hourly Fee</label>
                                <input type="text" class="form-control" name="hourlyFee" value="{{ $client->hourly_fee }}">
                                @error('hourlyFee')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="medications">Medications</label>
                                <div id="medications">
                                    {!! $client->medications !!}
                                </div>
                                <input type="hidden" name="medications">
                                @error('medications')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="conditions">Conditions</label>
                                <div id="conditions">
                                    {!! $client->conditions !!}
                                </div>
                                <input type="hidden" name="conditions">
                                @error('conditions')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="other_info">Other Info</label>
                                <div id="other_info">
                                    {!! $client->other_info !!}
                                </div>
                                <input type="hidden" name="otherInfo">
                                @error('other_info')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="meeting_notes_1">{!! $client->meeting_notes ? "<a
                                            href='/client/download-meeting-notes?id=$client->id'>$client->meeting_notes</a>"
                                        : 'Meeting Notes' !!}</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="meeting_notes" name="meetingNotes"
                                        aria-describedby="meeting_notes">
                                    <label class="custom-file-label" for="meeting_notes">Choose file</label>
                                </div>
                            </div>
                            @error('meetingNotes')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <!-- Core build with no theme, formatting, non-essential modules
                                                            -->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        var quill = new Quill('#medications', {
            theme: 'snow'
        });

        var quill = new Quill('#conditions', {
            theme: 'snow'
        });

        var quill = new Quill('#other_info', {
            theme: 'snow'
        });

        // https://quilljs.com/playground/#form-submit
        // This is code implemented from the example above
        var form = document.querySelector('#updateForm');
        form.onsubmit = function() {
            // Populate hidden form on submit
            var medications = document.querySelector('input[name=medications]');
            medications.value = document.querySelector('#medications').querySelector('.ql-editor').innerHTML;

            var conditions = document.querySelector('input[name=conditions]');
            conditions.value = document.querySelector('#conditions').querySelector('.ql-editor').innerHTML;

            var otherInfo = document.querySelector('input[name=otherInfo]');
            otherInfo.value = document.querySelector('#other_info').querySelector('.ql-editor').innerHTML;
        };

        $('#meeting_notes').on('change', function(e) {
            //get the file name
            var fileName = e.target.files[0].name;
            //replace the "Choose a file" label
            $(this).next('.custom-file-label').html(fileName);
        })

    </script>


@endsection
