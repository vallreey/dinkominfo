<style>
  .col-6 {
    padding: 2em 0 2em 0;
  }
  .with-background {
    background: url('asset/background-primbon.png') no-repeat center center fixed; 
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    image-rendering: auto;
    image-rendering: crisp-edges;
    image-rendering: pixelated;
  }
</style>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=$title?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url('adminLTE/plugins/fontawesome-free/css/all.min.css')?>">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?=base_url('adminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css')?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url('adminLTE/dist/css/adminlte.min.css')?>">
</head>

<body class="hold-transition login-page with-background">
  <!-- /.login-logo -->
  <div class="card card-primary shadow-lg rounded">
    <div class="container" style="max-width:800px">
      <div class="row">
        <div class="col-6">
          <div class="card-header text-center">
            <img src="<?=base_url('asset/logo-primbon.png')?>" style="max-width: 30%"><br><br>
            <a href="#" class="h4"><b>PRIMBON DINKOMINFO</b></a>
          </div>
          <div class="card-body">
            <!-- Error -->
            <?php if (isset($alertLogin)) { ?>
              <div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?= $alertLogin ?>
              </div>
            <?php } ?>
            <form id="form-login" action="<?=base_url('account/logon')?>" method="post">
              <?=csrf_field();?>
              <div>
                <div class="input-group mb-3">
                  <input type="username" name="username" class="form-control" placeholder="Username">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-user"></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3">
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-8">
                  <div class="icheck-primary">
                    <a href="forgot-password.html">Lupa Password?</a>
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" class="btn btn-primary btn-block">Masuk</button>
                </div>
                <!-- /.col -->
              </div>
            </form>
          </div>
        </div>
        <div class="col-6 rounded-right" style="background:#27156E; color:#FFFFFF;">
          <div class="card-body text-center">
            <p class="h4"><b>SELAMAT DATANG</b></p><br><br>Primbon adalah Pusat Informasi Data Dinas Komunikasi dan
            Informatika Kabupaten Banjarnegara
          </div>
        </div>
      </div>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="<?=base_url('adminLTE/plugins/jquery/jquery.min.js')?>"></script>
  <!-- jquery-validation -->
  <script src="<?=base_url('adminLTE/plugins/jquery-validation/jquery.validate.min.js')?>"></script>
  <script src="<?=base_url('adminLTE//plugins/jquery-validation/additional-methods.min.js')?>"></script>

  <script>
    $(function () {
      $('#form-login').validate({
        rules: {
          username: {
            required: true,
            minlength: 5,
          },
          password: {
            required: true,
            minlength: 5
          }
        },
        messages: {
          username: {
            required: "Please enter a valid username",
            email: "Your password must be at least 5 characters long"
          },
          password: {
            required: "Please provide a password",
            minlength: "Your password must be at least 5 characters long"
          },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.input-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
      });
    });
  </script>
</body>

</html>