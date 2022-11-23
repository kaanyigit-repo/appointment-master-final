@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <form action="/financial-report" method="GET">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <input type="month" class="form-control" name="month" id="month" aria-describedby="helpId"
                                    value="{{ $month ?? now()->format('Y-m') }}" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-block btn-primary">Get Financial Report</button>
                        </div>
                        <div class="col-md-12 mb-3">
                            <a href="/financial-report/export?month={{ request()->month }}"
                                class="btn btn-success btn-block"> DOWNLOAD MONTHLY FINANCIAL
                                REPORT </a>
                        </div>
                    </div>
                </form>
                <div class="card">
                    <div class="card-header">
                        Monthly Financial Report
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 33%">Client</th>
                                    <th style="width: 22%">Date</th>
                                    <th style="width: 11%">Hour</th>
                                    <th style="width: 34%">Fee</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($appointments as $appointment)
                                    <tr>
                                        <td style="width: 33%" scope="row">{{ $appointment->client->name }}</td>
                                        <td style="width: 22%">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d.m.Y') }}</td>
                                        <td style="width: 22%">{{ $appointment->start_time }} - {{ $appointment->end_time }}
                                        </td>
                                        <td style="width: 23%">{{ $appointment->fee }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td style="width: 33%" scope="row"></td>
                                    <td style="width: 22%"></td>
                                    <td style="width: 22%"></td>
                                    <td style="width: 23%"><b class="text-bold">Total :</b>
                                        {{ $appointments->sum('fee') }}</td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        Monthly Expenses
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($expenses as $expense)
                                    <tr>
                                        <td style="width: 33%" scope="row">{{ $expense->title }}</td>
                                        <td style="width: 33%">{{ \Carbon\Carbon::parse($expense->date)->format('d.m.Y') }}</td>
                                        <td style="width: 33%">{{ $expense->amount }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td scope="row" style="width: 33%"></td>
                                    <td style="width: 33%"></td>
                                    <td style="width: 33%"><b class="text-bold">Total :</b> -{{ $expenses->sum('amount') }}
                                    </td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
