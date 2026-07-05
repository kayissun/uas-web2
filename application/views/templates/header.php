<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Dashboard' ?> · Hotel Reservasi</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/sbadmin/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">

    <style>
        :root {
            --ink: #14213D;
            --ink-soft: #1F3A5F;
            --brass: #C9A227;
            --brass-soft: #E4C766;
            --paper: #F7F5F0;
            --paper-card: #FFFFFF;
            --text-dark: #23272F;
            --text-muted: #6B7280;
            --border: #E8E6E1;
            --radius: 0.9rem;
            --sidebar-w: 15.5rem;
            --sidebar-w-collapsed: 5.5rem;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif !important;
            background: var(--paper);
            color: var(--text-dark);
            min-height: 100vh;
        }

        h1, h2, h3, h4, h5, .brand-font, .page-title {
            font-family: 'Poppins', serif;
            letter-spacing: -0.01em;
        }

        code, .mono, .room-code {
            font-family: 'Poppins', monospace;
        }

        #wrapper { min-height: 100vh; }

        /* ---------- Sidebar ---------- */
        #accordionSidebar {
            position: fixed;
            top: 0; left: 0; bottom: 0;
            width: var(--sidebar-w);
            height: 100vh;
            overflow-y: auto;
            z-index: 1040;
            background: linear-gradient(190deg, var(--ink) 0%, var(--ink-soft) 100%);
            padding: 0;
            transition: width .2s ease-in-out;
            scrollbar-width: thin;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: .65rem;
            padding: 1.6rem 1.5rem 1.1rem;
            color: #fff;
            text-decoration: none;
        }

        .sidebar-brand-icon {
            width: 2.35rem;
            height: 2.35rem;
            border-radius: .6rem;
            background: var(--brass);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--ink);
            font-size: 1.05rem;
            flex-shrink: 0;
        }

        .sidebar-brand-text {
            font-family: 'Poppins', serif;
            font-weight: 600;
            font-size: 1.15rem;
            line-height: 1.15;
            color: #fff;
        }

        .sidebar-divider {
            border-top: 1px solid rgba(255,255,255,.12);
            margin: .5rem 1.25rem 1rem;
        }

        #accordionSidebar .nav-item { padding: 0 .9rem; }

        #accordionSidebar .nav-link {
            position: relative;
            display: flex;
            align-items: center;
            gap: .85rem;
            padding: .7rem .9rem;
            margin-bottom: .2rem;
            border-radius: .6rem;
            color: rgba(255,255,255,.72);
            font-size: .89rem;
            font-weight: 500;
            transition: background .15s ease, color .15s ease;
        }

        #accordionSidebar .nav-link i {
            width: 1.1rem;
            text-align: center;
            font-size: .95rem;
        }

        #accordionSidebar .nav-link:hover {
            background: rgba(255,255,255,.07);
            color: #fff;
        }

        #accordionSidebar .nav-link.active {
            background: rgba(201,162,39,.16);
            color: #fff;
        }

        /* signature: key-tag indicator on the active/hovered item */
        #accordionSidebar .nav-link::before {
            content: '';
            position: absolute;
            left: -.9rem;
            top: 50%;
            transform: translateY(-50%);
            width: .28rem;
            height: 0;
            border-radius: 0 .3rem .3rem 0;
            background: var(--brass);
            transition: height .15s ease;
        }

        #accordionSidebar .nav-link.active::before,
        #accordionSidebar .nav-link:hover::before {
            height: 1.6rem;
        }

        /* ---------- Content area ---------- */
        #content-wrapper {
            margin-left: var(--sidebar-w);
            width: calc(100% - var(--sidebar-w));
            min-height: 100vh;
            transition: margin-left .2s ease-in-out, width .2s ease-in-out;
        }

        #content .topbar {
            position: sticky;
            top: 0;
            z-index: 1030;
            background: var(--paper-card);
            border-bottom: 1px solid var(--border);
            padding: .85rem 1.75rem;
        }

        #content > .container-fluid { padding: 1.75rem; }

        .card {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: 0 1px 2px rgba(20,33,61,.04);
        }

        .card:hover { box-shadow: 0 6px 16px rgba(20,33,61,.07); }

        .btn-primary {
            background: var(--ink);
            border-color: var(--ink);
        }

        .btn-primary:hover {
            background: var(--ink-soft);
            border-color: var(--ink-soft);
        }

        .btn-brass {
            background: var(--brass);
            border-color: var(--brass);
            color: var(--ink);
            font-weight: 600;
        }

        .btn-brass:hover { background: var(--brass-soft); color: var(--ink); }

        .table thead th {
            font-size: .72rem;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: var(--text-muted);
            border-bottom-width: 1px;
        }

        footer.sticky-footer {
            flex-shrink: 0;
            background: transparent;
            color: var(--text-muted);
            font-size: .85rem;
        }

        body.sidebar-toggled #accordionSidebar { width: var(--sidebar-w-collapsed); }
        body.sidebar-toggled #accordionSidebar .sidebar-brand-text,
        body.sidebar-toggled #accordionSidebar .nav-link span { display: none; }
        body.sidebar-toggled #accordionSidebar .nav-link { justify-content: center; }
        body.sidebar-toggled #content-wrapper {
            margin-left: var(--sidebar-w-collapsed);
            width: calc(100% - var(--sidebar-w-collapsed));
        }

        @media (max-width: 767.98px) {
            #accordionSidebar {
                transform: translateX(-100%);
                width: var(--sidebar-w) !important;
            }
            body.sidebar-toggled #accordionSidebar {
                transform: translateX(0);
            }
            body.sidebar-toggled #accordionSidebar .sidebar-brand-text,
            body.sidebar-toggled #accordionSidebar .nav-link span { display: inline; }
            body.sidebar-toggled #accordionSidebar .nav-link { justify-content: flex-start; }
            #content-wrapper, body.sidebar-toggled #content-wrapper {
                margin-left: 0;
                width: 100%;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            #accordionSidebar, #content-wrapper { transition: none; }
        }
    </style>
</head>
<body id="page-top">

<div id="wrapper">