@extends('layouts.app')

@section('title', 'Профиль')

@section('content')
<div class="profile-page">
    <h1 class="profile-title">Профиль</h1>

    <div class="profile-info">
        <p><strong>Имя:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
    </div>

    @if($user->isAdmin() || $user->isEmployee())
        <div class="profile-links-section">
            <h2 class="profile-section-title">Быстрые разделы</h2>
            <div class="profile-links-grid">
                <a href="{{ route('staff.articles.index') }}" class="profile-quick-link">
                    <span class="profile-quick-link-icon" aria-hidden="true">📁</span>
                    <span>Статьи</span>
                </a>
                <a href="{{ route('staff.vacancies.index') }}" class="profile-quick-link">
                    <span class="profile-quick-link-icon" aria-hidden="true">💼</span>
                    <span>Вакансии</span>
                </a>
                <a href="{{ route('staff.administration.index') }}" class="profile-quick-link">
                    <span class="profile-quick-link-icon" aria-hidden="true">🏛️</span>
                    <span>Администрация</span>
                </a>
                <a href="{{ route('staff.content.index') }}" class="profile-quick-link">
                    <span class="profile-quick-link-icon" aria-hidden="true">📝</span>
                    <span>Контент</span>
                </a>
                <a href="{{ route('staff.appeals.index') }}" class="profile-quick-link">
                    <span class="profile-quick-link-icon" aria-hidden="true">📨</span>
                    <span>Обращения граждан</span>
                </a>
                <a href="{{ route('staff.anticorruption.index') }}" class="profile-quick-link">
                    <span class="profile-quick-link-icon" aria-hidden="true">⚖️</span>
                    <span>Сообщения об антикоррупции</span>
                </a>
                <a href="{{ route('staff.analytics') }}" class="profile-quick-link">
                    <span class="profile-quick-link-icon" aria-hidden="true">📊</span>
                    <span>Аналитика</span>
                </a>
            </div>
        </div>
    @endif

    @if($user->isAdmin() && $adminStats)
        <div class="profile-admin-section">
            <h2 class="profile-section-title">Администрирование</h2>

            <div class="dashboard-stats">
                <div class="stat-card">
                    <h3>Пользователи</h3>
                    <p class="stat-number">{{ $adminStats['totalUsers'] }}</p>
                </div>
                <div class="stat-card">
                    <h3>Администраторы</h3>
                    <p class="stat-number">{{ $adminStats['adminCount'] }}</p>
                </div>
                <div class="stat-card">
                    <h3>Сотрудники</h3>
                    <p class="stat-number">{{ $adminStats['employeeCount'] }}</p>
                </div>
                <div class="stat-card">
                    <h3>Пользователи</h3>
                    <p class="stat-number">{{ $adminStats['userCount'] }}</p>
                </div>
            </div>

            <div class="admin-actions">
                <h3 class="profile-subsection-title">Управление</h3>
                <div class="action-list">
                    <div class="action-row">
                        <div class="action-meta">
                            <h4>Управление пользователями</h4>
                            <p>Просмотр, создание и редактирование учетных записей</p>
                        </div>
                        <a href="{{ route('admin.users.index') }}" class="action-btn">Открыть</a>
                    </div>
                    <div class="action-row">
                        <div class="action-meta">
                            <h4>Управление контентом</h4>
                            <p>Статьи, разделы и материалы сайта</p>
                        </div>
                        <a href="{{ route('staff.articles.index') }}" class="action-btn">Открыть</a>
                    </div>
                    <div class="action-row">
                        <div class="action-meta">
                            <h4>Карусель на главной</h4>
                            <p>Изображения и порядок отображения слайдов</p>
                        </div>
                        <a href="{{ route('staff.carousel.index') }}" class="action-btn">Открыть</a>
                    </div>
                    <div class="action-row">
                        <div class="action-meta">
                            <h4>Обращения граждан</h4>
                            <p>Просмотр и обработка входящих обращений</p>
                        </div>
                        <a href="{{ route('staff.appeals.index') }}" class="action-btn">Открыть</a>
                    </div>
                    <div class="action-row">
                        <div class="action-meta">
                            <h4>Аналитика</h4>
                            <p>Показатели SLA, динамика и категории проблем</p>
                        </div>
                        <a href="{{ route('admin.analytics') }}" class="action-btn">Открыть</a>
                    </div>
                    <div class="action-row">
                        <div class="action-meta">
                            <h4>Категории проблем</h4>
                            <p>Справочник категорий для формы обращений и аналитики</p>
                        </div>
                        <a href="{{ route('admin.problem-categories.index') }}" class="action-btn">Открыть</a>
                    </div>
                    <div class="action-row">
                        <div class="action-meta">
                            <h4>Сообщения об антикоррупции</h4>
                            <p>Регистрация и ответы на профильные обращения</p>
                        </div>
                        <a href="{{ route('staff.anticorruption.index') }}" class="action-btn">Открыть</a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="profile-password-section">
        <h2 class="profile-section-title">Сменить пароль</h2>
        <form method="POST" action="{{ route('profile.password.update') }}" class="profile-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="current_password" class="form-label">Текущий пароль <span class="required">*</span></label>
                <input type="password"
                       class="form-control @error('current_password') is-invalid @enderror"
                       id="current_password"
                       name="current_password"
                       required
                       autocomplete="current-password">
                @error('current_password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Новый пароль <span class="required">*</span></label>
                <input type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       id="password"
                       name="password"
                       required
                       autocomplete="new-password"
                       minlength="8">
                <span class="form-hint">Не менее 8 символов.</span>
                @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Подтверждение нового пароля <span class="required">*</span></label>
                <input type="password"
                       class="form-control"
                       id="password_confirmation"
                       name="password_confirmation"
                       required
                       autocomplete="new-password"
                       minlength="8">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Изменить пароль</button>
            </div>
        </form>
    </div>
</div>

<style>
.profile-page { padding: 28px 0; max-width: 1100px; color: #1f2937; }
.profile-title {
    color: #111827;
    margin-bottom: 20px;
    border-bottom: 1px solid #d1d5db;
    padding-bottom: 12px;
    font-size: 1.75rem;
    letter-spacing: 0.01em;
}
.profile-info {
    background: #f8fafc;
    border: 1px solid #d9e1ea;
    padding: 18px 20px;
    border-radius: 6px;
    margin-bottom: 24px;
}
.profile-info p { margin: 0 0 8px 0; color: #1f2937; }
.profile-info p:last-child { margin-bottom: 0; }
.profile-links-section,
.profile-admin-section,
.profile-password-section {
    background: #ffffff;
    border: 1px solid #d9e1ea;
    padding: 24px;
    border-radius: 6px;
    margin-bottom: 24px;
    box-shadow: 0 1px 3px rgba(15, 23, 42, 0.05);
}
.profile-links-grid { display: grid; gap: 10px; }
.profile-quick-link {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    color: #1f2937;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    padding: 10px 12px;
    background: #ffffff;
    transition: background-color .2s ease, border-color .2s ease, color .2s ease;
}
.profile-quick-link:hover {
    background: #f8fafc;
    border-color: #94a3b8;
    color: #111827;
}
.profile-quick-link-icon { font-size: 17px; line-height: 1; }
.profile-section-title {
    color: #111827;
    margin-bottom: 16px;
    font-size: 1.15rem;
    font-weight: 700;
}
.profile-subsection-title {
    color: #111827;
    margin: 0 0 16px;
    font-size: 1.05rem;
    font-weight: 600;
}
.profile-form .form-actions { margin-top: 20px; }
.required { color: #dc3545; }
.form-hint { font-size: 13px; color: #6b7280; margin-top: 4px; display: block; }

.dashboard-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    margin-bottom: 24px;
}
.stat-card {
    background: #f8fafc;
    color: #111827;
    border: 1px solid #d1d5db;
    padding: 20px;
    border-radius: 6px;
    text-align: left;
    box-shadow: none;
}
.stat-card h3 {
    font-size: 14px;
    margin-bottom: 8px;
    font-weight: 600;
    color: #374151;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.stat-number {
    font-size: 30px;
    font-weight: 700;
    color: #111827;
}
.action-list {
    border: 1px solid #d1d5db;
    border-radius: 6px;
    background: #ffffff;
}
.action-row {
    display: flex;
    gap: 16px;
    align-items: center;
    justify-content: space-between;
    padding: 14px 16px;
    border-bottom: 1px solid #e5e7eb;
}
.action-row:last-child {
    border-bottom: none;
}
.action-meta h4 {
    color: #111827;
    margin: 0 0 6px 0;
    font-size: 1rem;
}
.action-meta p {
    color: #6b7280;
    font-size: 13px;
    line-height: 1.5;
    margin: 0;
}
.action-btn {
    flex: 0 0 auto;
    text-decoration: none;
    border: 1px solid #94a3b8;
    color: #1e293b;
    background: #f8fafc;
    border-radius: 6px;
    padding: 8px 14px;
    font-size: 14px;
    font-weight: 600;
    transition: background-color 0.2s ease, border-color 0.2s ease;
}
.action-btn:hover {
    background: #eef2f7;
    border-color: #64748b;
}
@media (max-width: 720px) {
    .action-row {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>
@endsection
