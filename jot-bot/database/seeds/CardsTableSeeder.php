<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Cards;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('cards')->delete();
/*
        uid INT(11) NOT NULL,
        CardName VARCHAR(255) NOT NULL,
        CardNumber VARCHAR(50) NOT NULL,
        acquiringBin VARCHAR(30) NOT NULL,
        acquirerCountryCode INT(5) NOT NULL,
        expirationData VARCHAR(15) NOT NULL,
        currencyCode INT(5) NOT NULL,
*/
        $cards = array(
                ['uid' => 1, 'CardName' => 'John Smith', 'CardNumber' => '4805070000000002', 'acquiringBin' => '408999', 'acquirerCountryCode' => '840', 'expirationData' => '2020-03', 'currencyCode' => '840'],
                ['uid' => 2, 'CardName' => 'Jacob Smith', 'CardNumber' => '4815070000000018', 'acquiringBin' => '408999', 'acquirerCountryCode' => '840', 'expirationData' => '2020-03', 'currencyCode' => '840'],
                ['uid' => 3, 'CardName' => 'Joseph Smith', 'CardNumber' => '4835070000000014', 'acquiringBin' => '408999', 'acquirerCountryCode' => '840', 'expirationData' => '2020-03', 'currencyCode' => '840']
                
        );
            
        // Loop through each user above and create the record for them in the database
        foreach ($cards as $card)
        {
            User::create($card);
        }

        Model::reguard();
    }
}
