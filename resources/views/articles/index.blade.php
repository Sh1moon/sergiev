@extends('layouts.app')

@section('title', $section->name)

@section('content')
<div class="articles-page">
    @if(in_array($section->slug, ['forecast', 'report', 'programs', 'programs-archive', 'social-partnership'], true))
    <a href="{{ route('finance') }}" class="articles-back">← Финансы</a>
    @endif
    <h1 class="articles-title">{{ $section->name }}</h1>

    @if($articles->isEmpty())
        <p>Пока нет статей в этом разделе.</p>
    @else
        <ul class="articles-list">
            @foreach($articles as $article)
            <li class="article-card">
                @php
    $articleUrl = match($section->slug) {
        'news' => route('news.show', $article->slug),
        'gosadmtechnadzor' => route('gosadmtechnadzor.show', $article->slug),
        'information' => route('information.show', $article->slug),
        'finance' => route('finance.show', $article->slug),
        'forecast', 'report', 'programs', 'programs-archive', 'social-partnership' => route('finance.article.show', [$section->slug, $article->slug]),
        default => route('articles.show', [$section->slug, $article->slug]),
    };
@endphp
                <a href="{{ $articleUrl }}" class="article-card-link">
                    <div class="article-card-image">
                        @if($article->image)
                            <img src="{{ Storage::url($article->image) }}" alt="">
                        @else
                            <span class="article-card-placeholder"><img src="{{ asset('images/logo.svg') }}" alt="" class="article-card-placeholder-logo"></span>
                        @endif
                    </div>
                    <div class="article-card-body">
                        <h2 class="article-card-title">{{ $article->title }}</h2>
                        <time class="article-card-date" datetime="{{ $article->published_at?->toIso8601String() }}">
                            {{ $article->published_at?->format('d.m.Y') }}
                        </time>
                        @if($article->excerpt)
                            <p class="article-card-excerpt">{{ Str::limit($article->excerpt, 160) }}</p>
                        @endif
                        <span class="article-card-more">Читать далее</span>
                    </div>
                </a>
            </li>
            @endforeach
        </ul>

        @if($articles->hasPages())
            <div class="articles-pagination">
                {{ $articles->links() }}
            </div>
        @endif
    @endif
</div>

<style>
.articles-page { padding: 20px 0; }
.articles-back { display: inline-block; color: #1a3c1a; text-decoration: none; font-size: 0.95em; margin-bottom: 12px; }
.articles-back:hover { color: #eac31b; }
.articles-title { color: #1a3c1a; margin-bottom: 24px; border-bottom: 2px solid #1a3c1a; padding-bottom: 12px; }
.articles-list { list-style: none; padding: 0; margin: 0; }
.article-card { margin-bottom: 24px; background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); overflow: hidden; }
.article-card-link {
    display: flex;
    flex-wrap: wrap;
    text-decoration: none;
    color: inherit;
    min-height: 180px;
}
.article-card-link:hover .article-card-title { color: #eac31b; }
.article-card-image {
    flex: 0 0 280px;
    width: 280px;
    min-height: 180px;
    background: #e8e8e8;
    display: flex;
    align-items: center;
    justify-content: center;
}
.article-card-image img { max-width: 100%; max-height: 100%; width: auto; height: auto; object-fit: contain; display: block; }
.article-card-placeholder { display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; background: #1a3c1a; padding: 24px; box-sizing: border-box; }
.article-card-placeholder-logo { max-width: 70%; max-height: 70%; width: auto; height: auto; object-fit: contain; opacity: 0.7; }
.article-card-body { flex: 1; min-width: 200px; padding: 20px; display: flex; flex-direction: column; justify-content: center; }
.article-card-title { color: #1a3c1a; margin-bottom: 8px; font-size: 1.25rem; transition: color 0.2s; }
.article-card-date { font-size: 0.9em; color: #666; margin-bottom: 10px; }
.article-card-excerpt { color: #555; line-height: 1.5; margin-bottom: 12px; }
.article-card-more { color: #eac31b; font-weight: 500; }
@media (max-width: 640px) {
    .article-card-link { flex-direction: column; min-height: auto; }
    .article-card-image { flex: 0 0 auto; width: 100%; height: 200px; }
}
.articles-pagination { margin-top: 30px; }
.articles-pagination nav { display: flex; justify-content: center; flex-wrap: wrap; gap: 6px; }
.articles-pagination a,
.articles-pagination span {
    display: inline-block;
    padding: 8px 14px;
    background: #1a3c1a;
    color: #fafffa;
    text-decoration: none;
    border-radius: 4px;
}
.articles-pagination a:hover { background: #2a5a2a; color: #eac31b; }
.articles-pagination span { background: #eac31b; color: #1a3c1a; }
</style>
@endsection
