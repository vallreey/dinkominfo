<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper with-background">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <!-- <h1><?=$title?></h1> -->
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active"><?=$title?></li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row justify-content-md-center">
        <div class="col-6">
          <div class="card-body text-center">
            <img src="<?=base_url('asset/logo-primbon-resize.png')?>"><br><br>
            <p class="h4">PRIMBON DINKOMINFO</p>
            <p class="h3"><b>KABUPATEN BANJARNEGARA</b></p>
            <p class="h5" style="border-radius: 20px 20px 20px 20px; background-color:#b2bec3; padding: 2px">primbon.dinkominfo.banjarnegarakab.go.id</p>
          </div>
          <div class="card-footer bg-transparent"></div>
        </div>
      </div>
      <div class="row justify-content-md-center">
        <div class="col-lg-2" style="margin-right:1em; margin-left:1em">
          <!-- small box -->
          <div class="small-box bg-light border" style="border-radius: 50px 50px 0px 0px; border-width: medium">
            <div class="inner text-center" style="padding: 2em 0 2em 0">
              <img src="<?=base_url('asset/search.png')?>">
            </div>
            <a href="<?=site_url('dashboard/search')?>" class="small-box-footer">Cek Data <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2" style="margin-right:1em; margin-left:1em">
          <!-- small box -->
          <div class="small-box bg-light border" style="border-radius: 50px 50px 0px 0px; border-width: medium">
            <div class="inner text-center" style="padding: 2em 0 2em 0">
              <img src="<?=base_url('asset/approved.png')?>">
            </div>
            <a href="<?=site_url('dashboard/approval/onreview')?>" class="small-box-footer">Approval Dokumen <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2" style="margin-right:1em; margin-left:1em">
          <!-- small box -->
          <div class="small-box bg-light border" style="border-radius: 50px 50px 0px 0px; border-width: medium">
            <div class="inner text-center" style="padding: 2em 0 2em 0">
              <img src="<?=base_url('asset/add-file.png')?>">
            </div>
            <a href="<?=site_url('dashboard/update')?>" class="small-box-footer">Tambah Dokumen <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2" style="margin-right:1em; margin-left:1em">
          <!-- small box -->
          <div class="small-box bg-light border" style="border-radius: 50px 50px 0px 0px; border-width: medium">
            <div class="inner text-center" style="padding: 2em 0 2em 0">
              <img src="<?=base_url('asset/admin.png')?>">
            </div>
            <a href="#" class="small-box-footer">Administrasi <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->