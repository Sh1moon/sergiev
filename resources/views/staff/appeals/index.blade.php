@extends('layouts.app')

@section('title', 'Обращения граждан')

@section('content')
<div class="staff-appeals">
    <h1>Обращения граждан</h1>

    <form method="get" class="appeals-toolbar">
        <div class="appeals-search-wrap">
            <input type="text" name="q" value="{{ $search }}" class="form-control appeals-search" placeholder="Поиск по ФИО, email, тексту...">
            <select name="problem_category_id" id="problem_category_id" class="form-control appeals-filter">
                <option value="">Все категории</option>
                @foreach($problemCategories as $category)
                    <option value="{{ $category->id }}" @selected($selectedCategoryId === $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            <select name="problem_subcategory_id" id="problem_subcategory_id" class="form-control appeals-filter">
                <option value="">Все подкатегории</option>
            </select>
            <select name="problem_detail_id" id="problem_detail_id" class="form-control appeals-filter">
                <option value="">Все детальные проблемы</option>
            </select>
            <select name="filter" class="form-control appeals-filter">
                <option value="new" {{ $filter === 'new' ? 'selected' : '' }}>Новые (без ответа)</option>
                <option value="archived" {{ $filter === 'archived' ? 'selected' : '' }}>Архив (с ответом)</option>
            </select>
            <button type="submit" class="btn btn-primary">Найти</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Дата</th>
                    <th>ФИО</th>
                    <th>Контакты</th>
                    <th>Категория</th>
                    <th>Подкатегория</th>
                    <th>Детальная проблема</th>
                    <th>Текст</th>
                    <th>Статус</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($appeals as $appeal)
                <tr>
                    <td>{{ $appeal->created_at->format('d.m.Y H:i') }}</td>
                    <td>{{ $appeal->fio }}</td>
                    <td>
                        {{ $appeal->email }}
                        @if($appeal->phone)<br><small>{{ $appeal->phone }}</small>@endif
                    </td>
                    <td>{{ $appeal->problemCategory?->name ?: '—' }}</td>
                    <td>{{ $appeal->problemSubcategory?->name ?: '—' }}</td>
                    <td>{{ $appeal->problemDetail?->name ?: '—' }}</td>
                    <td class="appeal-body-cell">{{ Str::limit($appeal->body, 80) }}</td>
                    <td>
                        @if($appeal->responded_at)
                            <span class="badge badge-answered">Ответ дан</span>
                        @else
                            <span class="badge badge-new">Новое</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('staff.appeals.show', $appeal) }}" class="btn btn-sm btn-primary">Открыть</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">Нет обращений</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $appeals->links() }}
</div>

<style>
.staff-appeals { padding: 20px 0; }
.staff-appeals h1 { color: #1a3c1a; margin-bottom: 24px; }
.appeals-toolbar { margin-bottom: 24px; }
.appeals-search-wrap { display: flex; gap: 12px; flex-wrap: wrap; align-items: center; }
.appeals-search { max-width: 280px; }
.appeals-filter { width: auto; min-width: 180px; }
.appeal-body-cell { max-width: 200px; }
.badge-new { background: #fff3cd; color: #856404; padding: 4px 8px; border-radius: 4px; font-size: 12px; }
.badge-answered { background: #d4edda; color: #155724; padding: 4px 8px; border-radius: 4px; font-size: 12px; }
.btn-sm { padding: 6px 12px; font-size: 14px; }
</style>

<script>
    (function () {
        const categorySelect = document.getElementById('problem_category_id');
        const subcategorySelect = document.getElementById('problem_subcategory_id');
        const detailSelect = document.getElementById('problem_detail_id');
        if (!categorySelect || !subcategorySelect || !detailSelect) return;

        const selectedSubcategory = @json($selectedSubcategoryId);
        const selectedDetail = @json($selectedDetailId);

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
                fillOptions(subcategorySelect, [], 'Все подкатегории');
                fillOptions(detailSelect, [], 'Все детальные проблемы');
                return;
            }
            const response = await fetch(`/api/problem-subcategories/${categoryId}`);
            const data = await response.json();
            fillOptions(subcategorySelect, data, 'Все подкатегории', selectedValue);
            await loadDetails(subcategorySelect.value, selectedDetail);
        };

        const loadDetails = async (subcategoryId, selectedValue = null) => {
            if (!subcategoryId) {
                fillOptions(detailSelect, [], 'Все детальные проблемы');
                return;
            }
            const response = await fetch(`/api/problem-details/${subcategoryId}`);
            const data = await response.json();
            fillOptions(detailSelect, data, 'Все детальные проблемы', selectedValue);
        };

        categorySelect.addEventListener('change', () => loadSubcategories(categorySelect.value, null));
        subcategorySelect.addEventListener('change', () => loadDetails(subcategorySelect.value, null));

        if (categorySelect.value) {
            loadSubcategories(categorySelect.value, selectedSubcategory);
        }
    })();
</script>
@endsection
