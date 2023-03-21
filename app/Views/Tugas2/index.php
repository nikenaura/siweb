<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="container">
    <h1>Container</h1>
    <div class=row>
        <div class="text-center bg-warning">
          
            <div class="container-1">
    
    <div class="row">
        <div class="text-center bg-warning">
            <h5>Container 1 - Gambar</h5>
        </div>
        <div class="col-sm-6 bg-primary">
            <div class="text-center">
                <br>
                <img style="height : 300px; width : 300px;" src="https://w7.pngwing.com/pngs/402/413/png-transparent-nezuko-kamado.png">
                <p style="font-weight: bold;">Gambar 1 </p>
            </div>
        </div>
        <div class="col-sm-6 bg-success">
            <div class="text-center">
                <br>
                <img style="height : 300px; width : 300px;" src="http://logo.uajy.ac.id/file/uploads/2021/08/UAJY-LOGOGRAM_-01.png">
                <p style="font-weight: bold;">Gambar 2</p>
            </div>
        </div>  
    </div>
</div>
<div class="col-sm-4 bg-light">
    <h5></h5>
</div>
<div class="container-2">
    <div class="row">
        <div class="text-center bg-warning">
            <h5>Container 2 - Pesan dan kesan</h5>
        </div>
        <div class="col-sm-7 bg-info">
            <h4 class="text-center">Pengalaman Belajar Siweb :</h4><br>
            <p>Cukup menyenangkan</p>
        </div>
        <div class="col-sm-5 text-center bg-primary">
            <h4>Pesan dan kesan kepada Asdos :</h4>
            <p>Pesan : gaada sih</p>
            <p>Kesan : menyenangkan</p>
        </div>
    </div>

<?= $this->endSection() ?>