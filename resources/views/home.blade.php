@extends('layouts.app')

@section('title', 'Главная страница')

@section('content_full')
@if($carouselSlides->isNotEmpty())
<div class="home-carousel-bleed">
<div class="home-carousel" aria-label="Карусель изображений" data-slide-count="{{ $carouselSlides->count() }}">
    <div class="carousel-viewport">
        <div class="carousel-inner">
            @foreach($carouselSlides as $slide)
            <div class="carousel-slide">
                <div class="js-img-lightbox carousel-slide-click" role="button" tabindex="0" aria-label="Открыть в полном размере">
                    <img src="{{ asset('storage/' . $slide->image) }}" alt="" loading="{{ $loop->first ? 'eager' : 'lazy' }}">
                </div>
            </div>
            @endforeach
            @if($carouselSlides->count() > 1)
            @foreach($carouselSlides as $slide)
            <div class="carousel-slide carousel-slide-clone" aria-hidden="true">
                <div class="js-img-lightbox carousel-slide-click" role="button" tabindex="0" aria-label="Открыть в полном размере">
                    <img src="{{ asset('storage/' . $slide->image) }}" alt="">
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
    @if($carouselSlides->count() > 1)
    <button type="button" class="carousel-btn carousel-btn-prev" aria-label="Предыдущий слайд">&lsaquo;</button>
    <button type="button" class="carousel-btn carousel-btn-next" aria-label="Следующий слайд">&rsaquo;</button>
    <button type="button" class="carousel-hit carousel-hit-prev" aria-label="Предыдущий слайд"></button>
    <button type="button" class="carousel-hit carousel-hit-next" aria-label="Следующий слайд"></button>
    @endif
</div>
</div>
@endif
@endsection

@section('content')
<div class="home-content">
    <section class="news-preview">
        <h2 class="news-preview-title-section">Новости округа</h2>
        @if($latestNews->isEmpty())
            <p>Пока нет новостей.</p>
        @else
            <ul class="news-preview-articles-list">
                @foreach($latestNews as $item)
                <li class="news-preview-article-card">
                    <a href="{{ route('news.show', $item->slug) }}" class="news-preview-article-card-link">
                        <div class="news-preview-article-card-image">
                            @if($item->image)
                                <span class="js-img-lightbox" role="button" tabindex="0" aria-label="Открыть в полном размере">
                                    <img src="{{ Storage::url($item->image) }}" alt="">
                                </span>
                            @else
                                <span class="news-preview-article-card-placeholder"><img src="{{ asset('images/logo.svg') }}" alt="" class="news-preview-article-card-placeholder-logo"></span>
                            @endif
                        </div>
                        <div class="news-preview-article-card-body">
                            <h2 class="news-preview-article-card-title">{{ $item->title }}</h2>
                            <time class="news-preview-article-card-date" datetime="{{ $item->published_at?->toIso8601String() }}">{{ $item->published_at?->format('d.m.Y') }}</time>
                            @if($item->excerpt)
                                <p class="news-preview-article-card-excerpt">{{ Str::limit($item->excerpt, 160) }}</p>
                            @endif
                            <span class="news-preview-article-card-more">Читать далее</span>
                        </div>
                    </a>
                </li>
                @endforeach
            </ul>
            <a href="{{ route('news.index') }}" class="btn btn-news">Все новости</a>
        @endif
    </section>

    <section class="home-appeals">
        <h2>Обращение граждан</h2>
        @guest
            <p class="home-appeals-intro">Для отправки обращения необходимо <a href="{{ route('login') }}">войти в систему</a>.</p>
        @endguest
        @auth
            <p class="home-appeals-intro">Заполните форму ниже или перейдите в раздел <a href="{{ route('appeals') }}">Обращения граждан</a> для просмотра своих обращений.</p>
        @endauth
        <div class="home-appeals-form-wrap">
            @include('appeals.partials.form')
        </div>
    </section>

    <section class="home-quick-links">
        <h2 class="home-quick-links-title">Полезные разделы</h2>
        <div class="home-quick-links-grid">
            <a href="{{ route('administration') }}" class="home-quick-card">
                <h3 class="home-quick-card-heading">Администрация округа</h3>
                <p class="home-quick-card-desc">Глава и заместители, подразделения, территории, контакты</p>
                <span class="home-quick-card-arrow">→</span>
            </a>
            <a href="{{ route('appeals.work') }}" class="home-quick-card">
                <h3 class="home-quick-card-heading">Обращения граждан</h3>
                <p class="home-quick-card-desc">Порядок приёма, график, подача обращений и антикоррупционных сообщений</p>
                <span class="home-quick-card-arrow">→</span>
            </a>
            <a href="{{ route('documents') }}" class="home-quick-card">
                <h3 class="home-quick-card-heading">Документы</h3>
                <p class="home-quick-card-desc">Устав, постановления, нормативные акты, антикоррупция</p>
                <span class="home-quick-card-arrow">→</span>
            </a>
            <a href="{{ route('finance') }}" class="home-quick-card">
                <h3 class="home-quick-card-heading">Финансы</h3>
                <p class="home-quick-card-desc">Бюджет, отчёты, программы и архив финансовых документов</p>
                <span class="home-quick-card-arrow">→</span>
            </a>
            <a href="{{ route('reference') }}" class="home-quick-card">
                <h3 class="home-quick-card-heading">Справочная</h3>
                <p class="home-quick-card-desc">Телефоны экстренных служб, участковые, УК, вакансии</p>
                <span class="home-quick-card-arrow">→</span>
            </a>
            <a href="{{ route('ecology') }}" class="home-quick-card">
                <h3 class="home-quick-card-heading">Экология</h3>
                <p class="home-quick-card-desc">Раздельный сбор, обращение с отходами, контакты</p>
                <span class="home-quick-card-arrow">→</span>
            </a>
        </div>
    </section>

    <section class="home-extra-links">
        <h2 class="home-extra-links-title">Ещё на сайте</h2>
        <ul class="home-extra-list">
            <li><a href="{{ route('our-district') }}">О нашем округе</a></li>
            <li><a href="{{ route('our-district.council') }}">Совет депутатов</a></li>
            <li><a href="{{ route('appeals.ank') }}">АНК</a></li>
            <li><a href="{{ route('appeals.anticorruption') }}">Сообщения об антикоррупции</a></li>
            <li><a href="{{ url('/reference#vacancies') }}">Вакансии</a></li>
            <li><a href="{{ route('information') }}">Информация</a></li>
        </ul>
    </section>
