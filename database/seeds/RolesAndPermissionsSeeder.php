<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'CREATE_POST']);
        Permission::create(['name' => 'DELETE_POST']);
        Permission::create(['name' => 'LIKE']);
        Permission::create(['name' => 'COMMENT']);
        Permission::create(['name' => 'CREATE_GROUP']);
        Permission::create(['name' => 'JOIN_GROUP']);
        Permission::create(['name' => 'MANAGE_CONTENT']);
        Permission::create(['name' => 'MANAGE_USER']);

        // create roles and assign created permissions

        // this can be done as separate statements
        $role = Role::create(['name' => 'MEMBER']);
        $role->givePermissionTo('CREATE_POST', 'DELETE_POST', 'LIKE', 'COMMENT', 'CREATE_GROUP', 'JOIN_GROUP');

        // or may be done by chaining
        $role = Role::create(['name' => 'MODERATOR'])
            ->givePermissionTo(['MANAGE_CONTENT']);

        $role = Role::create(['name' => 'SUPER_ADMIN']);
        $role->givePermissionTo(Permission::all());
    }
}
