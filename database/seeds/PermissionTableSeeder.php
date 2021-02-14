<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            $permissions = [
                'user-list',
                'user-create',
                'user-edit',
                'user-disable',
                'role-list',
                'role-create',
                'role-edit',
                'role-delete',
                'article-list',
                'article-create',
                'article-edit',
                'article-delete'
            ];

            foreach ($permissions as $permission) {
                Permission::create(['name' => $permission]);
            }
        }
    }
}
