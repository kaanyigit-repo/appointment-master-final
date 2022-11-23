@extends('layouts.app')

@section('css')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('content')


    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Edit Expense</div>

                    <div class="card-body">
                        <form action="/expense/update" method="POST" id="updateForm" enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="id" value="{{ $expense->id }}" hidden>

                            <div class="form-group">
                                <label for="">Date</label>
                                <input type="date" class="form-control" name="date" id="date" value="{{ old('date') ??
                                        now()->startOfHour()->format('Y-m-d') }}" aria-describedby="helpId" placeholder="">
                                @error('date')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" value="{{ $expense->title }}">
                                @error('title')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="text" class="form-control" name="amount" value="{{ $expense->amount }}">
                                @error('amount')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description"
                                    rows="5">{{ $expense->description }}</textarea>
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
    <!-- Core build with no theme, formatting, non-essential modules -->
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
