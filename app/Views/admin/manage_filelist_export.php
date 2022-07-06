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
                <h3 class="card-title float-right"><i>File List Export</i></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive mailbox-messages">
                  <!-- <table class="table table-hover table-striped"> -->
                  <table id="filelistexportTable" class="table table-bordered table-striped display" style="width: 100%;">
                    <thead>
                      <tr>
                        <th>Filename</th>
                        <th>Description</th>
                        <th>Publishable</th>
                        <th>Status</th>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Revision</th>
                        <th>Publishing Status</th>
                        <th>Check-out Status</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Filename</th>
                        <th>Description</th>
                        <th>Publishable</th>
                        <th>Status</th>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Revision</th>
                        <th>Publishing Status</th>
                        <th>Check-out Status</th>
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

    var table = $('#filelistexportTable').DataTable({
      'dom': '<"d-flex justify-content-between align-items-end"Blf>rt<"d-flex justify-content-between"ip><"clear">', 
      'responsive': true, 
      'autoWidth': false,
      'buttons': [
          {
              extend: 'collection',
              text: 'Export',
              buttons: [
                  'copy',
                  'excel',
                  'csv',
                  'pdf',
                  'print'
              ]
          }
      ],
      'processing': true,
      'serverSide': true,
      'pageLength': 10,
      'ajax': {
        'url': '<?=site_url('admin/loadData/filelistexport')?>',
        'type': 'POST',
      },
      'columns': [
        { data: 'realname'},
        { data: 'description'},
        { data: 'publishable'},
        { data: 'status'},
        { data: 'id'},
        { data: 'username'},
        { data: 'revision'},
        { data: 'publishing_status'},
        { data: 'checkout_status'},
      ]
    });
  });
</script>