<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="./">Beranda</a>
                </li>
                <li class="active">Pemesanan Bahan Baku</li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">

            <div class="page-header">
                <h1>
                    Pemesanan Bahan Baku
                    <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        Form Pemesanan
                    </small>
                </h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->

                    <form action="../action/order_bahan_baku.php" method="post" class="myform">

                        <!-- hidden status hapus false -->
                        <input type="hidden" name="hapus" value="0" class="form-control" placeholder="" readonly>

                        <table class="table table-renponsive">
                            <h4><caption>Masukkan Data Order:</caption></h4>
                            <tr>
                                <th width="20%">Bahan Baku</th>
                                <th width="60%">Qty</th>
                                <th width="5%"></th>
                            </tr>
                            <tr>
                                <td>
                                    <select name="id_bahan_baku" class="form-control select2" required>
                                        <option>Pilih Barang</option>
                                        <?php
                                        // retrieve data dari API
                                        $file = file_get_contents($url_api."tampilkan_data_bahan_baku.php");
                                        $json = json_decode($file, true);
                                        $i=0;
                                        while ($i < count($json['data'])) {
                                            $id_bahan_baku[$i] = $json['data'][$i]['id_bahan_baku'];
                                            $nama_bahan_baku[$i] = $json['data'][$i]['id_bahan_baku'].' - '.$json['data'][$i]['nama_bahan_baku'];
                                            ?>
                                            <option value="<?= $id_bahan_baku[$i] ?>" <?php if(isset($_GET['id'])){ if($_GET['id']==$id_bahan_baku[$i]) echo 'selected'; } ?>> <?= $nama_bahan_baku[$i] ?></option>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="jumlah_pemesanan" id="jumlah_pemesanan" value="" class="form-control" min="1" required>
                                </td>
                                <td><i class="fa fa-trash fa red" title="hapus"></i></td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <div class="btn-group">
                                        <button type="submit" class="btn btn-sm btn-primary"><i class="ace-icon fa fa-save bigger-120"></i> Order</button>
                                        <a href="index.php?menu=pemesanan" class="btn btn-sm btn-danger"><i class="ace-icon fa fa-refresh bigger-120"></i> Batal</a>
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

<!-- Modal Hapus -->
<div class="modal fade" id="hapus" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-trash"></i> Hapus Data</h4>
            </div>
            <form method="post" action="../action/pemesanan_bahan_baku.php" class="myform">
                <div class="modal-body">
                    <input type="hidden" name="hapus" value="1" readonly>
                    <input type="hidden" name="nomor_faktur" readonly>
                    <p>Apakah anda akan menghapus data pemesanan ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

    function hapus(nomor_faktur){
        $('.modal-body input[name=nomor_faktur]').val(nomor_faktur);
    }

    // LOADING SCREEN WHILE PROCESS SAVING/UPDATE/DELETE DATA
    $(document).ready(function(){

        $('#mytable').DataTable({
                    "bProcessing": true,
                    "sAjaxSource": "<?php echo $base_url.'action/tampilkan_data_pemesanan_bahan_baku.php' ?>",
                    "deferRender": true,
                    "select": true,
                    //"dom": 'Bfrtip',
                    //"scrollY": "300",
                    //"order": [[ 4, "desc" ]],
                     "aoColumns": [
                            { mData: 'no' } ,
                            { mData: 'nomor_faktur' } ,
                            { mData: 'id_supplier' } ,
                            { mData: 'id_pegawai' },
                            { mData: 'status_pemesanan' },
                            { mData: 'tanggal_pemesanan' },
                            { mData: 'action' }
                    ],
                    "aoColumnDefs": [
                        { sClass: "dt-center", "aTargets": [0,3,4] },
                        { sClass: "dt-nowrap", "aTargets": [0,1,2] }
                    ]
        });

    });
</script>
