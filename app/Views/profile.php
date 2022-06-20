<div class="content-wrapper with-background">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <!-- <h1><?=$title?></h1> -->
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?=site_url('dashboard')?>">Home</a></li>
            <li class="breadcrumb-item active"><?=$title?></li>
          </ol>
        </div>
      </div>
    </div>
  </section>
  <section class="content">
    <div class="container-fluid">
      <div class="row justify-content-md-center">
        <div class="col-6">
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle"
                      src="<?=base_url('adminLTE/dist/img/avatar5.png')?>"
                      alt="User profile picture">
              </div>
              <h5><p class="text-muted text-center"><?=$first_name.' '.$last_name?></p></h5>
              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>Username</b> <a class="float-right"><?=$username?></a>
                </li>
                <li class="list-group-item">
                  <b>Nama Depan</b> <a class="float-right"><?=$first_name?></a>
                </li>
                <li class="list-group-item">
                  <b>Nama Belakang</b> <a class="float-right"><?=$last_name?></a>
                </li>
                <li class="list-group-item">
                  <b>Department</b> <a class="float-right"><?=$dept_name?></a>
                </li>
                <li class="list-group-item">
                  <b>Phone Number</b> <a class="float-right"><?=$phone?></a>
                </li>
                <li class="list-group-item">
                  <b>Email Address</b> <a class="float-right"><?=$Email?></a>
                </li>
                <?php 
                  $isAdmin = isAdmin($id) ? 'fa-check' : 'fa-times';
                  $canAdd  = $can_add == 1 ? 'fa-check' : 'fa-times';
                  $canCheckIn  = $can_checkin == 1 ? 'fa-check' : 'fa-times';
                ?>
                <li class="list-group-item">
                  <b>Admin</b> <a class="float-right"><i class="fa <?=$isAdmin?>" aria-hidden="true"></i></a>
                </li>
                <li class="list-group-item">
                  <b>Can Add Documents ?</b> <a class="float-right"><i class="fa <?=$canAdd?>" aria-hidden="true"></i></a>
                </li>
                <li class="list-group-item">
                  <b>Can Check-In Documents ?</b> <a class="float-right"><i class="fa <?=$canCheckIn?>" aria-hidden="true"></i></a>
                </li>
              </ul>

              <button id="btn-edit-profile" class="btn btn-primary btn-block"><b>Edit Profile</b></button>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<div class="modal fade" id="add-user-modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i><span id="title-modal">Edit Profile</span></i></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="userForm" name="user">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Nama Depan</label>
                <input type="text" class="form-control" id="inputNamaDepan" value="<?=$first_name?>">
              </div>
              <div class="form-group">
                <label>Username</label>
                <input type="text" class="form-control" id="inputUsername" placeholder="johncarter">
              </div>
              <div class="form-group">
                <label>Phone Number</label>
                <input type="text" class="form-control" id="inputPhoneNumber" placeholder="082xxxxxxxxx">
              </div>
              <div class="form-group">
                <label>Bidang</label>
                <select class="form-control select2" style="width: 100%;">
                  <?php
                    // $ownerDept = isset($fileExist) ? $fileExist[0]->department : $_SESSION['department'];
                    foreach ($listBidang as $key => $val) { 
                      $selected = '';
                      // $selected = $val->id == $ownerDept ? "selected" : "";  
                  ?>
                  <option value="<?=$val->id?>" <?=$selected?>><?=$val->name?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Nama Belakang</label>
                <input type="text" class="form-control" id="inputNamaBelakang" placeholder="Carter">
              </div>
              <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" id="inputPassword" placeholder="jjg67ee">
              </div>
              <div class="form-group">
                <label>Email Address</label>
                <input type="email" class="form-control" id="inputEmail" placeholder="john@gmail.com">
              </div>
              <div class="form-group">
                <label>Dept. Reviewer for</label>
                <select class="select2" multiple="multiple" data-placeholder="Select one or more" style="width: 100%;">
                  <?php
                    // $ownerDept = isset($fileExist) ? $fileExist[0]->department : $_SESSION['department'];
                    foreach ($listBidang as $key => $val) { 
                      $selected = '';
                      // $selected = $val->id == $ownerDept ? "selected" : "";  
                  ?>
                  <option value="<?=$val->id?>" <?=$selected?>><?=$val->name?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-12">
              <div class="card card-footer">
                <div class="row">
                  <div class="col-md-4 text-center">
                    <div class="form-group">
                      <label><br>Is Admin?</label><br>
                      <input class="form-check-input" type="checkbox" checked>
                    </div>
                  </div>
                  <div class="col-md-4 text-center">
                  <div class="form-group">
                      <label>Can<br>"Tambah Dokumen"?</label><br>
                      <input class="form-check-input" type="checkbox">
                    </div>
                  </div>
                  <div class="col-md-4 text-center">
                    <div class="form-group">
                      <label>Can<br>"Cek Data"?</label><br>
                      <input class="form-check-input" type="checkbox">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-info">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- jQuery -->
<script src="<?=base_url('adminLTE/plugins/jquery/jquery.min.js')?>"></script>

<script>
  $(function () {
    $('#btn-edit-profile').on('click', function () {
        const id = $(this).attr('id');
        $.ajax({
          url: "<?=site_url('admin/getUserById/')?>" + id,
          type: "POST",
          success: function(response){
            var arr = JSON.parse(response);
            $('#inputNamaDepan').val(arr.first_name);
            $('#inputNamaBelakang').val(arr.last_name);
            $('#inputUsername').val(arr.username);
            $('#inputPassword').val(arr.password);
            $('#inputPhone').val(arr.phone);
            $('#inputEmail').val(arr.Email);
            // $('#inputBidang').val(arr.department);
            $('#inputCanAdd').val(arr.can_add);
            $('#inputCanCheckin').val(arr.can_checkin);
            $('#add-user-modal').modal('show');
          }
        });
    });
  });
</script>