<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Expense;
use App\Exports\FinancialReportExport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FinancialReportController extends Controller
{
    //This section checks the validity of the request and gathers data if necessary
    public function index(Request $request)
    {
        $month = $request->month ?? now()->format('Y-m'); //The date of the request
        // is extracted in Year-Month form

        if (!$request->month) {
            return redirect('/financial-report?month=' . $month);
            //The request is checked for the input, if it is not present user is re-directed to date picker
        }

        $appointments = $this->getMonthlyAppointments($month);

        $expenses = $this->getMonthlyExpenses($month);

        return view('financial_report.index', compact(['appointments', 'month', 'expenses']));
    }

    //This function enables to pull the monthly appointment fees
    private function getMonthlyAppointments($month)
    {
        $date = Carbon::createFromFormat('Y-m', $month);
        //The $month variable is parsed with the carbon library to Year-month

        return Appointment::with('client')//Appointment collection is searched
            ->whereYear('appointment_date', $date->year)
            ->whereMonth('appointment_date', $date->month)
            ->get();
    }

    //This function enables to pull the monthly expenses
    private function getMonthlyExpenses($month)
    {
        $date = Carbon::createFromFormat('Y-m', $month);
        //The $month variable is parsed with the carbon library to Year-month

        return Expense::whereYear('date', $date->year) //Expense collection is searched
            ->whereMonth('date', $date->month)
            ->get();
    }

    //This function enables to export the collected fee and expense data as spreadsheet
    public function export(Request $request)
    {
        //financialReportExport class is called with the month to produce and download report.
        return Excel::download(new FinancialReportExport($request->month), "financial_report_$request->month.xlsx");
        //The file name is also manipulated as financial_report$month.xls
    }
}
