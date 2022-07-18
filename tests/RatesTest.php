<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Carbon\Carbon;

class RatesTest extends TestCase
{
    /**
     * A few unit tests carried out.
     *
     * @return void
     */
    public function test_get_new_rates_code(){           
        $this->get("api/v2/newrates", []);
        $this->seeStatusCode(200); 
    }

    public function test_get_invalid_api_key_code(){           
        $this->get("api/v2/newrates", []);
        $this->seeStatusCode(404); 
    }
    public function test_check_invalid_date_from(){
        $from="23456e";
        $to = 2022-12-06;
        $this->json('GET', '/api/v2/betweendates/'.$from.'/'.$to,  [])
       ->seeJson([
        'Error: ' => 'The date from is invalid',
       ]);     
   }
   public function test_check_invalid_date_to(){
        $from= 2022-12-06;
        $to = "er0r";
        $this->json('GET', '/api/v2/betweendates/'.$from.'/'.$to,  [])
    ->seeJson([
        'Error: ' => 'The date to is invalid',
    ]);     
    }
    public function test_valid_dates(){
        $from= 2022-07-17;
        $to = 2022-07-18;
        $this->get('/api/v2/betweendates/'.$from.'/'.$to, []);
        $this->seeStatusCode(200);
    
    }
    public function test_valid_yesterday(){
        $from= 2022-07-17;
        $to = 2022-07-18;
        $this->get('/api/v2/betweendates/'.$from.'/'.$to, []);
        $this->seeStatusCode(200);
    
    }

    public function test_valid_dates_with_blank_results(){
        $from= 2021-07-17;
        $to = 2021-07-18;
        $this->get('/api/v2/betweendates/'.$from.'/'.$to, []);
        $this->seeStatusCode(200);
    
    }
}
