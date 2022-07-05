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
            <button type="button" class="btn btn-primary btn-block mb-3" data-toggle="modal" data-target="#add-filetypes-modal">Add File Types</button>

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
                <h3 class="card-title float-right"><i>File Types</i></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive mailbox-messages">
                  <!-- <table class="table table-hover table-striped"> -->
                  <table id="filetypesTable" class="table table-bordered table-striped display" style="width: 100%;">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Active</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Active</th>
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

<div class="modal fade" id="add-filetypes-modal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i><span id="title-modal">Add File Types</span></i></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form-filetypes" action="<?=site_url('admin/addFiletype')?>" method="POST">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>File Types</label>
                <input type="text" class="form-control" id="inputNamaFileType" name="type" placeholder="ex.: application/pdf">
              </div>
              <div class="form-group">
                <label>Status</label>
                <div class="form-check">
                  <input id="inputStatus" class="form-check-input" name="active" type="checkbox" value="1" checked>
                  <label class="form-check-label">Active</label>
                </div>
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
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
          </form>
      </div>
  </div>
</div>

<script>  
  $(function () {

    var table = $('#filetypesTable').DataTable({
      'processing': true,
      'serverSide': true,
      'pageLength': 10,
      'ajax': {
        'url': '<?=site_url('admin/loadData/filetypes')?>',
        'type': 'POST',
      },
      'columns': [
        { data: 'id'},
        { data: 'type'},
        { data: 'active', orderable: false},
        { data: 'action', orderable: false},
      ]
    });

    $('#add-filetypes-modal').on('hidden.bs.modal', function () {
        $('#title-modal').html('Add File Type');
        var fbidang = $('#form-filetypes');
        fbidang.validate().resetForm();
        fbidang.find('.error').removeClass('error');
        fbidang.find('.is-invalid').removeClass('is-invalid');
        fbidang.trigger('reset');
    });

    $('#form-filetypes').validate({
      rules: {
        type: "required"
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

    $('.status-active').change(function() {
      alert(this.checked);
    });

    $('#filetypesTable tbody').on('change', '.status-active', function () {
        const id = $(this).attr('id');
        const status = this.checked ? 1 : 0;

        $.ajax({
          url: "<?=site_url('admin/updateFileType/')?>" + id + '/' + status,
          success: function(response){
            location.reload();
          }
        });
    });

  });
</script>