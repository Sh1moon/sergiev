@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')
<div class="auth-container">
    <h1>Регистрация</h1>
    
    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <div class="form-group">
            <label for="name" class="form-label">Имя</label>
            <input type="text" 
                   class="form-control @error('name') is-invalid @enderror" 
                   id="name" 
                   name="name" 
                   value="{{ old('name') }}" 
                   required 
                   autofocus>
            @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input type="email" 
                   class="form-control @error('email') is-invalid @enderror" 
                   id="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required>
            @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password" class="form-label">Пароль</label>
            <input type="password" 
                   class="form-control @error('password') is-invalid @enderror" 
                   id="password" 
                   name="password" 
                   required>
            @error('password')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password-confirm" class="form-label">Подтверждение пароля</label>
            <input type="password" 
                   class="form-control" 
                   id="password-confirm" 
                   name="password_confirmation" 
                   required>
        </div>

        <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
        
        <div class="auth-links">
            <a href="{{ route('login') }}">Уже есть аккаунт? Войти</a>
        </div>
    </form>
</div>

<style>
/* Стили такие же как в login.blade.php */
</style>
@endsection