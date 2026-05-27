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
        $this->call(ProblemCategorySeeder::class);
        $this->call(ProblemHierarchySeeder::class);

        // Идемпотентные тестовые аккаунты: повторный seed не вызывает duplicate key.
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Администратор',
                'password' => Hash::make('password'),
                'role_id' => Role::getRoleId(Role::ADMIN),
            ]
        );

        User::updateOrCreate(
            ['email' => 'employee@example.com'],
            [
                'name' => 'Сотрудник',
                'password' => Hash::make('password'),
                'role_id' => Role::getRoleId(Role::EMPLOYEE),
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Пользователь',
                'password' => Hash::make('password'),
                'role_id' => Role::getRoleId(Role::USER),
            ]
        );
    }
}