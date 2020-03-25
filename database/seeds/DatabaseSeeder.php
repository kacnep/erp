<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Role;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('users')->truncate();
        DB::table('roles')->truncate();
        DB::table('role_user')->truncate();

        $roleAdmin = Role::create(['role' => 'Admin']);
        $roleUser = Role::create(['role' => 'User']);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.loc',
            'password' => Hash::make('secret'),
        ]);
        $admin->roles()->save($roleUser);
        $admin->roles()->save($roleAdmin);

        $user = User::create([
            'name' => 'User',
            'email' => 'user@user.loc',
            'password' => Hash::make('secret')
        ]);
        $user->roles()->save($roleUser);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
