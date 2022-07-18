<?php
namespace App\Http\Controllers;
use BaseValuesController;
use App\Models\ExchangeRate; 
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\PDO;
use Carbon\Carbon;
use DB;
use DateTime;

class RatesWithDatesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
  
    public function __construct( )
    {
         $this->info = 'Data stored ';
        $this->currencies = ['USD', 'GBP', 'JPY', 'EUR', 'CHF', 'CAD', 'ZAR', 'AED'];
        $this->baseCurrency = 'EUR';  
    }
    
    public function getbetweendates($from, $to){       

        //Check that the dates are valid
        if (!strtotime($from)) {
            return response()->json([
                'Error: ' => 'The date from is invalid'
            ], 200);            
        }         
        if (!strtotime($to)) {
            return response()->json([
                'Error: ' => 'The date to is invalid'
            ], 200);            
        } 
        //Check that date is in right format
        if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$from)) {
            return response()->json([
                'Error: ' => 'The date from is not in the right format use YYYY-MM-DD'
            ], 200);
        }      
        //filter with dates given
        $from = date($from).' 00:00:00'; 
        $to = date($to).' 00:00:00'; 

        $betweendates = ExchangeRate::select('to_currency', 'rate')->whereDate('since', '>=', $from)
        ->whereDate('until', '<=', $to)->where('to_currency', '!=' , $this->baseCurrency)->get(); 

        return response()->json([
            'Exchange rates to Euro: ' => $betweendates
        ], 200);

    }
    public function getyesterday(){
         
        
        $yesterday = Carbon::yesterday();
        $yesterday = date($yesterday).' 00:00:00'; 
        $rateyesterday = ExchangeRate::select('to_currency', 'rate')->whereDate('since', '=', $yesterday)
        ->where('to_currency', '!=' , $this->baseCurrency)->get(); 

        return response()->json([
            'Exchange rates to Euro yesterday: ' => $rateyesterday
        ], 200);

       
    }


}