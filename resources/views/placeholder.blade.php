@extends('layouts.app')

@section('title', 'Раздел в разработке')

@section('content')
<div class="placeholder-page">
    <h1>Раздел в разработке</h1>
    <p>Содержимое этой страницы будет добавлено позже.</p>
    <a href="{{ route('home') }}" class="btn">На главную</a>
</div>
<style>
.placeholder-page { text-align: center; padding: 60px 20px; }
.placeholder-page h1 { color: #1a3c1a; margin-bottom: 15px; }
.placeholder-page p { color: #666; margin-bottom: 25px; }
</style>
@endsection
