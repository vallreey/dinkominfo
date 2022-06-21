<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('adminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')?>">
<link rel="stylesheet" href="<?=base_url('adminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')?>">
<link rel="stylesheet" href="<?=base_url('adminLTE/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')?>">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="<?=base_url('adminLTE/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')?>">
<!-- Toastr -->
<link rel="stylesheet" href="<?=base_url('adminLTE/plugins/toastr/toastr.min.css')?>">

<div class="content-wrapper">
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

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-3">
            <button type="button" class="btn btn-primary btn-block mb-3" data-toggle="modal" data-target="#add-user-modal">Add User</button>

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Administrasi</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body p-0">
                <ul class="nav nav-pills flex-column">
                  <li class="nav-item">
                    <a href="<?=site_url('admin/user')?>" class="nav-link" style="color:#007bff">
                      <i class="fas fa-inbox"></i> User <span class="badge bg-primary float-right">&#10003;	</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?=site_url('admin/bidang')?>" class="nav-link">
                      <i class="far fa-envelope"></i> Bidang
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?=site_url('admin/kategori')?>" class="nav-link">
                      <i class="far fa-file-alt"></i> Kategori
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="fas fa-filter"></i> File
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-trash-alt"></i> Report
                    </a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">About</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body p-0">
                <ul class="nav nav-pills flex-column">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      App Version: 1.4.4<br>
                      Database Version: 1.4.0
                    </a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card card-primary card-outline">
              <div class="card-footer">
                <h3 class="card-title float-right"><i>User</i></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive mailbox-messages">
                  <!-- <table class="table table-hover table-striped"> -->
                  <table id="userTable" class="table table-bordered table-striped display" style="width: 100%;">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th></th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Admin</th>
                        <th>Reviewer</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>ID</th>
                        <th></th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Admin</th>
                        <th>Reviewer</th>
                        <th>Action</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
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
        <h4 class="modal-title"><i><span id="title-modal">Add User</span></i></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form-user" name="user">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Nama Depan</label>
                <input type="text" class="form-control" id="inputNamaDepan" name="first_name" placeholder="John">
              </div>
              <div class="form-group">
                <label>Username</label>
                <input type="text" class="form-control" id="inputUsername" name="username" placeholder="johncarter">
              </div>
              <div class="form-group">
                <label>Phone Number</label>
                <input type="text" class="form-control" id="inputPhoneNumber" name="phone" placeholder="082xxxxxxxxx">
              </div>
              <div class="form-group">
                <label>Bidang</label>
                <select class="form-control select2" name="department" style="width: 100%;">
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
                <input type="text" class="form-control" id="inputNamaBelakang" name="last_name" placeholder="Carter">
              </div>
              <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" id="inputPassword" name="password" placeholder="jjg67ee">
              </div>
              <div class="form-group">
                <label>Email Address</label>
                <input type="email" class="form-control" id="inputEmail" name="email" placeholder="john@gmail.com">
              </div>
              <div class="form-group">
                <label>Dept. Reviewer for</label>
                <select class="select2" name="deptreviewer" multiple="multiple" data-placeholder="Select one or more" style="width: 100%;">
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
                      <input class="form-check-input" name="is_admin" type="checkbox" checked>
                    </div>
                  </div>
                  <div class="col-md-4 text-center">
                  <div class="form-group">
                      <label>Can<br>"Tambah Dokumen"?</label><br>
                      <input class="form-check-input" name="can_add" type="checkbox">
                    </div>
                  </div>
                  <div class="col-md-4 text-center">
                    <div class="form-group">
                      <label>Can<br>"Cek Data"?</label><br>
                      <input class="form-check-input" name="can_checkin" type="checkbox">
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
<!-- InputMask -->
<script src="<?=base_url('adminLTE/plugins/inputmask/jquery.inputmask.min.js')?>"></script>
<!-- SweetAlert2 -->
<script src="<?=base_url('adminLTE/plugins/sweetalert2/sweetalert2.min.js')?>"></script>
<!-- Toastr -->
<script src="<?=base_url('adminLTE/plugins/toastr/toastr.min.js')?>"></script>

<script>
  function format(d) {
    // `d` is the original data object for the row
    return (
        '<table class="table table-sm table-bordered">' +
        '<thead class="bg-primary">' + 
        '<tr>' + 
        '<th>Department</th>' +
        '<th>Email</th>' +
        '<th>Phone Number</th>' +
        '</tr>' + 
        '</thead>' +
        '<tr>' +
        '<td>' +
        d.dept_name +
        '</td>' +
        '<td>' +
        d.email +
        '</td>' +
        '<td>' +
        d.phone + 
        '</td>' + 
        '</tr>' +
        '</table>'
    );
  }
  
  $(function () {
    var table = $('#userTable').DataTable({
      'processing': true,
      'serverSide': true,
      'pageLength': 10,
      'ajax': {
        'url': '<?=site_url('admin/loadData/user')?>',
        'type': 'POST',
      },
      'columns': [
        { data: 'id' },
        {
            className: 'dt-control',
            orderable: false,
            data: null,
            defaultContent: '',
        },
        { data: 'nama'},
        { data: 'username'},
        { data: 'is_admin', orderable: false},
        { data: 'is_reviewer', orderable: false},
        { data: 'action', orderable: false},
      ]
    });

    $('#userTable tbody').on('click', 'td.dt-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
 
        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });

    $('.callnumb').change(function(){
      var numb  = $(this).val();
      var str_alert = '';
      if (numb.length < 8)
        str_alert += 'pengisian nomor minimal 8 digit angka ';
      if (numb.substr(0, 1) != '0' || numb.substr(0, 2) == '00' || numb.substr(0, 3) == '000') {
        if (str_alert != '')
          str_alert += 'dan format tidak sesuai';
        else
          str_alert += 'format tidak sesuai';
      }

      if (str_alert != '') {
        alert('Kesalahan: ' + str_alert);
        $(this).val('');
      }
      return false;
    });

    $('#userTable tbody').on('click', '.btn-edit', function () {
        $('#title-modal').html('Update User');
        
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

    $('#add-user-modal').on('hidden.bs.modal', function () {
        $('#title-modal').html('Add User');
        
        var fuser = $('#form-user');
        fuser.validate().resetForm();
        fuser.find('.error').removeClass('error');
        fuser.find('.is-invalid').removeClass('is-invalid');
        fuser.trigger('reset');

        return false;
    });

    $('#form-user').validate({
      rules: {
        first_name: "required",
        last_name: "required",
        username: {
          required: true,
          minlength: 3,
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

  });
</script>