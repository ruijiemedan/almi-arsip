<?= $this->include('layout/header') ?>

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Tambah Arsip</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Home</a></li>
          <li class="breadcrumb-item"><a href="<?= base_url('arsip') ?>">Arsip</a></li>
          <li class="breadcrumb-item active">Add Arsip</li>
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
            <h3 class="card-title">Add Arsip</h3>
          </div>
          <form action="<?= base_url('arsip/save') ?>" method="post" enctype="multipart/form-data">
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
                <label for="id_kategori">Kategori <span class="text-danger">*</span></label>
                <select name="id_kategori" id="id_kategori" class="form-control" required>
                  <option value="">-- Pilih Kategori --</option>
                  <?php foreach ($kategori as $kat): ?>
                    <option value="<?= $kat['id_kategori'] ?>" <?= old('id_kategori') == $kat['id_kategori'] ? 'selected' : '' ?>>
                      <?= $kat['nama_kategori'] ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group">
                <label for="nama_file">Nama Arsip <span class="text-danger">*</span></label>
                <input type="text" name="nama_file" id="nama_file" class="form-control" placeholder="Nama Arsip" value="<?= old('nama_file') ?>" required>
              </div>

              <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" placeholder="Deskripsi"><?= old('deskripsi') ?></textarea>
              </div>

              <div class="form-group">
                <label for="file_arsip">File Arsip (PDF) <span class="text-danger">*</span></label>
                <div class="custom-file">
                  <input type="file" name="file_arsip" id="file_arsip" class="custom-file-input" accept=".pdf" required>
                  <label class="custom-file-label" for="file_arsip">Choose file</label>
                </div>
                <small class="form-text text-muted">File Harus Format .PDF (Max 5MB)</small>
              </div>

            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan
              </button>
              <a href="<?= base_url('arsip') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  // Update file input label
  document.getElementById('file_arsip').addEventListener('change', function(e) {
    var fileName = e.target.files[0].name;
    var label = e.target.nextElementSibling;
    label.innerText = fileName;
  });
</script>

<?= $this->include('layout/footer') ?>
