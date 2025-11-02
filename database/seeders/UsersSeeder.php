<?php declare(strict_types=1); 

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pour SQLite, on désactive les contraintes de clés étrangères
        if (DB::connection()->getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF');
            DB::table('model_has_roles')->truncate();
            DB::table('users')->truncate();
            DB::statement('PRAGMA foreign_keys = ON');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            DB::table('model_has_roles')->truncate();
            DB::table('users')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }

        $superAdminId = DB::table('users')->insertGetId([
            'name' => 'Super Admin',
            'nickname' => 'Root',
            'email' => 'root@example.com',
            'password' => bcrypt('password'),
            'is_author' => true,
            'created_at'=>now(),'updated_at'=>now(),
        ]);
        $adminId = DB::table('users')->insertGetId([
            'name' => 'Admin',
            'nickname' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_author' => true,
            'created_at'=>now(),'updated_at'=>now(),
        ]);
        $author1Id = DB::table('users')->insertGetId([
            'name' => 'Jean Martin',
            'nickname' => 'Jean M.',
            'email' => 'jean@example.com',
            'password' => bcrypt('password'),
            'is_author' => true,
            'created_at'=>now(),'updated_at'=>now(),
        ]);
        $author2Id = DB::table('users')->insertGetId([
            'name' => 'Sophie Laurent',
            'nickname' => 'Sophie L.',
            'email' => 'sophie@example.com',
            'password' => bcrypt('password'),
            'is_author' => true,
            'created_at'=>now(),'updated_at'=>now(),
        ]);
        $userId = DB::table('users')->insertGetId([
            'name' => 'Marie Dubois',
            'nickname' => 'Marie D.',
            'email' => 'marie@example.com',
            'password' => bcrypt('password'),
            'is_author' => false,
            'created_at'=>now(),'updated_at'=>now(),
        ]);

        $superAdmin = Role::findOrCreate('super-admin');
        $admin = Role::findOrCreate('admin');
        $user = Role::findOrCreate('user');

        DB::table('model_has_roles')->insert([
            ['role_id'=>$superAdmin->id,'model_type'=>'App\Models\User','model_id'=>$superAdminId],
        ]);
        DB::table('model_has_roles')->insert([
            ['role_id'=>$admin->id,'model_type'=>'App\Models\User','model_id'=>$adminId],
        ]);
        foreach ([$author1Id,$author2Id,$userId] as $id) {
            DB::table('model_has_roles')->insert([
                'role_id'=>$user->id,'model_type'=>'App\Models\User','model_id'=>$id
            ]);
        }
    }
}
