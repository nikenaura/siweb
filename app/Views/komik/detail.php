<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">DATA KOMIK</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">
                Pengelolaan Data Komik
            </li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                <?= $title ?>
            </div>
            <div class="card-body">
                <!-- Isi Detail -->
                <div class="card mb-3">
                    <div class="col-md-4">
                        <img src="https://cdn.pixabay.com/photo/2017/01/31/00/09/book-2022464_960_720.png"
                        alt="" width="50%">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= $result['judul'] ?></h5>
                            <p class="card-text">Penulis:<br><?= $result['penulis'] ?></p>
                            <p class="card-text">Tahun Rilis: <?= $result['tahun_rilis'] ?></p>
                            <p class="card-text">Stok: <?= $result['stok'] ?></p>
                            <p class="card-text">Harga: <?= $result['harga'] ?></p>
                            <p class="card-text">Diskon: <?= $result['diskon'] ?></p>
                            <div class="d-grip gap-2 d-md-block">
                                <a class="btn btn-dark" type="button" href="<?= base_url('komik') ?>">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>