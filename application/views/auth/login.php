<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Hotel Reservasi</title>

    <link href="<?= base_url('assets/sbadmin/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/sbadmin/css/sb-admin-2.min.css') ?>" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-xl-4 col-lg-5 col-md-6">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">

                        <div class="p-5">

                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Login Admin</h1>
                            </div>

                            <?php if($this->session->flashdata('error')): ?>
                                <div class="alert alert-danger">
                                    <?= $this->session->flashdata('error') ?>
                                </div>
                            <?php endif; ?>

                            <form method="post" action="<?= base_url('auth/login') ?>">

                                <div class="form-group">
                                    <input type="text" name="username" class="form-control" placeholder="Username">
                                </div>

                                <div class="form-group">
                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                </div>

                                <input type="hidden" 
                                name="<?= $this->security->get_csrf_token_name(); ?>" 
                                value="<?= $this->security->get_csrf_hash(); ?>" />

                                <button class="btn btn-primary btn-block">Login</button>

                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>