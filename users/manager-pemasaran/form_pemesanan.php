<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="./">Beranda</a>
                </li>
                <li class="active">Pemesanan Produk</li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">

            <div class="page-header">
                <h1>
                    Pemesanan Produk
                    <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        Form Pemesanan
                    </small>
                </h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <button type="button" name="add" id="add" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Tambah Item</button>
                    <form action="../action/order_produk.php" method="post" class="myform">

                        <!-- hidden status hapus false -->
                        <input type="hidden" name="hapus" value="0" class="form-control" placeholder="" readonly>

                        <table class="table table-renponsive">
                            <h4><caption>Masukkan Data Order:</caption></h4>
                            <tr>
                                <th width="20%">Nama Pelanggan :</th>
                                <th colspan="2">
                                    <select name="id_pelanggan" class="form-control select2" required>
                                        <?php
                                        // retrieve data dari API
                                        $file = file_get_contents($url_api."tampilkan_data_pelanggan.php");
                                        $json = json_decode($file, true);
                                        $i=0;
                                        while ($i < count($json['data'])) {
                                            $id_pelanggan[$i] = $json['data'][$i]['id_pelanggan'];
                                            $nama_pelanggan[$i] = $json['data'][$i]['nama_pelanggan'];
                                            ?>
                                            <option value="<?= $id_pelanggan[$i] ?>"> <?= $nama_pelanggan[$i] ?></option>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </select>
                                </th>
                            </tr>
                            <tr>
                                <th width="20%">Produk</th>
                                <th width="60%">Qty</th>
                                <th width="5%"></th>
                            </tr>
                        </table>

                        <div class="modal fade" id="konfirmasi_checkout" role="dialog">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header bg-red">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title"><i class="fa fa-question"></i> Konfirmasi Pesanan</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>Apakah anda yakin?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-shopping-cart"></i> Checkout</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <table class="table table-renponsive" id="dynamic_field">
                            <tr>
                                <td colspan="3">
                                    <div class="btn-group">
                                        <a data-toggle="modal" data-target="#konfirmasi_checkout" class="btn btn-sm btn-success"><i class="ace-icon fa fa-shopping-cart bigger-120"></i> Checkout</a>
                                        <a data-toggle="modal" data-target="#batalkan" class="btn btn-sm btn-danger"><i class="ace-icon fa fa-refresh bigger-120"></i> Batal</a>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </form>

                    <!-- loading -->
                    <center><div id="loading"></div></center>
                    <div id="result"></div>

                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->

<div class="modal fade" id="batalkan" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header red">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-question"></i> Konfirmasi</h4>
            </div>
            <div class="modal-body">
                <p>Batalkan pesanan?</p>
            </div>
            <div class="modal-footer">
                <a href="index.php?menu=pemesanan" class="btn btn-sm btn-danger"><i class="ace-icon fa fa-refresh bigger-120"></i> Batalkan</a>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function(){
        $("#dynamic_field").hide();
        $("#add").click(function(){
            $("#dynamic_field").show();
        });

        var i = 1;
        $('#add').click(function(){
            i++;
            $('#dynamic_field').prepend(
                '<tr id="row'+i+'">' +
                '<td width="20%">' +
                    '<select name="id_produk[]" class="form-control select2" required>' +
                        <?php
                        // retrieve data dari API
                        $file = file_get_contents($url_api."tampilkan_data_produk.php");
                        $json = json_decode($file, true);
                        $i=0;
                        while ($i < count($json['data'])) {
                            $id_produk[$i] = $json['data'][$i]['id_produk'];
                            $nama_produk[$i] = $json['data'][$i]['id_produk'].' - '.$json['data'][$i]['nama_produk'];
                            ?>
                            '<option value="<?= $id_produk[$i] ?>" <?php if(isset($_GET['id'])){ if($_GET['id']==$id_produk[$i]) echo 'selected'; } ?>> <?= $nama_produk[$i] ?></option>'+
                            <?php
                            $i++;
                        }
                        ?>
                    '</select>' +
                '</td>' +
                '<td width="60%">' +
                    '<input type="text" name="jumlah_pemesanan[]" id="jumlah_pemesanan" value="" class="form-control" min="1" required>' +
                '</td>' +
                '<td width="5%"><button name="remove" id="'+i+'" class="btn btn-sm btn-danger btn_remove">X</button></td></tr>');
        });

        $(document).on('click','.btn_remove', function(){
            var button_id = $(this).attr("id");
            $("#row"+button_id+"").remove();
        });

        //Callback handler for form submit event
        $(".myform").submit(function(e)
        {

        var formObj = $(this);
        var formURL = formObj.attr("action");
        var formData = new FormData(this);
        $.ajax({
            url: formURL,
            type: 'POST',
            data:  formData,
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function (){
                       $("#loading").show(1000).html("<img src='../assets/images/loading.gif' height='100'>");
                       },
            success: function(data, textStatus, jqXHR){
                    $("#result").html(data);
                    $("#loading").hide();
                    $("#konfirmasi_checkout").modal('hide');

                    setTimeout(
                        function()
                        {
                            $(location).attr('href', 'index.php?menu=pemesanan');
                        }, 1500);
            },
                error: function(jqXHR, textStatus, errorThrown){
         }
        });
            e.preventDefault(); //Prevent Default action.
            e.unbind();
        });

    });

</script>
