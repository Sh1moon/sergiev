@extends('layouts.app')

@section('title', 'ГО и ЧС')

@section('content')
<div class="staff-content-form">
    <h1>ГО и ЧС</h1>
    <a href="{{ route('staff.content.index') }}" class="btn btn-sm" style="margin-bottom: 20px;">← К списку разделов</a>

    <form action="{{ route('staff.content.go-chs.update') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label class="form-label">Содержимое раздела</label>
            <textarea name="body" class="form-control" rows="25">{{ old('body', $item->body) }}</textarea>
            <small>Можно использовать HTML: &lt;p&gt;, &lt;h3&gt;, &lt;a href=""&gt;, &lt;strong&gt; и т.д.</small>
            @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('staff.content.index') }}" class="btn">Отмена</a>
        </div>
    </form>
</div>

<style>
.staff-content-form { padding: 20px 0; max-width: 800px; }
.staff-content-form h1 { color: #1a3c1a; margin-bottom: 16px; }
.form-actions { margin-top: 24px; display: flex; gap: 12px; }
</style>
@endsection
