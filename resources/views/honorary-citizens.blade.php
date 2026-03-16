@extends('layouts.app')

@section('title', 'Почётные граждане')

@section('content')
<div class="honorary-citizens-page">
    <h1 class="page-title">Почётные граждане</h1>

    <div class="honorary-tables">
        @forelse(($items ?? collect())->groupBy('category') as $category => $categoryItems)
        <section class="honorary-section">
            <h2>{{ $category }}</h2>
            <div class="table-responsive">
                <table class="honorary-table">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Фамилия, имя, отчество, сведения</th>
                            <th>Кем и когда присвоено звание</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categoryItems as $num => $item)
                        <tr>
                            <td>{{ $num + 1 }}</td>
                            <td>{{ $item->person_name }}{{ $item->person_info ? ', ' . $item->person_info : '' }}</td>
                            <td>{{ $item->awarded_by }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
        @empty
        <p>Список почётных граждан пока не заполнен.</p>
        @endforelse
    </div>
</div>

<style>
.honorary-citizens-page { padding: 20px 0; max-width: 1100px; }
.honorary-citizens-page .page-title { color: #1a3c1a; margin-bottom: 24px; border-bottom: 2px solid #1a3c1a; padding-bottom: 10px; }
.honorary-section { margin-bottom: 36px; }
.honorary-section h2 { color: #1a3c1a; font-size: 1.15rem; margin-bottom: 16px; }
.table-responsive { overflow-x: auto; margin-bottom: 20px; }
.honorary-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 1.2rem;
    background: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    border-radius: 8px;
    overflow: hidden;
}
.honorary-table th,
.honorary-table td { padding: 12px 16px; text-align: left; border-bottom: 1px solid #eee; }
.honorary-table th { background: #1a3c1a; color: #fafffa; font-weight: 600; }
.honorary-table tbody tr:hover { background: #f9f9f9; }
.honorary-table td:first-child { font-weight: 500; color: #1a3c1a; width: 40px; }
</style>
@endsection
