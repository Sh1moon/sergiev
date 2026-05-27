<form action="{{ route('appeals.store') }}" method="POST" class="appeals-form" enctype="multipart/form-data">
    @csrf
    @php($problemCategories = $problemCategories ?? collect())

    <div class="form-group">
        <label for="fio" class="form-label">ФИО <span class="required">*</span></label>
        <input type="text" name="fio" id="fio" class="form-control @error('fio') is-invalid @enderror"
               value="{{ old('fio', Auth::user()->name ?? '') }}" required maxlength="255" autocomplete="name">
        @error('fio')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="postal_address" class="form-label">Почтовый адрес</label>
        <input type="text" name="postal_address" id="postal_address" class="form-control @error('postal_address') is-invalid @enderror"
               value="{{ old('postal_address') }}" maxlength="500" autocomplete="street-address">
        @error('postal_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="email" class="form-label">Адрес электронной почты <span class="required">*</span></label>
        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', Auth::user()->email ?? '') }}" required maxlength="255" autocomplete="email">
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="phone" class="form-label">Номер телефона</label>
        <input type="tel" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
               value="{{ old('phone') }}" maxlength="50" autocomplete="tel">
        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="problem_category_id" class="form-label">Категория проблемы</label>
        <select name="problem_category_id" id="problem_category_id" class="form-control @error('problem_category_id') is-invalid @enderror">
            <option value="">Выберите категорию</option>
            @foreach($problemCategories as $category)
                <option value="{{ $category->id }}" @selected((string) old('problem_category_id') === (string) $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('problem_category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="problem_subcategory_id" class="form-label">Подкатегория</label>
        <select name="problem_subcategory_id" id="problem_subcategory_id" class="form-control @error('problem_subcategory_id') is-invalid @enderror">
            <option value="">Сначала выберите категорию</option>
        </select>
        @error('problem_subcategory_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="problem_detail_id" class="form-label">Детальная проблема</label>
        <select name="problem_detail_id" id="problem_detail_id" class="form-control @error('problem_detail_id') is-invalid @enderror">
            <option value="">Сначала выберите подкатегорию</option>
        </select>
        @error('problem_detail_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="body" class="form-label">Текст обращения <span class="required">*</span></label>
        <textarea name="body" id="body" class="form-control @error('body') is-invalid @enderror" rows="6"
                  required maxlength="10000" placeholder="Опишите суть обращения...">{{ old('body') }}</textarea>
        @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        <label for="attachment" class="form-label">Прикрепить файл</label>
        <input type="file" name="attachment" id="attachment" class="form-control"
               accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
        <span class="form-hint">До 10 МБ. Форматы: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG.</span>
        @error('attachment')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group form-group-consent">
        <label class="consent-label">
            <input type="checkbox" name="consent" value="1" class="consent-checkbox @error('consent') is-invalid @enderror"
                   {{ old('consent') ? 'checked' : '' }} required>
            <span class="consent-text">
                Даю согласие на обработку персональных данных
                <span class="consent-tooltip-wrap" tabindex="0" role="button" aria-label="Правовая основа обработки персональных данных">
                    <span class="consent-tooltip-icon" title="">ⓘ</span>
                    <span class="consent-tooltip-content">
                        Обработка персональных данных осуществляется в соответствии с Федеральным законом от 27.07.2006 № 152-ФЗ «О персональных данных» (ст. 6, 9). Согласие даётся на сбор, хранение и использование указанных данных исключительно в целях рассмотрения обращения и направления ответа заявителю. Персональные данные не передаются третьим лицам, за исключением случаев, предусмотренных законодательством РФ.
                    </span>
                </span>
            </span>
        </label>
        @error('consent')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Отправить обращение</button>
    </div>
</form>

<script>
    (function () {
        const categorySelect = document.getElementById('problem_category_id');
        const subcategorySelect = document.getElementById('problem_subcategory_id');
        const detailSelect = document.getElementById('problem_detail_id');
        if (!categorySelect || !subcategorySelect || !detailSelect) return;

        const selectedSubcategory = @json(old('problem_subcategory_id'));
        const selectedDetail = @json(old('problem_detail_id'));

        const fillOptions = (select, options, placeholder, selectedValue) => {
            select.innerHTML = `<option value="">${placeholder}</option>`;
            options.forEach((item) => {
                const opt = document.createElement('option');
                opt.value = String(item.id);
                opt.textContent = item.name;
                if (selectedValue && String(selectedValue) === String(item.id)) {
                    opt.selected = true;
                }
                select.appendChild(opt);
            });
        };

        const loadSubcategories = async (categoryId, selectedValue = null) => {
            if (!categoryId) {
                fillOptions(subcategorySelect, [], 'Сначала выберите категорию');
                fillOptions(detailSelect, [], 'Сначала выберите подкатегорию');
                return;
            }
            const response = await fetch(`/api/problem-subcategories/${categoryId}`);
            const data = await response.json();
            fillOptions(subcategorySelect, data, 'Выберите подкатегорию', selectedValue);
            const currentSubcategory = subcategorySelect.value;
            await loadDetails(currentSubcategory, selectedDetail);
        };

        const loadDetails = async (subcategoryId, selectedValue = null) => {
            if (!subcategoryId) {
                fillOptions(detailSelect, [], 'Сначала выберите подкатегорию');
                return;
            }
            const response = await fetch(`/api/problem-details/${subcategoryId}`);
            const data = await response.json();
            fillOptions(detailSelect, data, 'Выберите детальную проблему', selectedValue);
        };

        categorySelect.addEventListener('change', async () => {
            await loadSubcategories(categorySelect.value, null);
        });

        subcategorySelect.addEventListener('change', async () => {
            await loadDetails(subcategorySelect.value, null);
        });

        if (categorySelect.value) {
            loadSubcategories(categorySelect.value, selectedSubcategory);
        }
    })();
</script>
