<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;

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

        DB::table('users')->delete();

        $users = array(
                ['name' => 'Jeremy Smith', 'email' => 'jsmith@geemail.com', 'pass' => Hash::make('secret'), 'phone' => '5013217788', 'address1' => '1 Dirt Rd Way', 'address2' => '', 'city' => 'Romance', 'state' => 'AR', 'zipcode' => '72136', 'country' => 'USA'],
                ['name' => 'Chris Gnome', 'email' => 'gnome@geemail.com', 'pass' => Hash::make('secret'), 'phone' => '2132224567', 'address1' => '313 Steel Rd', 'address2' => 'Unit 100', 'city' => 'Penciltucky', 'state' => 'PA', 'zipcode' => '47898', 'country' => 'USA'],
                ['name' => 'Henry Tudor', 'email' => 'henryt@geemail.com', 'pass' => Hash::make('secret'), 'phone' => '9545555001', 'address1' => '615 Washington St.', 'address2' => 'Apt 2', 'city' => 'Rollywood', 'state' => 'FL', 'zipcode' => '33333', 'country' => 'USA']
                
        );
            
        // Loop through each user above and create the record for them in the database
        foreach ($users as $user)
        {
            User::create($user);
        }

        Model::reguard();
    }
}
