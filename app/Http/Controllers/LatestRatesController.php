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
  
    public function __construct( )
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
    public function getdata()
    {
        
        echo $this->info;
        // We are using cURL to call the exchangerate-api and fetch the data
        $cURLConnection = curl_init();

        //Calling the Exchange rates API     
        curl_setopt($cURLConnection, CURLOPT_URL, 'https://v6.exchangerate-api.com/v6/'.env('EXCHANGE_RATES_API_KEY') .'/latest/EUR');
    
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
        
        $exchangerateInfo = curl_exec($cURLConnection);

        curl_close($cURLConnection);

        $response = json_decode($exchangerateInfo, true);
    
        $saveddata = [];
        $newdata="";
        // If we get a valid response
        if ( $response !== null && $response['result'] === "success") {
                    
            $conversions =  $response['conversion_rates'];

            foreach($conversions as $cur => $rate) {

                //Find previous rates using EUR as base currency
                $previous = ExchangeRate::where('from_currency', $this->baseCurrency)
                        ->where('to_currency', $cur)
                        ->whereNull('until')->get()->first();

                // Set the until date if a previous value exists. 
                if(!is_null($previous)){
                    $previous->until = Carbon::now();
                    $previous->updated_at = Carbon::now();
                    $previous->save();
                }
                            
                // Save the new records from the selected currencies              
                if (in_array($cur, $this->currencies)) {
                
                    $new = new ExchangeRate;     
                    $new  -> from_currency = $this->baseCurrency;
                    $new  -> to_currency =  $cur;
                    $new  -> rate = $rate;  
                    $new  -> since = Carbon::now();
                    $new  -> save();

                    $newdata  = $newdata.Carbon::now() . 
                    ' The new convertion rate from ' . $new ->from_currency . 
                    ' to ' . $new ->to_currency . 
                    ' is ' . $new ->rate . 
                    ' available at ' .  $new ->since;
                }                           
            }         
            return response()->json([
                'rates' => $this-> description .$newdata            
            ], 200);
        } 
    }  
    
    public function getonecurrentrate($currencycode){        
        if (!in_array($currencycode, $this->currencies)) {
            return response()->json([
                'Error: ' => 'Invalid currency code'           
            ], 200);
        } 
        //Get current rate for a given currency code
        $currentrate = ExchangeRate::select('rate')->where('from_currency', $this->baseCurrency)
                ->where('to_currency', $currencycode)
                ->whereNull('until')->get()->first();

        return response()->json([
            'The current : '.$this->baseCurrency.' to '.$currencycode. ' rate is 1.00 to ' => $currentrate->rate
        ], 200);

    }
}
