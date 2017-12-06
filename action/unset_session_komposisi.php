<?php
session_start();

// unset session
for ($i=0; $i <= count($_SESSION['id_bahan_baku'])+1; $i++) { 
    unset($_SESSION['id_bahan_baku'][$i]);
}
unset($_SESSION['id_produk']);
header('location:../admin/index.php?menu=komposisi');
?>