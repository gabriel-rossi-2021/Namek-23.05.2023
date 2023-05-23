<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoginsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // CREATION USER
        $logins = new User();
        $logins->last_name="Administrateur";
        $logins->first_name="Admin";
        $logins->title="Monsieur";
        $logins->birth_date='2004-04-29';
        $logins->phone_number= 788237818;
        $logins->username= "admin";
        $logins->email= "admin@namek.ch";
        $logins->password= "Admin2023i;151-120#";
        $logins->function_id=1;
        $logins->address_id=1;
        $logins->getRememberToken();
        $logins->save();

        // CREATION USER
        $logins = new User();
        $logins->last_name="Faris";
        $logins->first_name="Stéphanie";
        $logins->title="Madame";
        $logins->birth_date='2001-09-09';
        $logins->phone_number= 765657364;
        $logins->username= "fsteph";
        $logins->email= "fsteph@namek.ch";
        $logins->password= "alpha-1i;151-120#";
        $logins->function_id=3;
        $logins->address_id=2;
        $logins->getRememberToken();
        $logins->save();

        // COMPTE ADMIN POUR LE PROF
        // CREATION USER
        $logins = new User();
        $logins->last_name="Rogeiro";
        $logins->first_name="Angelo";
        $logins->title="Monsieur";
        $logins->birth_date='1971-03-14';
        $logins->phone_number= 776546352;
        $logins->username= "rogeiro2023";
        $logins->email= "angelo.rogeiro@eduvaud.ch";
        $logins->password= "arogeiroi;151-120#";
        $logins->function_id=1;
        $logins->address_id=3;
        $logins->getRememberToken();
        $logins->save();
    }
}
