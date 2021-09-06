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
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
                $comDistinct = Company::all();
                $companies = $comDistinct->unique('company_name');
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
                    $strAhmed = "Ahmed";
                    $strAbdulrazzaq = "Abdulrazzaq";
                    $strYahya = "Yahya";
                    $dateRelease = date('Y-m-d');
                    $dateExpiry = Carbon::createFromFormat('Y-m-d',$dateRelease)->addDays(364);
                    //generate social security number
                    $companyCard->warranty_number = $faker->unique()->numberBetween(10000000,99999999);
                    $companyCard->release_date = $dateRelease;
                    $companyCard->expiry_date = $dateExpiry;
                    $testqr = $strAhmed . PHP_EOL . $strAbdulrazzaq.PHP_EOL.$strYahya;

                    $companyCard->qr_code = $testqr;

                    // $companyCard->qr_code = Hash::make($req->qr_code);

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
            //prevent select multiple array
            $comDistinct = Company::all();
            $companies = $comDistinct->unique('company_name');

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

    function test(){
        $str = 'my name is ahmed i am programmer in sama alyamama company , i live in iraq baghdad , my age 28 years old, iam gradute collage depaartment inforamation technology';
        //$hexx = bin2hex($str);
        //$hexStr = strval($hexx);
        //less letters count
        /**======================ghazwan========================*/
////////////////////okkkkkk////////////////////////////
        $compressed = gzcompress($str, 9);  //1
        $encrypted = encrypt($compressed); //2
        $mydecrypt = decrypt($encrypted); //3
        $toOrginal = gzuncompress($mydecrypt); //4
        ////////////////////////////////////////////////
        //  $token = Crypt::encryptString($myStr);
        //  $myenc = substr($token, -15);
        //  return $myenc;
        
        /*========================== Ahmed ==============================*/
        $strAhmed = "Ahmed";
        $strAbdulrazzaq = "Abdulrazzaq";
        $strYahya = "Yahya";

        $hex1 = bin2hex($str);
        $hex2 = bin2hex($str);
        //return Str::length($strAhmed . PHP_EOL . $strAbdulrazzaq.PHP_EOL.$strYahya);

        //return $hex1.'<br>'.$hex2;
//////////////////////////////////////////////////////////////////////
         $encrypt = bin2hex($str);
            $compress1 = gzcompress($encrypt);
            // return Str::length($compress1);        

          $qr = QrCode::errorCorrection('L')->size(250)->encoding('UTF-8')->generate(
            $encrypted
            //utf8_encode($compress)
          // $card->ss_num.'<br>'.$card->full_name.'<br>'.$card->gender.'<br>'.$card->birth_date.'<br>'.$card->release_date.'<br>'.$card->expiry_date.'<br>'.$card->national_number.'<br>'.$card->mother_name.'<br>'.$card->company_name.'<br>'.$card->location
          );
          return view('card.test', compact('qr'));
          ///////////////////////////////
    }

}
