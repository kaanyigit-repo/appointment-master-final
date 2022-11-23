@extends('layouts.app')


@section('content')


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Add Expense</div>

                    <div class="card-body">
                        <form action="/expenses/add" method="POST">
                            @csrf
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
                                <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                                @error('title')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="text" class="form-control" name="amount" value="{{ old('amount') }}">
                                @error('amount')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description"
                                    rows="5">{{ old('description') }}</textarea>
                                @error('description')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary float-right">Submit</button>
                        </form>
                    </div>
                </div>

            </div>



            <div class="col-md-9 mt-4 mt-md-0 mt-xl-0">
                <div class="card">
                    <div class="card-header">Expenses</div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Expense Title</th>
                                        <th scope="col">Expense Amount</th>
                                        <th scope="col">Expense Description</th>
                                        <th scope="col">Expense Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($expenses as $expense)
                                        <tr>
                                            <th scope="row"> {{ $expense->id }} </th>
                                            <td> {{ $expense->title }} </td>
                                            <td> {{ $expense->amount }} </td>
                                            <td> {{ $expense->description }} </td>
                                            <td> {{ Carbon\Carbon::parse($expense->date)->format('d.m.Y') }} </td>
                                            <td style="width:15%" class="d-flex justify-content-between">
                                                <a class="btn btn-warning mr-2"
                                                    href="/expense/edit/{{ $expense->id }}">Update</a>
                                                <a class="btn btn-danger"
                                                    href="/expense/delete/{{ $expense->id }}">Delete</a>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
