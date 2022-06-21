<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;

class BookingExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return[
            'Name',
            'Email',
            'Phone',
            'Class Type',
            'Created_at',
        ];
    } 
    public function collection()
    {
        if (request()->start_date || request()->end_date) {
            $start_date = Carbon::parse(request()->start_date)->toDateTimeString();
            $end_date = Carbon::parse(request()->end_date)->toDateTimeString();
            $data = Booking::Select("user_name","user_email","phone","class_type","created_at")->whereBetween('created_at',[$start_date,$end_date])->get();
        } else {
            $data = Booking::Select("user_name","user_email","phone","class_type","created_at")->latest()->get();
        }
        return $data;
         //return Booking::all();
    }
}
