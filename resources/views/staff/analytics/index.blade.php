@extends('layouts.app')

@section('title', 'Аналитика обращений')

@section('content')
<div class="analytics-page">
    <h1>Аналитика обращений</h1>
    <p class="analytics-lead">
        Единая аналитика по обращениям граждан и антикоррупционным сообщениям. Разбивки по районам нет.
        SLA ответа: <strong>{{ $slaDays }} дн.</strong>
    </p>

    <div class="analytics-kpis">
        <div class="kpi-card">
            <p class="kpi-label">Всего входящих</p>
            <p class="kpi-value">{{ $incomingTotal }}</p>
            <p class="kpi-sub">Открытых: {{ $incomingNew }}, закрытых: {{ $incomingResolved }}</p>
        </div>
        <div class="kpi-card">
            <p class="kpi-label">Просрочка SLA</p>
            <p class="kpi-value">{{ $overdueShare }}%</p>
            <p class="kpi-sub">Просрочено: {{ $overdueResolved }}, вовремя: {{ $onTimeResolved }}</p>
        </div>
        <div class="kpi-card">
            <p class="kpi-label">Среднее время ответа</p>
            <p class="kpi-value">{{ $avgResponseHours }} ч</p>
            <p class="kpi-sub">По всем закрытым обращениям</p>
        </div>
    </div>

    <div class="analytics-breakdown">
        <div class="breakdown-card">
            <h3>Обращения граждан</h3>
            <p>Всего: <strong>{{ $appealsTotal }}</strong></p>
            <p>Новые: <strong>{{ $appealsNew }}</strong></p>
            <p>Закрытые: <strong>{{ $appealsResolved }}</strong></p>
        </div>
        <div class="breakdown-card">
            <h3>Антикоррупция</h3>
            <p>Всего: <strong>{{ $anticorruptionTotal }}</strong></p>
            <p>Новые: <strong>{{ $anticorruptionNew }}</strong></p>
            <p>Закрытые: <strong>{{ $anticorruptionResolved }}</strong></p>
        </div>
    </div>

    <div class="analytics-charts">
        <div class="chart-card">
            <h3>Динамика по месяцам</h3>
            <div class="chart-box"><canvas id="chartMonthly"></canvas></div>
        </div>
        <div class="chart-card">
            <h3>Категории проблем (топ)</h3>
            <div class="chart-box"><canvas id="chartCategories"></canvas></div>
        </div>
        <div class="chart-card">
            <h3>Подкатегории (топ)</h3>
            <div class="chart-box"><canvas id="chartSubcategories"></canvas></div>
        </div>
        <div class="chart-card">
            <h3>Детальные проблемы (топ)</h3>
            <div class="chart-box"><canvas id="chartDetails"></canvas></div>
        </div>
        <div class="chart-card">
            <h3>SLA: вовремя и просрочено</h3>
            <div class="chart-box"><canvas id="chartSla"></canvas></div>
        </div>
    </div>
</div>

<style>
.analytics-page { padding: 20px 0; }
.analytics-lead { margin-bottom: 16px; color: #4d4d4d; }
.analytics-kpis { display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 14px; margin-bottom: 18px; }
.kpi-card { background: #fff; border: 1px solid #e2e8e2; border-radius: 10px; padding: 14px 16px; }
.kpi-label { margin: 0; color: #666; font-size: 13px; }
.kpi-value { margin: 6px 0; font-size: 28px; line-height: 1.1; font-weight: 700; color: #1a3c1a; }
.kpi-sub { margin: 0; color: #555; font-size: 13px; }
.analytics-breakdown { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 14px; margin-bottom: 18px; }
.breakdown-card { background: #fff; border: 1px solid #e2e8e2; border-radius: 10px; padding: 14px 16px; }
.breakdown-card h3 { margin-top: 0; margin-bottom: 10px; color: #1a3c1a; }
.breakdown-card p { margin: 4px 0; }
.analytics-charts { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 14px; }
.chart-card { background: #fff; border: 1px solid #e2e8e2; border-radius: 10px; padding: 12px; }
.chart-card h3 { margin-top: 0; margin-bottom: 8px; color: #1a3c1a; font-size: 16px; }
.chart-box { height: 260px; }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    (function () {
        const monthLabels = @json($monthLabels);
        const appealsMonthly = @json($appealsMonthlyValues);
        const reportsMonthly = @json($reportsMonthlyValues);
        const topCategoryLabels = @json($topCategoryLabels);
        const topCategoryValues = @json($topCategoryValues);
        const topSubcategoryLabels = @json($topSubcategoryLabels);
        const topSubcategoryValues = @json($topSubcategoryValues);
        const topDetailLabels = @json($topDetailLabels);
        const topDetailValues = @json($topDetailValues);

        new Chart(document.getElementById('chartMonthly'), {
            type: 'bar',
            data: {
                labels: monthLabels,
                datasets: [
                    { label: 'Обращения', data: appealsMonthly, backgroundColor: '#2e7d32' },
                    { label: 'Антикоррупция', data: reportsMonthly, backgroundColor: '#1e88e5' }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });

        new Chart(document.getElementById('chartCategories'), {
            type: 'bar',
            data: {
                labels: topCategoryLabels,
                datasets: [{
                    label: 'Количество',
                    data: topCategoryValues,
                    backgroundColor: '#8e24aa'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                scales: { x: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });
        new Chart(document.getElementById('chartSubcategories'), {
            type: 'bar',
            data: {
                labels: topSubcategoryLabels,
                datasets: [{
                    label: 'Количество',
                    data: topSubcategoryValues,
                    backgroundColor: '#00897b'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                scales: { x: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });
        new Chart(document.getElementById('chartDetails'), {
            type: 'bar',
            data: {
                labels: topDetailLabels,
                datasets: [{
                    label: 'Количество',
                    data: topDetailValues,
                    backgroundColor: '#3949ab'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                scales: { x: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });

        const onTime = {{ (int) $onTimeResolved }};
        const overdue = {{ (int) $overdueResolved }};
        const hasData = onTime + overdue > 0;

        new Chart(document.getElementById('chartSla'), {
            type: 'doughnut',
            data: {
                labels: hasData ? ['Вовремя', 'Просрочено'] : ['Нет данных'],
                datasets: [{
                    data: hasData ? [onTime, overdue] : [1],
                    backgroundColor: hasData ? ['#43a047', '#e53935'] : ['#cfd8dc'],
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    })();
</script>
@endsection
