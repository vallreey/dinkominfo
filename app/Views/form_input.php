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
          <!-- <h1><?//=$title?></h1> -->
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?=site_url('dashboard/index')?>">Home</a></li>
            <li class="breadcrumb-item active"><?=$title?></li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <!-- <div class="row"> -->
        <!-- left column -->
        <div class="col-md-12">
          <!-- jquery validation -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title"><?=$title?></h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="form-horizontal">
              <div class="card-body">
                <div class="form-group row">
                  <label for="inputFile" class="col-sm-2 col-form-label">File</label>
                  <div class="col-sm-10">
                    <?php if (isset($fileExist)) {
                      echo '<a href="#">'.$fileExist[0]->realname.'</a>';
                    } else {
                      echo '<div class="custom-file">
                              <input type="file" class="custom-file-input" id="customFile">
                              <label class="custom-file-label" for="customFile">Pilih file</label>
                            </div>';
                    } ?>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEmail3" class="col-sm-2 col-form-label">Tetapkan ke Pemilik</label>
                  <div class="col-sm-10">
                  <select class="form-control select2" style="width: 100%;">
                    <?php 
                      $owner = isset($fileExist) ? $fileExist[0]->owner : $_SESSION['id'];
                      foreach ($listPemilik as $key => $val) { 
                        $selected = $val->id == $owner ? "selected" : "";
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
                    <?php
                      $ownerDept = isset($fileExist) ? $fileExist[0]->department : $_SESSION['department'];
                      foreach ($listBidang as $key => $val) { 
                        $selected = $val->id == $ownerDept ? "selected" : "";  
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
                      $selected = isset($fileExist) && $val->id == $fileExist[0]->category ? "selected" : ""; 
                    ?>
                    <option value="<?=$val->id?>" <?=$selected?>><?=$val->name?></option>
                    <?php } ?>
                  </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputPassword3" class="col-sm-2 col-form-label">Izin</label>
                  <div class="col-sm-10">
                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title" style="font-size: 1rem;"><a href="#" id="Bidang_hide" onclick="showHideRights(this)">Edit Izin Bidang &nbsp;<span id="iconIzinBidang"><i class="fas fa-chevron-circle-up"></i></span></a></h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body" id="cardIzinBidang" style="display: none;">
                        <table class="table table-sm table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>Bidang</th>
                              <th>Dilarang</th>
                              <th>Tidak Ada</th>
                              <th>Lihat</th>
                              <th>Baca</th>
                              <th>Tulis</th>
                              <th>Admin</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php 
                              foreach ($listBidang as $dept) { 
                                if (!is_null($file_id)) {
                                  $deptRights = getDeptRights($file_id, $dept->id);
                                  if ($deptRights == '') $deptRights = 0;
                                } else {
                                  $deptRights = $dept->id == $_SESSION['department'] ? 1 : 0;
                                }
                            ?>
                            <tr>
                              <td><?=$dept->name?></td>
                              <?php for ($i=-1; $i < 5; $i++) { 
                                $checked = $deptRights == $i ? 'checked' : '';
                                echo '<td><input type="radio" name="bidang_perms_'.$dept->id.'" value="'.$i.'" '.$checked.'></td>';
                              }?>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title" style="font-size: 1rem;"><a href="#" id="User_hide" onclick="showHideRights(this)">Edit Izin User &nbsp;<span id="iconIzinUser"><i class="fas fa-chevron-circle-up"></i></span></a></h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body" id="cardIzinUser" style="display: none">
                        <table class="table table-sm table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>User</th>
                              <th>Dilarang</th>
                              <th>Lihat</th>
                              <th>Baca</th>
                              <th>Tulis</th>
                              <th>Admin</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($allUsers as $user) {
                              if (!is_null($file_id)) {
                                $userRights = getUserRights($user->id, $file_id);
                                if ($userRights == '') $userRights = 0;
                              } else {
                                $userRights = $user->id == $_SESSION['id'] ? 4 : 0;
                              }
                            ?>
                            <tr>
                              <td><?=$user->last_name.', '.$user->first_name?></td>
                              <?php for ($i=-1; $i < 5; $i++) {
                                if ($i !== 0) {
                                  $checked = $userRights == $i ? 'checked' : '';
                                  echo '<td><input type="radio" name="user_perms_'.$user->id.'" value="'.$i.'" '.$checked.'></td>';
                                } 
                              }?>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputPassword3" class="col-sm-2 col-form-label">Deskripsi</label>
                  <div class="col-sm-10">
                  <input type="text" class="form-control" placeholder="Ketikkan Deskripsi" value="<?=isset($fileExist) ? $fileExist[0]->description : ''?>">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputPassword3" class="col-sm-2 col-form-label">Comment</label>
                  <div class="col-sm-10">
                  <textarea class="form-control" rows="3" placeholder="Ketikkan Komentar"><?=isset($fileExist) ? htmlspecialchars($fileExist[0]->comment) : ''?></textarea>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="submit" class="btn btn-info">Save</button>
                <button type="reset" class="btn btn-warning">Reset</button>
                <?php 
                  switch ($status) {
                    case 'onreview': $cancelUrl = 'dashboard/approval/onreview'; break;
                    case 'rejected': $cancelUrl = 'dashboard/approval/rejected'; break;
                    case 'approved': $cancelUrl = 'dashboard/search'; break;
                    default: $cancelUrl = 'dashboard'; break;
                  }
                ?>
                <a href="<?=site_url($cancelUrl)?>" class="btn btn-default float-right">Cancel</a>
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
<!-- bs-custom-file-input -->
<script src="<?=base_url('adminLTE/plugins/bs-custom-file-input/bs-custom-file-input.min.js')?>"></script>
<!-- Select2 -->
<script src="<?=base_url('adminLTE/plugins/select2/js/select2.full.min.js')?>"></script>
<!-- SweetAlert2 -->
<script src="<?=base_url('adminLTE/plugins/sweetalert2/sweetalert2.min.js')?>"></script>
<!-- Toastr -->
<script src="<?=base_url('adminLTE/plugins/toastr/toastr.min.js')?>"></script>

<script>
  $(function () {
    bsCustomFileInput.init();
  });

  function showHideRights(obj)
  {
    var thisId = $(obj).attr('id');
    var arrId = thisId.split('_');
    
    if (arrId[1] === 'show') {
      $(obj).attr('id', arrId[0] + '_hide');
      $('#iconIzin' + arrId[0]).html('<i class="fas fa-chevron-circle-up"></i>');
      $('#cardIzin' + arrId[0]).slideUp();
    } else {
      $(obj).attr('id', arrId[0] + '_show');
      $('#iconIzin' + arrId[0]).html('<i class="fas fa-chevron-circle-down"></i>');
      $('#cardIzin' + arrId[0]).slideDown();
    }

    return false;
  }
</script>