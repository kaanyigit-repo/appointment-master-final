@extends('layouts.app')


@section('content')


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Add Client</div>

                    <div class="card-body">
                        <form action="/clients/add" method="POST">
                            @csrf
                            <div class="form-group">
                                <label  placeholder="John Appleseed"for="userName">Client Name</label>
                                <input type="text" class="form-control" name="userName" value="{{ old('userName') }}">
                                @error('userName')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="mail">Mail</label>
                                <input  placeholder="abc@xyz.com"type="text" class="form-control" name="mail" value="{{ old('mail') }}">
                                @error('mail')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input  placeholder="0xxx-xxx-xxxx"type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                                @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="hourlyFee">Hourly Fee</label>
                                <input  placeholder="200"type="text" class="form-control" name="hourlyFee" value="{{ old('hourlyFee') }}">
                                @error('hourlyFee')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="medications">Medications*</label>
                                <input  placeholder="Prozac, passiflora, etc. "type="text" class="form-control" name="medications" value="{{ old('medications') }}">
                                @error('medications')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="conditions">Conditions*</label>
                                <input placeholder="Demantia, schizophrenia, etc. " type="text" class="form-control" name="conditions" value="{{ old('conditions') }}">
                                @error('conditions')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="otherInfo">Other Info*</label>
                                <textarea class="form-control" name="otherInfo" rows="5">{{ old('otherInfo') }}</textarea>
                                @error('otherInfo')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                
                                <h9> <style= "font:3"> * = Optional</style></h9>

                            </div>
                            <button type="submit" class="btn btn-primary float-right">Submit</button>
                        </form>
                    </div>
                </div>

            </div>



            <div class="col-md-9 mt-4 mt-md-0 mt-xl-0">
                <form action="/clients" method="GET">
                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <div class="form-group w-100 mb-0 mr-4">
                            <input type="text" class="form-control" name="search" id="search" aria-describedby="helpId"
                                placeholder="Search in clients">
                        </div>
                        <button type="submit" class="btn btn-primary ml-auto">Search</button>

                    </div>
                </form>
                <div class="card">
                    <div class="card-header">Clients</div>
                    <div class="card-body">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Client Name</th>
                                    <th scope="col">Mail</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Other Info</th>
                                    <th scope="col">Appointments</th>
                                    <th scope="col">Hourly Fee</th>
                                    <th scope="col">Last Updated</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $client)
                                    <tr>
                                        <th scope="row"> {{ $client->id }} </th>
                                        <td> {{ $client->name }} </td>
                                        <td> {{ $client->mail }} </td>
                                        <td style="width: 17%"> {{ $client->phone }} </td>
                                        <td> {{ strip_tags($client->other_info) }} </td>
                                        <td> {{ $client->appointments->count() }} </td>
                                        <td> {{ $client->hourly_fee }} </td>
                                        <td> {{ $client->updated_at->format('Y-m-d') }} </td>
                                        <td class="d-flex justify-content-between">
                                            <a class="btn btn-warning mr-2" href="/client/edit/{{ $client->id }}">Update</a>
                                            <a class="btn btn-danger" href="/client/delete/{{ $client->id }}">Delete</a>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="w-100 d-flex justify-content-center">{{ $clients->links() }}</div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
