
<?php

use Illuminate\Database\Seeder;

class AdminAuth extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_auth')->insert([
        	'email'=>'admin@smartpharmacy.com',
        	'password'=>Hash::make('smartpass'),
        	'level'=>'admin'
        ]);
    }
}
