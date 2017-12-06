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
                        Pengolahan Data
                    </small>
                </h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->

                    <div id="" class="collapse tampil_detail">
                        <div class="well">
                        Detail Pemesanan
                        <button data-toggle="collapse" data-target=".tampil_detail" class="btn btn-sm"><i class="ace-icon fa fa-close bigger-110"></i> Tutup</button>
                    
                        </div>
                    </div>

                    <div class="clearfix">
                        <div class="pull-right tableTools-container"></div>
                    </div>
                    <div class="table-header">
                        Daftar data "Pemesanan Produk"
                    </div>
                    <!-- div.table-responsive -->

                    <!-- div.dataTables_borderWrap -->
                    <div class="table table-responsive">
                        <table id="mytable" class="display" width="100%" cellspacing="0">
                            <thead>
                                <tr class="">
                                    <th width="5%" class="text-center">No</th>
                                    <th width="15%" class="text-left">Nomor Faktur</th>
                                    <th width="10%" class="text-left">Pelanggan</th>
                                    <th width="10%" class="text-left">Pegawai</th>
                                    <th width="15%" class="text-left">Status Pemesanan</th>
                                    <th width="15%" class="text-left">Tgl Pemesanan</th>
                                    <th width="15%" class="text-left">Tgl Pembayaran</th>
                                    <th width="5%" class="text-left"></th>
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
            
<script>
    function detail(nomor_faktur){

    }
    
    // LOADING SCREEN WHILE PROCESS SAVING/UPDATE/DELETE DATA 
    $(document).ready(function(){

        $('#mytable').DataTable({
                    "bProcessing": true,
                    "sAjaxSource": "<?php echo $base_url.'action/tampilkan_data_pemesanan_produk.php' ?>",
                    "deferRender": true,
                    "select": true,
                    //"dom": 'Bfrtip',
                    //"scrollY": "300",
                    //"order": [[ 4, "desc" ]],
                     "aoColumns": [
                            { mData: 'no' } ,
                            { mData: 'nomor_faktur' } ,
                            { mData: 'id_pelanggan' } ,
                            { mData: 'id_pegawai' },
                            { mData: 'status_pemesanan' },
                            { mData: 'tanggal_pemesanan' },
                            { mData: 'tanggal_pembayaran' },
                            { mData: 'action' }
                    ],
                    "aoColumnDefs": [
                        { sClass: "dt-center", "aTargets": [0,3,4] },
                        { sClass: "dt-nowrap", "aTargets": [0,1,2] }
                    ]
        });

    });
</script>





