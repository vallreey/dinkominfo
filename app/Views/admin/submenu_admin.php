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
      <li class="nav-item">
        <a href="<?=site_url('admin/user')?>" class="nav-link <?=$active == 'user' ? 'active' : ''?>">
          <i class="nav-icon far fa-user"></i>
          <p>
            User
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?=site_url('admin/bidang')?>" class="nav-link <?=$active == 'bidang' ? 'active' : ''?>">
          <i class="nav-icon fas fa-table"></i>
          <p>
            Bidang
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="<?=site_url('admin/kategori')?>" class="nav-link <?=$active == 'kategori' ? 'active' : ''?>">
          <i class="nav-icon fas fa-tree"></i>
          <p>
            Kategori
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon far fa-file-alt"></i>
          <p>
            File
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="<?=site_url('admin/documents/deleted')?>" class="nav-link <?=$active == 'file_deleted' ? 'active' : ''?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Deleted/Undeleted</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=site_url('admin/documents/onreview')?>" class="nav-link <?=$active == 'file_review' ? 'active' : ''?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Reviews</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=site_url('admin/documents/rejected')?>" class="nav-link <?=$active == 'file_reject' ? 'active' : ''?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Rejections</p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item <?=$active == 'accesslog' || $active == 'filelistexport' ? 'menu-open' : ''?>">
        <a href="#" class="nav-link <?=$active == 'accesslog' || $active == 'filelistexport' ? 'active' : ''?>">
          <i class="nav-icon far fa-list-alt"></i>
          <p>
            Reports
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="<?=site_url('admin/accesslog')?>" class="nav-link <?=$active == 'accesslog' ? 'active' : ''?>">
              <i class="far fa-circle nav-icon"></i>
              <p>Access Log</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=site_url('admin/filelistexport')?>" class="nav-link <?=$active == 'filelistexport' ? 'active' : ''?>">
              <i class="far fa-circle nav-icon"></i>
              <p>File List Export</p>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item <?=$active == 'filetypes' ? 'menu-open' : ''?>">
        <a href="#" class="nav-link <?=$active == 'filetypes' ? 'active' : ''?>">
          <i class="nav-icon far fa-plus-square"></i>
          <p>
            Settings
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="<?=site_url('admin/filetypes')?>" class="nav-link <?=$active == 'filetypes' ? 'active' : ''?>">
              <i class="far fa-circle nav-icon"></i>
              <p>File Types</p>
            </a>
          </li>
        </ul>
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
<!-- Bootstrap Switch -->
<script src="<?=base_url('adminLTE/plugins/bootstrap-switch/js/bootstrap-switch.min.js')?>"></script>