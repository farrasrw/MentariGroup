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
			"order": [[ 0, "desc" ]],
            "serverSide": true,
            "sDom": '<"top"i>rt<"bottom"flp><"clear">',
            "sAjaxSource": "<?php echo base_url(); ?>admin/berita/listberitadata",
            "bAutoWidth": true,
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                $('td', nRow).attr('nowrap', 'nowrap');
                return nRow;
            },
            "fnServerData": function (sSource, aoData, fnCallback, oSettings) {
				aoData.push({ "name": "beritatitle", "value": $('#beritatitle').val() });
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
    <h1>List berita Admin <small>Silahkan Kelola, Tambah Baru Atau Hapus Berita Baru</small>
    </h1>
    
</section>
<!--<div class="box-body">
    <button class="btn btn-default btn-block btn-flat" onclick="location.href='<?php //echo site_url('admin/banner/addBanner'); ?>'"><b>Add Banner</b></button>
</div>-->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-body">
					<button class="btn btn-warning btn-flat" onclick="location.href='<?php echo site_url('admin/berita/addberita'); ?>'">&nbsp;&nbsp;&nbsp;Tambah berita Baru&nbsp;&nbsp;&nbsp;</button>
				</div>
                
                <div class="box-body">
                    <table id="contoj" class="table table-striped table-bordered" cellspacing="0" width="100%">
						<label class="nobold"> Cari Title Berita <input id="beritatitle"  onkeyup="contoj.fnDraw();" name="beritatitle" type="text" class="form-control" value=""/> </label>

						<thead>
							<tr>
								<th>Schedule</th>
								<th>Title</th>
								<th>Type</th>
								<th>Kategori</th>
								<th>Author</th>
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
