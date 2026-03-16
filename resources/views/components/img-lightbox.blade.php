<div class="img-lightbox-overlay" id="imgLightbox" role="dialog" aria-modal="true" aria-label="Увеличенное изображение" hidden>
    <button type="button" class="img-lightbox-close" aria-label="Закрыть">&times;</button>
    <img src="" alt="" class="img-lightbox-img">
</div>

<style>
.img-lightbox-overlay {
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
.img-lightbox-overlay[hidden] { display: none; }
.img-lightbox-overlay.img-lightbox-open {
    opacity: 1;
    visibility: visible;
    display: flex;
}
.img-lightbox-close {
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
.img-lightbox-close:hover { background: rgba(255,255,255,0.3); }
.img-lightbox-img {
    max-width: 95vw;
    max-height: 90vh;
    width: auto;
    height: auto;
    object-fit: contain;
}
.js-img-lightbox { cursor: pointer; }
</style>

<script>
(function() {
    document.addEventListener('DOMContentLoaded', function() {
        var lightbox = document.getElementById('imgLightbox');
        var lightboxImg = lightbox ? lightbox.querySelector('.img-lightbox-img') : null;
        var closeBtn = lightbox ? lightbox.querySelector('.img-lightbox-close') : null;
        function openLightbox(src, alt) {
            if (!lightboxImg || !lightbox) return;
            lightboxImg.src = src;
            lightboxImg.alt = alt || '';
            lightbox.removeAttribute('hidden');
            lightbox.classList.add('img-lightbox-open');
            document.body.style.overflow = 'hidden';
            if (closeBtn) closeBtn.focus();
        }
        function closeLightbox() {
            if (!lightbox) return;
            lightbox.setAttribute('hidden', '');
            lightbox.classList.remove('img-lightbox-open');
            document.body.style.overflow = '';
        }
        document.body.addEventListener('click', function(e) {
            var el = e.target.closest('.js-img-lightbox');
            if (!el) return;
            var img = el.tagName === 'IMG' ? el : el.querySelector('img');
            if (img && img.src && img.style.display !== 'none') {
                e.preventDefault();
                e.stopPropagation();
                openLightbox(img.src, img.alt);
            }
        });
        document.body.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeLightbox();
            var el = document.activeElement && document.activeElement.closest('.js-img-lightbox');
            if (el && (e.key === 'Enter' || e.key === ' ')) {
                e.preventDefault();
                var img = el.tagName === 'IMG' ? el : el.querySelector('img');
                if (img && img.src && img.style.display !== 'none') openLightbox(img.src, img.alt);
            }
        });
        if (closeBtn) closeBtn.addEventListener('click', closeLightbox);
        if (lightbox) lightbox.addEventListener('click', function(e) {
            if (e.target === lightbox) closeLightbox();
        });
    });
})();
</script>
