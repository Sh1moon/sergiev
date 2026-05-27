<div id="a11yUiRoot" class="a11y-ui">
    <div class="a11y-bar">
        <button
            id="a11yTrigger"
            class="a11y-trigger"
            type="button"
            aria-label="Открыть режим для слабовидящих"
            aria-controls="a11yPanel"
            aria-expanded="false"
        >
            Режим для слабовидящих
        </button>
    </div>

    <div id="a11yBackdrop" class="a11y-backdrop" aria-hidden="true"></div>

    <aside
        id="a11yPanel"
        class="a11y-panel"
        role="dialog"
        aria-modal="true"
        aria-label="Панель версии для слабовидящих"
        aria-hidden="true"
    >
    <button id="closeXBtn" class="a11y-close-x" type="button" aria-label="Закрыть окно">×</button>
    <h2 class="a11y-title">Версия для слабовидящих</h2>

    <section class="a11y-group">
        <h3>Размер шрифта</h3>
        <div class="a11y-range-wrap">
            <button id="fontMinus" class="a11y-btn" type="button" aria-label="Уменьшить шрифт">A-</button>
            <input
                id="fontRange"
                class="a11y-range"
                type="range"
                min="100"
                max="150"
                step="25"
                value="100"
                aria-label="Размер шрифта: 100, 125 или 150 процентов"
            >
            <button id="fontPlus" class="a11y-btn" type="button" aria-label="Увеличить шрифт">A+</button>
            <strong id="fontValue" aria-live="polite">100%</strong>
        </div>
    </section>

    <section class="a11y-group">
        <h3>Шрифт</h3>
        <div class="a11y-row">
            <select id="fontFamily" class="a11y-select" aria-label="Выбор шрифта">
                <option value="default">По умолчанию</option>
                <option value="Arial">Arial</option>
                <option value="Tahoma">Tahoma</option>
                <option value="Verdana">Verdana</option>
            </select>
        </div>
    </section>

    <section class="a11y-group">
        <h3>Цветовая схема</h3>
        <div class="a11y-row">
            <button class="a11y-btn a11y-swatch a11y-swatch-bw" data-scheme="bw" type="button" aria-label="Схема: чёрный на белом">Ч/Б</button>
            <button class="a11y-btn a11y-swatch a11y-swatch-wb" data-scheme="wb" type="button" aria-label="Схема: белый на чёрном">Б/Ч</button>
            <button class="a11y-btn a11y-swatch a11y-swatch-by" data-scheme="by" type="button" aria-label="Схема: чёрный на жёлтом">Ч/Ж</button>
            <button class="a11y-btn a11y-swatch a11y-swatch-yb" data-scheme="yb" type="button" aria-label="Схема: жёлтый на чёрном">Ж/Ч</button>
        </div>
    </section>

    <section class="a11y-group">
        <h3>Дополнительно</h3>
        <div class="a11y-row">
            <button id="invertBtn" class="a11y-btn" type="button" aria-label="Включить или выключить инверсию цветов">Инверсия</button>
            <button id="monoBtn" class="a11y-btn" type="button" aria-label="Включить или выключить монохромный режим">Монохром</button>
        </div>
        <div class="a11y-row a11y-row-spaced">
            <label class="a11y-check" aria-label="Показать рамки фокуса">
                <input id="focusToggle" type="checkbox">
                Показать рамки фокуса
            </label>
            <label class="a11y-check" aria-label="Отключить анимации">
                <input id="animToggle" type="checkbox">
                Отключить анимации
            </label>
        </div>
    </section>

        <div class="a11y-footer">
            <button id="resetBtn" class="a11y-btn" type="button" aria-label="Сбросить настройки версии для слабовидящих">Сброс</button>
            <button id="closeBtn" class="a11y-btn" type="button" aria-label="Закрыть панель версии для слабовидящих">Закрыть</button>
        </div>
    </aside>
</div>

