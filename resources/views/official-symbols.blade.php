@extends('layouts.app')

@section('title', 'Официальные символы')

@section('content')
<div class="official-symbols-page">
    <h1 class="page-title">Официальные символы</h1>

    <section class="symbols-section">
        <h2>Герб Сергиево-Посадского городского округа Московской области</h2>

        <div class="symbols-grid">
            <figure class="symbols-item">
                <div class="symbols-img-wrap symbols-img-clickable" role="button" tabindex="0" aria-label="Увеличить">
                    <img src="{{ asset('images/symbols/gerb-color.jpg') }}" alt="Герб многоцветный" onerror="this.style.display='none'; this.nextElementSibling.classList.add('visible');">
                    <div class="symbols-placeholder"><span>Герб<br>(многоцветный)</span></div>
                </div>
                <figcaption>Герб Сергиево-Посадского городского округа (многоцветный)</figcaption>
            </figure>
            <figure class="symbols-item">
                <div class="symbols-img-wrap symbols-img-clickable" role="button" tabindex="0" aria-label="Увеличить">
                    <img src="{{ asset('images/symbols/gerb-mono.jpg') }}" alt="Герб одноцветный" onerror="this.style.display='none'; this.nextElementSibling.classList.add('visible');">
                    <div class="symbols-placeholder"><span>Герб<br>(одноцветный)</span></div>
                </div>
                <figcaption>Герб Сергиево-Посадского городского округа (одноцветный)</figcaption>
            </figure>
            <figure class="symbols-item">
                <div class="symbols-img-wrap symbols-img-clickable" role="button" tabindex="0" aria-label="Увеличить">
                    <img src="{{ asset('images/symbols/gerb-hatch.jpg') }}" alt="Герб с штриховкой" onerror="this.style.display='none'; this.nextElementSibling.classList.add('visible');">
                    <div class="symbols-placeholder"><span>Герб<br>(с штриховкой)</span></div>
                </div>
                <figcaption>Герб Сергиево-Посадского городского округа (одноцветный, с условной штриховкой для обозначения цвета)</figcaption>
            </figure>

            <figure class="symbols-item">
                <div class="symbols-img-wrap symbols-img-clickable" role="button" tabindex="0" aria-label="Увеличить">
                    <img src="{{ asset('images/symbols/gerb-volnaya-color.jpg') }}" alt="Герб с вольной частью многоцветный" onerror="this.style.display='none'; this.nextElementSibling.classList.add('visible');">
                    <div class="symbols-placeholder"><span>С вольной частью<br>(многоцветный)</span></div>
                </div>
                <figcaption>Герб с вольной частью (многоцветный)</figcaption>
            </figure>
            <figure class="symbols-item">
                <div class="symbols-img-wrap symbols-img-clickable" role="button" tabindex="0" aria-label="Увеличить">
                    <img src="{{ asset('images/symbols/gerb-volnaya-mono.jpg') }}" alt="Герб с вольной частью одноцветный" onerror="this.style.display='none'; this.nextElementSibling.classList.add('visible');">
                    <div class="symbols-placeholder"><span>С вольной частью<br>(одноцветный)</span></div>
                </div>
                <figcaption>Герб с вольной частью (одноцветный)</figcaption>
            </figure>
            <figure class="symbols-item">
                <div class="symbols-img-wrap symbols-img-clickable" role="button" tabindex="0" aria-label="Увеличить">
                    <img src="{{ asset('images/symbols/gerb-volnaya-hatch.jpg') }}" alt="Герб с вольной частью с штриховкой" onerror="this.style.display='none'; this.nextElementSibling.classList.add('visible');">
                    <div class="symbols-placeholder"><span>С вольной частью<br>(с штриховкой)</span></div>
                </div>
                <figcaption>Герб с вольной частью (одноцветный, с условной штриховкой для обозначения цвета)</figcaption>
            </figure>

            <figure class="symbols-item">
                <div class="symbols-img-wrap symbols-img-clickable" role="button" tabindex="0" aria-label="Увеличить">
                    <img src="{{ asset('images/symbols/gerb-crown-color.jpg') }}" alt="Герб с короной многоцветный" onerror="this.style.display='none'; this.nextElementSibling.classList.add('visible');">
                    <div class="symbols-placeholder"><span>С короной<br>(многоцветный)</span></div>
                </div>
                <figcaption>Герб (многоцветный) с короной, соответствующей статусу Сергиево-Посадского городского округа</figcaption>
            </figure>
            <figure class="symbols-item">
                <div class="symbols-img-wrap symbols-img-clickable" role="button" tabindex="0" aria-label="Увеличить">
                    <img src="{{ asset('images/symbols/gerb-crown-mono.jpg') }}" alt="Герб с короной одноцветный" onerror="this.style.display='none'; this.nextElementSibling.classList.add('visible');">
                    <div class="symbols-placeholder"><span>С короной<br>(одноцветный)</span></div>
                </div>
                <figcaption>Герб (одноцветный) с короной, соответствующей статусу Сергиево-Посадского городского округа</figcaption>
            </figure>
            <figure class="symbols-item">
                <div class="symbols-img-wrap symbols-img-clickable" role="button" tabindex="0" aria-label="Увеличить">
                    <img src="{{ asset('images/symbols/gerb-crown-hatch.jpg') }}" alt="Герб с короной с штриховкой" onerror="this.style.display='none'; this.nextElementSibling.classList.add('visible');">
                    <div class="symbols-placeholder"><span>С короной<br>(с штриховкой)</span></div>
                </div>
                <figcaption>Герб (одноцветный, с условной штриховкой для обозначения цвета) с короной, соответствующей статусу Сергиево-Посадского городского округа</figcaption>
            </figure>

            <figure class="symbols-item">
                <div class="symbols-img-wrap symbols-img-clickable" role="button" tabindex="0" aria-label="Увеличить">
                    <img src="{{ asset('images/symbols/gerb-volnaya-crown-color.jpg') }}" alt="Герб с вольной частью и короной многоцветный" onerror="this.style.display='none'; this.nextElementSibling.classList.add('visible');">
                    <div class="symbols-placeholder"><span>С вольной частью и короной<br>(многоцветный)</span></div>
                </div>
                <figcaption>Герб (многоцветный) с вольной частью и с короной, соответствующей статусу Сергиево-Посадского городского округа</figcaption>
            </figure>
            <figure class="symbols-item">
                <div class="symbols-img-wrap symbols-img-clickable" role="button" tabindex="0" aria-label="Увеличить">
                    <img src="{{ asset('images/symbols/gerb-volnaya-crown-mono.jpg') }}" alt="Герб с вольной частью и короной одноцветный" onerror="this.style.display='none'; this.nextElementSibling.classList.add('visible');">
                    <div class="symbols-placeholder"><span>С вольной частью и короной<br>(одноцветный)</span></div>
                </div>
                <figcaption>Герб (одноцветный) с вольной частью и с короной, соответствующей статусу Сергиево-Посадского городского округа</figcaption>
            </figure>
            <figure class="symbols-item">
                <div class="symbols-img-wrap symbols-img-clickable" role="button" tabindex="0" aria-label="Увеличить">
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
                <div class="symbols-img-wrap symbols-img-clickable" role="button" tabindex="0" aria-label="Увеличить">
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

