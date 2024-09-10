<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>js/DataTables/css/jquery.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>js/DataTables/css/dataTables.responsive.css">

<script src="<?php echo base_url() ?>js/DataTables/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>js/DataTables/js/dataTables.responsive.js"></script>

<!-- jColorBox -->
<link rel="stylesheet" href="<?php echo base_url(); ?>js/ColorBox/colorbox.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>js/ColorBox/jquery.colorbox.js"></script>

<style>
    .dataTables_filter {
        display: none;
    }

    #contoj_length {
        margin-top: 15px !important;
    }
</style>
<script type="text/javascript">
    var contoj;
    var n;
    var v;
    $(function () {
        contoj = $('#contoj').dataTable({
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "sDom": '<"top"i>rt<"bottom"flp><"clear">',
            "sAjaxSource": "<?php echo $this->config->item('rootPath'); ?>/admin/banner/listBanner",
            "bAutoWidth": true,
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                $('td', nRow).attr('nowrap', 'nowrap');
                return nRow;
            },
            "fnServerData": function (sSource, aoData, fnCallback, oSettings) {
                aoData.push({ "name": "bannerStatus", "value": $('select[name=BannerStatus]').val() });
                aoData.push({ "name": "bannerpos", "value": $('select[name=bannerpos]').val() });
                aoData.push({ "name": "bannertitle", "value": $('input[name=bannertitle]').val() });

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

	function fDelete(strKey){
		if (confirm("Anda ingin menghapus data tersebut?")){
			$.ajax({
				url:"<?php echo $this->config->item('rootPath'); ?>/admin/banner/delete",
				type:"POST",
				data: { KeyId:strKey },
				success:function(objResult){
					var obj = jQuery.parseJSON(objResult);
					if(obj.Valid){
						alert("Data berhasil di hapus");
						contoj.fnDraw();
					}
				}
			});
		}else{
			contoj.fnDraw();
		}
	}
	
	function fActive(strKey, strStatus){
		if (confirm("Anda ingin mengubah data tersebut?")){
			$.ajax({
				url:"<?php echo $this->config->item('rootPath'); ?>/admin/banner/active",
				type:"POST",
				data: { KeyId:strKey, Status:strStatus },
				success:function(objResult){
					var obj = jQuery.parseJSON(objResult);
					if(obj.Valid){
						alert("Data berhasil di update");
						contoj.fnDraw();
					}
				}
			});
		}else{
			contoj.fnDraw();
		}
	}
	
	function lightbox(strImage){ 
	  $.colorbox({ href:strImage,width: "600px",
    height: "240px" });
	}
</script>

<style>
    #contoj td {
        white-space: normal;
        font-size: 14px;
    }

    #contoj tr {
        white-space: normal;
        font-size: 14px;
    }
</style>

<section class="content-header">
    <h1>Admin <small>mentarigroup.com</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('admin/menu'); ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Data Banner</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Data Banner</h3>
                </div>
                
                <div class="box-body">
    <button class="btn btn-danger btn-flat" onclick="location.href='<?php echo site_url('admin/banner/addBanner'); ?>'"><b>&nbsp;&nbsp;&nbsp;Add Banner&nbsp;&nbsp;&nbsp;</b></button>
</div>
                
                <div class="box-body">
                    <table class="data display datatable" id="contoj" width="100%">
                       
						<label  style="margin:0px 5px; display: inline-table;"> Cari Status Banner 
							<select name="BannerStatus" onchange="contoj.fnDraw();" class="form-control ">
								<option value="All" >ALL</option>
								<option value="1" >Aktif</option>
								<option value="0">Tidak Aktif</option>
							</select> 
						</label>
						<?php 
						//$dataPos = $this->enums->enumsBannerPos(); 
						//$dataPos = array_keys($dataPos);
						?>
						<label style="margin:0px 5px; display: inline-table;"> Cari Posisi Banner 
							<select onchange="contoj.fnDraw();" name="bannerpos" class="form-control">
								<option>ALL</option>
								<?php 
								    foreach($this->enums->enumsBannerPos() as $field=>$value){
									   echo'<option value="'.$field.'">'.$field.'</option>';
								    }
								?>
								
							</select> 
						</label>
						<label style="margin:0px 5px; display: inline-table;" > Cari Nama Banner 
							<input name="bannertitle" onkeyup="contoj.fnDraw();" type="text" class="form-control" >
						</label>
						<hr>
                        <thead>
                            <tr>
                                <th>Banner Image</th>
								<th>Banner Title</th>
                                <th>Schedule ON</th>
                                <th>Schedule OFF</th>
                                <th>Position</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5" class="dataTables_empty">Loading data from server</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

