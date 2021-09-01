<?php

namespace App\Http\Controllers;

use App\Exports\CardsExport;
use App\Models\Admin;
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
        $cards = DB::select('SELECT * FROM company_cards');

        $companyDistinct = Company::all();
            $companies = $companyDistinct->unique('company_name');
        $data = ['LoggedUserInfo'=> Admin::where('id','=', Session('LoggedUser'))->first()];
        return view('card.select', compact('data','companies','cards'));   
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

        if(!$adminInfo){
            return back()->with('fail', 'we dont recongnize your email address');
        }else{
            if(Hash::check($request->password, $adminInfo->password)){
                $request->session()->put('LoggedUser', $adminInfo->id);
                return redirect()->route('index');
            }
            
            return back()->with('fail', 'incorrect password');
        
        }
    }


}
