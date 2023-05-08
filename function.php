<?php

session_start();

// Membuat koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "inventori");

// Menambah Barang Baru
if(isset($_POST['addnewbarang'])){
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];

    //soal gambar
    $allowed_extension = array('png','jpg');
    $nama = $_FILES['file']['name']; //ambil nama file gambar
    $dot = explode('.',$nama);
    $ekstensi = strtolower(end($dot)); //ambil ekstensinya
    $ukuran = $_FILES['file']['size']; //ambil size
    $file_tmp = $_FILES['file']['tmp_name']; //ambil lokasi file

    //Penamaan File -> Enkripsi
    $image = md5(uniqid($nama,true) . time()).'.'.$ekstensi; //menggabungkan nama file yang dienkripsi dengan ekstensinya

    //validasi sudah ada atau belum
        $cek = mysqli_query($conn,"select * from stock where namabarang = '$namabarang'");
        $hitung = mysqli_num_rows($cek);

        if($hitung<1){
            //jika belum ada 

        //proses upload gambar
        if(in_array($ekstensi, $allowed_extension) === true){
            //validasi ukuran files
            if($ukuran < 15000000){
                move_uploaded_file($file_tmp, 'images/'.$image);

                $addtotable = mysqli_query($conn, "insert into stock (namabarang, deskripsi, stock, Image) values('$namabarang', '$deskripsi', '$stock' , '$image')");
                if($addtotable){
                    header("location: index.php");
                } else {
                    echo "Gagal";
                    header("location: index.php");
                }
            } else {
                //kalau filenya lbih dari 1.5 mb
                echo '
            <script>
                alert("Ukuran Terlalu Besar");
                windows.location.href="index.php";
                </script> 
                ';
            }
        } else{ //kalau filenya tidak jpg atau png
            echo '
            <script>
                alert("File harus Png/Jpg");
                windows.location.href="index.php";
                </script> 
                ';

            
}
            
        }
        

        

   
   
}

