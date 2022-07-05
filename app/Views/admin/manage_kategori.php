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
      <form id="form-kategori" action="<?=site_url('admin/updateKategori')?>" method="POST">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Kategori</label>
                <input type="text" class="form-control" id="inputNamaKategori" name="cat_name" placeholder="Nama Kategori">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <input type="hidden" id="inputKategoriId" name="id">
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
                  <label>Re-assign to other category</label>
                  <select class="form-control select2" name="new_cat" style="width: 100%;" data-placeholder="Select a category">
                    <option value=""></option>
                    <?php
                      foreach ($listKategori as $key => $val) {
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
            $('#inputKategoriId').val(id);
            $('#inputNamaKategori').val(arr.name);
            $('#add-kategori-modal').modal('show');
          }
        });
    });

    $('#add-kategori-modal').on('hidden.bs.modal', function () {
        $('#title-modal').html('Add Kategori');
        var fbidang = $('#form-kategori');
        fbidang.validate().resetForm();
        fbidang.find('.error').removeClass('error');
        fbidang.find('.is-invalid').removeClass('is-invalid');
        fbidang.trigger('reset');
    });

    $('#form-kategori').validate({
      rules: {
        cat_name: "required"
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
        new_cat: "required"
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