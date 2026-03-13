@extends('layouts.app')

@section('title', 'Наш округ')

@section('content')
<div class="our-district-page">
    <h1 class="page-title">Наш округ</h1>
    <div class="our-district-content">
        @include('our-district.content')
    </div>
</div>
<style>
.our-district-page { padding: 20px 0; max-width: 900px; }
.our-district-page .page-title { color: #1a3c1a; margin-bottom: 20px; border-bottom: 2px solid #1a3c1a; padding-bottom: 10px; }
.our-district-content { color: #333; line-height: 1.6; }
.our-district-content p { margin-bottom: 1em; }
.our-district-content h2 { color: #1a3c1a; font-size: 1.35rem; margin-top: 2em; margin-bottom: 0.75em; }
.our-district-content h3 { color: #1a3c1a; font-size: 1.15rem; margin-top: 1.5em; margin-bottom: 0.5em; }
.our-district-content ul { margin: 0.75em 0 1em 1.5em; padding: 0; }
.our-district-content li { margin-bottom: 0.35em; }
</style>
@endsection
