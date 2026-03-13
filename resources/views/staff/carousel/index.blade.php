@extends('layouts.app')

@section('title', 'Карусель на главной')

@section('content')
<div class="staff-carousel">
    <h1>Карусель на главной</h1>
    <a href="{{ route('staff.articles.index') }}" class="btn btn-sm" style="margin-bottom: 20px;">← К статьям</a>

    <form action="{{ route('staff.carousel.store') }}" method="POST" enctype="multipart/form-data" class="carousel-add-form">
        @csrf
        <div class="form-group">
            <label class="form-label">Изображение *</label>
            <input type="file" name="image" class="form-control" accept="image/*" required>
            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Порядок</label>
            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
        </div>
        <button type="submit" class="btn btn-primary">Добавить слайд</button>
    </form>

    <div class="carousel-list">
        @forelse($slides as $slide)
        <div class="carousel-slide-item">
            <img src="{{ asset('storage/' . $slide->image) }}" alt="">
            <form action="{{ route('staff.carousel.destroy', $slide) }}" method="POST" style="margin-top: 8px;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm js-confirm-delete" data-confirm-message="Удалить слайд?">Удалить</button>
            </form>
        </div>
        @empty
        <p>Нет слайдов. Добавьте изображения — они будут отображаться на главной от края до края без подписей.</p>
        @endforelse
    </div>
</div>

<style>
.staff-carousel { padding: 20px 0; }
.staff-carousel h1 { color: #1a3c1a; margin-bottom: 16px; }
.carousel-add-form { max-width: 400px; margin-bottom: 32px; padding: 20px; background: #f9f9f9; border-radius: 8px; }
.carousel-list { display: flex; flex-wrap: wrap; gap: 20px; }
.carousel-slide-item { width: 200px; }
.carousel-slide-item img { width: 100%; height: 120px; object-fit: cover; border-radius: 4px; display: block; }
</style>
@endsection
