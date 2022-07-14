<style>
  .col-6 {
    padding: 2em 0 2em 0;
  }
  .with-background {
    background: url(<?=base_url('asset/background-primbon.png')?>) no-repeat center center fixed; 
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
  <title><?=$_SESSION['title']?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url('adminLTE/plugins/fontawesome-free/css/all.min.css')?>">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?=base_url('adminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css')?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url('adminLTE/dist/css/adminlte.min.css')?>">
</head>

<body class="hold-transition login-page with-background" style="zoom:90%">
  <!-- /.login-logo -->
  <div class="card card-primary shadow-lg rounded" style="background-color:rgba(0,0,0,0)">
    <div class="container" style="max-width:800px">
      <div class="row">
        <div class="col-6" style="color: #27156E;">
          <div class="card-header text-center">
            <img src="<?=base_url('asset/logo-primbon-resize.png')?>" style=""><br><br>
            <a href="#" class="h4"><b>PRIMBON DINKOMINFO</b></a>
          </div>
          <div class="card-body">
            <p style="text-align: center;">Primbon adalah Pusat Informasi Data Dinas Komunikasi dan
            Informatika Kabupaten Banjarnegara<br></p>
          </div>
          <div class="card-footer" style="border: none; background-color:rgba(0,0,0,0); text-align:center">
          <a href="https://www.instagram.com/kabupatenbanjarnegara/"><img src="<?=base_url('asset/instagram.png')?>">&nbsp;dinkominfobanjarnegara</a>
          </div>
        </div>
        <div class="col-6 rounded-right" style="background:#27156E; color:#FFFFFF;">
          <div class="card-header">
            <br><p class="h5" style="text-align: center; opacity: 0.8"><i class="fas fa-sign-in-alt"></i> Login ke akun Anda</p><br>
          </div>
          <div class="card-body">
            <!-- Error -->
            <?php if (isset($_SESSION['info_success'])) { ?>
              <div class="alert alert-info" role="alert"><?=$_SESSION['info_success']?></div><?php unset($_SESSION['info_success']); }
            elseif(isset($_SESSION['info_error'])) { ?>
              <div class="alert alert-warning" role="alert"><?=$_SESSION['info_error']?></div><?php unset($_SESSION['info_error']); }
            ?>
            <form id="form-login" action="<?=site_url('account/logon')?>" method="post">
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
    window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
      });
    }, 5000);

    $(function () {
      $('#form-login').validate({
        rules: {
          username: {
            required: true,
            minlength: 3,
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