</div>

@if($carouselSlides->isNotEmpty() && $carouselSlides->count() > 1)
<script>
(function() {
    const carousel = document.querySelector('.home-carousel');
    if (!carousel) return;
    const viewport = carousel.querySelector('.carousel-viewport');
    const inner = carousel.querySelector('.carousel-inner');
    const slides = carousel.querySelectorAll('.carousel-slide');
    const totalSlides = parseInt(carousel.dataset.slideCount, 10);
    const prev = carousel.querySelector('.carousel-btn-prev');
    const next = carousel.querySelector('.carousel-btn-next');
    const hitPrev = carousel.querySelector('.carousel-hit-prev');
    const hitNext = carousel.querySelector('.carousel-hit-next');
    let index = 0;
    let resetTimer = null;
    const TRANSITION_MS = 300;
    function applyTransform(slideIndex, noTransition) {
        if (resetTimer) { clearTimeout(resetTimer); resetTimer = null; }
        const slide = slides[slideIndex];
        if (!slide) return;
        if (noTransition) inner.style.transition = 'none';
        var offset = slide.offsetLeft;
        inner.style.transform = 'translateX(-' + offset + 'px)';
        if (noTransition) {
            inner.offsetHeight;
            inner.style.transition = '';
        }
    }
    function go(n) {
        if (n >= totalSlides) {
            index = totalSlides;
            applyTransform(index, false);
            resetTimer = setTimeout(function() {
                resetTimer = null;
                index = 0;
                applyTransform(0, true);
            }, Math.round(TRANSITION_MS * 0.65));
        } else if (n < 0) {
            index = (n % totalSlides + totalSlides) % totalSlides;
            applyTransform(index, false);
        } else {
            index = n;
            applyTransform(index, false);
        }
    }
    function refreshPosition() {
        if (index >= totalSlides) index = 0;
        applyTransform(index, true);
    }
    prev?.addEventListener('click', function() { go(index - 1); });
    next?.addEventListener('click', function() { go(index + 1); });
    hitPrev?.addEventListener('click', function() { go(index - 1); });
    hitNext?.addEventListener('click', function() { go(index + 1); });
    var touchStartX = 0;
    var touchEndX = 0;
    viewport.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });
    viewport.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        var dx = touchStartX - touchEndX;
        if (Math.abs(dx) > 50) {
            if (dx > 0) go(index + 1);
            else go(index - 1);
        }
    }, { passive: true });
    var t = setInterval(function() { go(index + 1); }, 5000);
    carousel.addEventListener('mouseenter', function() { clearInterval(t); });
    carousel.addEventListener('mouseleave', function() { t = setInterval(function() { go(index + 1); }, 5000); });
    window.addEventListener('resize', function() {
        clearTimeout(inner._resizeT);
        inner._resizeT = setTimeout(refreshPosition, 100);
    });
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() { setTimeout(function() { go(0); }, 50); });
    } else {
        go(0);
        setTimeout(refreshPosition, 300);
    }
})();
</script>
@endif

<style>
.home-content { padding: 20px 0; }
.home-content h1 { display: none; }

