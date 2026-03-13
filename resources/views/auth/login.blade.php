@extends('layouts.app')

@section('title', 'Вход в систему')

@section('content')
<div class="auth-container">
    <h1>Вход в систему</h1>
    
    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input type="email" 
                   class="form-control @error('email') is-invalid @enderror" 
                   id="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   autofocus>
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
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    Запомнить меня
                </label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Войти</button>
        
        <div class="auth-links">
            <a href="{{ route('register') }}">Нет аккаунта? Зарегистрироваться</a>
        </div>
    </form>
</div>

<style>
.auth-container {
    max-width: 400px;
    margin: 50px auto;
    padding: 30px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.auth-container h1 {
    margin-bottom: 30px;
    text-align: center;
    color: #1a3c1a;
}

.checkbox {
    display: flex;
    align-items: center;
    gap: 8px;
}

.checkbox input {
    width: auto;
    margin-right: 5px;
}

.auth-links {
    margin-top: 20px;
    text-align: center;
}

.auth-links a {
    color: #1a3c1a;
    text-decoration: none;
}

.auth-links a:hover {
    text-decoration: underline;
    color: #eac31b;
}
</style>
@endsection