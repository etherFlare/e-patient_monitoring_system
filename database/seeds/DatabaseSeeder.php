<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
       /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker = Faker\Factory::create();

	    for($i = 0; $i < 10; $i++) {
	        App\Unit::create([
	            'mac_address'=> $faker->macAddress,
	            'unit_is_active'=> $faker-> boolean ($chanceOfGettingTrue = 50),
	            'unit_is_inuse'=> $faker->boolean,
	            'oximeter_is_active'=>  $faker->boolean,
	            'bp_is_active'=>  $faker->boolean,
	            'thermometer_is_active'=>  $faker->boolean,
	            'oximeter_delay'=> $faker->randomDigit,
	            'bp_delay' => $faker->randomDigit,
	            'thermometer_delay' => $faker->randomDigit,
	            'created_at' => Carbon\Carbon::now() , 
	            'updated_at' => Carbon\Carbon::now()
	        ]);
	    }
	    for($i = 0; $i < 10; $i++) {
	        App\User::create([
		        'email' =>$faker->email, 
		        'password' => 1,
		        'first_name' => $faker->firstName,
		        'middle_name'=>$faker->lastName,
		        'last_name'=>$faker->lastName,
		        'contact_number'=>$faker->phoneNumber,
		        'comment'=> "seeded",
		        'remember_token'=>0,
		        'created_at' => Carbon\Carbon::now() , 
	            'updated_at' => Carbon\Carbon::now()
	        ]);
	    }

	        App\Role::create([
	            'title'=> 'Admin',
	            'description'=> 'Admin',
	            'created_at' => Carbon\Carbon::now() , 
	            'updated_at' => Carbon\Carbon::now()
	        ]);
	      App\Role::create([
	            'title'=> 'SuperAdmin',
	            'description'=> 'SuperAdmin',
	            'created_at' => Carbon\Carbon::now() , 
	            'updated_at' => Carbon\Carbon::now()
	        ]);
	       App\Role::create([
	            'title'=> 'Guest',
	            'description'=> 'Guest',
	            'created_at' => Carbon\Carbon::now() , 
	            'updated_at' => Carbon\Carbon::now()
	        ]);
	}
}
