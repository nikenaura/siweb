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
                <form action="<?= base_url('users/edit/' .  $result['id']) ?>" method="POST">
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
                        <label for="name" class="col-sm-2 col-for m-label">Nama Belakang</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control <?= $validation->hasError('lastname') ? 'is-invalid'
                             : '' ?>" name="lastname" value="<?= old('lastname', $result['lastname']) ?>">
                             <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('lastname') ?>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control <?= $validation->hasError('user_name') ? 'is-invalid'
                             : '' ?>" name="username" value="<?= old('user_name', $result['user_name']) ?>">
                             <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('user_name') ?>
                            </div>
                        </div>
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control <?= $validation->hasError('user_email') ? 'is-invalid'
                             : '' ?>" name="email" value="<?= old('user_email', $result['user_email']) ?>">
                             <div id="validationServer03Feedback" class="invalid-feedback">
                                <?= $validation->getError('user_email') ?>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="username" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-4">
                            <select class="form-control <?= $validation->hasError('role') ? 'is-invalid'
                             : '' ?>" name="role" value="<?= old('role', $result['role']) ?>">
                                <option value="Karyawan" <?= $result['role'] == 'Karyawan' ? 'selected' : '' ?>>Karyawan</option>
                                <option value="Admin" <?= $result['role'] == 'Admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="Manajer" <?= $result['role'] == 'Manajer' ? 'selected' : '' ?>>Manajer</option>
                                <option value="Owner" <?= $result['role'] == 'Owner' ? 'selected' : '' ?>>Owner</option>
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