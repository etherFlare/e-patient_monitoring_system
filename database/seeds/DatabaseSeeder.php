<?php
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
	public function run()
	{
		$faker = Faker\Factory::create();
		for($i = 0; $i < 10; $i++) {
			App\NormalReference::create([
				'type_id' =>'1',
				'patient_id' =>'1',
				'normal.upper_limit' => '100',
				'normal.lower_limit' => '1',
				'created_at' => Carbon\Carbon::now() ,
				'updated_at' => Carbon\Carbon::now()
			]);
		}
		App\Type::create([
			'name' =>'oxymeter',
			'description' => 'seeded',
			'created_at' => Carbon\Carbon::now() ,
			'updated_at' => Carbon\Carbon::now()
		]);
		App\Type::create([
			'name' =>'Sphygmomanometer',
			'description' => 'seeded',
			'created_at' => Carbon\Carbon::now() ,
			'updated_at' => Carbon\Carbon::now()
		]);
		App\Type::create([
			'name' =>'temperature',
			'description' => 'seeded',
			'created_at' => Carbon\Carbon::now() ,
			'updated_at' => Carbon\Carbon::now()
		]);
		for($i = 0; $i < 10; $i++) {
			App\Location::create([
				'name' =>'room no $i',
				'description' => 'seeded',
				'created_at' => Carbon\Carbon::now() ,
				'updated_at' => Carbon\Carbon::now()
			]);
		}
		for($i = 0; $i < 10; $i++) {
			App\Patient::create([
				'unit_id' =>$i,
				'first_name' => $faker->firstName,
				'middle_name'=>$faker->lastName,
				'last_name'=>$faker->lastName,
				'gender'=> 'male',
				'age'=>18,
				'location_id' =>$i,
				'home_address' =>$faker->streetAddress,
				'contact_number'=>$faker->phoneNumber,
				'contact_person' => $faker->firstName,
				'is_active' => 0,
				'is_archive'  => 0,
				'comment' => 'seeded',
				'created_at' => Carbon\Carbon::now() ,
				'updated_at' => Carbon\Carbon::now()
			]);
		}
		for($i = 0; $i < 10; $i++) {
			App\Unit::create([
				'label' => 'samplex',
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
