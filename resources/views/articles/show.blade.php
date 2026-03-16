@extends('layouts.app')

@section('title', $article->title)

@section('content')
<article class="article-detail">
    <header class="article-detail-header">
        @php
    $sectionIndexRoute = match($section->slug) {
        'news' => route('news.index'),
        'go-chs' => route('go-chs'),
        'gosadmtechnadzor' => route('gosadmtechnadzor'),
        'information' => route('information'),
        'gardeners' => route('gardeners'),
        'finance' => route('finance'),
        'forecast', 'report', 'programs', 'programs-archive', 'social-partnership' => route('finance.section', $section->slug),
        default => route('articles.index', ['sectionSlug' => $section->slug]),
    };
@endphp
    <a href="{{ $sectionIndexRoute }}" class="article-back">← {{ $section->name }}</a>
        <h1 class="article-detail-title">{{ $article->title }}</h1>
        <div class="article-detail-meta">
            <time datetime="{{ $article->published_at?->toIso8601String() }}">{{ $article->published_at?->format('d.m.Y') }}</time>
            @if($article->user)
                <span>{{ $article->user->name }}</span>
            @endif
        </div>
    </header>

    <div class="article-detail-image">
        @if(!empty($article->image))
            <span class="js-img-lightbox article-detail-main-img-wrap" role="button" tabindex="0" aria-label="Открыть в полном размере">
                <img src="{{ Storage::url($article->image) }}" alt="" class="article-detail-main-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="article-detail-placeholder" style="display: none;"><img src="{{ asset('images/logo.svg') }}" alt="" class="article-detail-placeholder-logo"></div>
            </span>
        @else
            <div class="article-detail-placeholder"><img src="{{ asset('images/logo.svg') }}" alt="" class="article-detail-placeholder-logo"></div>
        @endif
    </div>

    <div class="article-detail-body">
        {!! nl2br(e($article->body)) !!}
    </div>

    @if($article->files->isNotEmpty())
    <div class="article-detail-files">
        <h3>Файлы</h3>
        <ul>
            @foreach($article->files as $file)
            <li>
                <a href="{{ Storage::url($file->path) }}" target="_blank" rel="noopener">{{ $file->original_name }}</a>
            </li>
            @endforeach
        </ul>
    </div>
    @endif

    <footer class="article-detail-footer">
        <a href="{{ $sectionIndexRoute }}" class="btn">К списку</a>
    </footer>
</article>

<style>
.article-detail { padding: 20px 0; max-width: 800px; }
.article-back { color: #1a3c1a; text-decoration: none; font-size: 0.95em; margin-bottom: 12px; display: inline-block; }
.article-back:hover { color: #eac31b; }
.article-detail-header { margin-bottom: 24px; }
.article-detail-title { color: #1a3c1a; margin-bottom: 12px; font-size: 1.75rem; }
.article-detail-meta { color: #666; font-size: 0.9em; }
.article-detail-image { margin-bottom: 24px; border-radius: 8px; overflow: hidden; min-height: 120px; max-height: min(70vh, 520px); background: #1a3c1a; display: flex; align-items: center; justify-content: center; }
.article-detail-main-img-wrap { cursor: pointer; display: block; }
.article-detail-image .article-detail-main-img { max-width: 100%; max-height: min(70vh, 500px); width: auto; height: auto; object-fit: contain; display: block; }
.article-detail-placeholder { display: flex; align-items: center; justify-content: center; padding: 48px 24px; min-height: 200px; width: 100%; box-sizing: border-box; }
.article-detail-placeholder-logo { max-width: 280px; width: 60%; height: auto; object-fit: contain;  opacity: 0.9; }
.article-detail-body { font-size: 1.2rem; line-height: 1.7; color: #1a3c1a; margin-bottom: 32px; }
.article-detail-body p { margin-bottom: 1em; }
.article-detail-files { margin-bottom: 24px; padding: 16px; background: #f5f5f5; border-radius: 8px; }
.article-detail-files h3 { color: #1a3c1a; margin-bottom: 12px; font-size: 1.1rem; }
.article-detail-files ul { list-style: none; padding: 0; margin: 0; }
.article-detail-files li { margin-bottom: 8px; }
.article-detail-files a { color: #1a3c1a; text-decoration: none; }
.article-detail-files a:hover { color: #eac31b; text-decoration: underline; }
.article-detail-footer { padding-top: 20px; border-top: 1px solid #eee; }
</style>
@endsection
