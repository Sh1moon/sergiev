@extends('layouts.app')

@section('title', 'Антикоррупция')

@section('content')
<div class="anticorruption-page">
    <h1 class="page-title">Антикоррупция</h1>

    <p class="anticorruption-intro">На этой странице Вы можете анонимно сообщить информацию о фактах проявления коррупции на территории Сергиево-Посадского городского округа.</p>

    <form action="{{ route('appeals.anticorruption.store') }}" method="POST" class="anticorruption-form">
        @csrf

        <div class="form-group">
            <p class="form-label">Контактные данные <span class="required">*</span></p>
            <p class="form-hint">Укажите Ваш адрес электронной почты, по которому можно будет выслать ответ</p>
        </div>

        <div class="form-group">
            <label for="email" class="form-label">E-mail <span class="required">*</span></label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email', Auth::user()->email ?? '') }}" required maxlength="255">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="body" class="form-label">Текст сообщения <span class="required">*</span></label>
            <p class="form-hint">Пожалуйста, изложите грамотно суть сообщения. От качества изложения будет зависеть решение этого вопроса.</p>
            <textarea name="body" id="body" class="form-control @error('body') is-invalid @enderror" rows="6"
                      required maxlength="10000" placeholder="Изложите суть сообщения...">{{ old('body') }}</textarea>
            @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Отправить сообщение</button>
        </div>
    </form>

    @if($myReports->isNotEmpty())
    <section class="my-reports">
        <h2 class="my-reports-title">Мои сообщения</h2>
        <ul class="my-reports-list">
            @foreach($myReports as $report)
            <li class="my-reports-item">
                <div class="my-reports-item-header">
                    <span class="my-reports-date">{{ $report->created_at->format('d.m.Y H:i') }}</span>
                    @if($report->responded_at)
                        <span class="my-reports-status my-reports-status-answered">Ответ получен</span>
                    @else
                        <span class="my-reports-status my-reports-status-waiting">На рассмотрении</span>
                    @endif
                </div>
                <p class="my-reports-excerpt">{{ Str::limit($report->body, 120) }}</p>
                @if($report->response)
                <div class="my-reports-response">
                    <strong>Ответ:</strong>
                    <p>{{ nl2br(e($report->response)) }}</p>
                    <span class="my-reports-response-date">{{ $report->responded_at->format('d.m.Y') }}</span>
                </div>
                @endif
            </li>
            @endforeach
        </ul>
    </section>
    @endif
</div>

<style>
.anticorruption-page { padding: 20px 0; max-width: 640px; }
.anticorruption-page .page-title { color: #1a3c1a; margin-bottom: 12px; border-bottom: 2px solid #1a3c1a; padding-bottom: 10px; }
.anticorruption-intro { color: #555; margin-bottom: 24px; line-height: 1.5; }
.anticorruption-form { background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); }
.required { color: #dc3545; }
.form-hint { font-size: 13px; color: #666; margin-top: 4px; margin-bottom: 8px; }
.form-actions { margin-top: 24px; }
.my-reports { margin-top: 40px; padding-top: 24px; border-top: 1px solid #e8e8e8; }
.my-reports-title { color: #1a3c1a; margin-bottom: 16px; font-size: 1.25rem; }
.my-reports-list { list-style: none; padding: 0; margin: 0; }
.my-reports-item { background: #fff; padding: 16px; border-radius: 8px; margin-bottom: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-left: 4px solid #1a3c1a; }
.my-reports-item-header { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; margin-bottom: 8px; }
.my-reports-date { font-size: 14px; color: #666; }
.my-reports-status { font-size: 13px; padding: 2px 8px; border-radius: 4px; }
.my-reports-status-waiting { background: #fff3cd; color: #856404; }
.my-reports-status-answered { background: #d4edda; color: #155724; }
.my-reports-excerpt { color: #555; line-height: 1.5; margin: 0 0 12px 0; }
.my-reports-response { background: #f5f5f5; padding: 12px; border-radius: 6px; margin-top: 12px; }
.my-reports-response strong { color: #1a3c1a; }
.my-reports-response p { margin: 8px 0 0 0; color: #333; }
.my-reports-response-date { font-size: 12px; color: #666; }
</style>
@endsection
