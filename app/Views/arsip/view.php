<?= $this->include('layout/header') ?>

<!-- Content Header -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Detail Arsip</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
          <li class="breadcrumb-item"><a href="<?= base_url('arsip') ?>">Arsip</a></li>
          <li class="breadcrumb-item active">View</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">View Arsip</h3>
          </div>
          <div class="card-body">
            <table class="table table-bordered">
              <tr>
                <th width="200">No Arsip</th>
                <td><?= $arsip['no_arsip'] ?></td>
              </tr>
              <tr>
                <th>Nama Arsip</th>
                <td><?= $arsip['nama_file'] ?></td>
              </tr>
              <tr>
                <th>Deskripsi</th>
                <td><?= $arsip['deskripsi'] ?></td>
              </tr>
              <tr>
                <th>Kategori</th>
                <td><?= $arsip['nama_kategori'] ?></td>
              </tr>
              <tr>
                <th>Departemen</th>
                <td><?= $arsip['nama_dep'] ?></td>
              </tr>
              <tr>
                <th>User</th>
                <td><?= $arsip['nama_user'] ?></td>
              </tr>
              <tr>
                <th>Tanggal Upload</th>
                <td><?= date('d-m-Y', strtotime($arsip['tgl_upload'])) ?></td>
              </tr>
              <tr>
                <th>Tanggal Update</th>
                <td><?= date('d-m-Y', strtotime($arsip['tgl_update'])) ?></td>
              </tr>
              <tr>
                <th>Ukuran File</th>
                <td><?= number_format(filesize(FCPATH . 'uploads/' . $arsip['file_arsip']) / 1024, 0) ?> KB</td>
              </tr>
            </table>
          </div>
          <div class="card-footer">
            <a href="<?= base_url('uploads/' . $arsip['file_arsip']) ?>" target="_blank" class="btn btn-info">
              <i class="fas fa-file-pdf"></i> Lihat File
            </a>
            <a href="<?= base_url('arsip') ?>" class="btn btn-secondary">
              <i class="fas fa-arrow-left"></i> Kembali
            </a>
          </div>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Preview PDF</h3>
          </div>
          <div class="card-body">
            <embed src="<?= base_url('uploads/' . $arsip['file_arsip']) ?>" type="application/pdf" width="100%" height="600px" />
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?= $this->include('layout/footer') ?>
