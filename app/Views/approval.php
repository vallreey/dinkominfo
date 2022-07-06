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
            <?php if ($admin_mode) { ?>
            <li class="breadcrumb-item"><a href="<?=site_url('admin/user')?>">Administrasi</a></li>
            <?php } ?>
            <li class="breadcrumb-item active">Dokumen</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="col-md-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title"><?=$title?></h3>
            <input id="hidStatus" type="hidden" value="<?=$status?>"/>
          </div>
          <div class="card-footer">
            <div class="row">
              <?php if ($admin_mode) { ?>
              <div class="col-sm-4 col-12">
                <div class="description-block border-right">
                  <h2><span class="description-percentage text-warning"><i class="fas fa-caret-down">&nbsp;<span id="totDeleted"></span></i></span></h2>
                  <span class="description-text"><a href="<?=site_url('admin/documents/deleted')?>">DOCUMENTS DELETED/UNDELETED</a></span>
                </div>
              </div>
              <?php } ?>
              <div class="<?=$admin_mode ? 'col-sm-4 col-12' : 'col-sm-6 col-12'?>">
                <div class="description-block border-right">
                  <h2><span class="description-percentage text-success"><i class="fas fa-caret-up">&nbsp;<span id="totReviewed"></span></i></span></h2>
                  <span class="description-text"><a href="<?=$admin_mode ? site_url('admin/documents/onreview') : site_url('dashboard/approval/onreview')?>">DOCUMENTS WAITING TO BE REVIEWED</a></span>
                </div>
              </div>
              <div class="<?=$admin_mode ? 'col-sm-4 col-12' : 'col-sm-6 col-12'?>">
                <div class="description-block">
                  <h2><span class="description-percentage text-danger"><i class="fas fa-caret-down">&nbsp;<span id="totRejected"></span></i></span></h2>
                  <span class="description-text"><a href="<?=$admin_mode ? site_url('admin/documents/rejected') : site_url('dashboard/approval/rejected')?>">DOCUMENTS REJECTED</a></span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row" style="padding-top:30px">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped display" style="width: 100%;">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th><input type="checkbox" id="checkall"></th>
                      <th>Action</th>
                      <th>Nama File</th>
                      <th>Deskripsi</th>
                      <th>Hak Akses</th>
                      <th>Tanggal Diunggah</th>
                      <th>Tanggal Ubah</th>
                      <th>Pemilik</th>
                      <th>Bidang</th>
                      <th>Ukuran</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>ID</th>
                      <th></th>
                      <th>Action</th>
                      <th>Nama File</th>
                      <th>Deskripsi</th>
                      <th>Hak Akses</th>
                      <th>Tanggal Diunggah</th>
                      <th>Tanggal Ubah</th>
                      <th>Pemilik</th>
                      <th>Bidang</th>
                      <th>Ukuran</th>
                      <th>Status</th>
                    </tr>
                  </tfoot>
                </table>
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
                      <a href="#" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i> <span id="pFileName"></span></a>
                          <span class="mailbox-attachment-size clearfix mt-1">
                            <span>1,245 KB</span>
                            <a href="#" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
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

<style>
  div.dt-buttons {
    float: right;
  }
  .card {
    margin-bottom: 0px;
  }
</style>

<!-- jQuery -->
<script src="<?=base_url('adminLTE/plugins/jquery/jquery.min.js')?>"></script>

<script>
  $(function () {
    fill_datatable();

    function fill_datatable() {
      var status = $('#hidStatus').val();
      var listDataTable = $('#example1').DataTable({
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
        'ajax': {
          'url': '<?=site_url('dashboard/loadAjaxTables/')?>' + status,
          'type': 'POST'
        },
        'columns': [
          { data: 'id' },
          { data: 'check', orderable: false},
          { data: 'detail', orderable: false},
          { data: 'nama_file' },
          { data: 'deskripsi' },
          { data: 'hak_akses', orderable: false},
          { data: 'created' },
          { data: 'changed' },
          { data: 'pemilik' },
          { data: 'bidang' },
          { data: 'ukuran' },
          { data: 'status' },
        ],
        'drawCallback': function (settings) { 
          var response = settings.json;
          $('#totDeleted').html(response.totDeleted);
          $('#totReviewed').html(response.totReviewed);
          $('#totRejected').html(response.totRejected);
        },
      });
    }

    // $('.dataTables_filter input').off().on('keyup', function() {
    //   $('#example1').DataTable().search(this.value.trim(), false, false).draw();
    // }); 

    $('#checkall').click(function () {
      $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $('#example1').on('click', '.btn-detail', function(){
      var status = $('#hidStatus').val();
      const id = $(this).attr('id');
      $.ajax({
        url: "<?=site_url('dashboard/getDataById/')?>" + status,
        type: "GET",
        data:{id: id},
        success: function(response) {
          const obj = JSON.parse(response);
          $('#pKategori').html(obj.cat_name);
          $('#pUkuran').html("-");
          $('#pCreated').html(obj.created);
          $('#pPemilik').html(obj.last_name + ', ' + obj.first_name);
          $('#pDeskripsi').html(obj.description);
          $('#pComment').html(obj.comment);
          $('#pRevision').html(obj.revision);
          $('#pFileName').html(obj.realname);
          $('#detailModal').modal('show');
        }
      });
    });
    return false;

  });
</script>