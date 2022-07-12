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

        <?php if (isset($_SESSION['info_success'])) { ?>
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?=$_SESSION['info_success']?></div><?php unset($_SESSION['info_success']); } elseif(isset($_SESSION['info_error'])) { ?>
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <?=$_SESSION['info_error']?></div><?php unset($_SESSION['info_error']); } ?>
          
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
          <?php if (isset($_SESSION['info_success'])) { ?>
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Alert!</h5>
              <?=$_SESSION['info_success']?></div><?php unset($_SESSION['info_success']); } elseif(isset($_SESSION['info_error'])) { ?>
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
            <?=$_SESSION['info_error']?></div><?php unset($_SESSION['info_error']); } ?>
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
                <a class="nav-link" id="custom-tabs-two-history-tab" data-toggle="pill" href="#custom-tabs-two-history" role="tab" aria-controls="custom-tabs-two-history" aria-selected="false">History</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="custom-tabs-three-accesslog-tab" data-toggle="pill" href="#custom-tabs-three-accesslog" role="tab" aria-controls="custom-tabs-three-history" aria-selected="false">Latest Access Log</a>
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
                    <td>File</td>
                    <td>
                      <span class="mailbox-attachment-icon"><i class="far fa-file-pdf"></i></span>
                      <div class="mailbox-attachment-info">
                        <a href="#" class="mailbox-attachment-name downloadFileButton"><i class="fas fa-paperclip"></i> <span id="pFileName"></span></a>
                            <span class="mailbox-attachment-size clearfix mt-1">
                            <span id="filepUkuran">-</span>
                              <a href="#" class="btn btn-default btn-sm float-right downloadFileButton"><i class="fas fa-cloud-download-alt"></i></a>
                            </span>
                      </div>
                    </td>
                  </tr>
                </table>
              </div>
              <div class="tab-pane fade" id="custom-tabs-two-history" role="tabpanel" aria-labelledby="custom-tabs-two-history-tab">
                <span id="pHistory"></span>
              </div>
              <div class="tab-pane fade" id="custom-tabs-three-accesslog" role="tabpanel" aria-labelledby="custom-tabs-three-accesslog-tab">
                <span id="pAccessLog"></span>
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
</div>

