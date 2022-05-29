<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('adminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')?>">
<link rel="stylesheet" href="<?=base_url('adminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')?>">
<link rel="stylesheet" href="<?=base_url('adminLTE/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')?>">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="<?=base_url('adminLTE/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')?>">
<!-- Toastr -->
<link rel="stylesheet" href="<?=base_url('adminLTE/plugins/toastr/toastr.min.css')?>">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <!-- <h1><?=$title?></h1> -->
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?=site_url('dashboard/index')?>">Home</a></li>
            <li class="breadcrumb-item active">Approval Dokumen</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- <form id="form-search"> -->
      <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Monthly Recap Report</h5>

                
              </div>
              <!-- /.card-header -->
              <!-- ./card-body -->
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-6 col-12">
                    <div class="description-block border-right">
                      <span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
                      <h5 class="description-header">$35,210.43</h5>
                      <span class="description-text">TOTAL REVENUE</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-6 col-12">
                    <div class="description-block">
                      <span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
                      <h5 class="description-header">$10,390.90</h5>
                      <span class="description-text">TOTAL COST</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
              
                </div>
                <!-- /.row -->
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
      <!-- </form> -->
      <div class="row" style="padding-top:30px">
        <div class="col-12">
    
          <div class="card">
            <div class="card-body">
              <!-- <div id="button_pdf" style="float:right;"></div> -->
              <table id="example1" class="table table-bordered table-striped display" style="width: 100%;">
                <thead>
                  <tr>
                    <th>ID</th>
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
  </section>
</div>

<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
          </div>
          <div class="modal-body">
              <p>You are about to delete <b><i class="title"></i></b> record, this procedure is irreversible.</p>
              <p>Do you want to proceed?</p>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-danger btn-ok">Delete</button>
          </div>
      </div>
  </div>
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
              <!-- timeline time label -->
              <div class="time-label">
                <span class="bg-danger">
                  10 Feb. 2014
                </span>
              </div>
              <!-- /.timeline-label -->
              <!-- timeline item -->
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
              <!-- END timeline item -->
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
<!-- Select2 -->
<script src="<?=base_url('adminLTE/plugins/select2/js/select2.full.min.js')?>"></script>
<!-- SweetAlert2 -->
<script src="<?=base_url('adminLTE/plugins/sweetalert2/sweetalert2.min.js')?>"></script>
<!-- Toastr -->
<script src="<?=base_url('adminLTE/plugins/toastr/toastr.min.js')?>"></script>

<script>
  $(function () {
    $('.select2').select2();
    
    $('#option_search').on("select2:select", function(e) { 
      var data = e.params.data;
      var idSelected = data.id;
      $.ajax({
        url: "<?=site_url('dashboard/searchField/')?>",
        type: "POST",
        data: "id="+idSelected,
        success: function(html){
          $("#search-field").empty().append(html);
          $('.select2').select2();
        }
      });
    });

    fill_datatable();

    function fill_datatable(filterId = '', filterVal = '') {
      var publishable = 1;
      var listDataTable = $('#example1').DataTable({
        'dom': 'Blfrtip',
        'responsive': true, 
        'autoWidth': false,
        'buttons': ["copy", "csv", "excel", "pdf", "print", "colvis"],
        'processing': true,
        'serverSide': true,
        'searching': false, // Remove default Search Control
        'ajax': {
          'url': '<?=site_url('dashboard/loadAjaxTables/review')?>',
          'type': 'POST',
          'data': {filterParam: [
            {
              [filterId]:filterVal,
            }
          ], publishable: publishable}
        },
        'columns': [
          { data: 'id' },
          { data: 'detail', orderable: false},
          { data: 'nama_file' },
          { data: 'deskripsi' },
          { data: 'hak_akses', orderable: false },
          { data: 'created' },
          { data: 'changed' },
          { data: 'pemilik' },
          { data: 'bidang' },
          { data: 'ukuran' },
          { data: 'status' },
        ]
      });

      // listDataTable.buttons().container().prependTo('#button_pdf');
    }

    $('#btn_search').click(function(){
      var filterId  = $('.filter').attr('id');
      var filterVal = $('#'+filterId).val();
      // console.log(filterId, filterVal);return false;
      $('#example1').DataTable().destroy();
      fill_datatable(filterId, filterVal);
      // listDataTable.draw();
    });

    $('#example1').on('click', '.btn-delete', function(){
      var confirmation = confirm("Anda yakin menghapus dokumen ini?");

      if (confirmation) {
        toastr.error('Sukses! Dokumen berhasil terhapus.')
      }
    });

    $('#example1').on('click', '.btn-detail', function(){
      const id = $(this).attr('id');
      $.ajax({
        url: "<?=site_url('dashboard/getDataById')?>",
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