<div class="symbols-lightbox-overlay" id="symbolsLightbox" role="dialog" aria-modal="true" aria-label="Увеличенное изображение" hidden>
    <button type="button" class="symbols-lightbox-close" aria-label="Закрыть">&times;</button>
    <img src="" alt="" class="symbols-lightbox-img">
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const lightbox = document.getElementById('symbolsLightbox');
    const lightboxImg = lightbox?.querySelector('.symbols-lightbox-img');
    const closeBtn = lightbox?.querySelector('.symbols-lightbox-close');
    const clickables = document.querySelectorAll('.symbols-img-clickable');
    function openLightbox(src, alt) {
        if (!lightboxImg || !lightbox) return;
        lightboxImg.src = src;
        lightboxImg.alt = alt || '';
        lightbox.removeAttribute('hidden');
        lightbox.classList.add('symbols-lightbox-open');
        document.body.style.overflow = 'hidden';
        closeBtn?.focus();
    }
    function closeLightbox() {
        if (!lightbox) return;
        lightbox.setAttribute('hidden', '');
        lightbox.classList.remove('symbols-lightbox-open');
        document.body.style.overflow = '';
    }
    clickables.forEach(function(el) {
        el.addEventListener('click', function() {
            const img = el.querySelector('img');
            if (img && img.src && img.style.display !== 'none') openLightbox(img.src, img.alt);
        });
        el.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                const img = el.querySelector('img');
                if (img && img.src && img.style.display !== 'none') openLightbox(img.src, img.alt);
            }
        });
    });
    closeBtn?.addEventListener('click', closeLightbox);
    lightbox?.addEventListener('click', function(e) {
        if (e.target === lightbox) closeLightbox();
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeLightbox();
    });
});
</script>

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

.symbols-lightbox-overlay {
    position: fixed;
    inset: 0;
    z-index: 2000;
    background: rgba(0,0,0,0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s, visibility 0.3s;
}
.symbols-lightbox-overlay[hidden] { display: none; }
.symbols-lightbox-overlay.symbols-lightbox-open {
    opacity: 1;
    visibility: visible;
    display: flex;
}
.symbols-lightbox-close {
    position: absolute;
    top: 20px;
    right: 20px;
    width: 44px;
    height: 44px;
    border: none;
    background: rgba(255,255,255,0.2);
    color: #fff;
    font-size: 32px;
    line-height: 1;
    cursor: pointer;
    border-radius: 8px;
    padding: 0;
}
.symbols-lightbox-close:hover { background: rgba(255,255,255,0.3); }
.symbols-lightbox-img {
    max-width: 95vw;
    max-height: 90vh;
    width: auto;
    height: auto;
    object-fit: contain;
}
</style>
@endsection
