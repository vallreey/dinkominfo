<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('adminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')?>">
<link rel="stylesheet" href="<?=base_url('adminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')?>">
<link rel="stylesheet" href="<?=base_url('adminLTE/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')?>">

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
            <button type="button" class="btn btn-primary btn-block mb-3" data-toggle="modal" data-target="#add-bidang-modal">Add Bidang</button>

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
                  <li class="nav-item active">
                    <a href="<?=site_url('admin/user')?>" class="nav-link">
                      <i class="fas fa-inbox"></i> User
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?=site_url('admin/bidang')?>" class="nav-link" style="color:#007bff">
                      <i class="fas fa-inbox"></i> Bidang <span class="badge bg-primary float-right">&#10003;	</span>
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
            <?php if (isset($_SESSION['info_success'])) { ?>
              <div class="alert alert-info" role="alert"><?=$_SESSION['info_success']?></div><?php unset($_SESSION['info_success']); }
            elseif(isset($_SESSION['info_error'])) { ?>
              <div class="alert alert-warning" role="alert"><?=$_SESSION['info_error']?></div><?php unset($_SESSION['info_error']); }
            ?>
            <div class="card card-primary card-outline">
              <div class="card-footer">
                <h3 class="card-title float-right"><i>Bidang</i></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive mailbox-messages">
                  <!-- <table class="table table-hover table-striped"> -->
                  <table id="bidangTable" class="table table-bordered table-striped display" style="width: 100%;">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th></th>
                        <th>Bidang</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>ID</th>
                        <th></th>
                        <th>Bidang</th>
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

<div class="modal fade" id="add-bidang-modal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i><span id="title-modal">Add Bidang</span></i></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form-bidang" action="<?=site_url('admin/updateBidang')?>" method="POST">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Department</label>
                <input type="text" class="form-control" id="inputNamaBidang" name="dept_name" placeholder="Bidang ....">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <input type="hidden" id="inputBidangId" name="id">
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
          <form id="form-delete" action="#" method="POST">
            <div class="modal-body">
                <p>Do you really want to delete these records? This process cannot be undone.</p>
                <hr>
                <div class="form-group">
                  <label>Re-assign to other department</label>
                  <select class="form-control select2" name="new_dept" style="width: 100%;" data-placeholder="Select a department">
                    <option value=""></option>
                    <?php
                      foreach ($listBidang as $key => $val) {
                    ?>
                    <option value="<?=$val->id?>"><?=$val->name?></option>
                    <?php } ?>
                  </select>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
          </form>
      </div>
  </div>
</div>

<style>
  .modal-confirm {
      color: #636363;
      width: 400px;
  }
  .modal-confirm .modal-content {
      padding: 20px;
      border-radius: 5px;
      border: none;
      text-align: center;
      font-size: 14px;
  }
  .modal-confirm .modal-header {
      border-bottom: none;
      position: relative;
  }
  .modal-confirm h4 {
      text-align: center;
      font-size: 26px;
      margin: 30px 0 -10px;
  }
  .modal-confirm .close {
      position: absolute;
      top: -5px;
      right: -2px;
  }
  .modal-confirm .modal-body {
      color: #999;
  }
  .modal-confirm .modal-footer {
      border: none;
      text-align: center;
      border-radius: 5px;
      font-size: 13px;
      padding: 10px 15px 25px;
      color: #999;
  }
  .modal-confirm .icon-box {
      width: 80px;
      height: 80px;
      margin: 0 auto;
      border-radius: 50%;
      z-index: 9;
      text-align: center;
      border: 3px solid #f15e5e;
  }
  .modal-confirm .icon-box i {
      color: #f15e5e;
      font-size: 46px;
      display: inline-block;
      margin-top: 13px;
  }
  .modal-confirm .btn,
  .modal-confirm .btn:active {
      color: #fff;
      border-radius: 4px;
      background: #60c7c1;
      text-decoration: none;
      transition: all 0.4s;
      line-height: normal;
      min-width: 120px;
      border: none;
      min-height: 34px;
      border-radius: 3px;
      margin: 0 5px;
  }
  .modal-confirm .btn-secondary {
      background: #c1c1c1;
  }
  .modal-confirm .btn-secondary:hover,
  .modal-confirm .btn-secondary:focus {
      background: #a8a8a8;
  }
  .modal-confirm .btn-danger {
      background: #f15e5e;
  }
  .modal-confirm .btn-danger:hover,
  .modal-confirm .btn-danger:focus {
      background: #ee3535;
  }
</style>

<!-- jQuery -->
<script src="<?=base_url('adminLTE/plugins/jquery/jquery.min.js')?>"></script>

<script>
  function format(d) {
    var div = $('<div/>')
        .addClass( 'loading' )
        .text( 'Loading...' );

    $.ajax({
      url: "<?=site_url('admin/getUserInDept/')?>" + d.id,
      type: "POST",
      success: function(response){
        var arr = JSON.parse(response);

        if (arr === '') {
          div.html('<span style="color:red"><i>Tidak ada user terdaftar.</i></span>').removeClass('loading');
        } else {
          var string_tbl = '<table class="table table-sm table-bordered table-striped" style="width:50%"><thead class="bg-primary"><tr><th>UID</th><th>Users in : <i>' + d.bidang + '</i></th></tr></thead>';

          arr.forEach(function(profile, index, myArray) {
            string_tbl += '<tr><td>' + profile.id + '</td><td>' + profile.first_name + ' ' + profile.last_name + '</td></tr>';
          });

          string_tbl += '</table>';
          div.html(string_tbl).removeClass('loading');
          // element(string_tbl);
        }
      },
      error: function(xhr, status, error){
         var errorMessage = xhr.status + ': ' + xhr.statusText
         alert('Error - ' + errorMessage);
      }
    });

    return div;
  }
  
  $(function () {
    var table = $('#bidangTable').DataTable({
      'processing': true,
      'serverSide': true,
      'pageLength': 10,
      'ajax': {
        'url': '<?=site_url('admin/loadData/department')?>',
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
        { data: 'bidang'},
        { data: 'action', orderable: false},
      ]
    });

    $('#bidangTable tbody').on('click', 'td.dt-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
 
        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            // format(row.child, row.data());
            // row.child.show();
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });

    $('#bidangTable tbody').on('click', '.btn-edit', function () {
        $('#title-modal').html('Update Bidang');
        
        const id = $(this).attr('id');
        $.ajax({
          url: "<?=site_url('admin/getBidangById/')?>" + id,
          type: "POST",
          success: function(response){
            var arr = JSON.parse(response);
            $('#inputBidangId').val(id);
            $('#inputNamaBidang').val(arr.name);
            $('#add-bidang-modal').modal('show');
          }
        });
    });

    $('#add-bidang-modal').on('hidden.bs.modal', function () {
        $('#title-modal').html('Add Bidang');
        var fbidang = $('#form-bidang');
        fbidang.validate().resetForm();
        fbidang.find('.error').removeClass('error');
        fbidang.find('.is-invalid').removeClass('is-invalid');
        fbidang.trigger('reset');
    });

    $('#form-bidang').validate({
      rules: {
        dept_name: "required"
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
        $(this).find('#form-delete').attr('action', $(e.relatedTarget).data('href'));
    });

    $('#form-delete').validate({
      rules: {
        new_dept: "required"
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