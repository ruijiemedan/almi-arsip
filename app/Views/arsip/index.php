<?= $this->include('layout/header') ?>

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Data Arsip</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
          <li class="breadcrumb-item active">Arsip</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data Arsip</h3>
            <div class="card-tools">
              <a href="<?= base_url('arsip/add') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add
              </a>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>No Arsip</th>
                    <th>Nama Arsip</th>
                    <th>Kategori</th>
                    <th>Upload</th>
                    <th>Update</th>
                    <th>User</th>
                    <th>Departemen</th>
                    <th>File</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; foreach ($arsip as $row): ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['no_arsip'] ?></td>
                    <td><?= $row['nama_file'] ?></td>
                    <td><?= $row['nama_kategori'] ?></td>
                    <td><?= date('d-m-Y', strtotime($row['tgl_upload'])) ?></td>
                    <td><?= date('d-m-Y', strtotime($row['tgl_update'])) ?></td>
                    <td><?= $row['nama_user'] ?></td>
                    <td><?= $row['nama_dep'] ?></td>
                    <td>
                      <a href="<?= base_url('uploads/' . $row['file_arsip']) ?>" target="_blank" class="btn btn-sm btn-info">
                        <i class="fas fa-file-pdf"></i> <?= number_format(filesize(FCPATH . 'uploads/' . $row['file_arsip']) / 1024, 0) ?> KB
                      </a>
                    </td>
                    <td>
                      <a href="<?= base_url('arsip/view/' . $row['id_arsip']) ?>" class="btn btn-sm btn-info" title="View">
                        <i class="fas fa-eye"></i>
                      </a>
                      <a href="<?= base_url('arsip/edit/' . $row['id_arsip']) ?>" class="btn btn-sm btn-warning" title="Edit">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a href="<?= base_url('arsip/delete/' . $row['id_arsip']) ?>" class="btn btn-sm btn-danger btn-delete" title="Delete">
                        <i class="fas fa-trash"></i>
                      </a>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?= $this->include('layout/footer') ?>