<div class="modal fade" id="approval-confirmation-modal">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div id="bg-header" class="modal-header">
        <h4 class="modal-title"><i><span id="title-modal">Note to Author(s)</span></i></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form-horizontal" id="form-approval" action="#" method="POST">
        <div class="modal-body">
          <div class="form-group row">
            <label class="col-sm-4 col-form-label">Custom To: Name</label>
            <div class="col-sm-8">
              <input class="form-control" id="inputAuthor" name="to" placeholder="Author(s)">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-4 col-form-label">Custom Subject</label>
            <div class="col-sm-8">
              <input class="form-control" id="inputSubject" name="subject" placeholder="">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-4 col-form-label">Custom Comment</label>
            <div class="col-sm-8">
              <textarea class="form-control" rows="3" name="comment" id="inputComment"></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-4 col-form-label">E-mail All Users</label>
            <div class="col-sm-8">
              <div class="form-check">
                <input type="checkbox" class="form-check-input" name="send_to_dept" name="send_to_all" id="inputEmailAllUser">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-4 col-form-label">E-mail Whole Department</label>
            <div class="col-sm-8">
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="inputEmailAllDept">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-4 col-form-label">E-mail These Users</label>
            <div class="col-sm-8">
              <select class="form-control select2" id="inputEmailUser" name="send_to_users[]" multiple style="width: 100%;" data-placeholder="Select one">
                <option value="0">No one</option>
                <option value="owner">File Owners</option>
                <?php
                  foreach ($listUsers as $key => $val) {
                ?>
                <option value="<?=$val['id']?>"><?=$val['last_name'].', '.$val['first_name']?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <input type="hidden" value="" id="hidAdminMode" name="admin_mode">
          <input type="hidden" value="" id="hidIds" name="ids">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" id="btn-approval" class="btn">Authorize</button>
        </div>
      </form>
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
  }

  .modal-confirm .modal-footer a {
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
      min-height: 40px;
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

  .trigger-btn {
      display: inline-block;
      margin: 100px auto;
  }
</style>

<!-- jQuery -->
<script src="<?=base_url('adminLTE/plugins/jquery/jquery.min.js')?>"></script>

<script>
  $(function () {
    var ids         = [];
    var status      = $('#hidStatus').val();
    var is_admin    = <?=$_SESSION['is_admin'] ? 1 : 0?>;
    var is_reviewer = <?=$_SESSION['is_reviewer'] ? 1 : 0?>;
    var admin_mode  = <?=$admin_mode ? 1 : 0?>;

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
        'url': '<?=site_url('dashboard/loadAjaxTables/')?>' + status + '/' + admin_mode,
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
      'columnDefs': [
        {
            targets: [-1, 0, 1, 2, 5],
            className: 'dt-center'
        },
        {
            targets: [-2],
            className: 'dt-head-center dt-body-right'
        }
      ],
      'drawCallback': function (settings) { 
        var response = settings.json;
        $('#totDeleted').html(response.totDeleted);
        $('#totReviewed').html(response.totReviewed);
        $('#totRejected').html(response.totRejected);
      },
    });

    if (status == 'onreview' && is_admin == 0 && is_reviewer == 0) {
      listDataTable.column(1).visible(false);
    }

    if (status == 'deleted') {
      listDataTable.button().add( 0, {
        action: function ( e, dt, button, config ) {
          var isChecked =  $('input:checkbox').is(':checked');
          if (!isChecked) {
            alert('Tidak ada data yang dipilih !');
            return false;
          } else {
            $('input:checkbox[name=ids]:checked').each(function(){
              ids.push($(this).val());
            });
          }

          $.ajax({
            url: "<?=site_url('admin/undeleteFile')?>",
            method: 'POST',
            data: {ids:ids},
            success: function(response) {
              location.reload();
            }
          })
        },
        text: 'Undelete',
        className: 'btn-default'
      } ).add( 1, {
        action: function ( e, dt, button, config ) {
          var isChecked =  $('input:checkbox').is(':checked');
          if (!isChecked) {
            alert('Tidak ada data yang dipilih !');
            return false;
          } else {
            $('input:checkbox[name=ids]:checked').each(function(){
              ids.push($(this).val());
            });
          }

          $.ajax({
            url: "<?=site_url('admin/permDeleteFile')?>",
            method: 'POST',
            data: {ids:ids},
            success: function(response) {
              location.reload();
            }
          })
        },
        text: 'Delete',
        className: 'btn-default'
      });
    } else if (status == 'onreview' && (is_admin == 1 || is_reviewer == 1)) {
      listDataTable.button().add( 0, {
        action: function ( e, dt, button, config ) {
          var isChecked =  $('input:checkbox').is(':checked');
          if (!isChecked) {
            alert('Tidak ada data yang dipilih !');
            return false;
          } else {
            $('input:checkbox[name=ids]:checked').each(function(){
              ids.push($(this).val());
            });
          }

          $('#form-approval').attr('action', '<?=site_url('dashboard/authorize')?>');
          $('#hidIds').val(JSON.stringify(ids));
          $('#hidAdminMode').val(admin_mode);
          $('#btn-approval').text('Authorize').attr('class', 'btn btn-info');
          $('#bg-header').attr('class', 'modal-header bg-info');
          $('#approval-confirmation-modal').modal('show');
        },
        text: 'Authorize',
        className: 'btn-default btns'
      } ).add( 1, {
        action: function ( e, dt, button, config ) {
          var isChecked =  $('input:checkbox').is(':checked');
          if (!isChecked) {
            alert('Tidak ada data yang dipilih !');
            return false;
          } else {
            $('input:checkbox[name=ids]:checked').each(function(){
              ids.push($(this).val());
            });
          }
          
          $('#form-approval').attr('action', '<?=site_url('dashboard/reject')?>');
          $('#hidIds').val(JSON.stringify(ids));
          $('#hidAdminMode').val(admin_mode);
          $('#btn-approval').text('Reject').attr('class', 'btn btn-danger');
          $('#bg-header').attr('class', 'modal-header bg-danger');
          $('#approval-confirmation-modal').modal('show');
        },
        text: 'Reject',
        className: 'btn-default btns'
      });
    } else if (status == 'rejected') {
      listDataTable.button().add( 0, {
        action: function ( e, dt, button, config ) {
          var isChecked =  $('input:checkbox').is(':checked');
          if (!isChecked) {
            alert('Tidak ada data yang dipilih !');
            return false;
          } else {
            $('input:checkbox[name=ids]:checked').each(function(){
              ids.push($(this).val());
            });
          }

          $.ajax({
            url: "<?=site_url('dashboard/resubmit')?>",
            method: 'POST',
            data: {ids:ids},
            success: function(response) {
              location.reload();
            }
          })
        },
        text: 'Re-submit for Review',
        className: 'btn-default btns'
      } ).add( 1, {
        action: function ( e, dt, button, config ) {
          var isChecked =  $('input:checkbox').is(':checked');
          if (!isChecked) {
            alert('Tidak ada data yang dipilih !');
            return false;
          } else {
            $('input:checkbox[name=ids]:checked').each(function(){
              ids.push($(this).val());
            });
          }

          $.ajax({
            url: "<?=site_url('dashboard/tempDeleteRejectedFile')?>",
            method: 'POST',
            data: {ids:ids},
            success: function(response) {
              location.reload();
            }
          })
        },
        text: 'Delete',
        className: 'btn-default btns'
      });
    }

    $('#checkall').click(function () {
      $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $('#example1').on('click', '.btn-detail', function(){
      const id = $(this).attr('id');
      $.ajax({
        url: "<?=site_url('dashboard/getDataById/')?>" + status,
        type: "GET",
        data:{id: id},
        success: function(response) {
          const obj = JSON.parse(response);
          $('#pKategori').html(obj.data.cat_name);
          $('#pUkuran').html(obj.data.file_size);
          $('#filepUkuran').text(obj.data.file_size);
          $('#pCreated').html(obj.data.created);
          $('#pPemilik').html(obj.data.last_name + ', ' + obj.data.first_name);
          $('#pDeskripsi').html(obj.data.description);
          $('#pComment').html(obj.data.comment);
          $('#pFileName').html(obj.data.realname);
          $(".downloadFileButton").attr("href", "<?=site_url('dashboard/file/')?>" + id)

          var str = '';
          var arr = obj.history;
          arr.forEach(function(hist, index, myArray) {
            str += '<div class="timeline timeline-inverse"><div class="time-label"><span class="bg-danger">'+hist.date_modified+'</span></div><div><i class="fas fa-envelope bg-primary"></i><div class="timeline-item"><span class="time"><i class="far fa-clock"></i> '+hist.time_modified+'</span><h3 class="timeline-header"><a href="#">'+hist.last_name+', '+hist.first_name+'</a></h3><div class="timeline-body"><table class="table table-sm"><tr><th>Revision</th><td>'+hist.revision+'</td></tr><tr><th>Note</th><td>'+hist.note+'</td></tr></table></div></div></div>';
          });
          str += '<div><i class="far fa-clock bg-gray"></i></div></div>';
          
          var strx = '';
          var arrx = obj.accesslog;
          if (Object.keys(arrx).length > 0) {
            arrx.forEach(function(log, index, myArray) {
              strx += '<div class="timeline timeline-inverse"><div class="time-label"><span class="bg-danger">'+log.date_modified+'</span></div><div><i class="fas fa-envelope bg-primary"></i><div class="timeline-item"><span class="time"><i class="far fa-clock"></i> '+log.time_modified+'</span><h3 class="timeline-header"><a href="#">'+log.username+'</a></h5><div class="timeline-body">'+log.action+'</h5></div></div></div>';
            });
            strx += '<div><i class="far fa-clock bg-gray"></i></div>';
          } else {
            strx += '<i>There is no writable log.</i>';
          }

          $('#pHistory').html(str);
          $('#pAccessLog').html(strx);
          $('#detailModal').modal('show');
        }
      });
    });

    $('#confirmDelete').on('show.bs.modal', function(e) {
        $(this).find('#form-delete').attr('action', $(e.relatedTarget).data('href'));
    });

    $('#approval-confirmation-modal').on('hidden.bs.modal', function (e) {
      $(this)
        .find("input,textarea,select")
          .val('')
          .end()
        .find("input[type=checkbox], input[type=radio]")
          .prop("checked", "")
          .end();
    })
  });
</script>