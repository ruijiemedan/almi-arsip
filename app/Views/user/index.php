<?= $this->include('layout/header') ?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Data User</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
          <li class="breadcrumb-item active">User</li>
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
            <h3 class="card-title">Data User</h3>
            <div class="card-tools">
              <a href="<?= base_url('user/add') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add
              </a>
            </div>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama User</th>
                  <th>E-Mail</th>
                  <th>Password</th>
                  <th>Level</th>
                  <th>Departemen</th>
                  <th>Foto</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; foreach ($users as $row): ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $row['nama_user'] ?></td>
                  <td><?= $row['email'] ?></td>
                  <td>1234</td>
                  <td><?= $row['level'] == 1 ? 'Admin' : 'User' ?></td>
                  <td><?= $row['nama_dep'] ?? '-' ?></td>
                  <td>
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($row['nama_user']) ?>&background=random" width="40" class="img-circle">
                  </td>
                  <td>
                    <a href="<?= base_url('user/edit/' . $row['id_user']) ?>" class="btn btn-sm btn-warning">
                      <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="<?= base_url('user/delete/' . $row['id_user']) ?>" class="btn btn-sm btn-danger btn-delete">
                      <i class="fas fa-trash"></i> Delete
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
</section>

<?= $this->include('layout/footer') ?>
