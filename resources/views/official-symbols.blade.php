@extends('layouts.app')

@section('title', 'Официальные символы')

@section('content')
<div class="official-symbols-page">
    <h1 class="page-title">Официальные символы</h1>

    <section class="symbols-section">
        <h2>Герб Сергиево-Посадского городского округа Московской области</h2>

        <div class="symbols-grid">
            <figure class="symbols-item">
                <div class="symbols-img-wrap symbols-img-clickable js-img-lightbox" role="button" tabindex="0" aria-label="Увеличить">
                    <img src="{{ asset('images/symbols/gerb-color.jpg') }}" alt="Герб многоцветный" onerror="this.style.display='none'; this.nextElementSibling.classList.add('visible');">
                    <div class="symbols-placeholder"><span>Герб<br>(многоцветный)</span></div>
                </div>
                <figcaption>Герб Сергиево-Посадского городского округа (многоцветный)</figcaption>
            </figure>
            <figure class="symbols-item">
                <div class="symbols-img-wrap symbols-img-clickable js-img-lightbox" role="button" tabindex="0" aria-label="Увеличить">
                    <img src="{{ asset('images/symbols/gerb-mono.jpg') }}" alt="Герб одноцветный" onerror="this.style.display='none'; this.nextElementSibling.classList.add('visible');">
                    <div class="symbols-placeholder"><span>Герб<br>(одноцветный)</span></div>
                </div>
                <figcaption>Герб Сергиево-Посадского городского округа (одноцветный)</figcaption>
            </figure>
            <figure class="symbols-item">
                <div class="symbols-img-wrap symbols-img-clickable js-img-lightbox" role="button" tabindex="0" aria-label="Увеличить">
                    <img src="{{ asset('images/symbols/gerb-hatch.jpg') }}" alt="Герб с штриховкой" onerror="this.style.display='none'; this.nextElementSibling.classList.add('visible');">
                    <div class="symbols-placeholder"><span>Герб<br>(с штриховкой)</span></div>
                </div>
                <figcaption>Герб Сергиево-Посадского городского округа (одноцветный, с условной штриховкой для обозначения цвета)</figcaption>
            </figure>

            <figure class="symbols-item">
                <div class="symbols-img-wrap symbols-img-clickable js-img-lightbox" role="button" tabindex="0" aria-label="Увеличить">
                    <img src="{{ asset('images/symbols/gerb-volnaya-color.jpg') }}" alt="Герб с вольной частью многоцветный" onerror="this.style.display='none'; this.nextElementSibling.classList.add('visible');">
                    <div class="symbols-placeholder"><span>С вольной частью<br>(многоцветный)</span></div>
                </div>
                <figcaption>Герб с вольной частью (многоцветный)</figcaption>
            </figure>
            <figure class="symbols-item">
                <div class="symbols-img-wrap symbols-img-clickable js-img-lightbox" role="button" tabindex="0" aria-label="Увеличить">
                    <img src="{{ asset('images/symbols/gerb-volnaya-mono.jpg') }}" alt="Герб с вольной частью одноцветный" onerror="this.style.display='none'; this.nextElementSibling.classList.add('visible');">
                    <div class="symbols-placeholder"><span>С вольной частью<br>(одноцветный)</span></div>
                </div>
                <figcaption>Герб с вольной частью (одноцветный)</figcaption>
            </figure>
            <figure class="symbols-item">
                <div class="symbols-img-wrap symbols-img-clickable js-img-lightbox" role="button" tabindex="0" aria-label="Увеличить">
                    <img src="{{ asset('images/symbols/gerb-volnaya-hatch.jpg') }}" alt="Герб с вольной частью с штриховкой" onerror="this.style.display='none'; this.nextElementSibling.classList.add('visible');">
                    <div class="symbols-placeholder"><span>С вольной частью<br>(с штриховкой)</span></div>
                </div>
                <figcaption>Герб с вольной частью (одноцветный, с условной штриховкой для обозначения цвета)</figcaption>
            </figure>

            <figure class="symbols-item">
                <div class="symbols-img-wrap symbols-img-clickable js-img-lightbox" role="button" tabindex="0" aria-label="Увеличить">
                    <img src="{{ asset('images/symbols/gerb-crown-color.jpg') }}" alt="Герб с короной многоцветный" onerror="this.style.display='none'; this.nextElementSibling.classList.add('visible');">
                    <div class="symbols-placeholder"><span>С короной<br>(многоцветный)</span></div>
                </div>
                <figcaption>Герб (многоцветный) с короной, соответствующей статусу Сергиево-Посадского городского округа</figcaption>
            </figure>
            <figure class="symbols-item">
                <div class="symbols-img-wrap symbols-img-clickable js-img-lightbox" role="button" tabindex="0" aria-label="Увеличить">
                    <img src="{{ asset('images/symbols/gerb-crown-mono.jpg') }}" alt="Герб с короной одноцветный" onerror="this.style.display='none'; this.nextElementSibling.classList.add('visible');">
                    <div class="symbols-placeholder"><span>С короной<br>(одноцветный)</span></div>
                </div>
                <figcaption>Герб (одноцветный) с короной, соответствующей статусу Сергиево-Посадского городского округа</figcaption>
            </figure>
            <figure class="symbols-item">
                <div class="symbols-img-wrap symbols-img-clickable js-img-lightbox" role="button" tabindex="0" aria-label="Увеличить">
                    <img src="{{ asset('images/symbols/gerb-crown-hatch.jpg') }}" alt="Герб с короной с штриховкой" onerror="this.style.display='none'; this.nextElementSibling.classList.add('visible');">
                    <div class="symbols-placeholder"><span>С короной<br>(с штриховкой)</span></div>
                </div>
                <figcaption>Герб (одноцветный, с условной штриховкой для обозначения цвета) с короной, соответствующей статусу Сергиево-Посадского городского округа</figcaption>
            </figure>

            <figure class="symbols-item">
                <div class="symbols-img-wrap symbols-img-clickable js-img-lightbox" role="button" tabindex="0" aria-label="Увеличить">
                    <img src="{{ asset('images/symbols/gerb-volnaya-crown-color.jpg') }}" alt="Герб с вольной частью и короной многоцветный" onerror="this.style.display='none'; this.nextElementSibling.classList.add('visible');">
                    <div class="symbols-placeholder"><span>С вольной частью и короной<br>(многоцветный)</span></div>
                </div>
                <figcaption>Герб (многоцветный) с вольной частью и с короной, соответствующей статусу Сергиево-Посадского городского округа</figcaption>
            </figure>
            <figure class="symbols-item">
                <div class="symbols-img-wrap symbols-img-clickable js-img-lightbox" role="button" tabindex="0" aria-label="Увеличить">
                    <img src="{{ asset('images/symbols/gerb-volnaya-crown-mono.jpg') }}" alt="Герб с вольной частью и короной одноцветный" onerror="this.style.display='none'; this.nextElementSibling.classList.add('visible');">
                    <div class="symbols-placeholder"><span>С вольной частью и короной<br>(одноцветный)</span></div>
                </div>
                <figcaption>Герб (одноцветный) с вольной частью и с короной, соответствующей статусу Сергиево-Посадского городского округа</figcaption>
            </figure>
            <figure class="symbols-item">
                <div class="symbols-img-wrap symbols-img-clickable js-img-lightbox" role="button" tabindex="0" aria-label="Увеличить">
                    <img src="{{ asset('images/symbols/gerb-volnaya-crown-hatch.jpg') }}" alt="Герб с вольной частью и короной с штриховкой" onerror="this.style.display='none'; this.nextElementSibling.classList.add('visible');">
                    <div class="symbols-placeholder"><span>С вольной частью и короной<br>(с штриховкой)</span></div>
                </div>
                <figcaption>Герб (одноцветный, с условной штриховкой для обозначения цвета) с вольной частью и с короной, соответствующей статусу Сергиево-Посадского городского округа</figcaption>
            </figure>
        </div>

        <p class="symbols-legal">Решение Совета депутатов Сергиево-Посадского муниципального района МО от 24.10.2019 N 06/01-МЗ «Об официальном символе (гербе) Сергиево-Посадского городского округа Московской области»</p>
    </section>

    <section class="symbols-section symbols-section-flag">
        <h2>Флаг Сергиево-Посадского городского округа Московской области</h2>
        <div class="symbols-grid symbols-grid-flag">
            <figure class="symbols-item">
                <div class="symbols-img-wrap symbols-img-clickable js-img-lightbox" role="button" tabindex="0" aria-label="Увеличить">
                    <img src="{{ asset('images/symbols/flag.jpg') }}" alt="Флаг" onerror="this.style.display='none'; this.nextElementSibling.classList.add('visible');">
                    <div class="symbols-placeholder symbols-placeholder-flag"><span>Флаг</span></div>
                </div>
            </figure>
        </div>
        <p class="symbols-legal">Решение Совета депутатов Сергиево-Посадского муниципального района Московской области от 24.10.2019 N 06/01-МЗ «Об официальном символе (флаге) Сергиево-Посадского городского округа Московской области»</p>
    </section>

    <section class="symbols-section symbols-section-song">
        <h2>Торжественная песня Сергиево-Посадского городского округа</h2>
        <div class="symbols-song-text">
            <p>Наш город Сергий основал,<br>Века его прославили,<br>Для сердца русского он стал<br>Столицей православия.</p>
            <p class="symbols-song-chorus">Сергиев Посад, славься город мой<br>С каждым днем ты станешь краше.<br>Ты достойный сын Родины святой,<br>Ты моя судьба и гордость наша.</p>
            <p>Великих прадедов дела<br>В сердцах у нас останутся.<br>Сияют Лавры купола<br>И город наш не старится.</p>
            <p class="symbols-song-chorus">Сергиев Посад, славься город мой!<br>С каждым днем ты станешь краше.<br>Ты достойный сын Родины святой,<br>Ты моя судьба и гордость наша.</p>
            <p>Свой труд и замыслов полет<br>Мы посвящаем Родине.<br>И что Господь нам ниспошлет<br>С тобою будет пройдено.</p>
            <p class="symbols-song-chorus">Сергиев Посад, славься город мой!<br>С каждым днем ты станешь краше.<br>Ты достойный сын Родины святой,<br>Ты моя судьба и гордость наша.</p>
        </div>
    </section>
