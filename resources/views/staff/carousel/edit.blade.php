@extends('layouts.app')

@section('title', 'Редактировать слайд')

@section('content')
<div class="staff-carousel-edit">
    <h1>Редактировать слайд</h1>
    <a href="{{ route('staff.carousel.index') }}" class="btn btn-sm" style="margin-bottom: 20px;">← К списку слайдов</a>

    <div class="carousel-edit-preview" style="margin-bottom: 20px;">
        <img src="{{ asset('storage/' . $slide->image) }}" alt="" style="max-width: 300px; height: auto; border-radius: 8px;">
    </div>

    <form action="{{ route('staff.carousel.update', $slide) }}" method="POST" enctype="multipart/form-data" style="max-width: 400px;">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label class="form-label">Новое изображение (оставьте пустым, чтобы не менять)</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Порядок</label>
            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $slide->sort_order) }}" min="0">
        </div>
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="{{ route('staff.carousel.index') }}" class="btn">Отмена</a>
    </form>
</div>
@endsection
