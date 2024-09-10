<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>js/DataTables/css/jquery.dataTables.min.css" />
<script src="<?php echo base_url() ?>js/DataTables/js/jquery.dataTables.min.js" type="text/javascript"></script>-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>js/DataTables/css/jquery.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>js/DataTables/css/dataTables.responsive.css">

<script src="<?php echo base_url() ?>js/DataTables/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>js/DataTables/js/dataTables.responsive.js"></script>

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
            "sAjaxSource": "<?php echo base_url(); ?>admin/kategori/listkategoridata",
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

<script>
	
	function savekategori(){
		var data;
		var url;
		var objform =$('#formkategori');
		postData(data,url,objform, function(){
			
			contoj.fnDraw();
		});
	}
	
	function tambahkategori(){
		$('#formkategori').attr('action','<?php echo base_url(); ?>admin/kategori/saveaddkategori');
		$('#titleBox').html('Sialahkan Tambah Kategori');
		$('#kategoriname').val('');
		$('#hdnkey').val('<?php echo $this->ffunction->encode($hdnkey); ?>');
	}
	
	function editkategori(v,katagoriname){
		$('#formkategori').attr('action','<?php echo base_url(); ?>admin/kategori/saveeditkategori');
		$('#titleBox').html('Edit Kategori');
		$('#hdnkey').val(v);
		$('#kategoriname').val(katagoriname);
		
		
		
	}
	
	$(function (){
        $('#datetimepicker').datepicker({
		  autoclose: true,
		  format:'yyyy-mm-dd'
		});
    });
	
</script>
        <?php error_reporting(0) ?>

<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tambah Kategori
        <small>silahkan kelolaKategori dengan mengisi form di bawah dengan lengkap</small>
      </h1>
    </section>

<section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Add Kategori</h3>
                                  
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post" action="<?php echo base_url(); ?>admin/kategori/<?php echo ($viewstate=='add'?'saveaddkategori':'saveeditkategori');  ?>" id="formkategori">
                  <div class="box-body">
                    <input id="hdnkey" type="hidden" name="hdnkey" value="<?php echo $this->ffunction->encode($hdnkey); ?>"/>                  
                    <div class="form-group row">
                     <div class="col-sm-6">
                      <label for="exampleInputEmail1">Kategori Name</label>
                      <input id="kategoriname" class="form-control" required name="kategoriname"  placeholder="Kategori Name" type="text" value="<?php echo $kategori->kategori_name;  ?>">
                       </div>
                    </div>
                    
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                      <button type="button" class="btn btn-danger btn-flat" onclick="savekategori();" >Save Kategori</button>
                    <a class="btn btn-success btn-flat" href="<?php echo base_url(); ?>admin/kategori">Cancel</a>
                    
                  </div>
                </form>
              </div><!-- /.box -->
			  </div>
			  </div>
</section>

<section class="content-header">
       <?php error_reporting(0) ?>
          <h1>
              Admin <small>mentarigroup.com</small>
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
				  <h3 class="box-title">Data Kategori</h3>
				</div>
                <div class="box-body">
                    <table id="contoj" class="data display datatable"  cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Id</th>
								<th>Kategori Name</th>
								<th>Opsi</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
                </div>
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