</div>

<style>
.official-symbols-page { padding: 20px 0; max-width: 960px; }
.official-symbols-page .page-title { color: #1a3c1a; margin-bottom: 24px; border-bottom: 2px solid #1a3c1a; padding-bottom: 10px; }
.symbols-section { margin-bottom: 40px; }
.symbols-section h2 { color: #1a3c1a; font-size: 1.25rem; margin-bottom: 20px; }
.symbols-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}
@media (max-width: 768px) {
    .symbols-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 480px) {
    .symbols-grid { grid-template-columns: 1fr; }
}
.symbols-item { margin: 0; text-align: center; }
.symbols-img-wrap {
    position: relative;
    min-height: 160px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    margin-bottom: 12px;
}
.symbols-img-clickable { cursor: pointer; }
.symbols-img-wrap img { max-width: 100%; max-height: 180px; object-fit: contain; }
.symbols-placeholder {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #999;
    font-size: 14px;
    text-align: center;
    line-height: 1.3;
    visibility: hidden;
}
.symbols-placeholder.visible { visibility: visible; }
.symbols-img-wrap img[style*="display: none"] + .symbols-placeholder { visibility: visible; }
.symbols-placeholder-flag { min-height: 200px; }
.symbols-section-flag .symbols-grid { display: flex; justify-content: center; max-width: none; }
.symbols-section-flag .symbols-img-wrap { min-height: 300px; min-width: 200px; max-width: 500px; }
.symbols-section-flag .symbols-img-wrap img { max-height: 400px; width: auto; }
.symbols-item figcaption {
    font-size: 13px;
    color: #555;
    line-height: 1.4;
}
.symbols-legal {
    margin-top: 24px;
    font-size: 13px;
    color: #666;
    font-style: italic;
}
.symbols-grid-flag { max-width: none; }
.symbols-section-song { max-width: 640px; }
.symbols-song-text { line-height: 1.8; color: #333; }
.symbols-song-text p { margin-bottom: 1.5em; }
.symbols-song-chorus { font-weight: 600; color: #1a3c1a; }

</style>
@endsection
