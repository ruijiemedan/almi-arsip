<?= $this->include('layout/header') ?>

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Dashboard</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3><?= $total_arsip ?></h3>
            <p>Arsip</p>
          </div>
          <div class="icon">
            <i class="fas fa-file-archive"></i>
          </div>
          <a href="<?= base_url('arsip') ?>" class="small-box-footer">View Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3><?= $total_kategori ?></h3>
            <p>Kategori</p>
          </div>
          <div class="icon">
            <i class="fas fa-tags"></i>
          </div>
          <a href="<?= base_url('kategori') ?>" class="small-box-footer">View Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3><?= $total_departemen ?></h3>
            <p>Departemen</p>
          </div>
          <div class="icon">
            <i class="fas fa-building"></i>
          </div>
          <a href="<?= base_url('departemen') ?>" class="small-box-footer">View Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3><?= $total_user ?></h3>
            <p>User</p>
          </div>
          <div class="icon">
            <i class="fas fa-users"></i>
          </div>
          <a href="<?= base_url('user') ?>" class="small-box-footer">View Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
    </div>
    <!-- /.row -->

    <!-- Info boxes -->
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-info-circle mr-1"></i>
              Selamat Datang di E-Kerja Almi
            </h3>
          </div>
          <div class="card-body">
            <div class="alert alert-info">
              <h5><i class="icon fas fa-info"></i> Informasi!</h5>
              Selamat datang <strong><?= session()->get('nama_user') ?></strong> di Sistem Informasi E-Kerja Almi. 
              Anda login sebagai <strong><?= session()->get('level') == 1 ? 'Administrator' : 'User' ?></strong>.
            </div>
            
            <div class="callout callout-success">
              <h5>Fitur Sistem:</h5>
              <ul>
                <li>Manajemen Arsip Digital</li>
                <li>Upload dan Download Dokumen</li>
                <li>Kategori Arsip</li>
                <li>Manajemen Departemen</li>
                <li>Manajemen User</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.row -->
  </div><!--/. container-fluid -->
</section>
<!-- /.content -->

<?= $this->include('layout/footer') ?>
