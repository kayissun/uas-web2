<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Dashboard' ?></title>

    <link href="<?= base_url('assets/sbadmin/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/sbadmin/css/sb-admin-2.min.css') ?>" rel="stylesheet">

    <style>
        #wrapper {
            min-height: 100vh;
        }

        #accordionSidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 1040;
        }

        #content-wrapper {
            margin-left: 14rem;
            width: calc(100% - 14rem);
            min-height: 100vh;
        }

        #content .topbar {
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        #content > .container-fluid {
            padding-bottom: 1.5rem;
        }

        footer.sticky-footer {
            flex-shrink: 0;
        }

        body.sidebar-toggled #content-wrapper {
            margin-left: 6.5rem;
            width: calc(100% - 6.5rem);
        }

        body.sidebar-toggled #accordionSidebar {
            width: 6.5rem !important;
        }

        @media (max-width: 767.98px) {
            #accordionSidebar {
                position: fixed;
                transform: translateX(-100%);
                transition: transform .2s ease-in-out;
            }

            body.sidebar-toggled #accordionSidebar {
                transform: translateX(0);
                width: 14rem !important;
            }

            #content-wrapper,
            body.sidebar-toggled #content-wrapper {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body id="page-top">

<div id="wrapper">
