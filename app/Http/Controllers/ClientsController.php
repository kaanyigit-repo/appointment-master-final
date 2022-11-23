<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientsController extends Controller
{
    //The following part of the code is used for search and pagination

    public function index(Request $request)/*when search button is clicked a new request
        is created under the variable $request by index function */
    {
        $clients = Client::when($request->search, function ($query) use ($request) {
            return $query->where('name', 'like', '%' . $request->search . '%');
        })->paginate(5); //results are paged by 5

        return view('clients.index', compact("clients"));
    }

    public function store(Request $request)
    {
        $client = new Client();

        $validatedData = $request->validate([
            'userName' => ['required', 'max:255'],
            'mail' => ['required'],
            'phone' => ['required'],
            'hourlyFee' => 'required|integer'
        ]);

        $client->name = $request->input('userName');
        $client->mail = $request->input('mail');
        $client->phone = $request->input('phone');
        $client->hourly_fee = $request->input('hourlyFee');
        $client->other_info = $request->input('otherInfo');
        $client->medications = $request->input('medications');
        $client->conditions = $request->input('conditions');

        $client->save();
        //Client::create([])
        return redirect()->back();
    }


    public function edit($id)/*When the edit button on a clients row is clicked the function
        is retrieved to reference the clients row on the database */
    {
        $client = Client::find($id);//Finds client id and stores in variable $client for future reference

        return view('clients.edit', compact("client"));
    }


    public function update(Request $request)
    {
        $request->validate([
            'userName' => ['required', 'max:255'],
            'mail' => ['required'],
            'phone' => ['required'],
            'hourlyFee' => 'required|integer',
            'meetingNotes' => 'mimes:pdf,doc,docx,txt|max:2048'
        ]);

//The following snippet is used to search for file in the request and save if any
        $client = Client::find($request->input('id'));

        if ($request->has('meetingNotes')) {
            $fileName =  time() . '-' . $request->meetingNotes->getClientOriginalName();

            Storage::putFileAs("private", $request->meetingNotes, $fileName);

            $client->meeting_notes = $fileName;
            $client->meeting_notes_path = "private/$fileName";
        }


        $client->name = $request->input('userName');
        $client->mail = $request->input('mail');
        $client->phone = $request->input('phone');
        $client->hourly_fee = $request->input('hourlyFee');
        $client->other_info = $request->input('otherInfo');
        $client->medications = $request->medications;
        $client->conditions = $request->conditions;

        $client->save();

        return redirect('/clients');
    }

    public function delete($id)
    {
        Client::find($id)->delete();

        return redirect()->back();
    }

    //This function ise used for recalling the file stored
    public function downloadMeetingNotes(Request $request)
    {
        $client = Client::find($request->id); //The client id in the request is identified

        return response()->download(storage_path('app/' . $client->meeting_notes_path));
        //Document is downloaded using the link stored
    }
}
