<?php

namespace App\Http\Controllers;

use App\Exports\CardsExport;
use App\Models\CompanyCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports;
use App\Imports\CardsImport;
use App\Imports\CompaniesImport;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Maatwebsite\Excel\Excel as exl;

class CompanyCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $method = $request->method();

        if ($request->isMethod('post'))
        {
            $from = $request->input('from');
            if ($request->has('search'))
            {
                // select search
                $cards = DB::select("SELECT * FROM company_cards WHERE company_name = '$from'");
                $companyDistinct = Company::all();
                $companies = $companyDistinct->unique('company_name');

                //return $cards;

                return view('card.select',compact('cards', 'companies'));
            } 


            elseif($request->has('exportExcel'))
                        
                // select Excel
            return Excel::download(new CardsExport($from), 'Excel-reports.xlsx');
            {
        } 
        }
        else
        {
            //select all
            $cards = DB::select('SELECT * FROM company_cards');
            $companies = Company::all();

            return view('card.select',['cards' => $cards, 'companies' => $companies]);
        }
        $cards = CompanyCard::paginate();
        $company = Company::all();
        $companyDistinct = Company::all();
        $companies = $companyDistinct->unique('company_name');
        return view('card.index', compact('cards','companies'));

    }

    public function select($id)
    {
        $cards = CompanyCard::where('company_id','=', $id)->get();

        $companyDistinct = Company::all();
        $companies = $companyDistinct->unique('company_name');

        return view('card.select', compact('cards','companies'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        $ext_xlsx = Excel::download(new CardsExport, 'card-'.date('Y-m-d').'.xlsx', \Maatwebsite\Excel\Excel::XLSX);
        $ext_xls =  Excel::download(new CardsExport, 'card-'.date('Y-m-d').'.xls', \Maatwebsite\Excel\Excel::XLS);
        if($ext_xlsx){
            return $ext_xlsx;
        }

        if($ext_xls){
            return $ext_xls;
        }
    }

    public function upload()
    {
        
        $cards = CompanyCard::all();
        $companyDistinct = Company::all();
        $companies = $companyDistinct->unique('company_name');
        return view('card.upload', compact('companies','cards'));
    }

    public function import(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'attachment'=>'required|mimes:xlsx,xls',
        ]);

         if($validation->fails()){
             return redirect()->back()->withErrors($validation)->withInput();
         }
        $file = $request->file('attachment');
        $fileCompany = $request->file('attachment');
        //queueImport
        Excel::import(new CompaniesImport(), $fileCompany);
        Excel::import(new CardsImport(), $file);

        return redirect()->route('card.index')->with([
           'message' => 'importing started successfully',
            'alert-type' =>'success'
        ]);
    }

    // public function search()
    // {
    //     $search_text = $_GET['query'];
    //     $cards = CompanyCard::where('company_name','LIKE','%'.$search_text.'%')->paginate();
    //     $companies = Company::all();

    //     return view('card.search', compact('cards','companies'));
    // }

    public function search()
    {
        $search_text = $_GET['query'];
        $cards = Company::where('company_name','LIKE','%'.$search_text.'%')->paginate();
        $companies = Company::all();

        return view('card.search', compact('cards','companies'));
    }
}
