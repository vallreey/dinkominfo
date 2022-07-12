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
        <div class="col-md-6">
          <?php if (isset($_SESSION['info_success'])) { ?>
            <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Alert!</h5>
              <?=$_SESSION['info_success']?></div><?php unset($_SESSION['info_success']); } elseif(isset($_SESSION['info_error'])) { ?>
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
            <?=$_SESSION['info_error']?></div><?php unset($_SESSION['info_error']); } ?>
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle"
                      src="<?=base_url('adminLTE/dist/img/avatar5.png')?>"
                      alt="User profile picture">
              </div>
              <h3 class="profile-username text-center"><?=$first_name.' '.$last_name?></h3>
              <p class="text-muted text-center"></p>
              <br>
              <div class="row">
                <div class="col-md-6">
                  <strong><i class="fas fa-book mr-1"></i> Username</strong><p class="text-muted"><?=$username?></p><hr>
                  <strong><i class="fas fa-map-marker-alt mr-1"></i> Nama Depan</strong><p class="text-muted"><?=$first_name?></p><hr>
                  <strong><i class="fas fa-map-marker-alt mr-1"></i> Nama Belakang</strong><p class="text-muted"><?=$last_name?></p><hr>
                  <strong><i class="fas fa-file-alt mr-1"></i> Department</strong><p class="text-muted"><?=$dept_name?></p><hr>
                </div>
                <div class="col-md-6">
                  <strong><i class="fas fa-pencil-alt mr-1"></i> Phone Number</strong><p class="text-muted"><?=$phone?></p><hr>
                  <strong><i class="fas fa-map-marker-alt mr-1"></i> Email Address</strong><p class="text-muted"><?=$Email?></p><hr>
                  <strong><i class="fas fa-map-marker-alt mr-1"></i> Akses</strong>
                  <p class="text-muted">
                  <?php 
                    $isAdmin = isAdmin($id) ? 'checked' : '';
                    $canAdd  = $can_add == 1 ? 'checked' : '';
                    $canCheckIn  = $can_checkin == 1 ? 'checked' : '';
                  ?>
                  <input type="checkbox" <?=$isAdmin?> disabled> Admin <br>
                  <input type="checkbox" <?=$canAdd?> disabled> Can Add Doc <br>
                  <input type="checkbox" <?=$canCheckIn?> disabled> Can Check-In Doc <br>
                  </p>
                </div>
              </div>

              <button type="button" class="btn btn-primary btn-block mb-3" data-toggle="modal" data-target="#edit-profile-modal">Edit Profile</button>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<div class="modal fade" id="edit-profile-modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i><span id="title-modal">Edit Profile</span></i></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form-profile" action="<?=site_url('account/updateProfile')?>" method="POST">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Nama Depan</label>
                <input type="text" class="form-control" id="inputNamaDepan" name="first_name" value="<?=$first_name?>">
              </div>
              <div class="form-group">
                <label>Username</label>
                <input type="text" class="form-control" id="inputUsername" name="username" value="<?=$username?>" <?=!isAdmin($id) ? 'disabled' : ''?>>
              </div>
              <div class="form-group">
                <label>Phone Number</label>
                <input type="text" class="form-control" id="inputPhoneNumber" name="phone" value="<?=$phone?>">
              </div>
              <div class="form-group">
                <label>Bidang</label>
                <select class="form-control select2" name="department" style="width: 100%;" <?=!isAdmin($id) ? 'disabled' : ''?>>
                  <?php
                    foreach ($listBidang as $key => $val) { 
                      $selected = $val->id == $department ? "selected" : "";  
                  ?>
                  <option value="<?=$val->id?>" <?=$selected?>><?=$val->name?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Nama Belakang</label>
                <input type="text" class="form-control" id="inputNamaBelakang" name="last_name" value="<?=$last_name?>">
              </div>
              <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" id="inputPassword" name="password" value="" placeholder="Leave empty if unchanged">
              </div>
              <div class="form-group">
                <label>Email Address</label>
                <input type="email" class="form-control" id="inputEmail" name="email" value="<?=$Email?>">
              </div>
              <?php
                  $admChecked = 'checked';
                  $admDisabled = $addDisabled = $cinDisabled = '';
                  if (!isAdmin($id)) { $admChecked = ''; $admDisabled = $addDisabled = $cinDisabled = 'disabled' ; }
                  $addChecked = $can_add == 1 ? 'checked' : '';
                  $cinChecked = $can_checkin == 1 ? 'checked' : '';
                ?>
              <div class="form-group">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="is_admin" value="1" <?=$admChecked . ' ' . $admDisabled?>>
                  <label class="form-check-label">Admin</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="can_add" value="1" <?=$addChecked . ' ' . $addDisabled?>>
                  <label class="form-check-label">Can Add Documents</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="can_checkin" value="1" <?=$cinChecked . ' ' . $cinDisabled?>>
                  <label class="form-check-label">Can Check-In Documents</label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <input type="hidden" name="uid" value="<?=$id?>">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-info">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- jQuery -->
<script src="<?=base_url('adminLTE/plugins/jquery/jquery.min.js')?>"></script>
<!-- jquery-validation -->
<script src="<?=base_url('adminLTE/plugins/jquery-validation/jquery.validate.min.js')?>"></script>
<script src="<?=base_url('adminLTE//plugins/jquery-validation/additional-methods.min.js')?>"></script>

<script>
  $(function() {
    $('#form-profile').validate({
      rules: {
        first_name: "required",
        last_name: "required",
        username: {
          required: true,
          minlength: 3,
        },
        password: {
          minlength: 5
        },
        phone: {
          required: true,
          digits: true
        },
        email: {
          required: true,
          email: true
        },
        department: "required"
      },
      messages: {
        username: {
          required: "Please enter a valid username",
          email: "Your password must be at least 5 characters long"
        },
        password: {
          required: "Please enter a valid password",
          minlength: "Your password must be at least 5 characters long"
        },
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });

    $('#edit-profile-modal').on('hidden.bs.modal', function () {
      var profile = $('#form-profile');
      profile.validate().resetForm();
      profile.find('.error').removeClass('error');
      profile.find('.is-invalid').removeClass('is-invalid');
      profile.trigger('reset');
      return false;
    });
  });
</script>