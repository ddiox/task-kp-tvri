<?php

require "function.php";
require "check.php";

?>
<html>
<head>
  <title>Export Barang Keluar</title>
  <link rel="stylesheet" href="assets/bootstrap-4.5.3-dist/css/bootstrap.min.css">
  <script src="assets/js/jquery-3.5.1.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/bootstrap-4.5.3-dist/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="assets/DataTables/DataTables-1.10.24/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="assets/css/buttons.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="assets/DataTables/DataTables-1.10.24/css/jquery.dataTables.min.css">
  <script type="text/javascript" charset="utf8" src="assets/DataTables/DataTables-1.10.24/js/jquery.dataTables.js"></script>
</head>

<body>
<div class="container">
			<h2>Barang Keluar</h2>
            <a href="keluar.php" class="btn btn-info">Kembali</a>
			<h4>(Inventory)</h4>
				<div class="data-tables datatable-dark">
					
                <table class="table table-bordered" id="mauexportkeluar" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Kondisi</th>
                                                <th>Penerima</th>
                                                <th>Petugas</th>
                                                <th>Qty</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $ambildatastock = mysqli_query($conn, "select * from keluar");
                                        $i = 1;
                                        while($data=mysqli_fetch_array($ambildatastock)){
                                            $tanggal= $data['tanggal'];
                                            $kondisi = $data['kondisi'];
                                            $penerima = $data['penerima'];
                                            $petugas = $data['petugas'];
                                            $qty = $data['qty'];
                                            $idk = $data['idkeluar'];

                                        ?>
                                            <tr>
                                                <td><?=$i++;?></td>
                                                <td><?php echo $tanggal?></td>
                                                <td><?php echo $kondisi?></td>
                                                <td><?php echo $penerima?></td>
                                                <td><?php echo $petugas?></td>
                                                <td><?php echo $qty?></td>
                                            </tr>
                                            
                                        <?php
                                        };
                                        ?>
                                        </tbody>
                                    </table>
					
				</div>
</div>
	
<script>
$(document).ready(function() {
    $('#mauexportkeluar').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy','csv','excel', 'pdf', 'print'
        ]
    } );
} );

</script>

<script src="assets/js/jquery-3.5.1.js"></script>
<script src="assets/DataTables/DataTables-1.10.24/js/jquery.dataTables.min.js"></script>
<script src="assets/js/dataTables.buttons.min.js"></script>
<script src="assets/js/buttons.flash.min.js"></script>
<script src="assets/js/jszip.min.js"></script>
<script src="assets/js//pdfmake.min.js"></script>
<script src="assets/js/vfs_fonts.js"></script>
<script src="assets/js/buttons.html5.min.js"></script>
<script src="assets/js/buttons.print.min.js"></script>

</body>

</html>