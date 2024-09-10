<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.11/css/dataTables.bootstrap.min.css">    
<style>
	.dataTable{
		margin-bottom: 15px !important;	width: 100%;
	}
	#contoj_paginate{
		width: 50%;		float: left;
	}
	.dataTable thead{
		background-color: rgb(93, 154, 245);
	}
	.dataTable thead tr th{
		font-size: 14px; font-weight: normal;color: white;
	}
    .dataTable td {
        white-space: normal; font-size: 14px;
    }

    .dataTable tr td {
        white-space: normal;  font-size: 14px;
    }
	
	#contoj_length {
    	margin-top: 0px !important;	width: 50%;	float: left;
	}
	.dataTable tbody > tr > td, .table-bordered > tfoot > tr > td {
		border: 1px solid #e9e0e0;
	}
</style>
<script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.11/js/dataTables.bootstrap.min.js" type="text/javascript"></script>

<script type="text/javascript">
    var contoj;
    var n;
    var v;
    $(function () {
        contoj = $('#contoj').dataTable({
			bFilter: false,
            "processing": true,
            "serverSide": true,
            "sDom": '<"top"i>rt<"bottom"flp><"clear">',
            "sAjaxSource": "<?php echo base_url(); ?>/admin/user/listuserdata",
            "bAutoWidth": true,
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                $('td', nRow).attr('nowrap', 'nowrap');
                return nRow;
            },
            "fnServerData": function (sSource, aoData, fnCallback, oSettings) {
                oSettings.jqXHR = $.ajax({
                    "dataType": 'json',
                    "type": "POST",
                    "url": sSource,
                    "data": aoData,
                    "success": fnCallback
                });
            }
        });
    });

</script>



<section class="content-header">
    <h1>List User Admin <small>Silahkan Kelola, Tambah Baru Atau Hapus Admin Baru</small>
    </h1>
    
</section>
<!--<div class="box-body">
    <button class="btn btn-default btn-block btn-flat" onclick="location.href='<?php //echo site_url('admin/banner/addBanner'); ?>'"><b>Add Banner</b></button>
</div>-->
<section class="content">
    <div class="row">
        <div class="col-md-9">
            <div class="box box-info">
                <div class="box-body">
					<button class="btn btn-warning btn-flat" onclick="location.href='<?php echo site_url('admin/user/adduser'); ?>'">&nbsp;&nbsp;&nbsp;Tambah User Baru&nbsp;&nbsp;&nbsp;</button>
				</div>
                
                <div class="box-body">
                    <table id="contoj" class="table table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Nama Lengkap</th>
								<th>Initial</th>
								<th>Jabatan</th>
								<th>Group User</th>
								<th>Status</th>
								<th>Opsi</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
                </div>
            </div>
        </div>
    </div>
</section>

