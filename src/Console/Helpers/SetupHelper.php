<?php

namespace Magicbox\LaraQuickKit\Console\Helpers;

use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class SetupHelper
{
    public static function displayMagicBanner()
    {
        echo PHP_EOL;
        echo '*********************************************' . PHP_EOL;
        echo '*                                           *' . PHP_EOL;
        echo '*               🎩 MAGIC BOX                *' . PHP_EOL;
        echo '*               ┌───────────┐               *' . PHP_EOL;
        echo '*               │  WELCOME  │               *' . PHP_EOL;
        echo '*               │    TO     │               *' . PHP_EOL;
        echo '*               │   MAGIC!  │               *' . PHP_EOL;
        echo '*               └───────────┘               *' . PHP_EOL;
        echo '*                                           *' . PHP_EOL;
        echo '*********************************************' . PHP_EOL;
        echo PHP_EOL;
    }

    public static function createModuleRolesAndPermissions($module)
    {
        echo "Creating roles and permissions for the $module module..." . PHP_EOL;

        $rolesAndPermissions = self::getModuleRolesAndPermissions($module);

        foreach ($rolesAndPermissions as $role => $permissions) {
            $roleInstance = Role::firstOrCreate(['name' => $role]);

            foreach ($permissions as $permission) {
                $permissionInstance = Permission::firstOrCreate(['name' => $permission]);
                $roleInstance->givePermissionTo($permissionInstance);
            }
        }

        echo "$module roles and permissions created." . PHP_EOL;
    }

    public static function createDefaultUsers()
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'Admin',
            ],
            [
                'name' => 'User',
                'email' => 'user@example.com',
                'password' => Hash::make('password'),
                'role' => 'User',
            ],
        ];

        foreach ($users as $userData) {
            $user = \Magicbox\LaraQuickKit\Models\User::create($userData);
            $user->assignRole($userData['role']);

        }

        echo "Default users created." . PHP_EOL;
    }

    public static function getDefaultUserCredentials()
    {
        return [
            ['Admin', 'admin@example.com', 'password', 'Admin'],
            ['User', 'user@example.com', 'password', 'User'],
        ];
    }

    public static function getModuleRolesAndPermissions($module)
    {
        $modulesConfig = [
            'Inventory' => [
                'Admin' => ['inventory.view', 'inventory.manage'],
                'Manager' => ['inventory.view'],
                'Staff' => ['inventory.add', 'inventory.update'],
            ],
            'Sales' => [
                'Admin' => ['sales.view', 'sales.manage'],
                'Salesperson' => ['sales.add', 'sales.update'],
            ],
            'CRM' => [
                'Admin' => ['crm.view', 'crm.manage'],
                'Agent' => ['crm.view', 'crm.update'],
            ],
        ];

        return $modulesConfig[$module] ?? [];
    }

    public static function displayThankYouCharacter()
    {
        echo PHP_EOL;
        echo '*********************************************' . PHP_EOL;
        echo '*                                           *' . PHP_EOL;
        echo '*  🎩 Thank you for using LaraQuickKit!     *' . PHP_EOL;
        echo '*  😊 We hope you enjoy our magic!          *' . PHP_EOL;
        echo '*                                           *' . PHP_EOL;
        echo '*       ┌──────┐                            *' . PHP_EOL;
        echo '*      (  °  °  )                           *' . PHP_EOL;
        echo '*       ╰──────╯                            *' . PHP_EOL;
        echo '*********************************************' . PHP_EOL;
        echo PHP_EOL;
    }
    public static function copyPermissionConfig()
    {
        $source = __DIR__ . '/../../vendor/spatie/laravel-permission/config/permission.php';  // Path ke file permission.php di vendor
        $destination = base_path('config/permission.php');  // Tujuan penyalinan ke dalam config di Laravel

        if (!File::exists($destination)) {
            File::copy($source, $destination);  // Menyalin file konfigurasi
            echo "permission.php config file copied." . PHP_EOL;
        }
    }
}
