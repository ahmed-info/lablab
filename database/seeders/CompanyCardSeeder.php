<?php

namespace Database\Seeders;

use App\Models\CompanyCard;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CompanyCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        for($i=0; $i<7; $i++){
            $cards[] =[
            // 'created_at'        =>Carbon::now(),
            // 'updated_at'        =>Carbon::now(),

            'ss_num'   =>$faker->ean8(),
            'full_name'         => $faker->sentence(),
            "gender"            => $faker->randomElement(["male", "female"]),
            'birth_date'        => $faker->dateTimeBetween('1930-01-01', '2003-12-31')->format('Y-m-d'),
            'release_date'      => $faker->dateTimeBetween('2015-01-01', '2021-08-01')->format('Y-m-d'),
            'expiry_date'       => $faker->dateTimeBetween('2021-09-01', '2022-12-31')->format('Y-m-d'),
            'national_number'   => $faker->unique()->numberBetween(10000000,9999999999),
            'mother_name'       => $faker->firstNameFemale(),
            'company_name'      =>$faker->name(),
            'location'          =>$faker->address(),
            'card_img'          =>'storage/img/1.jpg',
            'qr_code'           =>'qr_code/styf-gobz.png',
            'company_id'        =>$faker->numberBetween(1,2),
            'created_at'        =>Carbon::now(),
            'updated_at'        =>Carbon::now(),


            ];
        }

        $chunks = array_chunk($cards,1000);
        foreach($chunks as $chunk){
            CompanyCard::insert($chunk);
        }
    }

}