.home-carousel-bleed {
    width: 100%;
    overflow: hidden;
    margin: 0;
    padding: 0;
}
.home-carousel {
    position: relative;
    width: 100%;
    max-width: 100vw;
    margin-left: calc(50% - 50vw);
    left: 0;
    right: 0;
    height: 56vh;
    min-height: 320px;
    max-height: 70vh;
    overflow: hidden;
    background: #1a3c1a;
    box-sizing: border-box;
}
.carousel-viewport {
    width: 100%;
    height: 100%;
    overflow: hidden;
    touch-action: pan-y;
}
@media (min-width: 768px) {
    .home-carousel .carousel-viewport {
        margin-left: 64px;
        margin-right: 64px;
        width: calc(100% - 128px);
    }
}
.carousel-inner {
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    align-items: center;
    gap: 16px;
    height: 100%;
    padding: 16px 0;
    width: max-content;
    transition: transform 0.3s ease;
    will-change: transform;
}
.carousel-slide {
    flex: 0 0 auto;
    width: 28%;
    min-width: 180px;
    max-width: 420px;
    height: 100%;
    min-height: 260px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 6px;
}
@media (max-width: 799px) {
    .carousel-slide {
        width: 82vw;
        min-width: 82vw;
        max-width: 82vw;
        min-height: 240px;
    }
}
.carousel-slide-click { cursor: pointer; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; }
.carousel-slide img {
    max-height: 100%;
    max-width: 100%;
    width: auto;
    height: auto;
    object-fit: contain;
    display: block;
    margin: 0 auto;
}
.carousel-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 2;
    width: 48px;
    height: 48px;
    border: none;
    background: rgba(26,60,26,0.6);
    color: #fafffa;
    font-size: 24px;
    cursor: pointer;
    border-radius: 4px;
    transition: background 0.2s;
}
.carousel-btn:hover { background: rgba(26,60,26,0.9); }
.carousel-btn-prev { left: 12px; }
.carousel-btn-next { right: 12px; }

.carousel-hit {
    display: none;
    position: absolute;
    top: 0;
    bottom: 0;
    z-index: 2;
    padding: 0;
    border: none;
    background: transparent;
    cursor: pointer;
    -webkit-tap-highlight-color: transparent;
}
.carousel-hit-prev { left: 0; width: 50%; }
.carousel-hit-next { left: 50%; width: 50%; }
@media (max-width: 767px) {
    .carousel-btn { display: none; }
    .carousel-hit { display: block; }
    .carousel-hit-prev { width: 22%; }
    .carousel-hit-next { left: auto; right: 0; width: 22%; }
}
@media (max-width: 480px) {
    .carousel-slide { width: 88vw; min-width: 88vw; max-width: 88vw; min-height: 200px; }
}

