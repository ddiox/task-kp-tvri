<?php

require "function.php";
require "check.php";

//Dapat ID barang yang di passing di halaman sebelumnya

$idbarang=$_GET['id']; //get id barang
//Get Informasi Barang berdasarkan database
$get=mysqli_query($conn,"select * from stock where idbarang='$idbarang'");
$fetch = mysqli_fetch_assoc($get);
//set variabel
$namabarang = $fetch['namabarang'];
$deskripsi = $fetch ['deskripsi'];
$stock = $fetch ['stock'];


//cek ada gambar atau tidak
$gambar = $fetch['Image']; //ambil gambar
if($gambar==null){
    //jika tidak ada gambar
    $img = 'No Photo';
}else{
    //jika ada gambar
    $img = '<img src="images/'.$gambar.'" class="zoomable">';
}

//Generate QR
$urlview = 'http://localhost/KP/inventori/detail.php?id='.$idbarang;
$qrcode = 'https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl='.$urlview.'&choe=UTF-8';

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Detail Barang</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="assets/DataTables/datatables.min.css"/>
        <script src="assets/fontawesome-free-5.15.3-web/js/all.min.js"></script>


        <style>
        a{
            text-decoration:none;
            color:black;
        }
        .logo{
            width: 45%;
            height: auto;
        }

        .zoomable{
            width: 300px; 
        }
        .zoomable:hover{
            transform: scale(2.5);
            transition: 0.3s ease;
        }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php"><img class="logo" src="assets/img/tvri.png" alt="logo"></a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Menu</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Ruang Maintenance
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-arrow-left"></i></div>
                                Barang Kembali
                            </a>
                            <a class="nav-link" href="keluar.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-arrow-right"></i></div>
                                Barang Keluar
                            </a>
                            <a class="nav-link" href="admin.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                Admin
                            </a>
                            <a class="nav-link" href="logout.php">
                                Logout
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Detail Barang</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <h2><?=$namabarang;?></h2>
                                <?=$img;?>
                                <img src="<?=$qrcode;?>">
                                
                            <div class="card-body">
                            </div>

                            <div class="row">
                                <div class="col md-3">Stock</div>
                                <div class="col md-9">: <?=$deskripsi;?></div>
                            </div>

                            <div class="row">
                                <div class="col md-3">Deskripsi</div>
                                <div class="col md-9">: <?=$stock;?></div>
                            </div>

                            

                            <br><br><hr>


                                <h3> Barang Masuk</h3>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="barangmasuk" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>tanggal</th>
                                                <th>Kondisi</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $ambildatamasuk = mysqli_query($conn, "select * from masuk where idbarang='$idbarang'");
                                            $i = 1;

                                            while($fetch=mysqli_fetch_array($ambildatamasuk)){
                                            $tanggal = $fetch['tanggal'];
                                            $kondisi= $fetch['kondisi'];
                                            $quantity = $fetch['qty'];

                                        
                                        ?>
                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$tanggal;?></a></td>
                                                <td><?=$kondisi;?></td>
                                                <td><?=$quantity;?></td> 
                                            </tr>
                                            

                                        <?php
                                        };
                                        ?>
                                        </tbody>
                                    </table>
                                </div>

                                <br><br>


                                <h3> Barang Keluar</h3>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="barangkeluar" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>tanggal</th>
                                                <th>Penerima</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $ambildatakeluar = mysqli_query($conn, "select * from keluar where idbarang='$idbarang'");
                                            $i = 1;

                                            while($fetch=mysqli_fetch_array($ambildatakeluar)){
                                            $tanggal = $fetch['tanggal'];
                                            $penerima= $fetch['penerima'];
                                            $quantity = $fetch['qty'];

                                        
                                        ?>
                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?=$tanggal;?></a></td>
                                                <td><?=$penerima;?></td>
                                                <td><?=$quantity;?></td> 
                                            </tr>
                                            

                                        <?php
                                        };
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; TVRI SULSEL 2021</div>
                            <div>
                                <a href="http://tvri.go.id/">tvri.go.id</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="assets/js/jquery-3.5.1.min.js"></script>
        <script src="assets/bootstrap-4.5.3-dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
        <script src="assets/Chart.js-2.9.4/dist/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="assets/DataTables/DataTables-1.10.24/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="assets/DataTables/DataTables-1.10.24/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
    </body>
      <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Tambah Barang</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <form method="post" enctype="multipart/form-data">
            <div class="modal-body">
                <input type="text" name="namabarang" placeholder="Nama Barang" class="form-control" required>
                <br>
                <input type="text" name="deskripsi" placeholder="Deskripsi Barang" class="form-control" required>
                <br>
                <input type="number" name="stock" placeholder="Stock" class="form-control" required>
                <br>
                <input type="file" name="file" class="form-control">
                <br>
                <button type="submit" class="btn btn-primary" name="addnewbarang">Submit</button>
            </div> 
        </form>  
      </div>
    </div>
  </div>
</html>
