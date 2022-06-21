<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?=site_url('dashboard')?>" class="brand-link">
    <img src="<?=base_url('adminLTE/dist/img/primbonlogo.png')?>" alt="Primbon Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">PRIMBON</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
      <img src="<?=base_url('adminLTE/dist/img/avatar5.png')?>" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?=strtoupper($_SESSION['username'])?></a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="<?=site_url('dashboard')?>" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Dashboard
              <span class="right badge badge-danger">New</span>
            </p>
          </a>
        </li>
        <li class="nav-header">DOKUMEN</li>
        <li class="nav-item">
          <a href="<?=site_url('dashboard/search')?>" class="nav-link">
            <i class="nav-icon far fa-calendar-alt"></i>
            <p>
              Cari Dokumen
              <span class="badge badge-info right">2</span>
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?=site_url('dashboard/update')?>" class="nav-link">
            <i class="nav-icon far fa-edit"></i>
            <p>
              Tambah Dokumen
            </p>
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
        <?php if ($_SESSION['is_admin']) { ?>
        <li class="nav-header">ADMINISTRASI</li>
        <li class="nav-item">
          <a href="<?=site_url('admin/user')?>" class="nav-link">
            <i class="nav-icon far fa-calendar-alt"></i>
            <p>
              Users
              <span class="badge badge-info right">2</span>
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?=site_url('admin/bidang')?>" class="nav-link">
            <i class="nav-icon far fa-image"></i>
            <p>
              Bidang
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?=site_url('admin/kategori')?>" class="nav-link">
            <i class="nav-icon far fa-image"></i>
            <p>
              Kategori
            </p>
          </a>
        </li>
        <?php } ?>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>