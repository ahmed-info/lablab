<?php

namespace App\Http\Controllers;

use App\Exports\CardsExport;
use App\Models\Company;
use App\Models\CompanyCard;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class ViewController extends Controller
{
    public function index(Request $req)
    {
        $faker = Factory::create();
        $method = $req->method();

        if ($req->isMethod('post'))
        {
            $from = $req->input('from');
            if ($req->has('search'))
            {
                // select search
                $cards = DB::select("SELECT * FROM company_cards WHERE company_name = '$from'");
                $companyDistinct = Company::all();
                $companies = $companyDistinct->unique('company_name');
                //return $cards;

                return view('card.select',compact('cards', 'companies'));
            } 


            
            elseif($req->has('exportExcel'))
                        
                // select Excel
                $this->validate($req,[
                    'qr_code'=>'nullable',
                    'warranty_number'=>'number|unique'
                 ]);
                 $companyCards = CompanyCard::all();
                 foreach($companyCards as $companyCard){
                    //$dateNow = Carbon::createFormat('Y-m-d');
                    $dateRelease = date('Y-m-d');
                    $dateExpiry = Carbon::createFromFormat('Y-m-d',$dateRelease)->addDays(364);
                    //generate social security number
                    $companyCard->warranty_number = $faker->unique()->numberBetween(10000000,99999999);
                    $companyCard->release_date = $dateRelease;
                    $companyCard->expiry_date = $dateExpiry;
                    $companyCard->qr_code = Hash::make($req->qr_code);

                    $companyCard->save();
                 }


            return Excel::download(new CardsExport($from), 'Export_Excel_'.date('Y-m-d').'.xlsx');
            {
        } 
        }
        else
        {
            //select all
            $cards = DB::select('SELECT * FROM company_cards');
            $cards = CompanyCard::paginate();
            $companyDistinct = Company::all();
            $companies = $companyDistinct->unique('company_name');

            return view('card.select',['cards' => $cards, 'companies' => $companies]);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'qr_code'=>'nullable',
         ]);
         $companyCard = CompanyCard::find($id);
         $companyCard->qr_code = Hash::make($request->qr_code);
          $companyCard->save();
         return redirect()->route('card.select');

    }

    public function search()
    {
        $search_text = $_GET['getSearch'];
        $companyDistinct = Company::where('company_name','LIKE','%'. $search_text.'%')->get();
        $companies =$companyDistinct->unique('company_name');
        //$companies = Company::all();

        $cards = CompanyCard::where('company_name','LIKE','%'. $search_text.'%')->paginate();

        return view('card.search', compact('cards', 'companies'));
    }

}
