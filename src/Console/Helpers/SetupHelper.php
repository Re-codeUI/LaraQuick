<?php

namespace Magicbox\LaraQuickKit\Console\Helpers;

use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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

    public static function installFrameworkUI($uiFramework)
    {
        if ($uiFramework === 'Bootstrap') {
            echo "Installing Bootstrap..." . PHP_EOL;
            exec('composer require laravel/ui');
            exec('php artisan ui bootstrap');
            exec('npm install && npm run dev');
            echo "Bootstrap installed successfully." . PHP_EOL;
        } elseif ($uiFramework === 'Tailwind') {
            echo "Installing Tailwind CSS..." . PHP_EOL;
            exec('composer require laravel-frontend-presets/tailwindcss');
            exec('php artisan preset tailwindcss');
            exec('npm install && npm run dev');
            echo "Tailwind CSS installed successfully." . PHP_EOL;
        } elseif ($uiFramework === 'Vue.js') {
            echo "Installing Vue.js..." . PHP_EOL;
            exec('composer require laravel/ui');
            exec('php artisan ui vue');
            exec('npm install && npm run dev');
            echo "Vue.js installed successfully." . PHP_EOL;
        }
    }

    public static function createModuleRoles($module)
    {
        echo "Creating roles and permissions for $module module..." . PHP_EOL;
        $roleName = $module . ' Manager';
        $role = Role::create(['name' => $roleName]);
        $permission = Permission::create(['name' => strtolower($module) . '.manage']);
        $role->givePermissionTo($permission);
        echo "$module roles and permissions created." . PHP_EOL;
    }

    public static function createDefaultUsers()
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ])->assignRole('Admin');

        \App\Models\User::factory()->create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ])->assignRole('User');
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
}