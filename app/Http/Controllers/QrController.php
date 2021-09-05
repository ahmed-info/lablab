<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrController extends Controller
{
    public function index()
    {
        //Hash::make($value)
        // $qrs = QrCode::encoding('UTF-8')->generate(Hash::make('احمد'));
         
        // return view('card.index', compact('qrs'));
    }
}
