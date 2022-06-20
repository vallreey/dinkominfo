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
            <button type="button" class="btn btn-primary btn-block mb-3" data-toggle="modal" data-target="#add-kategori-modal">Add Kategori</button>

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
                    <a href="<?=site_url('admin/bidang')?>" class="nav-link">
                      <i class="far fa-envelope"></i> Bidang
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?=site_url('admin/kategori')?>" class="nav-link" style="color:#007bff">
                      <i class="fas fa-inbox"></i> Kategori <span class="badge bg-primary float-right">&#10003;	</span>
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
            </div>
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
            </div>
          </div>
          <div class="col-md-9">
            <div class="card card-primary card-outline">
              <div class="card-footer">
                <h3 class="card-title float-right"><i>Kategori</i></h3>
              </div>
              <div class="card-body">
                <div class="table-responsive mailbox-messages">
                  <table id="kategoriTable" class="table table-bordered table-striped display" style="width: 100%;">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th></th>
                        <th>Kategori</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>ID</th>
                        <th></th>
                        <th>Kategori</th>
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

<div class="modal fade" id="add-kategori-modal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i><span id="title-modal">Add Kategori</span></i></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="userForm" name="user">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Kategori</label>
                <input type="text" class="form-control" id="inputNamaKategori" placeholder="Nama Kategori">
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
<!-- SweetAlert2 -->
<script src="<?=base_url('adminLTE/plugins/sweetalert2/sweetalert2.min.js')?>"></script>
<!-- Toastr -->
<script src="<?=base_url('adminLTE/plugins/toastr/toastr.min.js')?>"></script>

<script>
  function format(d) {
    var div = $('<div/>')
        .addClass( 'loading' )
        .text( 'Loading...' );

    $.ajax({
      url: "<?=site_url('admin/getDataByKategoriId/')?>" + d.id,
      type: "POST",
      success: function(response){
        var arr = JSON.parse(response);

        if (arr === '') {
          div.html('<span style="color:red"><i>Tidak ada file terdaftar.</i></span>').removeClass('loading');
        } else {
          var string_tbl = '<table class="table table-sm table-bordered table-striped"><thead class="bg-primary"><tr><th>ID</th><th>Filename in : <i>' + d.kategori + '</i></th></tr></thead>';

          arr.forEach(function(profile, index, myArray) {
            string_tbl += '<tr><td>' + profile.id + '</td><td>' + profile.realname + '</td></tr>';
          });

          string_tbl += '</table>';
          div.html(string_tbl).removeClass('loading');
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
    var table = $('#kategoriTable').DataTable({
      'processing': true,
      'serverSide': true,
      'pageLength': 10,
      'ajax': {
        'url': '<?=site_url('admin/loadData/category')?>',
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
        { data: 'kategori'},
        { data: 'action', orderable: false},
      ]
    });

    $('#kategoriTable tbody').on('click', 'td.dt-control', function () {
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

    $('#kategoriTable tbody').on('click', '.btn-edit', function () {
        $('#title-modal').html('Update Kategori');
        
        const id = $(this).attr('id');
        $.ajax({
          url: "<?=site_url('admin/getKategoriById/')?>" + id,
          type: "POST",
          success: function(response){
            var arr = JSON.parse(response);
            $('#inputNamaKategori').val(arr.name);
            $('#add-kategori-modal').modal('show');
          }
        });
    });

    $('#add-kategori-modal').on('hidden.bs.modal', function () {
        $('#title-modal').html('Add Kategori');
        $(this).find('form').trigger('reset');
        return false;
    })

  });
</script>