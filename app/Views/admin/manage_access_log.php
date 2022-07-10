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

<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="card card-primary card-tabs">
        <div class="card-header p-0 pt-1">
          <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="custom-tabs-one-detail-tab" data-toggle="pill" href="#custom-tabs-one-detail" role="tab" aria-controls="custom-tabs-one-detail" aria-selected="true">Detail</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="custom-tabs-one-history-tab" data-toggle="pill" href="#custom-tabs-one-history" role="tab" aria-controls="custom-tabs-one-history" aria-selected="false">History</a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content" id="custom-tabs-one-tabContent">
            <div class="tab-pane fade show active" id="custom-tabs-one-detail" role="tabpanel" aria-labelledby="custom-tabs-one-detail-tab">
              <table class="table table-bordered table-striped">
                <tr>
                  <td>Kategori</td>
                  <td><p id="pKategori"></p></td>
                </tr>
                <tr>
                  <td>Ukuran</td>
                  <td><p id="pUkuran"></p></td>
                </tr>
                <tr>
                  <td>Tanggal Dibuat</td>
                  <td><p id="pCreated"></p></td>
                </tr>
                <tr>
                  <td>Pemilik</td>
                  <td><p id="pPemilik"></p></td>
                </tr>
                <tr>
                  <td>Deskripsi</td>
                  <td><p id="pDeskripsi"></p></td>
                </tr>
                <tr>
                  <td>Comment</td>
                  <td><p id="pComment"></p></td>
                </tr>
                <tr>
                  <td>Revision</td>
                  <td><p id="pRevision"></p></td>
                </tr>
                <tr>
                  <td>File</td>
                  <td>
                    <span class="mailbox-attachment-icon"><i class="far fa-file-pdf"></i></span>
                    <div class="mailbox-attachment-info">
                      <a href="#" id="downloadFileButton" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i> <span id="pFileName"></span></a>
                          <span class="mailbox-attachment-size clearfix mt-1">
                            <span id="filepUkuran">-</span>
                            <a href="#" id="downloadFileButton" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                          </span>
                    </div>
                  </td>
                </tr>
              </table>
            </div>
            <div class="tab-pane fade" id="custom-tabs-one-history" role="tabpanel" aria-labelledby="custom-tabs-one-history-tab">
            <div class="timeline timeline-inverse">
              <div class="time-label">
                <span class="bg-danger">
                  10 Feb. 2014
                </span>
              </div>
              <div>
                <i class="fas fa-envelope bg-primary"></i>

                <div class="timeline-item">
                  <span class="time"><i class="far fa-clock"></i> 12:05</span>

                  <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                  <div class="timeline-body">
                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                    weebly ning heekya handango imeem plugg dopplr jibjab, movity
                    jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                    quora plaxo ideeli hulu weebly balihoo...
                  </div>
                </div>
              </div>
              <div>
                <i class="far fa-clock bg-gray"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
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
          $("#downloadFileButton").attr("href", "<?=site_url('dashboard/download/')?>" + id)
          $('#detailModal').modal('show');
        }
      });
    });
  });
</script>