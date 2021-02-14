<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'رامین روزدار',
            'mobile' => '9337288808',
            'email' => 'raminroozdar@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        $role = Role::create(['name' => 'superAdmin']);
        $role2 = Role::create(['name' => 'admin']);
        $role3 = Role::create(['name' => 'employee']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
