<?php

require "function.php";
require "check.php";

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Barang Keluar</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="assets/DataTables/datatables.min.css"/>
        <script src="assets/fontawesome-free-5.15.3-web/js/all.min.js"></script>
        <style>
        .logo{
            width: 45%;
            height: auto;
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
                        <h1 class="mt-4">Barang Keluar</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <!-- Button to Open the Modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                    Tambah Barang
                                </button>
                                <a href="exportkeluar.php" class="btn btn-info">Export Data</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah</th>
                                                <th>Kondisi</th>
                                                <th>Penerima</th>
                                                <th>Petugas</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $ambildatastock = mysqli_query($conn, "select *from keluar k, stock s where s.idbarang = k.idbarang");
                                        $i = 1;
                                        while($data=mysqli_fetch_array($ambildatastock)){
                                            $idb = $data['idbarang'];
                                            $idk = $data['idkeluar'];
                                            $tanggal = $data['tanggal'];
                                            $namabarang = $data['namabarang'];
                                            $qty = $data['qty'];
                                            $kondisi= $data['kondisi'];
                                            $penerima = $data['penerima'];
                                            $petugas= $data['petugas'];

                                        ?>
                                            <tr>
                                                <td><?=$tanggal?></td>
                                                <td><?=$namabarang?></td>
                                                <td><?=$qty?></td>
                                                <td><?=$kondisi?></td>
                                                <td><?=$penerima?></td>
                                                <td><?=$petugas?></td>
                                                <td> 
                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$idk;?>">
                                                        Edit
                                                    </button>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$idk;?>">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>

                                              <!-- Edit Modal -->
                                              <div class="modal fade" id="edit<?=$idk;?>">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                    <h4 class="modal-title">Edit Barang</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    
                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            <input type="text" name="kondisi" value="<?=$kondisi?>" class="form-control" required>
                                                            <br>
                                                            <input type="text" name="penerima" value="<?=$penerima?>" class="form-control" required>
                                                            <br>
                                                            <input type="text" name="petugas" value="<?=$petugas?>" class="form-control" required>
                                                            <br>
                                                            <input type="number" name="qty" value="<?=$qty?>" class="form-control" required>
                                                            <br>
                                                            <input type="hidden" name="idb" value="<?=$idb?>">
                                                            <input type="hidden" name="idk" value="<?=$idk?>">
                                                            <button type="submit" class="btn btn-primary" name="updatebarangkeluar">Submit</button>
                                                        </div>
                                                    </form>  
                                                </div>
                                                </div>
                                            </div>

                                             <!-- Delete Modal -->
                                             <div class="modal fade" id="delete<?=$idk;?>">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                
                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                    <h4 class="modal-title">Hapus Barang?</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    
                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            Apakah anda yakin ingin menghapus <?=$namabarang?>?
                                                            <input type="hidden" name="idb" value="<?=$idb?>">
                                                            <input type="hidden" name="kty" value="<?=$qty?>">
                                                            <input type="hidden" name="idk" value="<?=$idk?>">
                                                            <br>
                                                            <br>
                                                            <button type="submit" class="btn btn-danger" name="hapusbarangkeluar">Hapus</button>
                                                        </div>
                                                    </form>  
                                                </div>
                                                </div>
                                            </div>

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
          <h4 class="modal-title">Tambah Barang Keluar</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <form method="post">
            <div class="modal-body">
            <select name="barangnya" class=form-control>
                    <?php
                        $ambilsemuanyadata = mysqli_query($conn, "select * from stock");
                        while($fetcharray = mysqli_fetch_array($ambilsemuanyadata)){
                            $namabarangnya = $fetcharray['namabarang'];
                            $idbarangnya = $fetcharray['idbarang'];
                        
                    ?>

                    <option value="<?=$idbarangnya?>"><?=$namabarangnya?></option>

                    <?php
                        }
                    ?>
                </select>
                <br>
                <input type="number" name="qty" placeholder="Quantity" class="form-control" required>
                <br>
                <input type="text" name="kondisi" placeholder="Kondisi" class="form-control" required>
                <br>
                <input type="text" name="penerima" placeholder="Penerima" class="form-control" required>
                <br>
                <input type="text" name="petugas" placeholder="Petugas" class="form-control" required>
                <br>
                <button type="submit" class="btn btn-primary" name="barangkeluar">Submit</button>
            </div>
        </form>  
      </div>
    </div>
  </div>
</html>
