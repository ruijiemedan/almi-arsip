<?= $this->include('layout/header') ?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Tambah Kategori</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
          <li class="breadcrumb-item"><a href="<?= base_url('kategori') ?>">Kategori</a></li>
          <li class="breadcrumb-item active">Add</li>
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
            <h3 class="card-title">Add Kategori</h3>
          </div>
          <form action="<?= base_url('kategori/save') ?>" method="post">
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
                <label for="nama_kategori">Nama Kategori <span class="text-danger">*</span></label>
                <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" placeholder="Nama Kategori" value="<?= old('nama_kategori') ?>" required>
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan
              </button>
              <a href="<?= base_url('kategori') ?>" class="btn btn-secondary">
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
