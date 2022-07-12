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
            <?=view('admin/submenu_admin', $submenu)?>
          </div>
          <div class="col-md-9">
            <div class="card card-primary card-outline">
              <div class="card-footer">
                <h3 class="card-title float-right"><i>Access Log</i></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive mailbox-messages">
                  <!-- <table class="table table-hover table-striped"> -->
                  <table id="accesslogTable" class="table table-bordered table-striped display" style="width: 100%;">
                    <thead>
                      <tr>
                        <th>File ID</th>
                        <th>Nama File</th>
                        <th>Username</th>
                        <th>Action</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>File ID</th>
                        <th>Nama File</th>
                        <th>Username</th>
                        <th>Action</th>
                        <th>Date</th>
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

<script>  
  $(function () {

    var table = $('#accesslogTable').DataTable({
      'processing': true,
      'serverSide': true,
      'pageLength': 10,
      'ajax': {
        'url': '<?=site_url('admin/loadData/accesslog')?>',
        'type': 'POST',
      },
      'columns': [
        { data: 'file_id'},
        { data: 'realname'},
        { data: 'username'},
        { data: 'action'},
        { data: 'date'},
      ]
    });

    $('#accesslogTable').on('click', '.btn-detail', function(){
      var status = $('#hidStatus').val();
      const id = $(this).attr('id');
      $.ajax({
        url: "<?=site_url('dashboard/getDataById/')?>" + status,
        type: "GET",
        data:{id: id},
        success: function(response) {
          const obj = JSON.parse(response);
          $('#pKategori').html(obj.cat_name);
          $('#pUkuran').html(obj.file_size);
          $('#filepUkuran').text(obj.file_size);
          $('#pCreated').html(obj.created);
          $('#pPemilik').html(obj.last_name + ', ' + obj.first_name);
          $('#pDeskripsi').html(obj.description);
          $('#pComment').html(obj.comment);
          $('#pRevision').html(obj.revision);
          $('#pFileName').html(obj.realname);
          $("#downloadFileButton").attr("href", "<?=site_url('dashboard/file/')?>" + id)
          $('#detailModal').modal('show');
        }
      });
    });
  });
</script>