@extends('layouts.app')

@section('title', 'Редактирование контента')

@section('content')
<div class="staff-content-hub">
    <h1>Редактирование контента</h1>
    <a href="{{ route('staff.articles.index') }}" class="btn btn-sm" style="margin-bottom: 20px;">← К статьям</a>

    @if(session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif

    <div class="content-links-grid">
        <a href="{{ route('staff.content.honorary') }}" class="content-link-card">Почётные граждане</a>
        <a href="{{ route('staff.content.council') }}" class="content-link-card">Совет депутатов</a>
        <a href="{{ route('staff.content.departments') }}" class="content-link-card">Подразделения</a>
        <a href="{{ route('staff.content.institutions') }}" class="content-link-card">Муниципальные учреждения</a>
        <a href="{{ route('staff.content.territories') }}" class="content-link-card">Территории</a>
        <a href="{{ route('staff.content.go-chs.edit') }}" class="content-link-card">ГО и ЧС</a>
        <a href="{{ route('staff.content.reference.edit', 'district_police') }}" class="content-link-card">Отдел участковых по району</a>
        <a href="{{ route('staff.content.reference.edit', 'emergency_phones') }}" class="content-link-card">Телефоны экстренных служб</a>
        <a href="{{ route('staff.content.management') }}" class="content-link-card">Управляющие компании</a>
    </div>
</div>

<style>
.staff-content-hub { padding: 20px 0; max-width: 800px; }
.staff-content-hub h1 { color: #1a3c1a; margin-bottom: 16px; }
.content-links-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 16px; }
.content-link-card { display: block; padding: 20px; background: #f8faf8; border: 1px solid #e0e0e0; border-radius: 8px; color: #1a3c1a; text-decoration: none; font-weight: 500; transition: background 0.2s; }
.content-link-card:hover { background: #e8f0e8; }
</style>
@endsection
