<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">DATA USER</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">
                Pengelolaan Data User
            </li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                <?= $title ?>
            </div>
            <div class="card-body">
                <!-- Form Ubah Users -->
                <form action="<?= base_url('user/edit/' .  $result['id']) ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="mb-3 row">
                        <label for="name" class="col-sm-2 col-for m-label">Nama Depan</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control <?= $validation->hasError('firstname') ? 'is-invalid'
                             : '' ?>" name="firstname" value="<?= old('firstname', $result['firstname']) ?>">
                             <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('firstname') ?>
                            </div>
                        </div>
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control <?= $validation->hasError('user_name') ? 'is-invalid'
                             : '' ?>" name="username" value="<?= old('user_name', $result['user_name']) ?>">
                             <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('user_name') ?>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="address" class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control <?= $validation->hasError('user_address') ? 'is-invalid'
                             : '' ?>" name="address" value="<?= old('user_address', $result['user_address']) ?>">
                             <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('user_address') ?>
                            </div>
                        </div>
                        <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control <?= $validation->hasError('user_phone') ? 'is-invalid'
                             : '' ?>" name="phone" value="<?= old('user_phone', $result['user_phone']) ?>">
                             <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('user_phone') ?>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="username" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-4">
                            <select class="form-control <?= $validation->hasError('role') ? 'is-invalid'
                             : '' ?>" name="role" value="<?= old('role', $result['role']) ?>">
                                <option value="Owner" <?= $result['role'] == 'Owner' ? 'selected' : '' ?>>Owner</option>
                                <option value="Kasir" <?= $result['role'] == 'Kasir' ? 'selected' : '' ?>>Kasir</option>
                            </select>
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('role') ?>
                            </div>
                        </div>
                    </div>
                    <div class="d-grip gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary me-md-2" type="submit">Simpan</button>
                        <button class="btn btn-danger" type="reset">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>