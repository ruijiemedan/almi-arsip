<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title ?? 'E-Kerja Almi' ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css">
  
  <style>
    .brand-link {
      font-size: 1.25rem;
      font-weight: 600;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?= base_url('home') ?>" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="#" role="button">
          <i class="far fa-user"></i> <?= session()->get('nama_user') ?>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url('auth/logout') ?>" onclick="return confirm('Yakin ingin logout?')">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= base_url('home') ?>" class="brand-link">
      <i class="fas fa-archive ml-3 mr-2"></i>
      <span class="brand-text font-weight-light">E-Kerja Almi</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="https://ui-avatars.com/api/?name=<?= urlencode(session()->get('nama_user')) ?>&background=random" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?= session()->get('nama_user') ?></a>
          <small class="text-muted"><?= session()->get('level') == 1 ? 'Administrator' : 'User' ?></small>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          
          <li class="nav-item">
            <a href="<?= base_url('home') ?>" class="nav-link <?= (uri_string() == 'home') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('arsip') ?>" class="nav-link <?= (strpos(uri_string(), 'arsip') !== false) ? 'active' : '' ?>">
              <i class="nav-icon fas fa-file-archive"></i>
              <p>Arsip</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('profile') ?>" class="nav-link <?= (strpos(uri_string(), 'profile') !== false) ? 'active' : '' ?>">
              <i class="nav-icon fas fa-user-circle"></i>
              <p>Profile</p>
            </a>
          </li>

          <?php if (session()->get('level') == 1): ?>
          <li class="nav-header">MASTER DATA</li>
          
          <li class="nav-item">
            <a href="<?= base_url('kategori') ?>" class="nav-link <?= (strpos(uri_string(), 'kategori') !== false) ? 'active' : '' ?>">
              <i class="nav-icon fas fa-tags"></i>
              <p>Kategori</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('departemen') ?>" class="nav-link <?= (strpos(uri_string(), 'departemen') !== false) ? 'active' : '' ?>">
              <i class="nav-icon fas fa-building"></i>
              <p>Departemen</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?= base_url('user') ?>" class="nav-link <?= (strpos(uri_string(), 'user') !== false) ? 'active' : '' ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>User</p>
            </a>
          </li>

          <li class="nav-header">SYSTEM</li>

          <li class="nav-item">
            <a href="<?= base_url('logs') ?>" class="nav-link <?= (strpos(uri_string(), 'logs') !== false) ? 'active' : '' ?>">
              <i class="nav-icon fas fa-history"></i>
              <p>Activity Logs</p>
            </a>
          </li>
          <?php endif; ?>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
