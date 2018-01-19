<?php
// buka koneksi
require_once '../config/connection.php';

$id_produk          = strtoupper(mysqli_escape_string($conn, trim($_POST['id_produk'])));
$nama_file        = mysqli_escape_string($conn, trim($_POST['nama_file']));
$imgFile = $_FILES['gambar_produk']['name'];
$tmp_dir = $_FILES['gambar_produk']['tmp_name'];
$imgSize = $_FILES['gambar_produk']['size'];


if($_FILES['gambar_produk']['name']==''){
    $valid = false;
}else{
    $valid = true;
}

if($valid==true){

    $upload_dir = '../assets/images/'; // upload directory

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

            // hapus gambar sebelumnya
            if (file_exists($upload_dir ."". $nama_file) AND $nama_file!='produk.jpg')
    		{
    		    unlink($upload_dir ."". $nama_file);
    		}
        }else{
            $pesan_gagal = "Maaf, ukuran file terlalu besar.";
        }
    }else{
        $pesan_gagal = "Maaf, hanya JPG, JPEG, PNG yang diperbolehkan.";
    }

    // if no error occured, continue ....
    if(!isset($pesan_gagal)){

        $sql = "UPDATE produk
                SET gambar_produk= '$file_transfer'
                WHERE id_produk = '$id_produk'
        ";
        if (mysqli_query($conn, $sql)) {
            $pesan_berhasil = "Gambar menu telah diperbaharui";
        } else {
            $pesan_gagal = "Gambar menu gagal diperbaharui";
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
                image: '../assets/images/berhasil.png',
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
                image: '../assets/images/gagal.png',
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
