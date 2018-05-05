<?php
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
	public function run()
	{
		$faker = Faker\Factory::create();
// for($i = 0; $i < 10; $i++) {
// 	App\NormalReference::create([
// 		'type_id' =>'1',
// 		'patient_id' =>'1',
// 		'normal.upper_limit' => '100',
// 		'normal.lower_limit' => '1',
// 		'created_at' => Carbon\Carbon::now() ,
// 		'updated_at' => Carbon\Carbon::now()
// 	]);
// }
		App\Type::create([
			'name' =>'Oxymeter',
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
			'name' =>'Thermometer',
			'description' => 'seeded',
			'created_at' => Carbon\Carbon::now() ,
			'updated_at' => Carbon\Carbon::now()
		]);
		for($i = 0; $i < 10; $i++) {
			App\Location::create([
				'name' =>$i ,
				'description' => 'seeded',
				'created_at' => Carbon\Carbon::now() ,
				'updated_at' => Carbon\Carbon::now()
			]);
		}
// for($i = 0; $i < 10; $i++) {
// 	App\Patient::create([
// 		'unit_id' =>$i,
// 		'first_name' => $faker->firstName,
// 		'middle_name'=>$faker->lastName,
// 		'last_name'=>$faker->lastName,
// 		'gender'=> 'male',
// 		'age'=>18,
// 		'location_id' =>$i,
// 		'home_address' =>$faker->streetAddress,
// 		'contact_number'=>$faker->phoneNumber,
// 		'contact_person' => $faker->firstName,
// 		'is_active' => 0,
// 		'is_archive'  => 0,
// 		'comment' => 'seeded',
// 		'created_at' => Carbon\Carbon::now() ,
// 		'updated_at' => Carbon\Carbon::now()
// 	]);
// }

		App\Unit::create([
			'label' => 'Working Unit 1',
			'mac_address'=> '5C:CF:7F:A4:83:5A',
			'unit_is_active'=> 1,
			'unit_is_inuse'=> 0,
			'oximeter_is_active'=>  1,
			'bp_is_active'=>  1,
			'thermometer_is_active'=> 1,
			'oximeter_delay'=> 1000,
			'bp_delay' => 1000,
			'thermometer_delay' => 1000,
			'created_at' => Carbon\Carbon::now() ,
			'updated_at' => Carbon\Carbon::now()
		]);
		App\Unit::create([
			'label' => 'Unit 1',
			'mac_address'=> 'ff:ff:ff:ff:ff:bb',
			'unit_is_active'=> 1,
			'unit_is_inuse'=> 0,
			'oximeter_is_active'=>  0,
			'bp_is_active'=>  0,
			'thermometer_is_active'=> 0,
			'oximeter_delay'=> 1000,
			'bp_delay' => 1000,
			'thermometer_delay' => 1000,
			'created_at' => Carbon\Carbon::now() ,
			'updated_at' => Carbon\Carbon::now()
		]);
		App\Unit::create([
			'label' => 'Unit 2',
			'mac_address'=> 'ff:ff:ff:ff:ff:aa',
			'unit_is_active'=> 1,
			'unit_is_inuse'=> 0,
			'oximeter_is_active'=>  0,
			'bp_is_active'=>  0,
			'thermometer_is_active'=> 0,
			'oximeter_delay'=> 1000,
			'bp_delay' => 1000,
			'thermometer_delay' => 1000,
			'created_at' => Carbon\Carbon::now() ,
			'updated_at' => Carbon\Carbon::now()
		]);
		App\Unit::create([
			'label' => 'Unit 3',
			'mac_address'=> 'ff:ff:ff:ff:ff:cc',
			'unit_is_active'=> 1,
			'unit_is_inuse'=> 0,
			'oximeter_is_active'=>  0,
			'bp_is_active'=>  0,
			'thermometer_is_active'=> 0,
			'oximeter_delay'=> 1000,
			'bp_delay' => 1000,
			'thermometer_delay' => 1000,
			'created_at' => Carbon\Carbon::now() ,
			'updated_at' => Carbon\Carbon::now()
		]);
		App\Unit::create([
			'label' => 'Unit 4',
			'mac_address'=> 'ff:ff:ff:ff:ff:dd',
			'unit_is_active'=> 1,
			'unit_is_inuse'=> 0,
			'oximeter_is_active'=>  0,
			'bp_is_active'=>  0,
			'thermometer_is_active'=> 0,
			'oximeter_delay'=> 1000,
			'bp_delay' => 1000,
			'thermometer_delay' => 1000,
			'created_at' => Carbon\Carbon::now() ,
			'updated_at' => Carbon\Carbon::now()
		]);
		App\Unit::create([
			'label' => 'Unit 5',
			'mac_address'=> 'ff:ff:ff:ff:ff:ee',
			'unit_is_active'=> 1,
			'unit_is_inuse'=> 0,
			'oximeter_is_active'=>  0,
			'bp_is_active'=>  0,
			'thermometer_is_active'=> 0,
			'oximeter_delay'=> 1000,
			'bp_delay' => 1000,
			'thermometer_delay' => 1000,
			'created_at' => Carbon\Carbon::now() ,
			'updated_at' => Carbon\Carbon::now()
		]);
		App\Unit::create([
			'label' => 'Unit 6',
			'mac_address'=> 'ff:ff:ff:ff:ff:ff',
			'unit_is_active'=> 1,
			'unit_is_inuse'=> 0,
			'oximeter_is_active'=>  0,
			'bp_is_active'=>  0,
			'thermometer_is_active'=> 0,
			'oximeter_delay'=> 1000,
			'bp_delay' => 1000,
			'thermometer_delay' => 1000,
			'created_at' => Carbon\Carbon::now() ,
			'updated_at' => Carbon\Carbon::now()
		]);
		App\User::create([
			'email' =>'admin@local.io',
			'password' => bcrypt('banana'),
			'first_name' => 'admin',
			'middle_name'=>'admin',
			'last_name'=>'admin',
			'contact_number'=>$faker->phoneNumber,
			'comment'=> "seeded",
			'remember_token'=>0,
			'created_at' => Carbon\Carbon::now() ,
			'updated_at' => Carbon\Carbon::now()
		]);
		App\User::create([
			'email' =>'developer@local.io',
			'password' => bcrypt('banana'),
			'first_name' => 'developer',
			'middle_name'=>'developer',
			'last_name'=>'developer',
			'contact_number'=> $faker->phoneNumber,
			'comment'=> "seeded",
			'remember_token'=>0,
			'created_at' => Carbon\Carbon::now() ,
			'updated_at' => Carbon\Carbon::now()
		]);
		App\User::create([
			'email' =>'observer@local.io',
			'password' => bcrypt('banana'),
			'first_name' => 'observer',
			'middle_name'=>'observer',
			'last_name'=>'observer',
			'contact_number'=>$faker->phoneNumber,
			'comment'=> "seeded",
			'remember_token'=>0,
			'created_at' => Carbon\Carbon::now() ,
			'updated_at' => Carbon\Carbon::now()
		]);
		App\UserRole::create([
			'user_id'=> '1',
			'role_id'=> '1',
		'created_at' => Carbon\Carbon::now() ,
			'updated_at' => Carbon\Carbon::now()
		]);
		// App\UserRole::create([
		// 	'user_id'=> 1,
		// 	'role_id'=> 2,
		// 	'created_at' => Carbon\Carbon::now() ,
		// 	'updated_at' => Carbon\Carbon::now()
		// ]);
		// App\UserRole::create([
		// 	'user_id'=> 1,
		// 	'role_id'=> 3,
		// 	'created_at' => Carbon\Carbon::now() ,
		// 	'updated_at' => Carbon\Carbon::now()
		// ]);
		// App\UserRole::create([
		// 	'user_id'=> 1,
		// 	'role_id'=> 4,
		// 	'created_at' => Carbon\Carbon::now() ,
		// 	'updated_at' => Carbon\Carbon::now()
		// ]);
		// App\UserRole::create([
		// 	'user_id'=> 1,
		// 	'role_id'=> 5,
		// 	'created_at' => Carbon\Carbon::now() ,
		// 	'updated_at' => Carbon\Carbon::now()
		// ]);
		App\Role::create([
			'title'=> 'Observer',
			'description'=> 'Can Observe patient',
			'created_at' => Carbon\Carbon::now() ,
			'updated_at' => Carbon\Carbon::now()
		]);
		App\Role::create([
			'title'=> 'developer',
			'description'=> 'developer full access mode',
			'created_at' => Carbon\Carbon::now() ,
			'updated_at' => Carbon\Carbon::now()
		]);
		App\Role::create([
			'title'=> 'Administrator',
			'description'=> 'admin Access Mode',
			'created_at' => Carbon\Carbon::now() ,
			'updated_at' => Carbon\Carbon::now()
		]);
		App\Role::create([
			'title'=> 'Editor',
			'description'=> 'Can modify',
			'created_at' => Carbon\Carbon::now() ,
			'updated_at' => Carbon\Carbon::now()
		]);
		App\Role::create([
			'title'=> 'Cleaner',
			'description'=> 'Can delete',
			'created_at' => Carbon\Carbon::now() ,
			'updated_at' => Carbon\Carbon::now()
		]);
	}
}
