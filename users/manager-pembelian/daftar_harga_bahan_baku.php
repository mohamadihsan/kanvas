<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="./">Beranda</a>
                </li>
                <li class="active">Bahan Baku</li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">

            <div class="page-header">
                <h1>
                    Bahan Baku
                    <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        Daftar Harga Bahan Baku
                    </small>
                </h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->

                    <div class="clearfix">
                        <div class="pull-left tableTools-container">
                            <a href="index.php?menu=form-pemesanan" class="btn btn-sm btn-info">Kembali ke Form Pemesanan</a>
                        </div>
                    </div>
                    <div class="table-header">
                        Daftar Harga Bahan Baku
                    </div>
                    <!-- div.table-responsive -->

                    <!-- div.dataTables_borderWrap -->
                    <div class="table table-responsive">
                        <table id="mytable" class="display" width="100%" cellspacing="0">
                            <thead>
                                <tr class="">
                                    <th width="7%" class="text-center">No</th>
                                    <th width="15%" class="text-left">Bahan Baku</th>
                                    <th width="20%" class="text-left">Supplier</th>
                                    <th width="10%" class="text-left">Harga</th>
                                    <th width="15%" class="text-center">Satuan</th>
                                    <th width="15%" class="text-center">Waktu Pegiriman</th>
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

    // LOADING SCREEN WHILE PROCESS SAVING/UPDATE/DELETE DATA
    $(document).ready(function(){

        $('#mytable').DataTable({
                    "bProcessing": true,
                    "sAjaxSource": "<?php echo $base_url.'action/tampilkan_data_list_harga_bahan_baku_termurah.php' ?>",
                    "deferRender": true,
                    "select": true,
                    //"dom": 'Bfrtip',
                    //"scrollY": "300",
                    //"order": [[ 4, "desc" ]],
                     "aoColumns": [
                            { mData: 'no' } ,
                            { mData: 'id_bahan_baku' } ,
                            { mData: 'id_supplier' } ,
                            { mData: 'harga' },
                            { mData: 'satuan' },
                            { mData: 'waktu_pengiriman' }
                    ],
                    "aoColumnDefs": [
                        { sClass: "dt-center", "aTargets": [0,3,4] },
                        { sClass: "dt-nowrap", "aTargets": [0,1,2] }
                    ]
        });

    });
</script>
