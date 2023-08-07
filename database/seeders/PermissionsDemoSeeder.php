<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'Create']);
        Permission::create(['name' => 'Read']);
        Permission::create(['name' => 'Edit']);
        Permission::create(['name' => 'South Region Access']);
        Permission::create(['name' => 'North Region Access']);
        Permission::create(['name' => 'Full Access']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'Credit Officer']);
        $role1->givePermissionTo('Create');
        $role1->givePermissionTo('Read');

        $role2 = Role::create(['name' => 'Branch Manager']);
        $role2->givePermissionTo('Create');
        $role2->givePermissionTo('Read');
        $role2->givePermissionTo('Edit');

        $role3 = Role::create(['name' => 'South Regional MIS Officer']);
        $role3->givePermissionTo('Read');
        $role3->givePermissionTo('Edit');
        $role3->givePermissionTo('South Region Access');


        $role6 = Role::create(['name' => 'North Regional MIS Officer']);
        $role6->givePermissionTo('Read');
        $role6->givePermissionTo('Edit');
        $role6->givePermissionTo('North Region Access');


        $role4 = Role::create(['name' => 'Head Office']);
        $role4->givePermissionTo('Read');
        $role4->givePermissionTo('Edit');

        $role5 = Role::create(['name' => 'Super-Admin']);
        $role5->givePermissionTo('Create');
        $role5->givePermissionTo('Read');
        $role5->givePermissionTo('Edit');
        $role5->givePermissionTo('Full Access');
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'Ali Raza Marchal',
            'email' => 'kh.marchal@gmail.com',
            'designation' => 'Administrator',
            'password' => Hash::make('123456789'),
        ]);
        $user->assignRole($role5);


        $user = \App\Models\User::factory()->create([
            'name' => 'Credit Officer',
            'email' => 'creditofficer@gmail.com',
            'designation' => 'Credit Officer',
            'password' => Hash::make('123456789'),
        ]);
        $user->assignRole($role1);

        $user = \App\Models\User::factory()->create([
            'name' => 'Branch Manager',
            'email' => 'branchmanager@gmail.com',
            'designation' => 'Branch Manager',
            'password' => Hash::make('123456789'),
        ]);
        $user->assignRole($role2);

        $user = \App\Models\User::factory()->create([
            'name' => 'South Regional MIS Officer',
            'email' => 'southregionalmisofficer@gmail.com',
            'designation' => 'South Regional MIS Officer',
            'password' => Hash::make('123456789'),
        ]);
        $user->assignRole($role3);


        $user = \App\Models\User::factory()->create([
            'name' => 'North Regional MIS Officer',
            'email' => 'northregionalmisofficer@gmail.com',
            'designation' => 'North Regional MIS Officer',
            'password' => Hash::make('123456789'),
        ]);
        $user->assignRole($role6);



        $user = \App\Models\User::factory()->create([
            'name' => 'Head Office',
            'email' => 'headoffice@gmail.com',
            'designation' => 'Head Office',
            'password' => Hash::make('123456789'),
        ]);
        $user->assignRole($role4);

    }
}
