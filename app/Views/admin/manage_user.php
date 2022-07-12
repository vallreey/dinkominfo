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

            <?=view('admin/submenu_admin', $submenu)?>
          </div>
          <div class="col-md-9">
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

    <div class="modal fade" id="add-user-modal">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><i><span id="title-modal">Add User</span></i></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="form-user" action="<?=site_url('admin/updateUser')?>" method="POST">
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
                    <select class="form-control select2" name="department" id="inputDepartment" style="width: 100%;" data-placeholder="Select a department">
                      <option value=""></option>
                      <?php
                        foreach ($listBidang as $key => $val) {
                      ?>
                      <option value="<?=$val->id?>"><?=$val->name?></option>
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
                    <select class="form-control select2" name="deptreviewer[]" id="inputDeptReviewer" multiple="multiple" data-placeholder="Select one or more department" style="width: 100%;">
                      <?php
                        foreach ($listBidang as $key => $val) { 
                      ?>
                      <option value="<?=$val->id?>"><?=$val->name?></option>
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
                          <input class="form-check-input" id="inputIsAdmin" name="is_admin" value="1" type="checkbox" checked>
                        </div>
                      </div>
                      <div class="col-md-4 text-center">
                      <div class="form-group">
                          <label>Can<br>"Tambah Dokumen"?</label><br>
                          <input class="form-check-input" id="inputCanAdd" name="can_add" value="1" type="checkbox" checked>
                        </div>
                      </div>
                      <div class="col-md-4 text-center">
                        <div class="form-group">
                          <label>Can<br>"Cek Data"?</label><br>
                          <input class="form-check-input" id="inputCanCheckIn" name="can_checkin" value="1" type="checkbox" checked>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <input type="hidden" id="inputUserId" name="id">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-info">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div id="confirmDelete" class="modal fade">
      <div class="modal-dialog modal-confirm">
          <div class="modal-content">
              <div class="modal-header flex-column">
                  <div class="icon-box">
                      <i class="fa fa-times"></i>
                  </div>
                  <h4 class="modal-title w-100">Are you sure?</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <div class="modal-body">
                  <p>Do you really want to delete these records? This process cannot be undone.</p>
              </div>
              <div class="modal-footer justify-content-center">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <a href="#" class="btn btn-danger btn-delete" role="button">Delete</a>
              </div>
          </div>
      </div>
    </div>
  </section>
</div>

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
            // console.log(arr);return false;
            $('#inputUserId').val(id);
            $('#inputNamaDepan').val(arr.first_name);
            $('#inputNamaBelakang').val(arr.last_name);
            $('#inputUsername').val(arr.username);
            $('#inputPassword').val('').attr('placeholder', 'Leave empty if unchanged');
            $('#inputPhoneNumber').val(arr.phone);
            $('#inputEmail').val(arr.Email);
            $('#inputDepartment').val(arr.department).trigger('change');
            $('#inputDeptReviewer').val(arr.dept_rev).trigger('change');
            if (arr.can_add == 1) $('#inputCanAdd').prop('checked', true);
            else $('#inputCanAdd').prop('checked', false);
            if (arr.can_checkin == 1) $('#inputCanCheckIn').prop('checked', true);
            else $('#inputCanCheckIn').prop('checked', false);
            if (arr.is_admin == 1) $('#inputIsAdmin').prop('checked', true);
            else $('#inputIsAdmin').prop('checked', false);

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
        $('.select2').val([]).trigger('change');

        return false;
    });

    $('#form-user').validate({
      rules: {
        first_name: {
          required: true,
          minlength: 2,
          maxlength: 255
        },
        last_name: {
          required: true,
          minlength: 2,
          maxlength: 255
        },
        username: {
          required: true,
          minlength: 2,
          maxlength: 25
        },
        password: {
          minlength: 5,
          maxlength: 32
        },
        phone: {
          digits: true,
          maxlength: 20
        },
        email: {
          required: true,
          email: true,
          maxlength: 50
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

    $('#confirmDelete').on('show.bs.modal', function(e) {
        $(this).find('.btn-delete').attr('href', $(e.relatedTarget).data('href'));
    });
  });
</script>