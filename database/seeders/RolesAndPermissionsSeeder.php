<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // clear cache spatie
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        /*
        |-----------------------------
        | PERMISSIONS
        |-----------------------------
        */
        $permissions = [
            // tickets
            'tickets.create',
            'tickets.view',
            'tickets.update',
            'tickets.delete',
            'tickets.assign',
            'tickets.comment',

            // departments
            'departments.manage',

            // users
            'users.manage',

            // sla
            'sla.manage',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        /*
        |-----------------------------
        | ROLES
        |-----------------------------
        */
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $supervisor = Role::firstOrCreate(['name' => 'supervisor']);
        $agent = Role::firstOrCreate(['name' => 'agent']);
        $requester = Role::firstOrCreate(['name' => 'requester']);

        /*
        |-----------------------------
        | ASSIGN PERMISSIONS
        |-----------------------------
        */

        // ADMIN → ALL ACCESS
        $admin->givePermissionTo(Permission::all());

        // SUPERVISOR
        $supervisor->givePermissionTo([
            'tickets.view',
            'tickets.assign',
            'tickets.update',
            'tickets.comment',
            'sla.manage',
        ]);

        // AGENT
        $agent->givePermissionTo([
            'tickets.view',
            'tickets.update',
            'tickets.comment',
        ]);

        // REQUESTER
        $requester->givePermissionTo([
            'tickets.create',
            'tickets.view',
        ]);
    }
}
