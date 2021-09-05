<?php

namespace App\Http\Controllers;

use App\Exports\CardsExport;
use App\Models\Admin;
use App\Models\Company;
use App\Models\CompanyCard;
use App\Models\User;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use function PHPSTORM_META\type;
use function Psy\bin;

class ViewController extends Controller
{
    public function index(Request $req)
    {
        // $cards = DB::select('SELECT * FROM company_cards');

        // $companyDistinct = Company::all();
        //     $companies = $companyDistinct->unique('company_name');
        // $data = ['LoggedUserInfo'=> Admin::where('id','=', Session('LoggedUser'))->first()];
        // return view('card.select', compact('data','companies','cards'));   
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
                    'ss_num'=>'number|unique'
                 ]);
                 $companyCards = CompanyCard::all();
                 foreach($companyCards as $companyCard){
                    //$dateNow = Carbon::createFormat('Y-m-d');
                    $dateRelease = date('Y-m-d');
                    $dateExpiry = Carbon::createFromFormat('Y-m-d',$dateRelease)->addDays(364);
                    //add date release and expiry
                    $companyCard->release_date = $dateRelease;
                    $companyCard->expiry_date = $dateExpiry;
                    $companyCard->qr_code = Hash::make($req->qr_code);
                    $companyCard->save();
                 }
                 //$companyName = $companyCards[0]->company_name;
                 
                //  $search_text = $_GET['form'];
            // return Excel::download(new CardsExport, 'F:\myExport\Export_Excel_'.date('Y-m-d').'.xlsx');
            Excel::store(new CardsExport($from), 'Export_excel_'.date('Y-m-d').'.xlsx');
            return redirect()->route('card.index')->with([
                'message' => 'Exporting started successfully',
                 'alert-type' =>'success'
             ]);
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

    public function logAdminIndex(Request $request)
    {
        return view('card.logAdminIndex');
    }

    public function logUserIndex(Request $request)
    {
        return view('card.logUserIndex');
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

    public function getCompany()
    {
        $getCompany = $_GET['getCompany'];
        return $getCompany;
        

        return view('card.search', compact('cards', 'companies'));
    }
    public function login()
    {
        return view('myauth.login');
    }

    public function logout()
    {
        if(session()->has('LoggedUser')){
            session()->pull('LoggedUser');
            return redirect()->route('myauth.login');
        }
    }

    public function check(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:5|max:12'
        ]);

        $adminInfo = Admin::where('email','=' ,$request->email)->first();
        $userInfo = User::where('email','=' ,$request->email)->first();
        if(!$adminInfo && (!$userInfo)){
            return back()->with('fail', 'we dont recongnize your email address');
        }
        elseif($adminInfo){
            if(Hash::check($request->password, $adminInfo->password)){
                $request->session()->put('LoggedUser', $adminInfo->id);
                session(['email' => 'admin@admin.com']);
                //dd($data);
                $request->session()->get('email');

                return redirect()->route('log.admin.index');
            }
            
            return back()->with('fail', 'incorrect password');
        
        }

        //////////////////////////////////////////////////////////

        if(!$adminInfo && !$userInfo){
            return back()->with('fail', 'we dont recongnize your email address');
        }elseif($userInfo){
            if(Hash::check($request->password, $userInfo->password)){
                $request->session()->put('LoggedUser', $userInfo->id);
                session(['email' => 'user@user.com']);
                $request->session()->get('email');

                return redirect()->route('log.user.index');
            }
            
            return back()->with('fail', 'incorrect password');
        
        }
    }

    function test(){
        $str = 'my name is ahmed i am programmer in sama alyamama company , i live in iraq baghdad , my age 28 years old, iam gradute collage depaartment inforamation technology';
       $hexx = bin2hex($str);
       $hexStr = strval($hexx);
      
    //    foreach ($hexStr as $itemss){
    //        if ($key === 0 || $key === "c") {
    //         return str_replace(key, '', '&');
    //        }
    //    }

        //less letters count
        /**======================ghazwan========================*/

        // $compressed = gzcompress($str, 9);
        // $encrypted = encrypt($compressed, $key);
        // $mydecrypt = decrypt($encrypted, $key);
        // $toOrginal = gzuncompress($mydecrypt);
        // //return $toOrginal;
        //  $myStr = '12345678_عبد الرحمن عبد العزيز عبد الصمد عبد الرحمنذكر_1957-10-22_1947927273سارة عبد الرحمن عبد الرحمنشركة سما اليمامة للخدمات العامة وتكنولوجيا المعلومات العراقيةبغداد - الكرادة';
        //  $token = Crypt::encryptString($myStr);
        //  $myenc = substr($token, -15);
        //  return $myenc;
        
        /*========================== Ahmed ==============================*/
        $str = "Ahmed";
        $hex1 = bin2hex($str);
        $hex2 = bin2hex($str);
        return $hex1.'<br>'.$hex2;
//////////////////////////////////////////////////////////////////////
         $encrypt = bin2hex($str);
            $compress1 = gzcompress($encrypt);
             return Str::length($compress1);        

          $qr = QrCode::encoding('UTF-8')->generate(
            //utf8_encode($compress)
          // $card->ss_num.'<br>'.$card->full_name.'<br>'.$card->gender.'<br>'.$card->birth_date.'<br>'.$card->release_date.'<br>'.$card->expiry_date.'<br>'.$card->national_number.'<br>'.$card->mother_name.'<br>'.$card->company_name.'<br>'.$card->location
          );
          return view('card.test', compact('qr'));
          ///////////////////////////////
        //return $mydecrypt;
        //return Str::length($encrypted);
        //return Str::length($compressed);
        // $mydecrypt = decrypt($encrypted, $key);
        // return Str::length($mydecrypt);
        // return $encrypted;
    }
}
