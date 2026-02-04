<?= $this->include('layout/header') ?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Profile</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-4">
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <img class="profile-user-img img-fluid img-circle" 
                   src="https://ui-avatars.com/api/?name=<?= urlencode($user['nama_user']) ?>&size=128&background=random" 
                   alt="User profile picture">
            </div>
            <h3 class="profile-username text-center"><?= $user['nama_user'] ?></h3>
            <p class="text-muted text-center"><?= $user['level'] == 1 ? 'Administrator' : 'User' ?></p>
            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Email</b> <a class="float-right"><?= $user['email'] ?></a>
              </li>
              <li class="list-group-item">
                <b>Departemen</b> <a class="float-right"><?= $user['nama_dep'] ?? '-' ?></a>
              </li>
              <li class="list-group-item">
                <b>Status</b> <a class="float-right">
                  <?= $user['is_active'] ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' ?>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-8">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#profile" data-toggle="tab">Update Profile</a></li>
              <li class="nav-item"><a class="nav-link" href="#password" data-toggle="tab">Change Password</a></li>
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <div class="active tab-pane" id="profile">
                <form action="<?= base_url('profile/update') ?>" method="post">
                  <?= csrf_field() ?>
                  
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
                    <label for="nama_user">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama_user" name="nama_user" value="<?= $user['nama_user'] ?>" required>
                  </div>

                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= $user['email'] ?>" required>
                  </div>

                  <div class="form-group">
                    <label for="id_dep">Departemen</label>
                    <select class="form-control" id="id_dep" name="id_dep" required>
                      <?php foreach ($departemen as $dep): ?>
                        <option value="<?= $dep['id_dep'] ?>" <?= $user['id_dep'] == $dep['id_dep'] ? 'selected' : '' ?>>
                          <?= $dep['nama_dep'] ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                      <i class="fas fa-save"></i> Update Profile
                    </button>
                  </div>
                </form>
              </div>

              <div class="tab-pane" id="password">
                <form action="<?= base_url('profile/change-password') ?>" method="post">
                  <?= csrf_field() ?>

                  <div class="form-group">
                    <label for="password_lama">Password Lama</label>
                    <input type="password" class="form-control" id="password_lama" name="password_lama" required>
                  </div>

                  <div class="form-group">
                    <label for="password_baru">Password Baru</label>
                    <input type="password" class="form-control" id="password_baru" name="password_baru" required>
                  </div>

                  <div class="form-group">
                    <label for="konfirmasi_password">Konfirmasi Password Baru</label>
                    <input type="password" class="form-control" id="konfirmasi_password" name="konfirmasi_password" required>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                      <i class="fas fa-key"></i> Change Password
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?= $this->include('layout/footer') ?>
