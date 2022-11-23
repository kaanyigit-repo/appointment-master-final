<?php

namespace App\Http\Controllers;

use App\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::all();

        return view('expenses.index', compact('expenses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'date' => 'required',
            'amount' => 'required|integer'
        ]);

        Expense::create([
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => $request->date,
            'description' => $request->description
        ]);

        return redirect('/expenses');
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'date' => 'required',
            'amount' => 'required|integer'
        ]);

        $expense = Expense::find($request->id);

        $expense->update([
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => $request->date,
            'description' => $request->description
        ]);

        return redirect('/expenses');
    }

    public function edit($id)
    {
        $expense = Expense::find($id);

        return view('expenses.edit', compact('expense'));
    }

    public function delete($id)
    {
        Expense::find($id)->delete();

        return redirect('/expenses');
    }
}
