<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\PermissionsTableSeeder;
use Database\Seeders\RolesTableSeeder;
use Database\Seeders\PermissionRoleTableSeeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\RoleUserTableSeeder;
use Database\Seeders\CategoriesTableSeeder;
use Database\Seeders\StatusesTableSeeder;
use Database\Seeders\ModelTableSeeder;
use Database\Seeders\PrioritiesTableSeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class,
            UsersTableSeeder::class,
            RoleUserTableSeeder::class,
            // CategoriesTableSeeder::class,
            StatusesTableSeeder::class,
            ModelTableSeeder::class,
            PrioritiesTableSeeder::class,
        ]);
    }
}
