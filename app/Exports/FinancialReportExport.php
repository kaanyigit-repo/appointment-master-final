<?php

namespace App\Exports;

use App\Appointment;
use App\Expense;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class FinancialReportExport implements FromCollection, WithHeadings, WithEvents
{
    public $date;

    public function __construct($date) //a date parser function is created
    {
        //The data in $month variable is parsed with the carbon library to Year-month
        $this->date = Carbon::createFromFormat('Y-m', $date);
    }

    public function collection()
    {
        //Appointments collection is searched for appropriate rows
        $appointments = Appointment::whereYear('appointment_date', $this->date->year)
            ->whereMonth('appointment_date', $this->date->month)
            ->with('client')
            ->get()
            ->map(function ($row) {
                $hourly_fee = $row->client['hourly_fee'];
                $client_name = $row->client['name'];
                $amount = $row->fee;
                $row = $row->only(['title', 'start_datetime']);
                $row['amount'] = $amount;
                $row['type'] = "APPOINTMENT";
                $row['client_name'] = $client_name;
                return $row;
            });

        //Expense collection is searched for appropriate rows
        $expenses = Expense::whereYear('date', $this->date->year)
            ->whereMonth('date', $this->date->month)
            ->get()
            ->map(function ($row) {
                $row['amount'] = -$row['amount'];
                $row['type'] = "EXPENSE";
                return $row->only(['title', 'date', 'amount', 'type']);
            });

        $financialReport = $appointments->merge($expenses);

        $financialReport->push([
            'title' => '',
            'date' => '',
            'total' => $financialReport->sum('amount'),
        ]);

        return $financialReport;
    }

    public function headings(): array
    {
        return [
            __('Title'),
            __('Date'),
            __('Amount'),
            __('Type'),
            __('Client')
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:N1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);
            },
        ];
    }
}
