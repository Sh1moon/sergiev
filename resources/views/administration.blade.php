@extends('layouts.app')

@section('title', 'Администрация округа')

@section('content')
<div class="administration-page">
    <h1 class="page-title">Администрация округа</h1>

    @if($head)
    <section class="administration-section" id="glava">
        <h2 class="section-title">Глава округа</h2>
        <div class="head-block">
            <div class="head-photo-wrap js-img-lightbox" role="button" tabindex="0" aria-label="Открыть в полном размере">
                @if($head->photoUrl())
                    <img src="{{ $head->photoUrl() }}" alt="{{ $head->title }}" class="head-photo" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                @endif
                <div class="head-photo-placeholder" style="display:{{ $head->photoUrl() ? 'none' : 'flex' }};">
                    <span class="placeholder-initials">{{ $head->initials() }}</span>
                </div>
            </div>
            <div class="head-info">
                <p class="head-caption">{{ $head->title }}</p>
                @if($head->description)
                    @foreach(explode("\n\n", $head->description) as $paragraph)
                        @if(trim($paragraph))<p>{{ trim($paragraph) }}</p>@endif
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    @endif

    <section class="administration-section" id="zamestiteli">
        <h2 class="section-title">Заместители главы</h2>

        @forelse($deputies as $deputy)
        <article class="deputy-block" id="{{ $deputy->slug ? 'zam-'.$deputy->slug : 'zam-'.$deputy->id }}">
            <div class="deputy-photo-wrap js-img-lightbox" role="button" tabindex="0" aria-label="Открыть в полном размере">
                @if($deputy->photoUrl())
                    <img src="{{ $deputy->photoUrl() }}" alt="{{ $deputy->name }}" class="deputy-photo" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                @endif
                <div class="deputy-photo-placeholder" style="display:{{ $deputy->photoUrl() ? 'none' : 'flex' }};"><span>{{ $deputy->initials() }}</span></div>
            </div>
            <div class="deputy-content">
                <h3 class="deputy-name">{{ $deputy->name }}</h3>
                @if($deputy->position)<p class="deputy-position">{{ $deputy->position }}</p>@endif
                @if($deputy->description)<p>{{ $deputy->description }}</p>@endif
                @if($deputy->contacts)<p class="deputy-contacts">{{ $deputy->contacts }}</p>@endif
            </div>
        </article>
        @empty
        <p>Список заместителей пока не заполнен.</p>
        @endforelse
    </section>

    <section class="administration-section" id="podrazdeleniya">
        <h2 class="section-title">Подразделения</h2>

        @forelse($departments ?? [] as $dept)
        <div class="dept-group">
            <h3 class="dept-management">{{ $dept->management_name }}</h3>
            @if($dept->head_text)<p class="dept-head">{{ $dept->head_text }}</p>@endif
            @if($dept->schedule_text)<p class="dept-schedule">{{ $dept->schedule_text }}</p>@endif
            @if($dept->body)
            <ul class="dept-list">
                @foreach(array_filter(explode("\n", $dept->body)) as $line)
                <li>{!! nl2br(e(trim($line))) !!}</li>
                @endforeach
            </ul>
            @endif
        </div>
        @empty
        <p>Список подразделений пока не заполнен.</p>
        @endforelse
    </section>

    <section class="administration-section" id="uchrezhdeniya">
        <h2 class="section-title">Муниципальные учреждения</h2>

        @forelse($institutions ?? [] as $inst)
        <div class="institution-card">
            <h3>{{ $inst->title }}</h3>
            @if($inst->leader)<p><strong>Руководитель:</strong> {{ $inst->leader }}</p>@endif
            @if($inst->address)<p><strong>Адрес:</strong> {{ $inst->address }}</p>@endif
            @if($inst->phones)<p><strong>Телефоны:</strong> {{ $inst->phones }}</p>@endif
            @if($inst->email)<p><strong>E-mail:</strong> <a href="mailto:{{ $inst->email }}">{{ $inst->email }}</a></p>@endif
            @if($inst->website)<p><strong>Сайт:</strong> <a href="{{ $inst->website }}" target="_blank" rel="noopener">{{ Str::limit($inst->website, 50) }}</a></p>@endif
            @if($inst->description)<p>{{ $inst->description }}</p>@endif
        </div>
        @empty
        <p>Список учреждений пока не заполнен.</p>
        @endforelse
    </section>

    <section class="administration-section" id="territorii">
        <h2 class="section-title">Территории</h2>
        @if(isset($territories) && $territories->isNotEmpty())
        <div class="territories-table-wrap">
            <table class="territories-table">
                <thead>
                    <tr>
                        <th>Управление</th>
                        <th>Руководитель</th>
                        <th>Телефон, e-mail</th>
                        <th>Адрес</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($territories as $t)
                    <tr>
                        <td>{{ $t->management }}</td>
                        <td>{{ $t->leader }}</td>
                        <td>{!! nl2br(e($t->contacts)) !!}</td>
                        <td>{{ $t->address }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p>Список территорий пока не заполнен.</p>
        @endif
    </section>

    <section class="administration-section" id="go-chs">
        <h2 class="section-title">ГО и ЧС</h2>
        @if($goChsArticles->isNotEmpty())
            <ul class="go-chs-articles-list">
                @foreach($goChsArticles as $article)
                <li class="go-chs-articles-item">
                    <a href="{{ route('go-chs.show', $article->slug) }}" class="go-chs-articles-link">
                        <time class="go-chs-articles-date" datetime="{{ $article->published_at?->toIso8601String() }}">{{ $article->published_at?->format('d.m.Y') }}</time>
                        <span class="go-chs-articles-title">{{ $article->title }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
            <a href="{{ route('go-chs') }}" class="go-chs-more">Все материалы по ГО и ЧС</a>
        @else
            <p>Раздел в разработке. <a href="{{ route('go-chs') }}">Перейти в раздел ГО и ЧС</a>.</p>
        @endif
    </section>
</div>

<style>
.head-block { display: flex; flex-wrap: wrap; gap: 24px; align-items: flex-start; }
.head-photo-wrap { flex-shrink: 0; width: 260px; }
.head-photo { width: 260px; height: auto; aspect-ratio: 3/4; object-fit: cover; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); display: block; }
.head-photo-placeholder { width: 260px; aspect-ratio: 3/4; background: #e8ebe8; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #7a9a7a; font-size: 1.5rem; font-weight: 600; }
.head-info { flex: 1; min-width: 0; }
.head-caption { font-size: 1.35rem; font-weight: 600; color: #1a3c1a; margin-bottom: 16px; }
.head-info p { margin-bottom: 1em; color: #333; line-height: 1.7; }

.deputy-block { display: flex; flex-wrap: wrap; gap: 24px; align-items: flex-start; margin-bottom: 36px; }
.deputy-photo-wrap { flex-shrink: 0; width: 180px; }
.deputy-photo { width: 180px; height: 220px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
.deputy-photo-placeholder { width: 180px; height: 220px; background: #e8ebe8; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #7a9a7a; font-size: 1rem; font-weight: 600; }
.deputy-content { flex: 1; min-width: 260px; }
.deputy-name { font-size: 1.15rem; font-weight: 600; color: #1a3c1a; margin-bottom: 6px; }
.deputy-position { font-size: 0.95rem; color: #5a7a5a; margin-bottom: 10px; font-style: italic; }
.deputy-content p { margin-bottom: 0.6em; color: #333; line-height: 1.7; }
.deputy-contacts { margin-top: 10px; font-size: 0.95rem; color: #1a3c1a; font-weight: 500; }

@media (max-width: 600px) {
    .head-block { flex-direction: column; }
    .head-photo-wrap { width: 100%; max-width: 260px; }
    .head-photo { width: 100%; max-width: 260px; }
    .head-photo-placeholder { width: 100%; max-width: 260px; }
    .deputy-block { flex-direction: column; }
    .deputy-photo-wrap { width: 100%; max-width: 180px; }
    .deputy-photo, .deputy-photo-placeholder { width: 100%; max-width: 180px; height: auto; min-height: 220px; }
    .deputy-content { min-width: 0; }
}

.dept-group { margin-bottom: 28px; }
.dept-management { font-size: 1.1rem; color: #1a3c1a; margin-bottom: 8px; }
.dept-head { font-size: 0.95rem; color: #444; margin-bottom: 8px; }
.dept-schedule { font-size: 0.9rem; color: #666; margin-bottom: 6px; font-style: italic; }
.dept-list { margin: 0 0 0 1.2em; padding: 0; }
.dept-list li { margin-bottom: 6px; color: #333; line-height: 1.7; }

.institution-card { background: #f8faf8; border-radius: 8px; padding: 18px; margin-bottom: 20px; border-left: 4px solid #1a3c1a; }
.institution-card h3 { font-size: 1.05rem; color: #1a3c1a; margin-bottom: 12px; }
.institution-card p { margin-bottom: 6px; font-size: 0.95rem; color: #333; }
.institution-card a { color: #1a3c1a; }

.territories-table-wrap { overflow-x: auto; }
.territories-table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
.territories-table th, .territories-table td { border: 1px solid #ddd; padding: 10px 12px; text-align: left; }
.territories-table th { background: #1a3c1a; color: #fff; font-weight: 600; }
.territories-table tr:nth-child(even) { background: #f8faf8; }
.territories-table td br { line-height: 1.4; }

.go-chs-articles-list { list-style: none; padding: 0; margin: 0 0 16px 0; }
.go-chs-articles-item { margin-bottom: 10px; }
.go-chs-articles-link { display: inline-flex; align-items: baseline; gap: 12px; text-decoration: none; color: #1a3c1a; }
.go-chs-articles-link:hover { color: #eac31b; }
.go-chs-articles-date { font-size: 0.9em; color: #666; flex-shrink: 0; }
.go-chs-articles-title { flex: 1; }
.go-chs-more { display: inline-block; margin-top: 8px; color: #1a3c1a; font-weight: 500; text-decoration: none; }
.go-chs-more:hover { color: #eac31b; }
#go-chs p { margin-bottom: 0.8em; color: #333; line-height: 1.7; }
</style>
@endsection
