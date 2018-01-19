<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="./">Beranda</a>
                </li>
                <li class="active">Persediaan Bahan Baku</li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">

            <div class="page-header">
                <h1>
                    Persediaan Bahan Baku
                    <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        Pengolahan Data
                    </small>
                </h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->

                    <button data-toggle="collapse" data-target=".tampil" class="btn btn-sm"><i class="ace-icon fa fa-plus bigger-110"></i> Form</button>

                    <div id="" class="collapse tampil">
                        <div class="well">
                            <form action="../action/persediaan_bahan_baku.php" method="post" class="myform">

                                <!-- hidden status hapus false -->
                                <input type="hidden" name="hapus" value="0" class="form-control" placeholder="" readonly>

                                <table class="table table-renponsive">
                                    <caption>Masukkan Data Persediaan Bahan Baku:</caption>
                                    <tr>
                                        <td width="15%">Bahan Baku</td>
                                        <td>
                                            <select name="id_bahan_baku" id="id_bahan_baku" class="form-control select2" required>
                                                <?php
                                                // retrieve data dari API
                                                $file = file_get_contents($url_api."tampilkan_data_bahan_baku.php");
                                                $json = json_decode($file, true);
                                                $i=0;
                                                while ($i < count($json['data'])) {
                                                    $id_bahan_baku[$i] = $json['data'][$i]['id_bahan_baku'];
                                                    $nama_bahan_baku[$i] = $json['data'][$i]['id_bahan_baku'].' - '.$json['data'][$i]['nama_bahan_baku'];
                                                    $satuan[$i] = $json['data'][$i]['satuan'];
                                                    ?>
                                                    <option value="<?= $id_bahan_baku[$i] ?>"> <?= $nama_bahan_baku[$i].' (satuan: '.$satuan[$i].')' ?></option>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Stok Awal</td>
                                        <td><input type="number" name="stok_awal" value="" class="form-control" placeholder="" min="0" required></td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Jumlah Pembelian</td>
                                        <td><input type="number" name="jumlah_pembelian" value="" class="form-control" placeholder="" min="0" required></td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Jumlah Pemakaian</td>
                                        <td><input type="number" name="jumlah_pemakaian" value="" class="form-control" placeholder="" min="0" required></td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Tanggal</td>
                                        <td><input type="date" name="tanggal" id="tanggal" value="" class="form-control" placeholder="" required></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="btn-group">
                                                <button type="submit" class="btn btn-sm btn-primary"><i class="ace-icon fa fa-save bigger-120"></i> Simpan</button>
                                                <button type="reset" class="btn btn-sm btn-default"><i class="ace-icon fa fa-refresh bigger-120"></i> Reset</button>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div>

                    <!-- loading -->
                    <center><div id="loading"></div></center>
                    <div id="result"></div>

                    <div class="clearfix">
                        <div class="pull-right tableTools-container"></div>
                    </div>
                    <div class="table-header">
                        Daftar data "Persediaan Bahan Baku"
                    </div>
                    <!-- div.table-responsive -->

                    <!-- div.dataTables_borderWrap -->
                    <div class="table table-responsive">
                        <table id="mytable" class="display" width="100%" cellspacing="0">
                            <thead>
                                <tr class="">
                                    <th width="7%" class="text-center">No</th>
                                    <th width="20%" class="text-left">Bahan Baku</th>
                                    <th width="10%" class="text-left">Stok Awal</th>
                                    <th width="12%" class="text-left">Jumlah Pembelian</th>
                                    <th width="12%" class="text-center">Jumlah Pemakaian</th>
                                    <th width="15%" class="text-center">Tanggal</th>
                                    <th width="14%" class="text-center"></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
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
            <form method="post" action="../action/persediaan_bahan_baku.php" class="myform">
                <div class="modal-body">
                    <input type="hidden" name="hapus" value="1" readonly>
                    <input type="hidden" name="id_bahan_baku" readonly>
                    <input type="hidden" name="tanggal" readonly>
                    <p>Apakah anda akan menghapus data ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function ubah(id_bahan_baku, stok_awal, jumlah_pembelian, jumlah_pemakaian, tanggal){
        $('.well select[name=id_bahan_baku]').val(id_bahan_baku);
        $('.well input[name=stok_awal]').val(stok_awal);
        $('.well input[name=jumlah_pembelian]').val(jumlah_pembelian);
        $('.well input[name=jumlah_pemakaian]').val(jumlah_pemakaian);
        $('.well input[name=tanggal]').val(tanggal);
        $('#id_bahan_baku').prop('readonly', true);
        $('#tanggal').prop('readonly', true);
    }

    function hapus(id_bahan_baku, tanggal){
        $('.modal-body input[name=id_bahan_baku]').val(id_bahan_baku);
        $('.modal-body input[name=tanggal]').val(tanggal);
    }

    // LOADING SCREEN WHILE PROCESS SAVING/UPDATE/DELETE DATA
    $(document).ready(function(){

        $('#mytable').DataTable({
                    "bProcessing": true,
                    "sAjaxSource": "<?php echo $base_url.'action/tampilkan_data_persediaan_bahan_baku.php' ?>",
                    "deferRender": true,
                    "select": true,
                    //"dom": 'Bfrtip',
                    //"scrollY": "300",
                    //"order": [[ 4, "desc" ]],
                     "aoColumns": [
                            { mData: 'no' } ,
                            { mData: 'id_bahan_baku' } ,
                            { mData: 'stok_awal' } ,
                            { mData: 'jumlah_pembelian' },
                            { mData: 'jumlah_pemakaian' },
                            { mData: 'tanggal' },
                            { mData: 'action'}
                    ],
                    "aoColumnDefs": [
                        { sClass: "dt-center", "aTargets": [0,3,4,5] },
                        { sClass: "dt-nowrap", "aTargets": [0,1,2] }
                    ]
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
                    $("#hapus").modal('hide');
                    $('#mytable').DataTable().ajax.reload();
            },
                error: function(jqXHR, textStatus, errorThrown){
         }
        });
            e.preventDefault(); //Prevent Default action.
            e.unbind();
        });

    });
</script>
