{{-- Модальное окно подтверждения удаления. Кнопки удаления с классом js-confirm-delete и data-confirm-message="Текст" открывают это окно. --}}
<div id="confirmDeleteModal" class="confirm-delete-modal" role="dialog" aria-labelledby="confirmDeleteModalTitle" aria-modal="true" aria-hidden="true" hidden>
    <div class="confirm-delete-modal-backdrop" data-dismiss="modal"></div>
    <div class="confirm-delete-modal-dialog">
        <div class="confirm-delete-modal-content">
            <h2 class="confirm-delete-modal-title" id="confirmDeleteModalTitle">Подтверждение удаления</h2>
            <p class="confirm-delete-modal-message" id="confirmDeleteModalMessage">Вы уверены, что хотите удалить?</p>
            <div class="confirm-delete-modal-actions">
                <button type="button" class="btn btn-danger confirm-delete-modal-submit" id="confirmDeleteModalSubmit">Удалить</button>
                <button type="button" class="btn confirm-delete-modal-cancel" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>

<style>
.confirm-delete-modal {
    position: fixed;
    inset: 0;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.2s ease, visibility 0.2s ease;
}
.confirm-delete-modal.is-open {
    opacity: 1;
    visibility: visible;
}
.confirm-delete-modal[hidden] { display: none !important; }
.confirm-delete-modal:not([hidden]).is-open { display: flex !important; }

.confirm-delete-modal-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    cursor: pointer;
}

.confirm-delete-modal-dialog {
    position: relative;
    width: 100%;
    max-width: 420px;
    max-height: 90vh;
    overflow: auto;
}

.confirm-delete-modal-content {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    padding: 24px;
    border: 1px solid #e0e0e0;
}

.confirm-delete-modal-title {
    margin: 0 0 12px;
    font-size: 1.25rem;
    color: #1a3c1a;
}

.confirm-delete-modal-message {
    margin: 0 0 20px;
    color: #333;
    line-height: 1.5;
}

.confirm-delete-modal-actions {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    flex-wrap: wrap;
}

.confirm-delete-modal-submit { min-width: 100px; }
.confirm-delete-modal-cancel { background: #6c757d; color: #fff; }
.confirm-delete-modal-cancel:hover { background: #5a6268; color: #fff; }

body.a11y-mode .confirm-delete-modal-content { border: 2px solid #000; }
body.a11y-mode .confirm-delete-modal-title { color: #000; }
body.a11y-mode .confirm-delete-modal-message { color: #000; }
</style>

<script>
(function() {
    var modal = document.getElementById('confirmDeleteModal');
    var messageEl = document.getElementById('confirmDeleteModalMessage');
    var submitBtn = document.getElementById('confirmDeleteModalSubmit');
    var pendingFormId = null;

    function openModal(message, form) {
        if (!modal || !form) return;
        pendingFormId = form.id || ('confirm-delete-form-' + Date.now());
        if (!form.id) form.id = pendingFormId;
        messageEl.textContent = message || 'Вы уверены, что хотите удалить?';
        modal.removeAttribute('hidden');
        modal.setAttribute('aria-hidden', 'false');
        modal.classList.add('is-open');
        submitBtn.focus();
    }

    function closeModal() {
        if (!modal) return;
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        modal.setAttribute('hidden', '');
        pendingFormId = null;
    }

    function confirmSubmit(e) {
        e.preventDefault();
        var form = pendingFormId ? document.getElementById(pendingFormId) : null;
        if (form) {
            form.submit();
        }
        closeModal();
    }

    document.addEventListener('click', function(e) {
        var btn = e.target.closest('.js-confirm-delete');
        if (btn && btn.type === 'submit') {
            e.preventDefault();
            e.stopPropagation();
            var form = btn.closest('form');
            if (!form) return;
            openModal(btn.getAttribute('data-confirm-message') || 'Вы уверены, что хотите удалить?', form);
        }
        if (e.target.closest('[data-dismiss="modal"]')) {
            closeModal();
        }
    });

    if (submitBtn) submitBtn.addEventListener('click', confirmSubmit);

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal && modal.classList.contains('is-open')) {
            closeModal();
        }
    });
})();
</script>
