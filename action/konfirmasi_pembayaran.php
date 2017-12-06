<?php  
// buka koneksi
require_once '../config/connection.php';

$nomor_faktur = mysqli_escape_string($conn, trim($_POST['nomor_faktur']));
$tanggal_pembayaran = mysqli_escape_string($conn, trim($_POST['tanggal_pembayaran']));
$status_pembayaran = 1;
$imgFile = $_FILES['bukti_pembayaran']['name'];
$tmp_dir = $_FILES['bukti_pembayaran']['tmp_name'];
$imgSize = $_FILES['bukti_pembayaran']['size'];
  

if($_FILES['bukti_pembayaran']['name']==''){
    $valid = false;
}else{
    $valid = true;
}

if($valid==true){
    
    $upload_dir = '../assets/bukti-pembayaran/'; // upload directory
   
    $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension

    // valid image extensions
    $valid_extensions = array('jpeg', 'jpg', 'png', 'rar', 'zip'); // valid extensions

    // rename uploading image
    $file_transfer = rand(1000,1000000).".".$imgExt;
    
    // allow valid image file formats
    if(in_array($imgExt, $valid_extensions)){   
        // Check file size '25MB'
        if($imgSize < 25000000)    {
            move_uploaded_file($tmp_dir,$upload_dir.$file_transfer);
        }else{
            $pesan_gagal = "Maaf, ukuran file terlalu besar.";
        }
    }else{
        $pesan_gagal = "Maaf, hanya JPG, JPEG, PNG yang diperbolehkan.";  
    }
      
    // if no error occured, continue ....
    if(!isset($pesan_gagal)){
        
        $sql = "UPDATE pemesanan_produk 
                SET tanggal_pembayaran = '$tanggal_pembayaran', bukti_pembayaran= '$file_transfer', status_pembayaran = '$status_pembayaran'
                WHERE nomor_faktur = '$nomor_faktur'
        ";
        if (mysqli_query($conn, $sql)) {
            $pesan_berhasil = "Konfirmasi pembayaran telah dikirim";
        } else {
            $pesan_gagal = "Konfirmasi gagal dikirim";
        }
    }
} 
  
if (isset($pesan_berhasil)) {
    ?>
    <script type="text/javascript">
        $(function(){
            $.gritter.add({
                // (string | mandatory) the heading of the notification
                title: 'Sukses!',
                // (string | mandatory) the text inside the notification
                text: '<?= $pesan_berhasil ?>',
                // (string | optional) the image to display on the left
                image: 'assets/images/berhasil.png',
                // (bool | optional) if you want it to fade out on its own or just sit there
                sticky: false,
                // (int | optional) the time you want it to be alive for before fading out
                time: ''
            });
        });
    </script>
    <?php
}else if(isset($pesan_gagal)){
    ?>
    <script type="text/javascript">
	    $(function(){
            $.gritter.add({
                // (string | mandatory) the heading of the notification
                title: 'Gagal!',
                // (string | mandatory) the text inside the notification
                text: '<?= $pesan_gagal ?>',
                // (string | optional) the image to display on the left
                image: 'assets/images/gagal.png',
                // (bool | optional) if you want it to fade out on its own or just sit there
                sticky: false,
                // (int | optional) the time you want it to be alive for before fading out
                time: ''
	        });
        });
	</script>
    <?php
}
?>