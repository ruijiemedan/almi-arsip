<?= $this->include('layout/header') ?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Activity Logs</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
          <li class="breadcrumb-item active">Logs</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data Activity Logs</h3>
            <div class="card-tools">
              <a href="<?= base_url('logs/clear') ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus semua log?')">
                <i class="fas fa-trash"></i> Clear All Logs
              </a>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Waktu</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>Aktivitas</th>
                    <th>Deskripsi</th>
                    <th>IP Address</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; foreach ($logs as $row): ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= date('d/m/Y H:i:s', strtotime($row['created_at'])) ?></td>
                    <td><?= $row['nama_user'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td>
                      <?php if ($row['aktivitas'] == 'Login'): ?>
                        <span class="badge badge-success"><?= $row['aktivitas'] ?></span>
                      <?php elseif (strpos($row['aktivitas'], 'Tambah') !== false): ?>
                        <span class="badge badge-primary"><?= $row['aktivitas'] ?></span>
                      <?php elseif (strpos($row['aktivitas'], 'Edit') !== false || strpos($row['aktivitas'], 'Update') !== false): ?>
                        <span class="badge badge-warning"><?= $row['aktivitas'] ?></span>
                      <?php elseif (strpos($row['aktivitas'], 'Hapus') !== false): ?>
                        <span class="badge badge-danger"><?= $row['aktivitas'] ?></span>
                      <?php else: ?>
                        <span class="badge badge-info"><?= $row['aktivitas'] ?></span>
                      <?php endif; ?>
                    </td>
                    <td><?= $row['deskripsi'] ?? '-' ?></td>
                    <td><code><?= $row['ip_address'] ?></code></td>
                    <td>
                      <a href="<?= base_url('logs/delete/' . $row['id_log']) ?>" class="btn btn-sm btn-danger btn-delete">
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
