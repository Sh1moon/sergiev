<form action="{{ route('appeals.store') }}" method="POST" class="appeals-form" enctype="multipart/form-data">
    @csrf

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
