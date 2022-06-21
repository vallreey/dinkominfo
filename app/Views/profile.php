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
      <form id="form-profile">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Nama Depan</label>
                <input type="text" class="form-control" id="inputNamaDepan" name="first_name" value="<?=$first_name?>">
              </div>
              <div class="form-group">
                <label>Username</label>
                <input type="text" class="form-control" id="inputUsername" name="username" value="<?=$username?>">
              </div>
              <div class="form-group">
                <label>Phone Number</label>
                <input type="text" class="form-control" id="inputPhoneNumber" name="phone" value="<?=$phone?>">
              </div>
              <div class="form-group">
                <label>Bidang</label>
                <select class="form-control select2" name="department" style="width: 100%;">
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
                <input type="password" class="form-control" id="inputPassword" name="password" value="<?=$password?>">
              </div>
              <div class="form-group">
                <label>Email Address</label>
                <input type="email" class="form-control" id="inputEmail" name="email" value="<?=$Email?>">
              </div>
              <div class="form-group">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" <?=isAdmin($id) ? 'checked' : ''?>>
                  <label class="form-check-label">Admin</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="can_add" <?=$can_add == 1 ? 'checked' : ''?>>
                  <label class="form-check-label">Can Add Documents</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="can_checkin" <?=$can_checkin == 1 ? 'checked' : ''?>>
                  <label class="form-check-label">Can Check-In Documents</label>
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
          minlength: 5,
        },
        password: {
          required: true,
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