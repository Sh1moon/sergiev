@extends('layouts.app')

@section('title', 'Отдел участковых по району')

@section('content')
<div class="reference-page district-police-page">
    <h1 class="page-title">Отдел участковых по району</h1>
    <div class="district-police-content">
        @foreach(array_filter(explode("\n\n", $content)) as $paragraph)
            <p>{{ $paragraph }}</p>
        @endforeach
    </div>
</div>
<style>
.district-police-page { padding: 20px 0; max-width: 900px; }
.district-police-page .page-title { color: #1a3c1a; margin-bottom: 24px; border-bottom: 2px solid #1a3c1a; padding-bottom: 10px; }
.district-police-content { font-size: 1.2rem; line-height: 1.7; color: #333; }
.district-police-content .block-title { font-weight: 700; color: #1a3c1a; margin: 24px 0 8px 0; font-size: 1.2rem; }
.district-police-content p { margin-bottom: 12px; }
</style>
@endsection
