<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Raihan Herdiansyah',
                'username' => 'raihan_hersyh_',
                'password' => bcrypt('raihansyh!!')
            ],
            [
                'name' => 'Trisna Aji Kusuma',
                'username' => 'trisna_aji_18',
                'password' => bcrypt('trisna_aji_18!!#'),
                'avatar' => 'users/icon1.png'
            ],
            [
                'name' => 'Dinda Novianti',
                'username' => 'dindaVia58',
                'password' => bcrypt('dindaVia58??'),
                'avatar' => 'users/icon5.png'
            ]
        ];

        foreach($data as $user){
            User::create($user);
        }
    }
}