// Menambah Barang Masuk
if(isset($_POST['barangmasuk'])){
    $barangnya = $_POST['barangnya'];
    $kondisi = $_POST['kondisi'];
    $petugas = $_POST['petugas'];
    $qty = $_POST['qty'];

    $checkstock = mysqli_query($conn, "select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($checkstock);
    $stocksekarang = $ambildatanya['stock'];

    $penambahanstock = $stocksekarang+$qty;

    $addtomasuk = mysqli_query($conn, "insert into masuk(idbarang, kondisi, petugas, qty) values('$barangnya', '$kondisi', '$petugas', '$qty')");
    $updatestockmasuk = mysqli_query($conn, "update stock set stock='$penambahanstock' where idbarang='$barangnya'");

    if($addtomasuk && $updatestockmasuk){
        header("location: masuk.php");
    } else {
        echo "Gagal";
        header("location: masuk.php");
    }
}

// Menambah Barang Keluar
if(isset($_POST['barangkeluar'])){
    $barangnya = $_POST['barangnya'];
    $kondisi = $_POST['kondisi'];
    $penerima = $_POST['penerima'];
    $petugas= $_POST['petugas'];
    $qty = $_POST['qty'];

    $checkstock = mysqli_query($conn, "select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($checkstock);
    $stocksekarang = $ambildatanya['stock'];

    if($stocksekarang >= $qty){ // kalau barangnya cukup
        $penambahanstock = $stocksekarang-$qty;

        $addtokeluar = mysqli_query($conn, "insert into keluar(idbarang, kondisi, penerima, petugas, qty) values('$barangnya', '$kondisi', '$penerima', '$petugas', '$qty')");
        $updatestockmasuk = mysqli_query($conn, "update stock set stock='$penambahanstock' where idbarang='$barangnya'");

        if($addtokeluar && $updatestockmasuk){
            header("location: keluar.php");
        } else {
            echo "Gagal";
            header("location: keluar.php");
        }
    } else { // kalau barang tidak cukup
        echo '
        <>
            alert("Stock saat ini tidak mencukupi");
            window.location.href="keluar.php";
        </>
        ';
    }
}

// Update info barang
if(isset($_POST['updatebarang'])){
    $idb = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
     $deskripsi = $_POST['deskripsi'];

    
        //soal gambar
        $allowed_extension = array('png','jpg');
        $nama = $_FILES['file']['name']; //ambil nama file gambar
        $dot = explode('.',$nama);
        $ekstensi = strtolower(end($dot)); //ambil ekstensinya
        $ukuran = $_FILES['file']['size']; //ambil size
        $file_tmp = $_FILES['file']['tmp_name']; //ambil lokasi file
    
        //Penamaan File -> Enkripsi
        $image = md5(uniqid($nama,true) . time()).'.'.$ekstensi; //menggabungkan nama file yang dienkripsi dengan ekstensinya

        if($ukuran==0){
            //jika tidak ingin upload
            $update = mysqli_query($conn, "update stock set namabarang='$namabarang', deskripsi='$deskripsi' where idbarang='$idb'");
            if($update){
                header("location: index.php");
            } else {
                echo 'Gagal';
                header("location: index.php");
            }
        }else{
            //jika ingin
            move_uploaded_file($file_tmp, 'images/'.$image);    
            $update = mysqli_query($conn, "update stock set namabarang='$namabarang', deskripsi='$deskripsi', Image='$image' where idbarang='$idb'");
    
            if($update){    
                header("location: index.php");
            } else {
                echo 'Gagal';
                header("location: index.php");
            }
        }
}

// Hapus barang dari stock
if(isset($_POST['hapusbarang'])){
    $idb = $_POST['idb']; //id barang

    $gambar = mysqli_query($conn, "select * from stock where idbarang ='$idb'");
    $get = mysqli_fetch_array($gambar);
    $img ='images/'.$get['Image'];
    unlink($img);

    $hapus = mysqli_query($conn, "delete from stock where idbarang ='$idb'");
   
    if($hapus){
        header("location: index.php");
    } else {
        echo "Gagal";
        header("location: index.php");
    }
}

// Mengubah barang masuk
if(isset($_POST['updatebarangmasuk'])){
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $deskripsi = $_POST['kondisi'];
    $petugas = $_POST['petugas'];
    $qty = $_POST['qty'];

    $lihaststock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihaststock);
    $stockskrg = $stocknya['stock'];

    $qtyskrg = mysqli_query($conn, "select * from masuk where idmasuk='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if($qty>$qtyskrg){
        $selisih = $qty - $qtyskrg;
        $kurangin = $stockskrg + $selisih;
        $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update masuk set qty='$qty', kondisi='$deskripsi', petugas='$petugas' where idmasuk='$idm'");
        if($kuranginstocknya && $updatenya){
            header("location: masuk.php");
        } else {
            echo "Gagal";
            header("location: masuk.php");
        }
    } else {
        $selisih = $qtyskrg - $qty;
        $kurangin = $stockskrg - $selisih;
        $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update masuk set qty='$qty', kondisi='$deskripsi', petugas='$petugas' where idmasuk='$idm'");
        if($kuranginstocknya && $updatenya){
            header("location: masuk.php");
        } else {
            echo "Gagal";
            header("location: masuk.php");
        }
    }
}

// Menghapus barang masuk
if(isset($_POST['hapusbarangmasuk'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok - $qty;

    $update = mysqli_query($conn, "update stock set stock='$selisih' where idbarang ='$idb'");
    $hapusdata = mysqli_query($conn, "delete from masuk where idmasuk='$idm'");
    
    if($update && $hapusdata){
        header("location: masuk.php");
    } else {
        echo "Gagal";
        header("location: masuk.php");
    }
}

// Mengubah barang keluar
if(isset($_POST['updatebarangkeluar'])){
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $kondisi = $_POST['kondisi'];
    $penerima = $_POST['penerima'];
    $petugas = $_POST['petugas'];
    $qty = $_POST['qty'];

    $lihaststock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihaststock);
    $stockskrg = $stocknya['stock'];

    $qtyskrg = mysqli_query($conn, "select * from keluar where idkeluar='$idk'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if($qty>$qtyskrg){
        $selisih = $qty - $qtyskrg;
        $kurangin = $stockskrg - $selisih;
        $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update keluar set qty='$qty', kondisi='$kondisi', penerima='$penerima', petugas='$petugas' where idkeluar='$idk'");
        
        if($kuranginstocknya && $updatenya){
            header("location: keluar.php");
        } else {
            echo "Gagal";
            header("location: keluar.php");
        }
    } else {
        $selisih = $qtyskrg - $qty;
        $kurangin = $stockskrg + $selisih;
        $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update keluar set qty='$qty', kondisi='$kondisi', penerima='$penerima', petugas='$petugas' where idkeluar='$idk'");
        
        if($kuranginstocknya && $updatenya){
            header("location: keluar.php");
        } else {
            echo "Gagal";
            header("location: keluar.php");
        }
    }
}

// Menghapus barang keluar
if(isset($_POST['hapusbarangkeluar'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idk = $_POST['idk'];

    $getdatastock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok + $qty;

    $update = mysqli_query($conn, "update stock set stock='$selisih' where idbarang ='$idb'");
    $hapusdata = mysqli_query($conn, "delete from keluar where idkeluar='$idk'");
    
    if($update && $hapusdata){
        header("location: keluar.php");
    } else {
        echo "Gagal";
        header("location: keluar.php");
    }
}

// Menambah admin
if(isset($_POST['add'])){
    $email = $_POST['email'];
    $password = sha1($_POST['password']);

    $queryinsert = mysqli_query($conn, "insert into login (email, password) values('$email', '$password')");

    if($queryinsert){
        header("location:admin.php");
    } else {
        header("location:admin.php");
    }
}

// Mengubah admin
if(isset($_POST['updateadmin'])){
    $emailbaru = $_POST['emailadmin'];
    $passwordbaru = sha1($_POST['passwordbaru']);
    $idnya = $_POST['id'];

    $queryupdate = mysqli_query($conn, "update login set email='$emailbaru', password='$passwordbaru' where iduser='$idnya'");

    if($queryupdate){
        header("location:admin.php");
    } else {
        header("location:admin.php");
    }
}

// Hapus admin
if(isset($_POST['hapusadmin'])){
    $id = $_POST['id'];

    $querydelete = mysqli_query($conn, "delete from login where iduser='$id'");

    if($querydelete){
        header("location:admin.php");
    } else {
        header("location:admin.php");
    }
}


?>