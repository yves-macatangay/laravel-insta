<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function __construct(User $user){
        $this->user = $user;
    }
    public function run(): void
    {
        $users = [
            [
                'name' => 'Ed',
                'email' => 'e@mail.com',
                'password' => Hash::make('password'),
                'role_id' => 1,
                'updated_at' => NOW(),
                'created_at' => NOW()
            ],
            [
                'name' => 'Fate',
                'email' => 'f@mail.com',
                'password' => Hash::make('password'),
                'role_id' => 2,
                'updated_at' => NOW(),
                'created_at' => NOW()
            ],
            [
                'name' => 'Gigi',
                'email' => 'g@mail.com',
                'password' => Hash::make('password'),
                'role_id' => 2,
                'updated_at' => NOW(),
                'created_at' => NOW()
            ]
        ];

        $this->user->insert($users);
    }
}
