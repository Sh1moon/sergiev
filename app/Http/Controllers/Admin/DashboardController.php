<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $adminCount = User::whereHas('role', fn ($q) => $q->where('slug', Role::ADMIN))->count();
        $employeeCount = User::whereHas('role', fn ($q) => $q->where('slug', Role::EMPLOYEE))->count();
        $userCount = User::whereHas('role', fn ($q) => $q->where('slug', Role::USER))->count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'adminCount',
            'employeeCount',
            'userCount'
        ));
    }
}
