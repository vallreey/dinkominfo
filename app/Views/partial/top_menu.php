<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-danger navbar-badge"><?=$_SESSION['notif_review']+$_SESSION['notif_rejected']?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="<?=site_url('dashboard/approval/onreview')?>" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Pending Approval
                  <span class="float-right text-sm text-success"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Document waiting to be reviewed</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> <?='Latest: ' . $_SESSION['notif_review'] .' '. ($_SESSION['notif_review'] > 1 ? 'Docs' : 'Doc')?></p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?=site_url('dashboard/approval/rejected')?>" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Rejected
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Document has been rejected by approver</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> <?='Latest: ' . $_SESSION['notif_rejected'] .' '. ($_SESSION['notif_rejected'] > 1 ? 'Docs' : 'Doc')?></p>
              </div>
            </div>
            <!-- Message End -->
          </a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">You're login as <?=ucwords($_SESSION['first_name'].' '.$_SESSION['last_name'])?></span>
          <div class="dropdown-divider"></div>
          <a href="<?=site_url('account/profile')?>" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Profile
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?=site_url('account/logout')?>" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
          </a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->