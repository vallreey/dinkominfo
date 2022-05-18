<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('adminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')?>">
<link rel="stylesheet" href="<?=base_url('adminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')?>">
<link rel="stylesheet" href="<?=base_url('adminLTE/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')?>">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="<?=base_url('adminLTE/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')?>">
<!-- Toastr -->
<link rel="stylesheet" href="<?=base_url('adminLTE/plugins/toastr/toastr.min.css')?>">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><?=$title?></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?=site_url('dashboard/index')?>">Home</a></li>
            <li class="breadcrumb-item active">Update File</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- jquery validation -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">File:  <small><i>FORM_A02_FORMAT_PROPOSAL.doc</i></small></h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="form-horizontal">
                <div class="card-body">
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Tetapkan ke Pemilik</label>
                    <div class="col-sm-10">
                    <select class="form-control select2" style="width: 100%;">
                      <?php foreach ($listPemilik as $key => $val) { 
                        $selected = $val->id == $fileExist[0]->owner ? "selected" : "";
                      ?>
                      <option value="<?=$val->id?>" <?=$selected?>><?=$val->last_name.', '.$val->first_name?></option>
                      <?php } ?>
                    </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Tetapkan ke Bidang</label>
                    <div class="col-sm-10">
                    <select class="form-control select2" style="width: 100%;">
                      <?php foreach ($listBidang as $key => $val) { 
                        $selected = $val->id == $fileExist[0]->department ? "selected" : "";  
                      ?>
                      <option value="<?=$val->id?>" <?=$selected?>><?=$val->name?></option>
                      <?php } ?>
                    </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Kategori</label>
                    <div class="col-sm-10">
                    <select class="form-control select2" style="width: 100%;">
                      <?php foreach ($listKategori as $key => $val) { 
                        $selected = $val->id == $fileExist[0]->category ? "selected" : ""; 
                      ?>
                      <option value="<?=$val->id?>" <?=$selected?>><?=$val->name?></option>
                      <?php } ?>
                    </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Izin</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Enter ...">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Deskripsi</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Ketikkan Deskripsi" value="<?=$fileExist[0]->description?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Comment</label>
                    <div class="col-sm-10">
                    <textarea class="form-control" rows="3" placeholder="Ketikkan Komentar"><?=htmlspecialchars($fileExist[0]->comment)?></textarea>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-info">Save</button>
                  <button type="reset" class="btn btn-warning">Reset</button>
                  <a href="<?=site_url('dashboard/search')?>" class="btn btn-default float-right">Cancel</a>
                </div>
                <!-- /.card-footer -->
              </form>
          </div>
          <!-- /.card -->
          </div>
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-6">

        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  
</div>

<!-- jQuery -->
<script src="<?=base_url('adminLTE/plugins/jquery/jquery.min.js')?>"></script>
<!-- Select2 -->
<script src="<?=base_url('adminLTE/plugins/select2/js/select2.full.min.js')?>"></script>
<!-- SweetAlert2 -->
<script src="<?=base_url('adminLTE/plugins/sweetalert2/sweetalert2.min.js')?>"></script>
<!-- Toastr -->
<script src="<?=base_url('adminLTE/plugins/toastr/toastr.min.js')?>"></script>

<script>
  $(function () {
  });
</script>