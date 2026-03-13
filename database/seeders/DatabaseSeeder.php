<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(ArticleSectionSeeder::class);
        $this->call(AdministrationSeeder::class);
        $this->call(AdministrationDepartmentsSeeder::class);
        $this->call(AdministrationInstitutionsSeeder::class);
        $this->call(AdministrationTerritoriesSeeder::class);
        $this->call(AdministrationGoChsSeeder::class);
        $this->call(CouncilDeputiesSeeder::class);
        $this->call(HonoraryCitizensSeeder::class);

        // Создание администратора
        User::create([
            'name' => 'Администратор',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role_id' => Role::getRoleId(Role::ADMIN),
        ]);

        // Создание тестового сотрудника
        User::create([
            'name' => 'Сотрудник',
            'email' => 'employee@example.com',
            'password' => Hash::make('password'),
            'role_id' => Role::getRoleId(Role::EMPLOYEE),
        ]);

        // Создание тестового пользователя
        User::create([
            'name' => 'Пользователь',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role_id' => Role::getRoleId(Role::USER),
        ]);
    }
}