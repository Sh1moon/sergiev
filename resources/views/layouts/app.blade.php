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

    :root {
        --a11y-font-scale: 100;
        --a11y-content-bg: #ffffff;
        --a11y-content-fg: #000000;
        --a11y-content-link: #0000EE;
        --a11y-content-link-hover: #0000AA;
        --a11y-content-link-visited: #0000EE;
        --a11y-content-border: #CCCCCC;
        --a11y-button-bg: #F0F0F0;
        --a11y-button-fg: #000000;
        --a11y-focus-color: #ff3b3b;
    }

    /* Цвета сайта из палитры только после явного выбора схемы (body.a11y-palette) */
    body.a11y-enabled.a11y-palette {
        background: var(--a11y-content-bg) !important;
        color: var(--a11y-content-fg) !important;
    }
    /* Масштаб шрифта только для основного контента: не трогаем rem-отступы всего body */
    body.a11y-enabled #a11y-content-root {
        font-size: calc(1em * (var(--a11y-font-scale) / 100));
        line-height: 1.7;
    }
    /* Панель и полоса: базовый размер; при включённом режиме масштабируется как и контент */
    #a11yUiRoot {
        font-size: 16px;
        line-height: 1.4;
    }
    body.a11y-enabled #a11yUiRoot {
        font-size: calc(16px * (var(--a11y-font-scale) / 100));
    }
    body.a11y-enabled.a11y-palette #a11y-content-root {
        background: var(--a11y-content-bg) !important;
        color: var(--a11y-content-fg) !important;
    }
    body.a11y-enabled.a11y-palette #a11y-content-root *:not(img):not(svg):not(path):not(video):not(canvas):not(iframe) {
        border-color: var(--a11y-content-border) !important;
    }
    body.a11y-enabled.a11y-palette #a11y-content-root *:not(img):not(svg):not(path):not(video):not(canvas):not(iframe):not(a):not(button):not(input):not(select):not(textarea) {
        background-color: var(--a11y-content-bg) !important;
        color: var(--a11y-content-fg) !important;
    }
    body.a11y-enabled.a11y-palette #a11y-content-root h1,
    body.a11y-enabled.a11y-palette #a11y-content-root h2,
    body.a11y-enabled.a11y-palette #a11y-content-root h3,
    body.a11y-enabled.a11y-palette #a11y-content-root h4,
    body.a11y-enabled.a11y-palette #a11y-content-root h5,
    body.a11y-enabled.a11y-palette #a11y-content-root h6,
    body.a11y-enabled.a11y-palette #a11y-content-root p,
    body.a11y-enabled.a11y-palette #a11y-content-root li,
    body.a11y-enabled.a11y-palette #a11y-content-root span,
    body.a11y-enabled.a11y-palette #a11y-content-root div,
    body.a11y-enabled.a11y-palette #a11y-content-root td,
    body.a11y-enabled.a11y-palette #a11y-content-root th,
    body.a11y-enabled.a11y-palette #a11y-content-root label {
        color: var(--a11y-content-fg) !important;
    }
    body.a11y-enabled.a11y-palette #a11y-content-root a {
        color: var(--a11y-content-link) !important;
        text-decoration: underline !important;
    }
    body.a11y-enabled.a11y-palette #a11y-content-root a:hover,
    body.a11y-enabled.a11y-palette #a11y-content-root a:focus {
        color: var(--a11y-content-link-hover) !important;
    }
    body.a11y-enabled.a11y-palette #a11y-content-root a:visited {
        color: var(--a11y-content-link-visited) !important;
    }
    body.a11y-enabled.a11y-palette #a11y-content-root table,
    body.a11y-enabled.a11y-palette #a11y-content-root th,
    body.a11y-enabled.a11y-palette #a11y-content-root td,
    body.a11y-enabled.a11y-palette #a11y-content-root hr,
    body.a11y-enabled.a11y-palette #a11y-content-root input,
    body.a11y-enabled.a11y-palette #a11y-content-root textarea,
    body.a11y-enabled.a11y-palette #a11y-content-root select,
    body.a11y-enabled.a11y-palette #a11y-content-root [class*="card"],
    body.a11y-enabled.a11y-palette #a11y-content-root [class*="panel"] {
        border-color: var(--a11y-content-border) !important;
    }
    body.a11y-enabled.a11y-palette #a11y-content-root input,
    body.a11y-enabled.a11y-palette #a11y-content-root textarea,
    body.a11y-enabled.a11y-palette #a11y-content-root select {
        background: var(--a11y-content-bg) !important;
        color: var(--a11y-content-fg) !important;
    }
    body.a11y-enabled.a11y-palette #a11y-content-root .btn,
    body.a11y-enabled.a11y-palette #a11y-content-root button:not(.a11y-btn):not(.a11y-trigger):not(.burger-btn):not(.user-dropdown-btn) {
        background: var(--a11y-button-bg) !important;
        color: var(--a11y-button-fg) !important;
        border: 1px solid var(--a11y-content-border) !important;
    }
    body.a11y-enabled.a11y-palette #a11y-content-root .site-footer,
    body.a11y-enabled.a11y-palette .site-header,
    body.a11y-enabled.a11y-palette #a11y-content-root .mobile-menu,
    body.a11y-enabled.a11y-palette #a11y-content-root .submenu,
    body.a11y-enabled.a11y-palette #a11y-content-root .user-dropdown,
    body.a11y-enabled.a11y-palette #a11y-content-root main,
    body.a11y-enabled.a11y-palette #a11y-content-root .container {
        background: var(--a11y-content-bg) !important;
        color: var(--a11y-content-fg) !important;
    }
    body.a11y-enabled.a11y-palette .site-header .nav-link,
    body.a11y-enabled.a11y-palette .site-header .logo-link,
    body.a11y-enabled.a11y-palette .site-header .auth-link,
    body.a11y-enabled.a11y-palette .site-header .user-dropdown-btn,
    body.a11y-enabled.a11y-palette .site-header .mobile-nav-link,
    body.a11y-enabled.a11y-palette .site-header .mobile-submenu-link {
        color: var(--a11y-content-fg) !important;
    }
    body.a11y-enabled.a11y-palette .site-header .nav-link:hover,
    body.a11y-enabled.a11y-palette .site-header .auth-link:hover,
    body.a11y-enabled.a11y-palette .site-header .user-dropdown-btn:hover,
    body.a11y-enabled.a11y-palette .site-header .mobile-nav-link:hover,
    body.a11y-enabled.a11y-palette .site-header .mobile-submenu-link:hover {
        background: var(--a11y-button-bg) !important;
        color: var(--a11y-button-fg) !important;
    }
    body.a11y-enabled.a11y-palette .site-header .nav-link.active {
        background: var(--a11y-button-bg) !important;
        color: var(--a11y-button-fg) !important;
        border: 1px solid var(--a11y-content-border) !important;
    }

    .a11y-ui {
        position: relative;
        width: 100%;
        margin: 0;
        padding: 0;
        margin-top: 4px;
    }
    .a11y-bar {
        width: 100%;
        padding: 8px 12px;
        display: flex;
        justify-content: flex-start;
        background: #1a3c1a;
    }
    .a11y-trigger {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: auto;
        margin: 0;
        padding: 10px 18px;
        border: 1px solid #334155;
        border-radius: 6px;
        background: #f8fafc;
        color: #111827;
        font-weight: 700;
        letter-spacing: 0.01em;
        font-size: 0.95em;
        cursor: pointer;
        box-sizing: border-box;
    }
    .a11y-trigger:hover,
    .a11y-trigger:focus-visible {
        background: #eef2f7;
        border-color: #0f172a;
        outline: 2px solid #0f172a;
        outline-offset: 1px;
    }

    .a11y-panel {
        position: fixed;
        left: 50%;
        top: 115px;
        transform: translateX(-50%);
        z-index: 1001;
        width: min(92vw, 480px);
        max-width: 480px;
        max-height: min(75vh, calc(100vh - 140px));
        overflow: auto;
        margin: 0;
        padding: 14px 16px 16px;
        border: 1px solid #3f3f3f;
        border-radius: 10px;
        background: #1a1a1a;
        color: #ffffff;
        box-shadow: 0 12px 28px rgba(0,0,0,0.35);
        box-sizing: border-box;
        display: none;
    }
    .a11y-panel[aria-hidden="false"] { display: block; }
    .a11y-close-x {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 36px;
        height: 36px;
        border: 1px solid #707070;
        border-radius: 8px;
        background: #1f1f1f;
        color: #ffffff;
        font-size: 24px;
        line-height: 1;
        cursor: pointer;
    }
    .a11y-close-x:hover,
    .a11y-close-x:focus-visible {
        border-color: #ffd400;
        outline: 2px solid #ffd400;
        outline-offset: 1px;
    }
    .a11y-backdrop {
        position: fixed;
        inset: 0;
        z-index: 1000;
        background: rgba(0, 0, 0, 0.28);
        display: none;
    }
    .a11y-backdrop[aria-hidden="false"] { display: block; }
    .a11y-title { font-size: 1.1em; margin: 0 0 10px; }
    .a11y-group {
        border: 1px solid #5a5a5a;
        border-radius: 10px;
        padding: 10px;
        margin-bottom: 10px;
    }
    .a11y-group h3 { margin: 0 0 8px; font-size: 0.95em; color: #f0f0f0; }
    .a11y-row { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
    .a11y-row-spaced { margin-top: 8px; }

    .a11y-btn,
    .a11y-select,
    .a11y-range,
    .a11y-check {
        min-height: 44px;
        min-width: 44px;
    }
    .a11y-btn {
        border: 1px solid #707070;
        border-radius: 8px;
        background: #1f1f1f;
        color: #ffffff;
        padding: 8px 12px;
        cursor: pointer;
        font-weight: 600;
    }
    .a11y-btn.active:not(.a11y-swatch) {
        background: #ffd400;
        color: #111;
        border-color: #ffd400;
    }
    .a11y-swatch.active {
        box-shadow: 0 0 0 3px #ffd400;
    }
    .a11y-select {
        border: 1px solid #707070;
        border-radius: 8px;
        background: #1f1f1f;
        color: #ffffff;
        padding: 8px 10px;
        min-width: 180px;
        font-size: 1em;
    }
    .a11y-range-wrap {
        display: grid;
        grid-template-columns: auto 1fr auto auto;
        gap: 8px;
        align-items: center;
        width: 100%;
    }
    .a11y-range {
        width: 100%;
        accent-color: #ffd400;
    }
    /* Панель и полоса в цветах выбранной схемы */
    body.a11y-enabled.a11y-palette #a11yUiRoot .a11y-trigger {
        background: var(--a11y-button-bg) !important;
        color: var(--a11y-button-fg) !important;
        border-color: var(--a11y-content-border) !important;
    }
    body.a11y-enabled.a11y-palette #a11yUiRoot .a11y-bar {
        background: var(--a11y-content-bg) !important;
        border: none !important;
    }
    body.a11y-enabled.a11y-palette #a11yUiRoot .a11y-panel {
        background: var(--a11y-content-bg) !important;
        color: var(--a11y-content-fg) !important;
        border-color: var(--a11y-content-border) !important;
    }
    body.a11y-enabled.a11y-palette #a11yUiRoot .a11y-title {
        color: var(--a11y-content-fg) !important;
    }
    body.a11y-enabled.a11y-palette #a11yUiRoot .a11y-group {
        border-color: var(--a11y-content-border) !important;
    }
    body.a11y-enabled.a11y-palette #a11yUiRoot .a11y-group h3 {
        color: var(--a11y-content-fg) !important;
        opacity: 0.92;
    }
    body.a11y-enabled.a11y-palette #a11yUiRoot .a11y-btn:not(.a11y-swatch) {
        background: var(--a11y-button-bg) !important;
        color: var(--a11y-button-fg) !important;
        border-color: var(--a11y-content-border) !important;
    }
    body.a11y-enabled.a11y-palette #a11yUiRoot .a11y-btn.active:not(.a11y-swatch) {
        outline: 2px solid var(--a11y-content-link) !important;
        outline-offset: 2px;
    }
    body.a11y-enabled.a11y-palette #a11yUiRoot .a11y-select {
        background: var(--a11y-content-bg) !important;
        color: var(--a11y-content-fg) !important;
        border-color: var(--a11y-content-border) !important;
    }
    body.a11y-enabled.a11y-palette #a11yUiRoot .a11y-check {
        background: var(--a11y-button-bg) !important;
        color: var(--a11y-button-fg) !important;
        border-color: var(--a11y-content-border) !important;
    }
    body.a11y-enabled.a11y-palette #a11yUiRoot .a11y-range {
        accent-color: var(--a11y-content-link);
    }
    body.a11y-enabled.a11y-palette #a11yUiRoot .a11y-close-x {
        background: var(--a11y-button-bg) !important;
        color: var(--a11y-button-fg) !important;
        border-color: var(--a11y-content-border) !important;
    }
    body.a11y-enabled.a11y-palette #a11yUiRoot .a11y-swatch.active {
        box-shadow: 0 0 0 3px var(--a11y-content-link);
    }
    /* Синхронизация с инверсией и монохромом без палитры (как у блока контента) */
    #a11yUiRoot.a11y-ui--invert .a11y-bar {
        filter: invert(1) hue-rotate(180deg);
    }
    #a11yUiRoot.a11y-ui--mono .a11y-bar {
        filter: grayscale(1);
    }
    #a11yUiRoot.a11y-ui--invert.a11y-ui--mono .a11y-bar {
        filter: invert(1) hue-rotate(180deg) grayscale(1);
    }
    .a11y-check {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid #707070;
        border-radius: 8px;
        padding: 8px 10px;
        background: #1f1f1f;
        cursor: pointer;
        user-select: none;
        font-weight: 600;
        color: #fff;
    }
    .a11y-check input { width: 20px; height: 20px; margin: 0; }
    .a11y-footer { display: flex; gap: 8px; flex-wrap: wrap; }
    .a11y-footer .a11y-btn { flex: 1 1 140px; }

    .a11y-swatch { min-width: 130px; }
    .a11y-swatch-bw { background: #fff; color: #000; border-color: #fff; }
    .a11y-swatch-wb { background: #000; color: #fff; border-color: #fff; }
    .a11y-swatch-by { background: #ffef5a; color: #000; border-color: #ffef5a; }
    .a11y-swatch-yb { background: #000; color: #ffeb3b; border-color: #ffeb3b; }

    body.a11y-show-focus :focus,
    body.a11y-show-focus :focus-visible {
        outline: 3px solid var(--a11y-focus-color) !important;
        outline-offset: 2px !important;
    }

    body.a11y-disable-animations *,
    body.a11y-disable-animations *::before,
    body.a11y-disable-animations *::after {
        transition: none !important;
        animation: none !important;
        transform: none !important;
        scroll-behavior: auto !important;
    }

    body.a11y-font-arial,
    body.a11y-font-arial * { font-family: Arial, sans-serif !important; }
    body.a11y-font-tahoma,
    body.a11y-font-tahoma * { font-family: Tahoma, sans-serif !important; }
    body.a11y-font-verdana,
    body.a11y-font-verdana * { font-family: Verdana, sans-serif !important; }

    #a11y-main-content.a11y-invert { filter: invert(1) hue-rotate(180deg); }
    /* Монохром без выбранной палитры: исходные цвета сайта, только обесцвечивание */
    body.a11y-enabled:not(.a11y-palette) #a11y-main-content.a11y-monochrome-only {
        filter: grayscale(1);
    }
    body.a11y-enabled:not(.a11y-palette) #a11y-main-content.a11y-invert.a11y-monochrome-only {
        filter: invert(1) hue-rotate(180deg) grayscale(1);
    }

    /* При инверсии: меню черное с белым текстом */
    body.a11y-enabled.a11y-invert-nav .site-header {
        background: #000000 !important;
        border-bottom: 1px solid #666666 !important;
    }
    body.a11y-enabled.a11y-invert-nav .site-header .nav-link,
    body.a11y-enabled.a11y-invert-nav .site-header .auth-link,
    body.a11y-enabled.a11y-invert-nav .site-header .user-dropdown-btn,
    body.a11y-enabled.a11y-invert-nav .site-header .mobile-nav-link,
    body.a11y-enabled.a11y-invert-nav .site-header .mobile-submenu-link,
    body.a11y-enabled.a11y-invert-nav .site-header .logo-link {
        color: #FFFFFF !important;
    }
    body.a11y-enabled.a11y-invert-nav .site-header .nav-link:hover,
    body.a11y-enabled.a11y-invert-nav .site-header .auth-link:hover,
    body.a11y-enabled.a11y-invert-nav .site-header .user-dropdown-btn:hover,
    body.a11y-enabled.a11y-invert-nav .site-header .mobile-nav-link:hover,
    body.a11y-enabled.a11y-invert-nav .site-header .mobile-submenu-link:hover {
        background: transparent !important;
        color: #FFFFFF !important;
        border: 2px solid #FFFFFF !important;
    }
    body.a11y-enabled.a11y-invert-nav .site-header .nav-link.active {
        background: transparent !important;
        color: #FFFFFF !important;
        border: 2px solid #FFFFFF !important;
    }

    @media (max-width: 960px) {
        .a11y-panel {
            top: 108px;
            max-height: min(70vh, calc(100vh - 120px));
            padding: 12px;
        }
        .a11y-bar {
            justify-content: stretch;
        }
        .a11y-trigger {
            padding: 10px 12px;
            width: 100%;
            max-width: 100%;
        }
    }
    .staff-back-nav {
        margin-bottom: 14px;
    }
    .staff-back-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 14px;
        border: 1px solid #2d4d2d;
        border-radius: 4px;
        background: #ffffff;
        color: #1a3c1a;
        text-decoration: none;
        font-weight: 600;
        line-height: 1.2;
        cursor: pointer;
    }
    .staff-back-btn:hover,
    .staff-back-btn:focus-visible {
        background: #f3f7f3;
        color: #1a3c1a;
        border-color: #1a3c1a;
        outline: 2px solid #1a3c1a;
        outline-offset: 1px;
    }
    </style>
</head>
<body id="app-body">
    @include('components.header')
    @include('components.accessibility-widget')

    <div id="a11y-content-root">
    @yield('content_full')

    <div id="a11y-main-content">
    <main class="container">
        @auth
            @if(request()->routeIs('staff.*'))
                <div class="staff-back-nav">
                    <button type="button" class="staff-back-btn" onclick="window.history.back()">
                        Назад
                    </button>
                </div>
            @endif
        @endauth
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
    </div>
    </div>

    <script>
    (function () {
        var STORAGE_KEY = 'a11y-settings-v2';
        var FONT_SCALE_OPTIONS = [100, 125, 150];
        var defaults = {
            enabled: false,
            paletteActive: false,
            fontScale: 100,
            fontFamily: 'default',
            scheme: 'bw',
            invert: false,
            monochrome: false,
            showFocus: true,
            disableAnimations: false
        };
        var state = loadState();
        var trigger = document.getElementById('a11yTrigger');
        var panel = document.getElementById('a11yPanel');
        var backdrop = document.getElementById('a11yBackdrop');
        var closeXBtn = document.getElementById('closeXBtn');
        var uiRoot = document.getElementById('a11yUiRoot');
        var mainContent = document.getElementById('a11y-main-content');
        if (!trigger || !panel || !uiRoot || !backdrop || !closeXBtn) {
            return;
        }
        var fontRange = document.getElementById('fontRange');
        var fontValue = document.getElementById('fontValue');
        var fontMinus = document.getElementById('fontMinus');
        var fontPlus = document.getElementById('fontPlus');
        var fontFamily = document.getElementById('fontFamily');
        var schemeButtons = Array.prototype.slice.call(document.querySelectorAll('[data-scheme]'));
        var invertBtn = document.getElementById('invertBtn');
        var monoBtn = document.getElementById('monoBtn');
        var focusToggle = document.getElementById('focusToggle');
        var animToggle = document.getElementById('animToggle');
        var resetBtn = document.getElementById('resetBtn');
        var closeBtn = document.getElementById('closeBtn');
        var lastFocus = null;

        function loadState() {
            try {
                var raw = localStorage.getItem(STORAGE_KEY);
                if (!raw) return Object.assign({}, defaults);
                var parsed = JSON.parse(raw);
                var merged = Object.assign({}, defaults, parsed);
                /* Раньше при любом включении сразу подставлялась палитра — сохраняем это для старых сохранений */
                if (parsed && Object.prototype.hasOwnProperty.call(parsed, 'paletteActive') === false && merged.enabled) {
                    merged.paletteActive = true;
                }
                return merged;
            } catch (e) {
                return Object.assign({}, defaults);
            }
        }

        function saveState() {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(state));
        }

        function clamp(value, min, max) {
            return Math.max(min, Math.min(max, value));
        }

        function normalizeFontScale(value) {
            var numeric = Number(value);
            if (!isFinite(numeric)) return FONT_SCALE_OPTIONS[0];
            return FONT_SCALE_OPTIONS.reduce(function (closest, option) {
                return Math.abs(option - numeric) < Math.abs(closest - numeric) ? option : closest;
            }, FONT_SCALE_OPTIONS[0]);
        }

        function stepFontScale(currentValue, direction) {
            var normalized = normalizeFontScale(currentValue);
            var currentIndex = FONT_SCALE_OPTIONS.indexOf(normalized);
            var nextIndex = clamp(currentIndex + direction, 0, FONT_SCALE_OPTIONS.length - 1);
            return FONT_SCALE_OPTIONS[nextIndex];
        }

        function hexToRgb(hex) {
            var clean = String(hex || '').replace('#', '');
            if (clean.length === 3) {
                clean = clean.split('').map(function (char) { return char + char; }).join('');
            }
            var value = parseInt(clean, 16);
            if (isNaN(value)) return { r: 0, g: 0, b: 0 };
            return {
                r: (value >> 16) & 255,
                g: (value >> 8) & 255,
                b: value & 255
            };
        }

        function toGrayHex(hex) {
            var rgb = hexToRgb(hex);
            var gray = Math.round(0.299 * rgb.r + 0.587 * rgb.g + 0.114 * rgb.b);
            var part = gray.toString(16).padStart(2, '0').toUpperCase();
            return '#' + part + part + part;
        }

        function applyScheme(scheme, monochromeEnabled) {
            var schemes = {
                bw: { bg: '#FFFFFF', fg: '#000000', link: '#0000EE', linkHover: '#0000AA', visited: '#0000EE', border: '#CCCCCC', buttonBg: '#F0F0F0', buttonFg: '#000000', focus: '#d60000' },
                wb: { bg: '#000000', fg: '#FFFFFF', link: '#FFFF00', linkHover: '#FFD700', visited: '#FFFF00', border: '#666666', buttonBg: '#1A1A1A', buttonFg: '#FFFFFF', focus: '#FFD700' },
                by: { bg: '#FFFF00', fg: '#000000', link: '#0000EE', linkHover: '#0000AA', visited: '#0000EE', border: '#B3B300', buttonBg: '#E6E600', buttonFg: '#000000', focus: '#000000' },
                yb: { bg: '#000000', fg: '#FFFF00', link: '#00FFFF', linkHover: '#00CCCC', visited: '#00FFFF', border: '#333300', buttonBg: '#1A1A00', buttonFg: '#FFFF00', focus: '#FFFFFF' }
            };
            var selected = schemes[scheme] || schemes.bw;
            if (monochromeEnabled) {
                selected = {
                    bg: toGrayHex(selected.bg),
                    fg: toGrayHex(selected.fg),
                    link: toGrayHex(selected.link),
                    linkHover: toGrayHex(selected.linkHover),
                    visited: toGrayHex(selected.visited),
                    border: toGrayHex(selected.border),
                    buttonBg: toGrayHex(selected.buttonBg),
                    buttonFg: toGrayHex(selected.buttonFg),
                    focus: toGrayHex(selected.focus)
                };
            }
            var root = document.documentElement;
            root.style.setProperty('--a11y-content-bg', selected.bg);
            root.style.setProperty('--a11y-content-fg', selected.fg);
            root.style.setProperty('--a11y-content-link', selected.link);
            root.style.setProperty('--a11y-content-link-hover', selected.linkHover);
            root.style.setProperty('--a11y-content-link-visited', selected.visited);
            root.style.setProperty('--a11y-content-border', selected.border);
            root.style.setProperty('--a11y-button-bg', selected.buttonBg);
            root.style.setProperty('--a11y-button-fg', selected.buttonFg);
            root.style.setProperty('--a11y-focus-color', selected.focus);
        }

        function clearPaletteCssVars() {
            var root = document.documentElement;
            [
                '--a11y-content-bg',
                '--a11y-content-fg',
                '--a11y-content-link',
                '--a11y-content-link-hover',
                '--a11y-content-link-visited',
                '--a11y-content-border',
                '--a11y-button-bg',
                '--a11y-button-fg',
                '--a11y-focus-color'
            ].forEach(function (prop) {
                root.style.removeProperty(prop);
            });
        }

        function applyState() {
            var scale = normalizeFontScale(state.fontScale);
            state.fontScale = scale;
            document.documentElement.style.setProperty('--a11y-font-scale', String(scale));
            var paletteOn = !!state.enabled && !!state.paletteActive;
            document.body.classList.toggle('a11y-palette', paletteOn);
            if (paletteOn) {
                applyScheme(state.scheme, !!state.monochrome);
            } else {
                clearPaletteCssVars();
            }
            schemeButtons.forEach(function (button) {
                button.classList.toggle('active', paletteOn && button.getAttribute('data-scheme') === state.scheme);
            });
            document.body.classList.toggle('a11y-enabled', !!state.enabled);
            document.body.classList.remove('a11y-font-arial', 'a11y-font-tahoma', 'a11y-font-verdana');
            if (state.enabled) {
                if (state.fontFamily === 'Tahoma') document.body.classList.add('a11y-font-tahoma');
                else if (state.fontFamily === 'Verdana') document.body.classList.add('a11y-font-verdana');
                else if (state.fontFamily === 'Arial') document.body.classList.add('a11y-font-arial');
            }

            document.body.classList.toggle('a11y-show-focus', !!state.enabled && !!state.showFocus);
            document.body.classList.toggle('a11y-disable-animations', !!state.enabled && !!state.disableAnimations);
            document.body.classList.toggle('a11y-invert-nav', !!state.enabled && !!state.invert);
            if (mainContent) {
                mainContent.classList.toggle('a11y-invert', !!state.enabled && !!state.invert);
                mainContent.classList.toggle(
                    'a11y-monochrome-only',
                    !!state.enabled && !!state.monochrome && !paletteOn
                );
            }

            uiRoot.classList.toggle('a11y-ui--invert', !!state.enabled && !!state.invert);
            uiRoot.classList.toggle('a11y-ui--mono', !!state.enabled && !!state.monochrome && !paletteOn);

            fontRange.value = String(scale);
            fontValue.textContent = scale + '%';
            if (!fontFamily.querySelector('option[value="' + state.fontFamily + '"]')) {
                state.fontFamily = 'default';
            }
            fontFamily.value = state.fontFamily;
            invertBtn.classList.toggle('active', !!state.invert);
            monoBtn.classList.toggle('active', !!state.monochrome);
            focusToggle.checked = !!state.showFocus;
            animToggle.checked = !!state.disableAnimations;
        }

        function isPanelOpen() {
            return panel.getAttribute('aria-hidden') === 'false';
        }

        function openPanel() {
            lastFocus = document.activeElement;
            backdrop.setAttribute('aria-hidden', 'false');
            panel.setAttribute('aria-hidden', 'false');
            trigger.setAttribute('aria-expanded', 'true');
            fontRange.focus();
        }

        function closePanel() {
            backdrop.setAttribute('aria-hidden', 'true');
            panel.setAttribute('aria-hidden', 'true');
            trigger.setAttribute('aria-expanded', 'false');
            if (lastFocus && typeof lastFocus.focus === 'function') lastFocus.focus();
            else trigger.focus();
        }

        function trapFocus(event) {
            if (!isPanelOpen() || event.key !== 'Tab') return;
            var nodes = panel.querySelectorAll('button, input, select, [tabindex]:not([tabindex="-1"])');
            if (!nodes.length) return;
            var first = nodes[0];
            var last = nodes[nodes.length - 1];
            var active = document.activeElement;
            if (!event.shiftKey && active === last) {
                event.preventDefault();
                first.focus();
            } else if (event.shiftKey && active === first) {
                event.preventDefault();
                last.focus();
            }
        }

        trigger.addEventListener('click', function () {
            if (isPanelOpen()) closePanel();
            else openPanel();
        });
        backdrop.addEventListener('click', closePanel);
        closeXBtn.addEventListener('click', closePanel);
        closeBtn.addEventListener('click', closePanel);
        document.addEventListener('mousedown', function (event) {
            if (!isPanelOpen()) return;
            if (uiRoot.contains(event.target)) return;
            closePanel();
        });
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && isPanelOpen()) closePanel();
            trapFocus(event);
        });

        fontRange.addEventListener('input', function (event) {
            state.enabled = true;
            state.fontScale = normalizeFontScale(event.target.value);
            applyState();
            saveState();
        });
        fontMinus.addEventListener('click', function () {
            state.enabled = true;
            state.fontScale = stepFontScale(state.fontScale, -1);
            applyState();
            saveState();
        });
        fontPlus.addEventListener('click', function () {
            state.enabled = true;
            state.fontScale = stepFontScale(state.fontScale, 1);
            applyState();
            saveState();
        });
        fontFamily.addEventListener('change', function (event) {
            state.enabled = true;
            state.fontFamily = event.target.value;
            applyState();
            saveState();
        });
        schemeButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                state.enabled = true;
                state.paletteActive = true;
                state.scheme = button.getAttribute('data-scheme');
                applyState();
                saveState();
            });
        });
        invertBtn.addEventListener('click', function () {
            state.enabled = true;
            state.invert = !state.invert;
            applyState();
            saveState();
        });
        monoBtn.addEventListener('click', function () {
            state.enabled = true;
            state.monochrome = !state.monochrome;
            applyState();
            saveState();
        });
        focusToggle.addEventListener('change', function (event) {
            state.enabled = true;
            state.showFocus = !!event.target.checked;
            applyState();
            saveState();
        });
        animToggle.addEventListener('change', function (event) {
            state.enabled = true;
            state.disableAnimations = !!event.target.checked;
            applyState();
            saveState();
        });
        resetBtn.addEventListener('click', function () {
            state = Object.assign({}, defaults);
            localStorage.removeItem(STORAGE_KEY);
            applyState();
        });

        applyState();
    })();
    </script>
    @include('components.confirm-delete-modal')
    @include('components.img-lightbox')
    @stack('scripts')
</body>
</html>