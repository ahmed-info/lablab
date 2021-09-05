<?php

namespace App\Exports;

use App\Models\Company;
use App\Models\CompanyCard;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\Queue\ShouldQueue;

class CardsExport implements FromCollection, WithHeadings,ShouldAutoSize, WithEvents
{
    
    public function __construct(String $from = null)
    {
        $this->from = $from;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //$cards =  CompanyCard::orderBy('id')->get();
        return CompanyCard::select()->where('company_name','=',$this->from)->get();  
        // $cards = CompanyCard::take(100)->orderBy('id')->get();
        // $comp = Company::find(3);
        // $cards = CompanyCard::where('company_id','=', $this->from)->get();

        // return $cards;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:P1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }
    // public function map($cards): array
    // {
    //     return [
            
    //         $cards->ss_num,
    //         $cards->full_name,
    //         $cards->gender,
    //         $cards->birth_date,
    //         $cards->release_date,
    //         $cards->expiry_date,
    //         $cards->national_number,
    //         $cards->mother_name,
    //         $cards->company_name,
    //         $cards->location,
    //         $cards->created_at->ToDateString()
    //     ];
    // }

    public function headings(): array
    {
        return [
            'id',
            'ss num',
            'full name',
            'gender',
            'birth date',
            'release date',
            'expiry date',
            'national number',
            'mother name',
            'company name',
            'location',
            'path_img',
            'qr_code',
            'company_id'
        ];
    }
}
