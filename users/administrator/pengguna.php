<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="./">Beranda</a>
                </li>
                <li class="active">Pengguna</li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">

            <div class="page-header">
                <h1>
                    Pengguna
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
                            <form action="../action/pegawai.php" method="post" class="myform">

                                <!-- hidden status hapus false -->
                                <input type="hidden" name="hapus" value="0" class="form-control" placeholder="" readonly>

                                <table class="table table-renponsive">
                                    <caption>Masukkan Data Pengguna:</caption>
                                    <tr>
                                        <td width="15%">ID Pegawai</td>
                                        <td><input type="text" name="id_pegawai" value="" class="form-control" placeholder="ID akan dibuat secara otomatis" readonly></td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Nama Pegawai</td>
                                        <td><input type="text" name="nama_pegawai" value="" class="form-control" placeholder="" required></td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Alamat</td>
                                        <td><input type="text" name="alamat" value="" class="form-control" placeholder="" ></td>
                                    </tr>
                                    <tr>
                                        <td width="15%">No Telp</td>
                                        <td><input type="text" name="no_telp" value="" class="form-control" placeholder="" ></td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Email</td>
                                        <td><input type="email" name="email" value="" class="form-control" placeholder=""></td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Jabatan</td>
                                        <td>
                                            <select name="jabatan" class="form-control select" required>
                                                <option value="manager pemasaran">Manager Pemasaran</option>
                                                <option value="manager produksi">Manager Produksi</option>
                                                <option value="manager pembelian">Manager Pembelian</option>
                                                <option value="manager keuangan">Manager Keuangan</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Nama Pengguna</td>
                                        <td><input type="text" name="nama_pengguna" value="" class="form-control" placeholder="" required></td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Kata Sandi</td>
                                        <td><input type="password" name="kata_sandi" value="" class="form-control" placeholder="" required></td>
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
                        Daftar data "Pengguna"
                    </div>
                    <!-- div.table-responsive -->

                    <!-- div.dataTables_borderWrap -->
                    <div class="table table-responsive">
                        <table id="mytable" class="display" width="100%" cellspacing="0">
                            <thead>
                                <tr class="">
                                    <th width="7%" class="text-center">No</th>
                                    <th width="10%" class="text-left">ID</th>
                                    <th width="15%" class="text-left">Nama</th>
                                    <!-- <th width="15%" class="text-left">Alamat</th>
                                    <th width="15%" class="text-center">No Telp</th> -->
                                    <th width="15%" class="text-center">Email</th>
                                    <th width="20%" class="text-center">Jabatan</th>
                                    <th width="15%" class="text-center">Nama Pengguna</th>
                                    <th width="15%" class="text-center"></th>
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
            <form method="post" action="../action/pegawai.php" class="myform">
                <div class="modal-body">
                    <input type="hidden" name="hapus" value="1" readonly>
                    <input type="hidden" name="id_pegawai" readonly>
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
    function ubah(id_pegawai, nama_pegawai, alamat, no_telp, email, jabatan, nama_pengguna){
        $('.well input[name=id_pegawai]').val(id_pegawai);
        $('.well input[name=nama_pegawai]').val(nama_pegawai);
        $('.well input[name=alamat]').val(alamat);
        $('.well input[name=no_telp]').val(no_telp);
        $('.well input[name=email]').val(email);
        $('.well select[name=jabatan]').val(jabatan);
        $('.well input[name=nama_pengguna]').val(nama_pengguna);
    }

    function hapus(id_pegawai){
        $('.modal-body input[name=id_pegawai]').val(id_pegawai);
    }

    // LOADING SCREEN WHILE PROCESS SAVING/UPDATE/DELETE DATA
    $(document).ready(function(){

        $('#mytable').DataTable({
                    "bProcessing": true,
                    "sAjaxSource": "<?php echo $base_url.'action/tampilkan_data_pegawai.php' ?>",
                    "deferRender": true,
                    "select": true,
                    //"dom": 'Bfrtip',
                    //"scrollY": "300",
                    //"order": [[ 4, "desc" ]],
                     "aoColumns": [
                            { mData: 'no' } ,
                            { mData: 'id_pegawai' } ,
                            { mData: 'nama_pegawai' } ,
                            // { mData: 'alamat' },
                            // { mData: 'no_telp' },
                            { mData: 'email' },
                            { mData: 'jabatan' },
                            { mData: 'nama_pengguna' },
                            { mData: 'action'}
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
