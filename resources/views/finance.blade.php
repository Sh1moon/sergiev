@extends('layouts.app')

@section('title', 'Финансы')

@section('content')
<div class="finance-page">
    <h1 class="page-title">Финансы</h1>

    @foreach($financeSectionSlugs as $slug)
    @php
        $section = $financeSections[$slug] ?? null;
        $articles = $articlesBySection[$slug] ?? collect();
        $sectionName = $section?->name ?? ($financeSectionNames[$slug] ?? $slug);
    @endphp
    <section class="finance-section" id="{{ $slug }}">
        <h2 class="section-title">{{ $sectionName }}</h2>
        @if($articles->isEmpty())
            <p class="finance-empty">Пока нет материалов в этом разделе.</p>
        @else
            <ul class="finance-articles-list">
                @foreach($articles as $article)
                <li class="finance-articles-item">
                    <a href="{{ $slug === 'finance' ? route('finance.show', $article->slug) : route('finance.article.show', [$slug, $article->slug]) }}" class="finance-articles-link">
                        <time class="finance-articles-date" datetime="{{ $article->published_at?->toIso8601String() }}">{{ $article->published_at?->format('d.m.Y') }}</time>
                        <span class="finance-articles-title">{{ $article->title }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
            <a href="{{ $slug === 'finance' ? route('articles.index', 'finance') : route('finance.section', $slug) }}" class="finance-section-more">Все материалы раздела</a>
        @endif
    </section>
    @endforeach
</div>

<style>
.finance-page { padding: 20px 0; max-width: 900px; }
.finance-page .page-title { color: #1a3c1a; margin-bottom: 28px; border-bottom: 2px solid #1a3c1a; padding-bottom: 10px; }
.finance-section { margin-bottom: 48px; scroll-margin-top: 100px; }
.finance-section .section-title { color: #1a3c1a; font-size: 1.4rem; margin-bottom: 20px; border-bottom: 1px solid #e0e0e0; padding-bottom: 8px; }
.finance-empty { color: #666; margin-bottom: 0; }
.finance-articles-list { list-style: none; padding: 0; margin: 0 0 16px 0; }
.finance-articles-item { margin-bottom: 10px; }
.finance-articles-link { display: inline-flex; align-items: baseline; gap: 12px; text-decoration: none; color: #1a3c1a; }
.finance-articles-link:hover { color: #eac31b; }
.finance-articles-date { font-size: 0.9em; color: #666; flex-shrink: 0; }
.finance-articles-title { flex: 1; }
.finance-section-more { font-size: 0.95rem; color: #eac31b; font-weight: 500; text-decoration: none; }
.finance-section-more:hover { text-decoration: underline; }
</style>
@endsection
