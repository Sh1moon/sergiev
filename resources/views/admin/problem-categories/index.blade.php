@extends('layouts.app')

@section('title', 'Каталог проблем')

@section('content')
<div class="problem-catalog">
    <h1>Каталог проблем</h1>
    <p class="catalog-intro">Полная иерархия для обращений: категория -> подкатегория -> детальная проблема.</p>

    <section class="catalog-create-grid">
        <div class="catalog-card">
            <h2>Новая категория</h2>
            <form method="POST" action="{{ route('admin.problem-categories.store') }}" class="catalog-form">
                @csrf
                <input type="text" name="name" class="form-control" required maxlength="255" placeholder="Название категории">
                <input type="text" name="description" class="form-control" maxlength="255" placeholder="Описание (опционально)">
                <input type="number" name="sort_order" class="form-control" min="0" value="0" placeholder="Порядок">
                <label class="catalog-check"><input type="checkbox" name="is_active" value="1" checked> Активна</label>
                <button type="submit" class="btn btn-primary">Добавить категорию</button>
            </form>
        </div>
        <div class="catalog-card">
            <h2>Новая подкатегория</h2>
            <form method="POST" action="{{ route('admin.problem-subcategories.store') }}" class="catalog-form">
                @csrf
                <select name="problem_category_id" class="form-control" required>
                    <option value="">Категория</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <input type="text" name="name" class="form-control" required maxlength="255" placeholder="Название подкатегории">
                <input type="text" name="description" class="form-control" maxlength="255" placeholder="Описание (опционально)">
                <input type="number" name="sort_order" class="form-control" min="0" value="0" placeholder="Порядок">
                <label class="catalog-check"><input type="checkbox" name="is_active" value="1" checked> Активна</label>
                <button type="submit" class="btn btn-primary">Добавить подкатегорию</button>
            </form>
        </div>
        <div class="catalog-card">
            <h2>Новая детальная проблема</h2>
            <form method="POST" action="{{ route('admin.problem-details.store') }}" class="catalog-form">
                @csrf
                <select name="problem_subcategory_id" class="form-control" required>
                    <option value="">Подкатегория</option>
                    @foreach($categories as $category)
                        @foreach($category->subcategories as $subcategory)
                            <option value="{{ $subcategory->id }}">{{ $category->name }} -> {{ $subcategory->name }}</option>
                        @endforeach
                    @endforeach
                </select>
                <input type="text" name="name" class="form-control" required maxlength="255" placeholder="Название детальной проблемы">
                <input type="text" name="description" class="form-control" maxlength="255" placeholder="Описание (опционально)">
                <input type="number" name="sort_order" class="form-control" min="0" value="0" placeholder="Порядок">
                <label class="catalog-check"><input type="checkbox" name="is_active" value="1" checked> Активна</label>
                <button type="submit" class="btn btn-primary">Добавить деталь</button>
            </form>
        </div>
    </section>

    <section class="catalog-tree">
        @forelse($categories as $category)
            <article class="tree-category">
                <div class="tree-header">
                    <h3>Категория: {{ $category->name }}</h3>
                    <span class="tree-badge">Обращений: {{ $category->appeals_count }}</span>
                </div>
                <form method="POST" action="{{ route('admin.problem-categories.update', $category) }}" class="tree-edit-form">
                    @csrf
                    @method('PUT')
                    <input type="text" name="name" class="form-control" value="{{ $category->name }}" required maxlength="255">
                    <input type="text" name="description" class="form-control" value="{{ $category->description }}" maxlength="255">
                    <input type="number" name="sort_order" class="form-control" min="0" value="{{ $category->sort_order }}">
                    <label class="catalog-check">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" @checked($category->is_active)> Активна
                    </label>
                    <button type="submit" class="btn btn-sm btn-secondary">Сохранить</button>
                </form>
                <form method="POST" action="{{ route('admin.problem-categories.destroy', $category) }}" onsubmit="return confirm('Удалить категорию вместе со всей вложенной иерархией?')" class="tree-delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Удалить категорию</button>
                </form>

                <div class="tree-subcategories">
                    @forelse($category->subcategories as $subcategory)
                        <div class="tree-subcategory">
                            <div class="tree-header">
                                <h4>Подкатегория: {{ $subcategory->name }}</h4>
                                <span class="tree-badge">Обращений: {{ $subcategory->appeals_count }}</span>
                            </div>
                            <form method="POST" action="{{ route('admin.problem-subcategories.update', $subcategory) }}" class="tree-edit-form">
                                @csrf
                                @method('PUT')
                                <select name="problem_category_id" class="form-control" required>
                                    @foreach($categories as $categoryOption)
                                        <option value="{{ $categoryOption->id }}" @selected($categoryOption->id === $subcategory->problem_category_id)>{{ $categoryOption->name }}</option>
                                    @endforeach
                                </select>
                                <input type="text" name="name" class="form-control" value="{{ $subcategory->name }}" required maxlength="255">
                                <input type="text" name="description" class="form-control" value="{{ $subcategory->description }}" maxlength="255">
                                <input type="number" name="sort_order" class="form-control" min="0" value="{{ $subcategory->sort_order }}">
                                <label class="catalog-check">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" value="1" @checked($subcategory->is_active)> Активна
                                </label>
                                <button type="submit" class="btn btn-sm btn-secondary">Сохранить</button>
                            </form>
                            <form method="POST" action="{{ route('admin.problem-subcategories.destroy', $subcategory) }}" onsubmit="return confirm('Удалить подкатегорию вместе с детальными проблемами?')" class="tree-delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Удалить подкатегорию</button>
                            </form>

                            <div class="tree-details">
                                @forelse($subcategory->details as $detail)
                                    <div class="tree-detail">
                                        <div class="tree-header">
                                            <h5>Детальная проблема: {{ $detail->name }}</h5>
                                            <span class="tree-badge">Обращений: {{ $detail->appeals_count }}</span>
                                        </div>
                                        <form method="POST" action="{{ route('admin.problem-details.update', $detail) }}" class="tree-edit-form">
                                            @csrf
                                            @method('PUT')
                                            <select name="problem_subcategory_id" class="form-control" required>
                                                @foreach($categories as $categoryOption)
                                                    @foreach($categoryOption->subcategories as $subcategoryOption)
                                                        <option value="{{ $subcategoryOption->id }}" @selected($subcategoryOption->id === $detail->problem_subcategory_id)>
                                                            {{ $categoryOption->name }} -> {{ $subcategoryOption->name }}
                                                        </option>
                                                    @endforeach
                                                @endforeach
                                            </select>
                                            <input type="text" name="name" class="form-control" value="{{ $detail->name }}" required maxlength="255">
                                            <input type="text" name="description" class="form-control" value="{{ $detail->description }}" maxlength="255">
                                            <input type="number" name="sort_order" class="form-control" min="0" value="{{ $detail->sort_order }}">
                                            <label class="catalog-check">
                                                <input type="hidden" name="is_active" value="0">
                                                <input type="checkbox" name="is_active" value="1" @checked($detail->is_active)> Активна
                                            </label>
                                            <button type="submit" class="btn btn-sm btn-secondary">Сохранить</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.problem-details.destroy', $detail) }}" onsubmit="return confirm('Удалить детальную проблему?')" class="tree-delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Удалить деталь</button>
                                        </form>
                                    </div>
                                @empty
                                    <p class="tree-empty">В этой подкатегории пока нет детальных проблем.</p>
                                @endforelse
                            </div>
                        </div>
                    @empty
                        <p class="tree-empty">В этой категории пока нет подкатегорий.</p>
                    @endforelse
                </div>
            </article>
        @empty
            <p>Каталог пока пуст.</p>
        @endforelse
    </section>
