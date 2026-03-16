<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Сергиево-Посадский округ')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('styles')
    <style>
        /* Шрифты SK Posad */
        @font-face {
            font-family: 'SK Posad Text';
            src: url('/fonts/SK%20Posad%20Text.woff2') format('woff2'),
                 url('/fonts/SK%20Posad%20Text.woff') format('woff');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }
        @font-face {
            font-family: 'SK Posad';
            src: url('/fonts/SK%20Posad.woff2') format('woff2'),
                 url('/fonts/SK%20Posad.woff') format('woff');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

        /* Защита от горизонтального переполнения на всех разрешениях */
        html { overflow-x: hidden; }
        body { overflow-x: hidden; }

        /* Здесь скопируйте все стили из вашего файла шапки */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'SK Posad Text', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 1.2rem;
            line-height: 1.7;
            padding-top: 80px;
            background-color: #fafffa;
            color: #1a3c1a;
            overflow-wrap: break-word;
            word-wrap: break-word;
        }
        h1, h2, h3, h4, h5, h6,
        .page-title, .section-title,
        .site-header, .site-header .nav-link, .site-header .logo-link,
        .header-mobile, .header-desktop {
            font-family: 'SK Posad', 'SK Posad Text', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            width: 100%;
        }

        /* Стили для сообщений */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Кнопки */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #1a3c1a;
            color: #fafffa;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #2a5a2a;
        }

        .btn-primary {
            background-color: #1a3c1a;
        }

        .btn-primary:hover {
            background-color: #2a5a2a;
        }

        .btn-warning {
            background-color: #eac31b;
            color: #1a3c1a;
        }

        .btn-warning:hover {
            background-color: #d4b018;
        }

        .btn-danger {
            background-color: #dc3545;
            color: #fafffa;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        /* Формы */
        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .form-control:focus {
            outline: none;
            border-color: #1a3c1a;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }

        /* Таблицы */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        .table th {
            background-color: #1a3c1a;
            color: #fafffa;
        }

        .table tr:hover {
            background-color: rgba(26, 60, 26, 0.05);
        }

        .pagination { display: flex; flex-wrap: wrap; gap: 6px; list-style: none; padding: 0; margin: 0; }
        .pagination li a, .pagination li span { display: inline-block; padding: 8px 14px; background: #1a3c1a; color: #fafffa; text-decoration: none; border-radius: 4px; }
        .pagination li a:hover { background: #2a5a2a; color: #eac31b; }
        .pagination li.active span { background: #eac31b; color: #1a3c1a; }
        .pagination li.disabled span { background: #ccc; color: #666; }
    </style>
    <style>
    /* ===== HEADER (шапка) ===== */
    .site-header {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      background-color: #1a3c1a;
      z-index: 1000;
      box-shadow: 0 2px 15px rgba(0, 0, 0, 0.3);
      transition: all 0.3s ease;
    }
    .header-container { max-width: 1440px; margin: 0 auto; padding: 0 16px; box-sizing: border-box; }
    .header-desktop {
      display: flex;
      width: 100%;
      align-items: center;
      justify-content: space-between;
      padding: 12px 0;
    }
    .logo-container { flex: 0 0 auto; }
    .logo-link { display: flex; align-items: center; text-decoration: none; letter-spacing: -0.02em; }
    .logo-img { max-width: 230px; width: 100%; height: auto; transition: transform 0.3s ease; }
    .logo-link:hover .logo-img { transform: scale(1.03); }
    .nav-desktop { flex: 1 !important; display: flex !important; justify-content: center !important; min-width: 0; }
    .nav-list { display: flex; list-style: none; gap: 6px; margin-bottom: 0; flex-wrap: wrap; justify-content: center; }
    .nav-item { position: relative; }
    .nav-link {
      display: flex;
      align-items: center;
      padding: 10px 12px;
      color: #fafffa;
      text-decoration: none;
      font-weight: 500;
      font-size: 15px;
      white-space: nowrap;
      letter-spacing: -0.02em;
      border-radius: 4px;
      transition: all 0.3s ease;
    }
    .nav-link:hover { color: #1a3c1a; background-color: rgba(250, 255, 250, 1); }
    .nav-link.active { color: #eac31b; background-color: rgba(234, 195, 27, 0.2); }
    .submenu {
      position: absolute;
      top: 100%;
      left: 0;
      background-color: #fafffa;
      min-width: 220px;
      border-radius: 6px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
      opacity: 0;
      visibility: hidden;
      transform: translateY(10px);
      transition: all 0.3s ease;
      z-index: 1001;
      padding: 8px 0;
      border: 1px solid #e8e8e8;
    }
    .nav-item:hover .submenu { opacity: 1; visibility: visible; transform: translateY(0); }
    .nav-item:last-child .submenu { left: -100px; }
    .submenu-list { list-style: none; }
    .submenu-item { padding: 0; }
    .submenu-link {
      display: block;
      padding: 10px 20px;
      color: #1a3c1a;
      text-decoration: none;
      font-size: 14px;
      transition: all 0.2s ease;
      border-left: 3px solid transparent;
    }
    .submenu-link:hover {
      color: #1a3c1a;
      font-weight: 700 !important;
      background-color: rgba(26, 60, 26, 0.05);
      border-left-color: #1a3c1a;
      padding-left: 25px;
    }
    .submenu-main-item { border-bottom: 1px solid #e8e8e8; margin-bottom: 5px; }
    .submenu-main-link { font-weight: 600 !important; color: #1a3c1a !important; background-color: rgba(26, 60, 26, 0.08) !important; }
    .submenu-main-link:hover { color: #1a3c1a !important; background-color: rgba(26, 60, 26, 0.12) !important; }
    .auth-section-desktop { flex: 0 0 auto; display: flex; align-items: center; gap: 12px; min-width: 0; }
    .auth-section-guest { display: flex; align-items: center; flex-direction: column; flex-shrink: 0; white-space: nowrap; }
    .user-dropdown-wrap { position: relative; flex-shrink: 0; }
    .user-dropdown-btn {
      display: flex;
      align-items: center;
      gap: 6px;
      padding: 8px 12px;
      color: #fafffa;
      background: none;
      border: none;
      border-radius: 4px;
      font-size: 14px;
      font-family: inherit;
      cursor: pointer;
      transition: color 0.2s ease, background-color 0.2s ease;
    }
    .user-dropdown-btn:hover { color: #1a3c1a; background-color: rgba(250, 255, 250, 0.9); }
    .user-dropdown-arrow { font-size: 10px; opacity: 0.9; transition: transform 0.2s ease; }
    .user-dropdown-btn[aria-expanded="true"] .user-dropdown-arrow { transform: rotate(180deg); }
    .user-dropdown {
      position: absolute;
      top: 100%;
      right: 0;
      margin-top: 4px;
      min-width: 160px;
      background: #fafffa;
      border-radius: 6px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
      border: 1px solid #e8e8e8;
      padding: 6px 0;
      z-index: 1002;
    }
    .user-dropdown-link {
      display: block;
      padding: 10px 16px;
      color: #1a3c1a;
      text-decoration: none;
      font-size: 14px;
      text-align: left;
      width: 100%;
      background: none;
      border: none;
      font-family: inherit;
      cursor: pointer;
      transition: background-color 0.2s ease;
    }
    .user-dropdown-link:hover { background-color: rgba(26, 60, 26, 0.08); }
    .user-dropdown-form { padding: 0; margin: 0; }
    .user-dropdown-logout { border-top: 1px solid #e8e8e8; margin-top: 4px; }
    .auth-section-desktop .auth-link {
      color: #fafffa;
      text-decoration: none;
      font-size: 14px;
      padding: 8px 12px;
      border-radius: 4px;
      transition: all 0.2s;
    }
    .auth-section-desktop .auth-link:hover { color: #1a3c1a; background-color: #eac31b; }
    .auth-section-desktop .auth-link.auth-link-btn {
      display: inline-flex;
      align-items: center;
      font-weight: 500;
      white-space: nowrap;
    }
    .auth-section-desktop .auth-link.auth-link-btn:hover { color: #1a3c1a; background-color: rgba(250, 255, 250, 0.9); }
    .auth-section-desktop .auth-link.register-link { margin-left: 0; }
    .header-mobile { display: none; padding: 12px 0; }
    .mobile-top { display: flex; align-items: center; justify-content: space-between; width: 100%; padding: 0 15px; }
    .mobile-logo { max-width: 200px; height: 74px; }
    .burger-btn {
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      width: 30px;
      height: 27px;
      background: none;
      border: none;
      cursor: pointer;
      padding: 0;
      z-index: 1002;
    }
    .burger-line { width: 100%; height: 3px; background-color: #fafffa; border-radius: 2px; transition: all 0.3s ease; }
    .burger-btn.active .burger-line:nth-child(1) { background-color: #eac31b; transform: translateY(12px) rotate(45deg); }
    .burger-btn.active .burger-line:nth-child(2) { opacity: 0; }
    .burger-btn.active .burger-line:nth-child(3) { background-color: #eac31b; transform: translateY(-11px) rotate(-45deg); }
    .mobile-menu-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.7);
      z-index: 999;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
    }
    .mobile-menu-overlay.active { opacity: 1; visibility: visible; }
    .mobile-menu {
      position: fixed;
      top: 0;
      right: -100%;
      width: 85%;
      max-width: 400px;
      height: 100%;
      background-color: #fafffa;
      z-index: 1000;
      padding: 80px 20px 40px;
      overflow-y: auto;
      transition: right 0.4s ease;
      box-shadow: -5px 0 25px rgba(0, 0, 0, 0.1);
    }
    .mobile-menu.active { right: 0; }
    .mobile-user-info { margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid #e8e8e8; }
    .mobile-user-info.mobile-auth-links-wrap { display: flex; align-items: center; gap: 10px; }
    .mobile-user-name { display: block; color: #1a3c1a; font-weight: 600; font-size: 17px; }
    .mobile-controls {
      margin-top: 24px;
      padding-top: 20px;
      border-top: 1px solid #e8e8e8;
    }
    .mobile-controls-title {
      font-size: 12px;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      color: #666;
      margin-bottom: 12px;
      padding: 0 10px;
    }
    .mobile-controls-link {
      display: block;
      padding: 12px 20px;
      color: #1a3c1a;
      text-decoration: none;
      font-size: 15px;
      transition: background-color 0.2s ease;
      width: 100%;
      text-align: left;
      background: none;
      border: none;
      font-family: inherit;
      cursor: pointer;
    }
    .mobile-controls-link:hover { background-color: rgba(26, 60, 26, 0.08); }
    .mobile-controls-form { padding: 0; margin: 0; }
    .mobile-controls-logout { border-top: 1px solid #e8e8e8; margin-top: 4px; color: #666; }
    .mobile-auth-links { display: flex; gap: 10px; margin-bottom: 20px; }
    .mobile-auth-link { color: #1a3c1a; text-decoration: none; font-weight: 500; }
    .mobile-auth-link:hover { color: #eac31b; }
    .mobile-nav-list { list-style: none; }
    .mobile-nav-item { margin-bottom: 10px; border-bottom: 1px solid #e8e8e8; }
    .mobile-nav-link {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 10px;
      color: #1a3c1a;
      text-decoration: none;
      font-weight: 700;
      font-size: 17px;
      transition: all 0.2s ease;
    }
    .mobile-nav-link:hover { color: #fafffa; background-color: rgba(26, 60, 26, 1); }
    .mobile-nav-link.has-submenu::after { content: '▲'; font-size: 12px; transition: transform 0.3s ease; }
    .mobile-nav-link.has-submenu.active::after { transform: rotate(180deg); }
    .mobile-submenu {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.4s ease;
      background-color: rgba(26, 60, 26, 0.03);
      border-radius: 4px;
      margin-bottom: 10px;
    }
    .mobile-submenu.active { max-height: 500px; }
    .mobile-submenu-list { list-style: none; padding: 10px 0; }
    .mobile-submenu-item { padding: 0 10px; }
    .mobile-submenu-link {
      display: block;
      padding: 12px 20px;
      color: #1a3c1a;
      text-decoration: none;
      font-size: 15px;
      transition: all 0.2s ease;
    }
    .mobile-submenu-link:hover { color: #1a3c1a; background-color: rgba(26, 60, 26, 0.05); padding-left: 25px; }
    .mobile-submenu-main-item { background-color: rgba(26, 60, 26, 0); }
    .mobile-submenu-main-link { font-weight: 400 !important; color: #1a3c1a !important; border-left-color: #1a3c1a !important; }
    .mobile-submenu-main-link:hover { background-color: rgba(26, 60, 26, 0.15); }
    @media (max-width: 1320px) { .logo-img { max-width: 180px; } .nav-link { padding: 8px 10px; font-size: 14px; letter-spacing: -0.03em; } .nav-list { gap: 4px; } }
    @media (max-width: 1220px) { .nav-list { gap: 4px; } .nav-link { padding: 8px 10px; font-size: 12px; letter-spacing: -0.03em; } }
    @media (max-width: 1040px) { .nav-link { padding: 8px 8px; font-size: 11.5px; letter-spacing: -0.03em; } }
    @media (max-width: 960px) {
      body { padding-top: 88px; }
      .header-desktop { display: none; }
      .header-mobile { display: block; }
    }
    @media (max-width: 480px) {
      .header-container { padding: 0 15px; }
      .mobile-logo { max-width: 180px; }
      .mobile-menu { width: 90%; padding: 70px 15px 30px; }
    }
    .site-header.scrolled { padding: 5px 0; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15); }

    /* Футер */
    .site-footer {
        margin-top: 48px;
        background: #1a3c1a;
        color: #e8ebe8;
        padding: 32px 20px 24px;
    }
    .footer-container { max-width: 1200px; margin: 0 auto; }
    .footer-nav {
        display: flex;
        flex-wrap: wrap;
        gap: 12px 24px;
        margin-bottom: 28px;
        padding-bottom: 24px;
        border-bottom: 1px solid rgba(255,255,255,0.2);
    }
    .footer-nav a {
        color: #e8ebe8;
        text-decoration: none;
        font-size: 0.95rem;
    }
    .footer-nav a:hover { color: #eac31b; text-decoration: underline; }
    .footer-legal { font-size: 0.85rem; line-height: 1.6; opacity: 0.95; }
    .footer-legal p { margin-bottom: 12px; }
    .footer-legal p:last-child { margin-bottom: 0; }
    .footer-age { margin-top: 16px; font-weight: 500; }
    @media (max-width: 640px) {
        .site-footer { padding: 24px 15px 20px; margin-top: 32px; }
        .footer-nav { gap: 10px 16px; margin-bottom: 20px; }
        .footer-legal { font-size: 0.8rem; }
    }
    @media (max-width: 600px) {
        .container { padding-left: 12px; padding-right: 12px; }
    }

    /* Кнопка «Версия для слабовидящих» */
    .a11y-toggle {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        font-size: 0.9rem;
        background: transparent;
        border: 1px solid #1a3c1a;
        color: #1a3c1a;
        border-radius: 4px;
        cursor: pointer;
        white-space: nowrap;
    }
    .a11y-toggle:hover { background: rgba(26,60,26,0.08); }
    .a11y-toggle[aria-pressed="true"] { background: #1a3c1a; color: #fafffa; }
    .a11y-toggle-icon { font-size: 1.1rem; }

    /* Полоска с кнопкой доступности под шапкой */
    .a11y-bar {
        background: #f5f5f5;
        border-bottom: 1px solid #e0e0e0;
        padding: 28px 0;
    }
    .a11y-bar-inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
    @media (max-width: 960px) {
        .a11y-bar { padding: 10px 0; min-height: 44px; display: flex; align-items: center; }
        .a11y-bar-inner { padding: 0 15px; }
    }

    /* Режим для слабовидящих (ГОСТ Р 56832, WCAG 2.1) — ч/б */
    body.a11y-mode {
        font-size: 1.45rem !important;
        line-height: 1.7 !important;
        background: #ffffff !important;
        color: #000000 !important;
    }
    body.a11y-mode,
    body.a11y-mode * {
        font-family: Arial, sans-serif !important;
    }
    body.a11y-mode .container,
    body.a11y-mode main { color: #000 !important; }
    body.a11y-mode a { color: #000 !important; text-decoration: underline !important; }
    body.a11y-mode a:hover { color: #000 !important; background: rgba(0,0,0,0.05) !important; }
    body.a11y-mode h1, body.a11y-mode h2, body.a11y-mode h3, body.a11y-mode .page-title { color: #000 !important; font-size: 1.5em !important; }
    body.a11y-mode .site-header { background: #fff !important; border-bottom: 2px solid #000 !important; }
    body.a11y-mode .nav-link, body.a11y-mode .auth-link { color: #000 !important; }
    body.a11y-mode .site-footer { background: #000 !important; color: #fff !important; }
    body.a11y-mode .site-footer a { color: #fff !important; }
    body.a11y-mode .btn { background: #000 !important; color: #fff !important; border: 2px solid #000 !important; }
    body.a11y-mode input, body.a11y-mode textarea, body.a11y-mode select {
        font-size: 1.45rem !important;
        border: 2px solid #000 !important;
        background: #fff !important;
        color: #000 !important;
    }
    body.a11y-mode .alert-success { background: #e0e0e0 !important; color: #000 !important; border: 2px solid #000 !important; }
    body.a11y-mode .alert-error { background: #e0e0e0 !important; color: #000 !important; border: 2px solid #000 !important; }
    body.a11y-mode .a11y-toggle { border-color: #000 !important; color: #000 !important; }
    body.a11y-mode .a11y-toggle[aria-pressed="true"] { background: #000 !important; color: #fff !important; }
    body.a11y-mode .auth-link { color: #000 !important; }
    body.a11y-mode .home-quick-card,
    body.a11y-mode .news-preview-article-card,
    body.a11y-mode .news-preview-article-card-link { background: #fff !important; color: #000 !important; border: 2px solid #000 !important; }
    body.a11y-mode .home-quick-card:hover,
    body.a11y-mode .news-preview-article-card:hover { background: #e8e8e8 !important; }
    body.a11y-mode .a11y-bar { background: #fff !important; border-bottom: 2px solid #000 !important; }
    body.a11y-mode .section-title { color: #000 !important; }
    body.a11y-mode .submenu,
    body.a11y-mode .submenu-link,
    body.a11y-mode .user-dropdown-menu { background: #fff !important; color: #000 !important; border: 2px solid #000 !important; }
    body.a11y-mode .submenu-link:hover { background: #e8e8e8 !important; color: #000 !important; }
    body.a11y-mode .pagination li a,
    body.a11y-mode .pagination li span { background: #fff !important; color: #000 !important; border: 2px solid #000 !important; }
    body.a11y-mode .pagination li a:hover { background: #e8e8e8 !important; color: #000 !important; }
    body.a11y-mode .pagination li.active span { background: #000 !important; color: #fff !important; }
    body.a11y-mode .table th { background: #000 !important; color: #fff !important; }
    body.a11y-mode .carousel-btn { background: #fff !important; color: #000 !important; border: 2px solid #000 !important; }
    body.a11y-mode .home-carousel-bleed,
    body.a11y-mode .home-carousel,
    body.a11y-mode .carousel-inner { background: #fff !important; }
    </style>
</head>
<body id="app-body">
    @include('components.header')

    <div class="a11y-bar" role="region" aria-label="Доступность">
        <div class="a11y-bar-inner">
            @include('components.accessibility-widget')
        </div>
    </div>

    @yield('content_full')

    <main class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="footer-container">
            <nav class="footer-nav" aria-label="Важные разделы сайта">
                <a href="{{ route('home') }}">Главная</a>
                <a href="{{ route('news.index') }}">Новости</a>
                <a href="{{ route('administration') }}">Администрация</a>
                <a href="{{ route('appeals.work') }}">Обращения граждан</a>
                <a href="{{ route('documents') }}">Документы</a>
                <a href="{{ route('finance') }}">Финансы</a>
                <a href="{{ route('reference') }}">Справочная</a>
                <a href="{{ route('ecology') }}">Экология</a>
            </nav>
            <div class="footer-legal">
                <p>© 2008–2024 Наименование средства массовой информации: «Официальный сайт администрации Сергиево-Посадского городского округа». Свидетельство о регистрации СМИ Эл № ФС77-78255 от 27 марта 2020 г. выдано Федеральной службой по надзору в сфере связи, информационных технологий и массовых коммуникаций (Роскомнадзор). Учредитель: Администрация Сергиево-Посадского городского округа Московской области.</p>
                <p class="footer-age">Настоящий ресурс содержит материалы возрастного ценза 18+</p>
            </div>
        </div>
    </footer>

    <script>
    (function() {
        var KEY = 'a11y-mode';
        function apply(active) {
            if (active) document.body.classList.add('a11y-mode'); else document.body.classList.remove('a11y-mode');
            try { localStorage.setItem(KEY, active ? '1' : '0'); } catch (e) {}
            document.querySelectorAll('.a11y-toggle').forEach(function(btn) {
                if (btn) {
                    btn.setAttribute('aria-pressed', active ? 'true' : 'false');
                    btn.innerHTML = (active ? '<span class="a11y-toggle-icon" aria-hidden="true">◐</span> Обычная версия' : '<span class="a11y-toggle-icon" aria-hidden="true">⊚</span> Версия для слабовидящих');
                }
            });
        }
        window.toggleA11yMode = function() {
            document.body.classList.toggle('a11y-mode');
            apply(document.body.classList.contains('a11y-mode'));
        };
        try {
            var saved = localStorage.getItem(KEY);
            if (saved === '1') apply(true);
        } catch (e) {}
    })();
    </script>
    @include('components.confirm-delete-modal')
    @include('components.img-lightbox')
    @stack('scripts')
</body>
</html>