.news-preview { margin-bottom: 40px; }
.news-preview-title-section { color: #1a3c1a; margin-bottom: 24px; border-bottom: 2px solid #1a3c1a; padding-bottom: 12px; }
.news-preview-articles-list { list-style: none; padding: 0; margin: 0; }
.news-preview-article-card { margin-bottom: 24px; background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); overflow: hidden; }
.news-preview-article-card-link {
    display: flex;
    flex-wrap: wrap;
    text-decoration: none;
    color: inherit;
    min-height: 180px;
}
.news-preview-article-card-link:hover .news-preview-article-card-title { color: #eac31b; }
.news-preview-article-card-image {
    flex: 0 0 280px;
    width: 280px;
    min-height: 180px;
    background: #e8e8e8;
    display: flex;
    align-items: center;
    justify-content: center;
}
.news-preview-article-card-image img { max-width: 100%; max-height: 100%; width: auto; height: auto; object-fit: contain; display: block; }
.news-preview-article-card-placeholder { display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; background: #1a3c1a; padding: 24px; box-sizing: border-box; }
.news-preview-article-card-placeholder-logo { max-width: 70%; max-height: 70%; width: auto; height: auto; object-fit: contain; opacity: 0.7; }
.news-preview-article-card-body { flex: 1; min-width: 0; padding: 20px; display: flex; flex-direction: column; justify-content: center; }
.news-preview-article-card-title { color: #1a3c1a; margin-bottom: 8px; font-size: 1.25rem; transition: color 0.2s; }
.news-preview-article-card-date { font-size: 0.9em; color: #666; margin-bottom: 10px; }
.news-preview-article-card-excerpt { color: #555; font-size: 1.2rem; line-height: 1.7; margin-bottom: 12px; }
.news-preview-article-card-more { color: #eac31b; font-weight: 500; }
@media (max-width: 640px) {
    .news-preview-article-card-link { flex-direction: column; min-height: auto; }
    .news-preview-article-card-image { flex: 0 0 auto; width: 100%; max-width: 100%; height: 200px; }
}
.btn-news { margin-top: 10px; }

/* Полезные разделы — карточки */
.home-quick-links { margin-top: 48px; margin-bottom: 40px; }
.home-quick-links-title {
    color: #1a3c1a;
    font-size: 1.35rem;
    margin-bottom: 24px;
    border-bottom: 2px solid #1a3c1a;
    padding-bottom: 12px;
}
.home-quick-links-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}
.home-quick-card {
    display: flex;
    flex-direction: column;
    background: #fff;
    padding: 24px;
    border-radius: 10px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    text-decoration: none;
    color: inherit;
    border-left: 4px solid #1a3c1a;
    transition: box-shadow 0.2s ease, transform 0.2s ease;
}
.home-quick-card:hover {
    box-shadow: 0 6px 20px rgba(26,60,26,0.12);
    transform: translateY(-2px);
}
.home-quick-card-icon {
    font-size: 1.75rem;
    margin-bottom: 12px;
    line-height: 1;
}
.home-quick-card-heading {
    color: #1a3c1a;
    font-size: 1.1rem;
    margin-bottom: 8px;
    font-weight: 600;
}
.home-quick-card:hover .home-quick-card-heading { color: #2a5a2a; }
.home-quick-card-desc {
    color: #555;
    font-size: 0.95rem;
    line-height: 1.5;
    flex: 1;
    margin-bottom: 12px;
}
.home-quick-card-arrow {
    color: #eac31b;
    font-weight: 600;
    font-size: 1.1rem;
}
.home-quick-card:hover .home-quick-card-arrow { color: #1a3c1a; }

/* Ещё на сайте */
.home-extra-links { margin-top: 40px; padding-top: 32px; border-top: 1px solid #e0e0e0; }
.home-extra-links-title {
    color: #1a3c1a;
    font-size: 1.15rem;
    margin-bottom: 16px;
}
.home-extra-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-wrap: wrap;
    gap: 12px 24px;
}
.home-extra-list a {
    color: #1a3c1a;
    text-decoration: none;
    font-size: 0.95rem;
}
.home-extra-list a:hover { color: #eac31b; text-decoration: underline; }

.home-appeals { margin-top: 40px; margin-bottom: 40px; }
.home-appeals h2 { color: #1a3c1a; margin-bottom: 12px; border-bottom: 2px solid #1a3c1a; padding-bottom: 10px; }
.home-appeals-intro { color: #555; margin-bottom: 16px; font-size: 1.2rem; line-height: 1.7; }
.home-appeals-intro a { color: #1a3c1a; text-decoration: none; }
.home-appeals-intro a:hover { color: #eac31b; text-decoration: underline; }
.home-appeals-form-wrap { background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); max-width: 640px; }
.home-appeals-form-wrap .required { color: #dc3545; }
.home-appeals-form-wrap .form-hint { font-size: 13px; color: #666; margin-top: 4px; display: block; }
.home-appeals-form-wrap .form-actions { margin-top: 24px; }
.home-appeals-form-wrap .form-group-consent { margin-top: 20px; }
.home-appeals-form-wrap .consent-label { display: flex; align-items: flex-start; gap: 10px; cursor: pointer; font-weight: normal; }
.home-appeals-form-wrap .consent-checkbox { margin-top: 4px; flex-shrink: 0; width: 18px; height: 18px; }
.home-appeals-form-wrap .consent-tooltip-wrap { display: inline-flex; align-items: center; position: relative; margin-left: 4px; vertical-align: middle; }
.home-appeals-form-wrap .consent-tooltip-icon { display: inline-flex; align-items: center; justify-content: center; width: 18px; height: 18px; border-radius: 50%; background: #1a3c1a; color: #fafffa; font-size: 12px; font-weight: bold; cursor: help; }
.home-appeals-form-wrap .consent-tooltip-content { position: absolute; left: 50%; transform: translateX(-50%); bottom: 100%; margin-bottom: 8px; width: 280px; padding: 12px; background: #1a3c1a; color: #fafffa; font-size: 12px; line-height: 1.4; border-radius: 6px; box-shadow: 0 4px 12px rgba(0,0,0,0.2); opacity: 0; visibility: hidden; transition: opacity 0.2s ease, visibility 0.2s ease; z-index: 100; pointer-events: none; }
.home-appeals-form-wrap .consent-tooltip-content::after { content: ''; position: absolute; top: 100%; left: 50%; margin-left: -6px; border: 6px solid transparent; border-top-color: #1a3c1a; }
.home-appeals-form-wrap .consent-tooltip-wrap:hover .consent-tooltip-content,
.home-appeals-form-wrap .consent-tooltip-wrap:focus .consent-tooltip-content,
.home-appeals-form-wrap .consent-tooltip-wrap:focus-within .consent-tooltip-content { opacity: 1; visibility: visible; }
</style>
@endsection
