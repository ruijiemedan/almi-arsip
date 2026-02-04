<?= $this->include('layout/header') ?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Edit User</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
          <li class="breadcrumb-item"><a href="<?= base_url('user') ?>">User</a></li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Edit User</h3>
          </div>
          <form action="<?= base_url('user/update/' . $user['id_user']) ?>" method="post">
            <?= csrf_field() ?>
            <div class="card-body">
              <?php if (session()->get('errors')): ?>
                <div class="alert alert-danger">
                  <ul class="mb-0">
                    <?php foreach (session()->get('errors') as $error): ?>
                      <li><?= $error ?></li>
                    <?php endforeach ?>
                  </ul>
                </div>
              <?php endif; ?>

              <div class="form-group">
                <label for="nama_user">Nama User <span class="text-danger">*</span></label>
                <input type="text" name="nama_user" id="nama_user" class="form-control" value="<?= $user['nama_user'] ?>" required>
              </div>

              <div class="form-group">
                <label for="email">E-Mail <span class="text-danger">*</span></label>
                <input type="email" name="email" id="email" class="form-control" value="<?= $user['email'] ?>" required>
              </div>

              <div class="form-group">
                <label for="password">Password (Kosongkan jika tidak ingin mengubah)</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
              </div>

              <div class="form-group">
                <label for="level">Level <span class="text-danger">*</span></label>
                <select name="level" id="level" class="form-control" required>
                  <option value="1" <?= $user['level'] == 1 ? 'selected' : '' ?>>Admin</option>
                  <option value="2" <?= $user['level'] == 2 ? 'selected' : '' ?>>User</option>
                </select>
              </div>

              <div class="form-group">
                <label for="id_dep">Departemen <span class="text-danger">*</span></label>
                <select name="id_dep" id="id_dep" class="form-control" required>
                  <?php foreach ($departemen as $dep): ?>
                    <option value="<?= $dep['id_dep'] ?>" <?= $user['id_dep'] == $dep['id_dep'] ? 'selected' : '' ?>>
                      <?= $dep['nama_dep'] ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update
              </button>
              <a href="<?= base_url('user') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<?= $this->include('layout/footer') ?>