</div>

<style>
.problem-catalog { padding: 20px 0; }
.catalog-intro { color: #555; margin-bottom: 16px; }
.catalog-create-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 14px; margin-bottom: 20px; }
.catalog-card { background: #fff; border: 1px solid #e2e8e2; border-radius: 10px; padding: 14px; }
.catalog-card h2 { margin: 0 0 10px; color: #1a3c1a; font-size: 18px; }
.catalog-form { display: grid; gap: 8px; }
.catalog-check { font-size: 14px; color: #444; display: inline-flex; align-items: center; gap: 6px; }
.catalog-tree { display: grid; gap: 16px; }
.tree-category, .tree-subcategory, .tree-detail { background: #fff; border: 1px solid #e2e8e2; border-radius: 10px; padding: 12px; }
.tree-subcategories { margin-top: 12px; display: grid; gap: 10px; }
.tree-details { margin-top: 10px; display: grid; gap: 8px; }
.tree-header { display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 8px; flex-wrap: wrap; }
.tree-header h3, .tree-header h4, .tree-header h5 { margin: 0; color: #1a3c1a; }
.tree-badge { font-size: 12px; color: #0b5394; background: #e3f2fd; border-radius: 4px; padding: 3px 8px; }
.tree-edit-form { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 8px; margin-bottom: 8px; }
.tree-delete-form { margin-bottom: 8px; }
.tree-empty { margin: 8px 0; color: #666; font-size: 14px; }
</style>
@endsection
