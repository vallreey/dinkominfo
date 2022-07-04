<!-- DataTables -->
<link rel="stylesheet" href="<?=base_url('adminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')?>">
<link rel="stylesheet" href="<?=base_url('adminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')?>">
<link rel="stylesheet" href="<?=base_url('adminLTE/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')?>">

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
    <!-- <ul class="nav nav-pills flex-column"> -->
    <ul id="submenus" class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true" style="border-bottom: 1px solidrgba(0,0,0,.125);">
      <li class="nav-item active">
        <a href="<?=site_url('admin/user')?>" class="nav-link" <?=$active == 'user' ? 'style="color:#007bff"' : ''?>>
          <i class="fas fa-inbox"></i> User <?=$active == 'user' ? '<span class="badge bg-primary float-right">&#10003;	</span>' : ''?>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?=site_url('admin/bidang')?>" class="nav-link" <?=$active == 'bidang' ? 'style="color:#007bff"' : ''?>>
          <i class="far fa-envelope"></i> Bidang <?=$active == 'bidang' ? '<span class="badge bg-primary float-right">&#10003;	</span>' : ''?>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?=site_url('admin/kategori')?>" class="nav-link" <?=$active == 'kategori' ? 'style="color:#007bff"' : ''?>>
          <i class="fas fa-inbox"></i> Kategori <?=$active == 'kategori' ? '<span class="badge bg-primary float-right">&#10003;	</span>' : ''?>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?=site_url('admin/file')?>" class="nav-link" <?=$active == 'file' ? 'style="color:#007bff"' : ''?>>
          <i class="fas fa-filter"></i> File <?=$active == 'file' ? '<span class="badge bg-primary float-right">&#10003;	</span>' : ''?>
        </a>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon far fa-envelope"></i>
          <p>
            Approval Dokumen
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="<?=site_url('dashboard/approval/onreview')?>" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>On Review</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=site_url('dashboard/approval/rejected')?>" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>Rejected</p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link" <?=$active == 'report' ? 'style="color:#007bff"' : ''?>>
          <i class="far fa-trash-alt"></i> Report <?=$active == 'report' ? '<span class="badge bg-primary float-right">&#10003;	</span>' : ''?>
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
<!-- InputMask -->
<script src="<?=base_url('adminLTE/plugins/inputmask/jquery.inputmask.min.js')?>"></script>