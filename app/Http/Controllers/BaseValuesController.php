<?php
namespace App\Http\Controllers;

use App\Models\ExchangeRate; 
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\PDO;
use Carbon\Carbon;
use DB;

class LatestRatesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
  
    public function setbasevalues( )
    {
         //Use PDO for data manipulation
        //$db = DB::connection()->getPdo();
        //$this->db =$db;
        $this->info = 'Fetching data from exchangerate-api.com';
        $this->currencies = ['USD', 'GBP', 'JPY', 'EUR', 'CHF', 'CAD', 'ZAR', 'AED'];
        $this->baseCurrency = 'EUR';       
        $this-> description = 'The exchange rate information has been updated using the latest 
        information from exchangerate-api: ';
    }
    
    
    
}
