<?php declare(strict_types=1); 

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $perms = [
            'books.create', 'books.update', 'books.delete',
            'chapters.create', 'chapters.update', 'chapters.delete',
        ];
        foreach ($perms as $name) {
            Permission::findOrCreate($name);
        }

        $superAdmin = Role::findOrCreate('super-admin');
        $admin = Role::findOrCreate('admin');
        $user = Role::findOrCreate('user');

        $superAdmin->givePermissionTo(Permission::all());
        $admin->givePermissionTo(['books.create','books.update','chapters.create','chapters.update']);
    }
}
