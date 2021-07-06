
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Aplikasi POS</title>

    <!-- Bootstrap -->
    <link href="<?= base_url() ?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?= base_url() ?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?= base_url() ?>assets/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?= base_url() ?>assets/vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?= base_url() ?>assets/build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form action="<?=site_url('auth/process')?>" method="post">
                <!-- <img style="width: 90%;height: auto;margin-top: 20px;" src="<?php echo base_url(); ?>assets/img/logo.png"> -->
                <h1>Login Form</h1>
              <div>
                <input type="text" class="form-control" placeholder="Username" name="username" required="" autocomplete="off" />
              </div>
              <div>
                <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password" required="" />
              </div>
              <div style="float: left;">
                <?=$image;?>
              </div>
              <div  style="float: right;">
                <input type="text" name="captcha_code" class="form-control" id="captcha_code" placeholder="Kode Captcha" required="" />
              </div>
              <div class="clearfix"></div>
              <div style="float: left;">
                <input type="checkbox" onclick="myFunction()"> Show Password
              </div>
              <div  style="float: right;">
                <button type="submit" class="btn btn-success" name="login"><i class="fa fa-unlock" aria-hidden="true"></i> Login</button>
              </div>
              <div class="clearfix"></div>

              <div class="separator">

                <div>
                  <h1><i class="fa fa-desktop"></i> Aplikasi POS</h1>
                  <p>©2021 - Aplikasi POS || Msramdan</p>
                </div>
              </div>
            </form>
          </section>
        </div>

      </div>
    </div>
  </body>
</html>


<script>
        function myFunction() {
            var x = document.getElementById("inputPassword");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>