<div class="main-content">
<div class="main-content-inner">
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="./">Beranda</a>
            </li>
            <li class="active">Komposisi Produk</li>
        </ul><!-- /.breadcrumb -->
    </div>

    <div class="page-content">
        
        <div class="page-header">
            <h1>
                Komposisi Produk 
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
                
                <div id="" class="collapse tampil_komposisi">
                    <div class="well">
                    Komposisi Produk
                    <button data-toggle="collapse" data-target=".tampil_komposisi" class="btn btn-sm"><i class="ace-icon fa fa-close bigger-110"></i> Tutup</button>
                
                    </div>
                </div>

                <div id="" class="collapse tampil">
                    <div class="well">
                        <form action="../action/komposisi.php" method="post" class="myform">
                            
                            <!-- hidden status -->
                            <input type="hidden" name="status" value="0" class="form-control" placeholder="" readonly>

                            <table class="table table-renponsive">
                                <caption>Masukkan Data Produk:</caption>
                                <tr>
                                    <td width="15%">Produk</td>
                                    <td>
                                        <select name="id_produk" class="form-control select2" required>
                                            <?php
                                            // retrieve data dari API
                                            $file = file_get_contents($url_api."tampilkan_data_produk.php");
                                            $json = json_decode($file, true);
                                            $i=0;
                                            while ($i < count($json['data'])) {
                                                $id_produk[$i] = $json['data'][$i]['id_produk'];
                                                $nama_produk[$i] = $json['data'][$i]['id_produk'].' - '.$json['data'][$i]['nama_produk'];
                                                ?>
                                                <option value="<?= $id_produk[$i] ?>"> <?= $nama_produk[$i] ?></option>
                                                <?php
                                                $i++;
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="15%">Bahan yang digunakan</td>
                                    <td>
                                        <select name="id_bahan_baku[]" class="form-control multiselect" multiple="" required>
                                            <?php
                                            // retrieve data dari API
                                            $file = file_get_contents($url_api."tampilkan_data_bahan_baku.php");
                                            $json = json_decode($file, true);
                                            $i=0;
                                            while ($i < count($json['data'])) {
                                                $id_bahan_baku[$i] = $json['data'][$i]['id_bahan_baku'];
                                                $nama_bahan_baku[$i] = $json['data'][$i]['id_bahan_baku'].' - '.$json['data'][$i]['nama_bahan_baku'];
                                                ?>
                                                <option value="<?= $id_bahan_baku[$i] ?>"> <?= $nama_bahan_baku[$i] ?></option>
                                                <?php
                                                $i++;
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div class="btn-group">
                                            <button type="submit" class="btn btn-sm btn-inverse"><i class="ace-icon fa fa-arrow-right bigger-120"></i> Selanjutnya</button>
                                            <button type="reset" class="btn btn-sm btn-default"><i class="ace-icon fa fa-refresh bigger-120"></i> Reset</button>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </form> 
                        
                        <div class="collapse" id="selanjutnya">
                            <form action="../action/komposisi.php" method="post" class="myform2">

                                <!-- hidden status -->
                                <input type="hidden" name="status" value="1" class="form-control" placeholder="" readonly>

                                <!-- tabel komposisi -->
                                <div class="table-header">
                                    Bahan Baku yang digunakan:
                                </div>
                                <div class="table table-responsive">
                                    <table id="komposisitable" class="display" width="100%" cellspacing="0">
                                        <thead>
                                            <tr class="">
                                                <th width="20%" class="text-left">ID Bahan</th>
                                                <th width="20%" class="text-left">Takaran</th>
                                                <th width="30%" class="text-left"></th>
                                                <th width="30%" class="text-left"></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3">
                                                    <button type="submit" class="btn btn-sm btn-primary"><i class="ace-icon fa fa-save bigger-120"></i> Simpan</button>
                                                    <a href="../action/unset_session_komposisi.php" class="btn btn-sm btn-danger"><i class="ace-icon fa fa-close bigger-120"></i> Batalkan</a>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                
                <!-- loading -->
                <center><div id="loading"></div></center>
                <div id="result"></div>
                
                <div id="tableproduk">
                    <div class="clearfix">
                        <div class="pull-right tableTools-container"></div>
                    </div>
                    <div class="table-header">
                        Cek "Komposisi Produk"
                    </div>
                    <!-- div.table-responsive -->

                    <!-- div.dataTables_borderWrap -->
                    <div class="table table-responsive">
                        <table id="mytable" class="display" width="100%" cellspacing="0">
                            <thead>
                                <tr class="">
                                    <th width="5%" class="text-center">No</th>
                                    <th width="10%" class="text-center">Gambar</th>
                                    <th width="10%" class="text-left">ID</th>
                                    <th width="20%" class="text-left">Nama</th>
                                    <th width="10%" class="text-left">Jenis</th>
                                    <th width="12%" class="text-left"></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
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
        <form method="post" action="../action/komposisi.php" class="myform">
            <div class="modal-body">
                <input type="hidden" name="hapus" value="1" readonly>
                <input type="hidden" name="id_produk" readonly>
                <p>Apakah anda akan menghapus data komposisi produk ini?</p>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</button>
            </div>
        </form>    
    </div>
</div>
</div>
        
<script>
function ubah(id_produk, id_bahan_baku, takaran){
    $('.well input[name=id_produk]').val(id_produk);
    $('.well input[name=id_bahan_baku]').val(id_bahan_baku);
    $('.well input[name=takaran]').val(takaran);
}

function tampil_komposisi(id_produk){
    
}

function hapus(id_produk){
    $('.modal-body input[name=id_produk]').val(id_produk);
}

// LOADING SCREEN WHILE PROCESS SAVING/UPDATE/DELETE DATA 
$(document).ready(function(){

    $('#mytable').DataTable({
                "bProcessing": true,
                "sAjaxSource": "<?php echo $base_url.'action/tampilkan_data_produk.php' ?>",
                "deferRender": true,
                "select": true,
                //"dom": 'Bfrtip',
                //"scrollY": "300",
                //"order": [[ 4, "desc" ]],
                 "aoColumns": [
                        { mData: 'no' } ,
                        { mData: 'gambar_produk' } ,
                        { mData: 'id_produk' } ,
                        { mData: 'nama_produk' } ,
                        { mData: 'jenis_produk' },
                        { mData: 'komposisi'}
                ]
    });

    $('#komposisitable').DataTable({
                "bProcessing": true,
                "sAjaxSource": "<?php echo $base_url.'action/tampilkan_data_komposisi.php' ?>",
                "deferRender": true,
                "select": true,
                //"dom": 'Bfrtip',
                //"scrollY": "300",
                //"order": [[ 4, "desc" ]],
                 "aoColumns": [
                        { mData: 'id_bahan_baku' } ,
                        { mData: 'takaran' },
                        { mData: 'input_id_produk' },
                        { mData: 'input_id_bahan_baku' }
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
                $('#komposisitable').DataTable().ajax.reload();
                $("#tableproduk").hide();
                $("#selanjutnya").collapse();
        },
            error: function(jqXHR, textStatus, errorThrown){
        }         
    });
        e.preventDefault(); //Prevent Default action.
        e.unbind();
    });    

    $(".myform2").submit(function(e)
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
                $("#selanjutnya").hide();
                $("#tableproduk").show();
        },
            error: function(jqXHR, textStatus, errorThrown){
        }         
    });
        e.preventDefault(); //Prevent Default action.
        e.unbind();
    });    

});
</script>





