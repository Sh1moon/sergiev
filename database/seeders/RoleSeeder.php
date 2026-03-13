<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Администратор', 'slug' => Role::ADMIN, 'description' => 'Полный доступ ко всем функциям'],
            ['name' => 'Сотрудник', 'slug' => Role::EMPLOYEE, 'description' => 'Доступ к управлению контентом'],
            ['name' => 'Пользователь', 'slug' => Role::USER, 'description' => 'Базовый доступ для авторизованных пользователей'],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(
                ['slug' => $role['slug']],
                $role
            );
        }
    }
}