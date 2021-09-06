<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function company_cards(){
        return $this->hasMany('App\Models\CompanyCard');
    }
}
