@extends('layouts.app')

@section('title', 'Панель администратора')

@section('content')
<div class="admin-dashboard">
    <h1>Панель администратора</h1>
    
    <div class="dashboard-stats">
        <div class="stat-card">
            <h3>Пользователи</h3>
            <p class="stat-number">{{ $totalUsers }}</p>
        </div>
        <div class="stat-card">
            <h3>Администраторы</h3>
            <p class="stat-number">{{ $adminCount }}</p>
        </div>
        <div class="stat-card">
            <h3>Сотрудники</h3>
            <p class="stat-number">{{ $employeeCount }}</p>
        </div>
        <div class="stat-card">
            <h3>Пользователи</h3>
            <p class="stat-number">{{ $userCount }}</p>
        </div>
    </div>

    <div class="admin-actions">
        <h2>Управление</h2>
        <div class="action-grid">
            <a href="{{ route('admin.users.index') }}" class="action-card">
                <h3>Управление пользователями</h3>
                <p>Просмотр, создание и редактирование пользователей</p>
            </a>
            <a href="{{ route('staff.articles.index') }}" class="action-card">
                <h3>Управление контентом</h3>
                <p>Статьи и разделы сайта</p>
            </a>
            <a href="{{ route('staff.carousel.index') }}" class="action-card">
                <h3>Карусель на главной</h3>
                <p>Изображения в шапке главной страницы</p>
            </a>
            <a href="{{ route('staff.appeals.index') }}" class="action-card">
                <h3>Обращения граждан</h3>
                <p>Просмотр и ответы на обращения</p>
            </a>
            <a href="{{ route('staff.anticorruption.index') }}" class="action-card">
                <h3>Сообщения об антикоррупции</h3>
                <p>Просмотр и ответы на сообщения о коррупции</p>
            </a>
            <a href="#" class="action-card">
                <h3>Настройки сайта</h3>
                <p>Общие настройки и конфигурация</p>
            </a>
        </div>
    </div>
</div>

<style>
.admin-dashboard {
    padding: 20px 0;
}

.admin-dashboard h1 {
    margin-bottom: 30px;
    color: #1a3c1a;
}

.dashboard-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
}

.stat-card {
    background: linear-gradient(135deg, #1a3c1a, #2a5a2a);
    color: #fafffa;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.stat-card h3 {
    font-size: 18px;
    margin-bottom: 10px;
    font-weight: normal;
}

.stat-number {
    font-size: 36px;
    font-weight: bold;
}

.admin-actions h2 {
    margin-bottom: 20px;
    color: #1a3c1a;
}

.action-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.action-card {
    background: white;
    padding: 20px;
    border-radius: 8px;
    text-decoration: none;
    color: inherit;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: transform 0.3s, box-shadow 0.3s;
    border-left: 4px solid #1a3c1a;
}

.action-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.action-card h3 {
    color: #1a3c1a;
    margin-bottom: 10px;
}

.action-card p {
    color: #666;
    font-size: 14px;
    line-height: 1.5;
}
</style>
@endsection