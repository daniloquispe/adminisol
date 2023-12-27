<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Database seeder for users.
 *
 * @author Danilo Quispe Lucana <dql@daniloquispe.dev>
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		User::create(['name' => 'Danilo', 'email' => 'dql@daniloquispe.dev', 'password' => '123456', 'email_verified_at' => now()]);
    }
}
