@extends('layouts.app')

@section('title', 'Дачникам и садоводам')

@section('content')
<div class="gardeners-page">
    <h1 class="page-title">Дачникам и садоводам</h1>

    <section class="gardeners-intro">
        <p>Управление Федеральной службы государственной регистрации, кадастра и картографии по Московской области (далее – Управление) в связи с принятием Федерального закона 26.12.2024 №487 ФЗ «О внесении изменений в отдельные законодательные акты Российской Федерации» в части необходимости подготовки межевых и технических планов объектов недвижимости сообщает.</p>
        <p>С 01.03.2025 вступают в силу изменения в действующее законодательство, которыми предусмотрен комплекс мер в целях повышения эффективности использования земельных участков и объектов недвижимости.</p>
        <p>В частности, в Федеральный закон от 13.07.2015 № 218 ФЗ «О государственной регистрации недвижимости» вносятся положения, в соответствии с которыми предусмотрено приостановление государственной регистрации прав и государственного кадастрового учета в случае отсутствия в ЕГРН сведений о местоположении границ земельного участка, являющегося предметом сделки.</p>
        <p>Одновременно, невозможно будет провести государственный кадастровый учет и (или) регистрацию прав на здания, сооружения, иные объекты, расположенные на земельных участках, сведения о границах которых отсутствуют в ЕГРН, с приложением межевого плана.</p>
        <p>Кроме того, законом установлено, что с 1 марта 2025 года внесение в ЕГРН сведений о ранее учтенных объектах недвижимости по заявлению заинтересованного лица осуществляется с приложением межевого плана в отношении земельного участка; с приложением технического плана — в отношении объекта капитального строительства.</p>
    </section>

    <section class="gardeners-images">
        <div class="gardeners-images-grid">
            <figure class="gardeners-image-item">
                <div class="gardeners-img-wrap gardeners-img-clickable js-img-lightbox" role="button" tabindex="0" aria-label="Увеличить">
                    <img src="{{ asset('images/gardeners/5-prichin.png') }}" alt="5 причин выбрать электронный способ подачи документов">
                </div>
                <figcaption>5 причин выбрать электронный способ подачи документов</figcaption>
            </figure>
            <figure class="gardeners-image-item">
                <div class="gardeners-img-wrap gardeners-img-clickable js-img-lightbox" role="button" tabindex="0" aria-label="Увеличить">
                    <img src="{{ asset('images/gardeners/gosklyuch.png') }}" alt="Заявления через Госуслуги и приложение Госключ">
                </div>
                <figcaption>Заявления через Госуслуги и приложение «Госключ»</figcaption>
            </figure>
            <figure class="gardeners-image-item">
                <div class="gardeners-img-wrap gardeners-img-clickable js-img-lightbox" role="button" tabindex="0" aria-label="Увеличить">
                    <img src="{{ asset('images/gardeners/lichny-kabinet.png') }}" alt="Заявления через Личный кабинет Росреестра">
                </div>
                <figcaption>Заявления через «Личный кабинет» Росреестра</figcaption>
            </figure>
        </div>
    </section>

    <section class="gardeners-news">
        <h2>Материалы раздела</h2>
        @if($articles->isEmpty())
            <p>Пока нет материалов в этом разделе.</p>
        @else
            <ul class="articles-list">
                @foreach($articles as $article)
                <li class="article-card">
                    <a href="{{ route('gardeners.show', $article->slug) }}" class="article-card-link">
                        <div class="article-card-image">
                            @if($article->image)
                                <span class="js-img-lightbox" role="button" tabindex="0" aria-label="Открыть в полном размере">
                                    <img src="{{ Storage::url($article->image) }}" alt="">
                                </span>
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
    </section>
</div>

<style>
.gardeners-page { padding: 20px 0; }
.gardeners-page .page-title { color: #1a3c1a; margin-bottom: 24px; border-bottom: 2px solid #1a3c1a; padding-bottom: 10px; }
.gardeners-intro { margin-bottom: 32px; font-size: 1.2rem; line-height: 1.7; color: #333; }
.gardeners-intro p { margin-bottom: 1em; }
.gardeners-images { margin-bottom: 40px; }
.gardeners-images-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; }
.gardeners-image-item { margin: 0; }
.gardeners-img-wrap { cursor: pointer; overflow: hidden; border-radius: 8px; }
.gardeners-image-item img { width: 100%; height: auto; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); display: block; }
.gardeners-image-item figcaption { font-size: 1.2rem; color: #666; margin-top: 8px; line-height: 1.7; }
.gardeners-news h2 { color: #1a3c1a; margin-bottom: 20px; font-size: 1.25rem; border-bottom: 2px solid #1a3c1a; padding-bottom: 10px; }
.gardeners-news .articles-list { list-style: none; padding: 0; margin: 0; }
.gardeners-news .article-card { margin-bottom: 24px; background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); overflow: hidden; }
.gardeners-news .article-card-link { display: flex; flex-wrap: wrap; text-decoration: none; color: inherit; min-height: 180px; }
.gardeners-news .article-card-link:hover .article-card-title { color: #eac31b; }
.gardeners-news .article-card-image { flex: 0 0 280px; width: 280px; min-height: 180px; background: #e8e8e8; display: flex; align-items: center; justify-content: center; }
.gardeners-news .article-card-image img { max-width: 100%; max-height: 100%; width: auto; height: auto; object-fit: contain; display: block; }
.gardeners-news .article-card-placeholder { display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; background: #1a3c1a; padding: 24px; box-sizing: border-box; }
.gardeners-news .article-card-placeholder-logo { max-width: 70%; max-height: 70%; width: auto; height: auto; object-fit: contain; opacity: 0.7; }
.gardeners-news .article-card-body { flex: 1; min-width: 0; padding: 20px; display: flex; flex-direction: column; justify-content: center; }
.gardeners-news .article-card-title { color: #1a3c1a; margin-bottom: 8px; font-size: 1.25rem; }
.gardeners-news .article-card-date { font-size: 0.9em; color: #666; margin-bottom: 10px; }
.gardeners-news .article-card-excerpt { color: #555; font-size: 1.2rem; line-height: 1.7; margin-bottom: 12px; }
.gardeners-news .article-card-more { color: #eac31b; font-weight: 500; }
@media (max-width: 640px) {
    .gardeners-news .article-card-link { flex-direction: column; min-height: auto; }
    .gardeners-news .article-card-image { flex: 0 0 auto; width: 100%; max-width: 100%; height: 200px; }
}
.gardeners-news .articles-pagination { margin-top: 30px; }
.gardeners-news .articles-pagination nav { display: flex; justify-content: center; flex-wrap: wrap; gap: 6px; }
.gardeners-news .articles-pagination a,
.gardeners-news .articles-pagination span { display: inline-block; padding: 8px 14px; background: #1a3c1a; color: #fafffa; text-decoration: none; border-radius: 4px; }
.gardeners-news .articles-pagination a:hover { background: #2a5a2a; color: #eac31b; }
.gardeners-news .articles-pagination span { background: #eac31b; color: #1a3c1a; }

</style>
@endsection
