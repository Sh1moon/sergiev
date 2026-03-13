@extends('layouts.app')

@section('title', 'Документы')

@section('content')
<div class="documents-page">
    <h1 class="page-title">Документы</h1>

    <section class="documents-section" id="charter">
        <h2 class="section-title">Устав</h2>
        @include('documents.charter')
    </section>

    @foreach($documentSectionSlugs as $slug)
    @php
        $section = $documentSections[$slug] ?? null;
        $articles = $articlesBySection[$slug] ?? collect();
    @endphp
    @if($section)
    <section class="documents-section" id="{{ $slug }}">
        <h2 class="section-title">{{ $section->name }}</h2>
        @if($articles->isEmpty())
            <p class="documents-empty">Пока нет материалов в этом разделе.</p>
        @else
            <ul class="documents-articles-list">
                @foreach($articles as $article)
                <li class="documents-articles-item">
                    <a href="{{ route('articles.show', [$section->slug, $article->slug]) }}" class="documents-articles-link">
                        <time class="documents-articles-date" datetime="{{ $article->published_at?->toIso8601String() }}">{{ $article->published_at?->format('d.m.Y') }}</time>
                        <span class="documents-articles-title">{{ $article->title }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
            <a href="{{ route('articles.index', $section->slug) }}" class="documents-section-more">Все материалы раздела</a>
        @endif
    </section>
    @endif
    @endforeach
</div>

<style>
.documents-page { padding: 20px 0; max-width: 900px; }
.documents-page .page-title { color: #1a3c1a; margin-bottom: 28px; border-bottom: 2px solid #1a3c1a; padding-bottom: 10px; }
.documents-section { margin-bottom: 48px; scroll-margin-top: 100px; }
.documents-section .section-title { color: #1a3c1a; font-size: 1.4rem; margin-bottom: 20px; border-bottom: 1px solid #e0e0e0; padding-bottom: 8px; }
.documents-empty { color: #666; margin-bottom: 0; }
.documents-articles-list { list-style: none; padding: 0; margin: 0 0 16px 0; }
.documents-articles-item { margin-bottom: 10px; }
.documents-articles-link { display: inline-flex; align-items: baseline; gap: 12px; text-decoration: none; color: #1a3c1a; }
.documents-articles-link:hover { color: #eac31b; }
.documents-articles-date { font-size: 0.9em; color: #666; flex-shrink: 0; }
.documents-articles-title { flex: 1; }
.documents-section-more { font-size: 0.95rem; color: #eac31b; font-weight: 500; text-decoration: none; }
.documents-section-more:hover { text-decoration: underline; }
.charter-content { font-size: 0.95rem; line-height: 1.65; color: #333; }
.charter-content .charter-title { text-align: center; font-weight: 600; margin-bottom: 20px; font-size: 1.1rem; }
.charter-content h3 { font-size: 1.05rem; color: #1a3c1a; margin-top: 24px; margin-bottom: 12px; }
.charter-content h4 { font-size: 1rem; color: #2a5a2a; margin-top: 16px; margin-bottom: 8px; }
.charter-content p { margin-bottom: 0.8em; }
.charter-content ol, .charter-content ul { margin: 0.5em 0 0.5em 1.5em; padding: 0; }
.charter-content li { margin-bottom: 0.4em; }
</style>
@endsection
