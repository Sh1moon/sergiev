@extends('layouts.app')

@section('title', $vacancy->title)

@section('content')
<article class="vacancy-detail">
    <header class="vacancy-detail-header">
        <a href="{{ route('reference') }}#vacancies" class="vacancy-back">← Вакансии</a>
        <h1 class="vacancy-detail-title">{{ $vacancy->title }}</h1>
        <div class="vacancy-detail-meta">
            <time datetime="{{ $vacancy->published_at?->toIso8601String() }}">{{ $vacancy->published_at?->format('d.m.Y') }}</time>
        </div>
    </header>
    <div class="vacancy-detail-body">
        {!! nl2br(e($vacancy->body)) !!}
    </div>
</article>
<style>
.vacancy-detail { padding: 20px 0; max-width: 720px; }
.vacancy-back { color: #1a5c1a; text-decoration: none; display: inline-block; margin-bottom: 16px; }
.vacancy-back:hover { color: #eac31b; }
.vacancy-detail-title { color: #1a3c1a; margin-bottom: 12px; }
.vacancy-detail-meta { color: #666; font-size: 0.95rem; margin-bottom: 24px; }
.vacancy-detail-body { line-height: 1.7; color: #333; }
</style>
@endsection
