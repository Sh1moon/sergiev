@extends('layouts.app')

@section('title', 'Панель администратора')

@section('content')
<div class="admin-dashboard">
    <h1>Панель администратора</h1>

    <div class="dashboard-stats">
        <div class="stat-card">
            <h3>Пользователи</h3>
            <p class="stat-number">{{ $totalUsers }}</p>
        </div>
        <div class="stat-card">
            <h3>Администраторы</h3>
            <p class="stat-number">{{ $adminCount }}</p>
        </div>
        <div class="stat-card">
            <h3>Сотрудники</h3>
            <p class="stat-number">{{ $employeeCount }}</p>
        </div>
        <div class="stat-card">
            <h3>Пользователи</h3>
            <p class="stat-number">{{ $userCount }}</p>
        </div>
    </div>

    <section class="analytics-section">
        <h2>Оперативная аналитика обращений</h2>
        <p class="analytics-lead">
            Единая аналитика по обращениям граждан и антикоррупционным сообщениям без разбиения по районам.
            SLA для ответа: <strong>{{ $slaDays }} дн.</strong>
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
                <p class="kpi-sub">Считается по закрытым обращениям</p>
            </div>
            <div class="kpi-card">
                <p class="kpi-label">Качество контактов</p>
                <p class="kpi-value">{{ $contactQualityShare }}%</p>
                <p class="kpi-sub">Есть телефон или почтовый адрес</p>
            </div>
        </div>

        <div class="analytics-breakdown">
            <div class="breakdown-card">
                <h3>Обращения граждан</h3>
                <p>Всего: <strong>{{ $appealsTotal }}</strong></p>
                <p>Новые: <strong>{{ $appealsNew }}</strong></p>
                <p>Закрытые: <strong>{{ $appealsResolved }}</strong></p>
                <a href="{{ route('staff.appeals.index') }}" class="btn btn-sm btn-primary">Открыть список</a>
            </div>
            <div class="breakdown-card">
                <h3>Антикоррупция</h3>
                <p>Всего: <strong>{{ $anticorruptionTotal }}</strong></p>
                <p>Новые: <strong>{{ $anticorruptionNew }}</strong></p>
                <p>Закрытые: <strong>{{ $anticorruptionResolved }}</strong></p>
                <a href="{{ route('staff.anticorruption.index') }}" class="btn btn-sm btn-primary">Открыть список</a>
            </div>
        </div>

        <div class="analytics-charts">
            <div class="chart-card">
                <h3>Динамика по месяцам</h3>
                <div class="chart-box"><canvas id="chartMonthly"></canvas></div>
            </div>
            <div class="chart-card">
                <h3>SLA: вовремя и просрочено</h3>
                <div class="chart-box"><canvas id="chartSla"></canvas></div>
            </div>
        </div>
    </section>

    <div class="admin-actions">
        <h2>Управление</h2>
        <div class="action-grid">
            <a href="{{ route('admin.users.index') }}" class="action-card">
                <h3>Управление пользователями</h3>
                <p>Просмотр, создание и редактирование пользователей</p>
            </a>
            <a href="{{ route('staff.articles.index') }}" class="action-card">
                <h3>Управление контентом</h3>
                <p>Статьи и разделы сайта</p>
            </a>
            <a href="{{ route('staff.carousel.index') }}" class="action-card">
                <h3>Карусель на главной</h3>
                <p>Изображения в шапке главной страницы</p>
            </a>
            <a href="{{ route('staff.appeals.index') }}" class="action-card">
                <h3>Обращения граждан</h3>
                <p>Просмотр и ответы на обращения</p>
            </a>
            <a href="{{ route('staff.anticorruption.index') }}" class="action-card">
                <h3>Сообщения об антикоррупции</h3>
                <p>Просмотр и ответы на сообщения о коррупции</p>
            </a>
            <a href="#" class="action-card">
                <h3>Настройки сайта</h3>
                <p>Общие настройки и конфигурация</p>
            </a>
        </div>
    </div>
</div>

<style>
.admin-dashboard {
    padding: 20px 0;
}

.admin-dashboard h1 {
    margin-bottom: 30px;
    color: #1a3c1a;
}

.dashboard-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
}

.stat-card {
    background: linear-gradient(135deg, #1a3c1a, #2a5a2a);
    color: #fafffa;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.stat-card h3 {
    font-size: 18px;
    margin-bottom: 10px;
    font-weight: normal;
}

.stat-number {
    font-size: 36px;
    font-weight: bold;
}

.admin-actions h2 {
    margin-bottom: 20px;
    color: #1a3c1a;
}

.analytics-section {
    margin-bottom: 36px;
}

.analytics-section h2 {
    margin-bottom: 8px;
    color: #1a3c1a;
}

.analytics-lead {
    margin-top: 0;
    margin-bottom: 16px;
    color: #4d4d4d;
}

.analytics-kpis {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
    gap: 14px;
    margin-bottom: 18px;
}

.kpi-card {
    background: #fff;
    border: 1px solid #e2e8e2;
    border-radius: 10px;
    padding: 14px 16px;
}

.kpi-label {
    margin: 0;
    color: #666;
    font-size: 13px;
}

.kpi-value {
    margin: 6px 0;
    font-size: 28px;
    line-height: 1.1;
    font-weight: 700;
    color: #1a3c1a;
}

.kpi-sub {
    margin: 0;
    color: #555;
    font-size: 13px;
}

.analytics-breakdown {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 14px;
    margin-bottom: 18px;
}

.breakdown-card {
    background: #fff;
    border: 1px solid #e2e8e2;
    border-radius: 10px;
    padding: 14px 16px;
}

.breakdown-card h3 {
    margin-top: 0;
    margin-bottom: 10px;
    color: #1a3c1a;
}

.breakdown-card p {
    margin: 4px 0;
}

.breakdown-card .btn {
    margin-top: 8px;
}

.analytics-charts {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 14px;
}

.chart-card {
    background: #fff;
    border: 1px solid #e2e8e2;
    border-radius: 10px;
    padding: 12px;
}

.chart-card h3 {
    margin-top: 0;
    margin-bottom: 8px;
    color: #1a3c1a;
    font-size: 16px;
}

.chart-box {
    height: 240px;
}

.action-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.action-card {
    background: white;
    padding: 20px;
    border-radius: 8px;
    text-decoration: none;
    color: inherit;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: transform 0.3s, box-shadow 0.3s;
    border-left: 4px solid #1a3c1a;
}

.action-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.action-card h3 {
    color: #1a3c1a;
    margin-bottom: 10px;
}

.action-card p {
    color: #666;
    font-size: 14px;
    line-height: 1.5;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    (function () {
        const monthLabels = @json($monthLabels);
        const appealsMonthly = @json($appealsMonthlyValues);
        const reportsMonthly = @json($reportsMonthlyValues);

        new Chart(document.getElementById('chartMonthly'), {
            type: 'bar',
            data: {
                labels: monthLabels,
                datasets: [
                    {
                        label: 'Обращения',
                        data: appealsMonthly,
                        backgroundColor: '#2e7d32'
                    },
                    {
                        label: 'Антикоррупция',
                        data: reportsMonthly,
                        backgroundColor: '#1e88e5'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } }
                }
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