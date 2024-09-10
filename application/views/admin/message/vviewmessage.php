
<?php 
error_reporting(0) ?>


<link href="<?php echo base_url() ?>js/datetimepicker/css/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/datetimepicker/jquery.datetimepicker.js"></script>

<!-- JS File Upload -->
<script type="text/javascript" src="<?php echo base_url(); ?>js/imageloader.js"></script>

<!-- Tiny Mce -->
<script type="text/javascript" src="<?php echo base_url() ?>js/tinymce/tinymce.min.js"></script>

<!-- Nicedit -->
<script type="text/javascript" src="<?php echo base_url() ?>js/nicedit/nicEdit.js"></script>


<script type="text/javascript">

	function fSubmit(){
		nicEditors.findEditor('area1').saveContent();
		nicEditors.findEditor('area2').saveContent();
		var data={};
		var url ;
		var objForm = $('#formsave') ;
		postData(data,url,objForm);
		
	}
	

    
    bkLib.onDomLoaded(function() {
		new nicEditor({maxHeight : 500,iconsPath : '<?php echo base_url(); ?>js/nicedit/nicEditorIcons.gif',fullPanel : true}).panelInstance('area1');
        
        new nicEditor({maxHeight : 500,iconsPath : '<?php echo base_url(); ?>js/nicedit/nicEditorIcons.gif',fullPanel : true}).panelInstance('area2');
	});
	
</script>
       
        <style>
			#sidebar.affix-top {
				position: static;
				margin-top:30px;
				width:228px;
			}

			#sidebar.affix {
				position: fixed;
				top:0px;
				width:228px;
			}
			
			.form-control{
				border-color:#7E7395;
				border-color:#AFACBA;
				font-size:16px
			}
			label{font-weight:normal;}
			.box{
				box-shadow:0px 1px 1px rgba(60, 58, 49, 0.3);
			}
			.btnsetimg{
				background-color: rgb(15, 15, 15);
				color: white;
				border-radius: 0px
			}
			.btnsetimg:hover,.btnsetimg:focus{
				background-color:rgb(15, 15, 15);
				color: white
			}
		</style>

      
		<?php //echo $error_gambar; ?>
		
		
		<section class="content-header col-md-offset-2">
          <h1>
              Admin <small>mentarigroup.com</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/menu'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Admin Message</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          	<div class="row">
				
				<form class="form-horizontal" method="post" name="formDetail" id="formsave" action="<?php echo base_url(); ?>admin/message/savereplyMessage">
				
				 <div class="col-md-2" id="leftCol">
					<div id="sidebar">
					<a style="margin-bottom:5px" href="<?php echo site_url('admin/message') ?>" class="btn btn-success btn-flat"><i class="glyphicon glyphicon-briefcase"></i>&nbsp;&nbsp; Lihat Data</a>
					<a onclick="fSubmit()" style="margin-bottom:5px" href="#" class="btn bg-navy btn-flat"><i class="glyphicon glyphicon-save"></i>&nbsp;&nbsp; Replay </a>
                    <a style="margin-bottom:5px" href="<?php echo site_url('admin/message');?>" class="btn btn-danger btn-flat"><i class="glyphicon glyphicon-briefcase"></i>&nbsp;&nbsp; Cancel </a>
				    </div>
				 </div>
					
				 <div class="col-md-7">
					<div class="box">
                         <div class="box-header">
							 <h3 class="box-title"><b>Message Detail</b></h3>
						 </div>
						  <div class="box-body">
				            <input type="hidden" id="hdnKey" name="hdnKey" value="<?php echo $this->encrypt->encode($Key); ?>">
							<input type="hidden" name="id" value="<?php echo $message[0]->message_id; ?>">
							<input type="hidden" name="savereplymessage" value="Reply">
                           
                            <div class="form-group">
							  <label for="exampleInputEmail1" class="col-sm-3 control-label">Nama</label>
							  <div class="col-sm-7">
								<input type="text" class="form-control" name="txtNama" value="<?php echo $message[0]->nama; ?>" required>
							  	<small class="text-muted">Nama Customer</small>
							  </div>
							</div>
                             
                             <div class="form-group">
							  <label for="exampleInputEmail1" class="col-sm-3 control-label">Email</label>
							  <div class="col-sm-7">
								<input type="text" class="form-control"  name="txtEmail" value="<?php echo $message[0]->email; ?>" required>
							  	<small class="text-muted">Email Customer</small>
							  </div>
							</div>
                              
                              
							<div class="form-group">
								<label class="col-sm-3 control-label" for="exampleInputEmail1">Message</label>
								<div class="col-sm-9">
								<textarea class="textarea" cols="100" id="area1" name="txtPesan" style="height: 200px;width: 100%;"><?php echo $message[0]->pesan ; ?></textarea>
								<small class="text-muted">Pesan Customer</small>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label" for="exampleInputEmail1">Replay</label>
								<div class="col-sm-9">
								<textarea class="textarea" cols="100" id="area2" name="txtReplay" style="height: 200px;width: 100%;"></textarea>
								<small class="text-muted">Silahkan isi kolom ini untuk membalas pesan customer</small>
								</div>
							</div>

						 
						  </div>
					</div> 
				 </div>
				 
				</form>
		 	</div>
		</section>

    

