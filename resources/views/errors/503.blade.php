@extends('layouts.app')

@section('title', 'Сервис недоступен')

@section('content')
<div class="error-page">
    <div class="error-page-content">
        <p class="error-code">503</p>
        <h1 class="error-title">Сервис недоступен</h1>
        <p class="error-text">Сайт временно на техническом обслуживании. Попробуйте зайти позже.</p>
        <a href="{{ route('home') }}" class="btn btn-primary">На главную</a>
    </div>
</div>
<style>
.error-page { padding: 60px 20px; text-align: center; min-height: 50vh; display: flex; align-items: center; justify-content: center; }
.error-page-content { max-width: 480px; }
.error-code { font-size: 4rem; font-weight: 700; color: #1a3c1a; margin-bottom: 8px; line-height: 1; }
.error-title { font-size: 1.5rem; color: #1a3c1a; margin-bottom: 12px; }
.error-text { color: #666; margin-bottom: 24px; line-height: 1.6; }
</style>
@endsection
