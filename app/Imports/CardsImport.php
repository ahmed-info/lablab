<?php

namespace App\Imports;

use App\Models\CompanyCard;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Company;
//, WithChunkReading,ShouldQueue
class CardsImport implements ToModel, WithHeadingRow
{
    private $companies;
    public function __construct()
    {
        $this->companies = Company::all();
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $company = $this->companies->where('company_name', $row['company_name'])->first();
        return new CompanyCard([
        'warranty_number'   => $row['warranty_number'],
        'full_name'         => $row['full_name'],
        'gender'            => $row['gender'],
        'birth_date'        => $row['birth_date'],
        'release_date'      => $row['release_date'],
        'expiry_date'       => $row['expiry_date'],
        'national_number'   => $row['national_number'],
        'mother_name'       => $row['mother_name'],
        'company_name'      => $row['company_name'],
        'location'          => $row['location'],
        'card_img'          => $row['card_img'],
        'qr_code'           => $row['qr_code'],
        'company_id'        => $company->id ?? null,
        ]);
    }

    // public function chunkSize(): int
    // {
    //     return 1000;
    // }
}
