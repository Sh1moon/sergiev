@extends('layouts.app')

@section('title', 'Профиль')

@section('content')
<div class="profile-page">
    <h1 class="profile-title">Профиль</h1>

    <div class="profile-info">
        <p><strong>Имя:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
    </div>

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
.profile-page { padding: 20px 0; max-width: 480px; }
.profile-title { color: #1a3c1a; margin-bottom: 20px; border-bottom: 2px solid #1a3c1a; padding-bottom: 10px; }
.profile-info { background: #f9f9f9; padding: 16px; border-radius: 8px; margin-bottom: 28px; }
.profile-info p { margin: 0 0 8px 0; }
.profile-info p:last-child { margin-bottom: 0; }
.profile-password-section { background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); }
.profile-section-title { color: #1a3c1a; margin-bottom: 16px; font-size: 1.2rem; }
.profile-form .form-actions { margin-top: 20px; }
.required { color: #dc3545; }
.form-hint { font-size: 13px; color: #666; margin-top: 4px; display: block; }
</style>
@endsection
