<style>
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
  .modal-backdrop {
    width: 100% !important;
    height: 100% !important;
  }
  html, body {
    /* IE 10-11 didn't like using min-height */
    height: 100%;
  }
  body {
    display: flex;
    flex-direction: column;
  }
  .content {
    flex: 1 0 auto; /* Prevent Chrome, Opera, and Safari from letting these items shrink to smaller than their content's default minimum size. */
    padding: 20px;
  }
  .footer {
    flex-shrink: 0; /* Prevent Chrome, Opera, and Safari from letting these items shrink to smaller than their content's default minimum size. */
    padding: 20px;
    background:#fe5;
  }
</style>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=$_SESSION['title']?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url('adminLTE/plugins/fontawesome-free/css/all.min.css')?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?=base_url('adminLTE/plugins/ionicons/2.0.1/css/ionicons.min.css')?>">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?=base_url('adminLTE/plugins/select2/css/select2.min.css')?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url('adminLTE/dist/css/adminlte.min.css')?>">

</head>

<body class="hold-transition sidebar-mini layout-footer-fixed" style="zoom:90%">
  <!-- Site wrapper -->
  <div class="wrapper">