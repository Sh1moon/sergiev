@extends('layouts.app')

@section('title', 'Создание пользователя')

@section('content')
<div class="user-form">
    <h1>Создание нового пользователя</h1>

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">Имя *</label>
            <input type="text" 
                   class="form-control @error('name') is-invalid @enderror" 
                   id="name" 
                   name="name" 
                   value="{{ old('name') }}" 
                   required>
            @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Email *</label>
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
            <label for="password" class="form-label">Пароль *</label>
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
            <label for="role_id" class="form-label">Роль *</label>
            <select class="form-control @error('role_id') is-invalid @enderror" 
                    id="role_id" 
                    name="role_id" 
                    required>
                <option value="">Выберите роль</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
            @error('role_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Создать пользователя</button>
            <a href="{{ route('admin.users.index') }}" class="btn">Отмена</a>
        </div>
    </form>
</div>

<style>
.user-form {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px 0;
}

.user-form h1 {
    margin-bottom: 30px;
    color: #1a3c1a;
    text-align: center;
}

.form-actions {
    display: flex;
    gap: 10px;
    justify-content: center;
    margin-top: 30px;
}
</style>
@endsection