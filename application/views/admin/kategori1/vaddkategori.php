<!-- JS File Upload -->
<script type="text/javascript" src="<?php echo base_url(); ?>js/topindo/imageloader.js"></script>

<!-- Tiny Mce -->
<script type="text/javascript" src="<?php echo base_url() ?>js/tinymce/tinymce.min.js"></script>

<!-- Nicedit -->
<script type="text/javascript" src="<?php echo base_url() ?>js/nicedit/nicEdit.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jagapati/ajaxpost.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jagapati/ajaxupload.js"></script>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>


<script type="text/javascript">
	var availableTags;
	var objData={};
	var parenttree;
	
	
	function upload( strImgId ){
		
		$('#imgdata').val('');
		objData={};
		$('#imgdata').trigger('click');
		objData={imgId:strImgId}
		
	}
	
	$(function (){
        
		 $('#kategoriname').keyup(function() {
            if (this.value.match(/[^a-zA-Z0-9_'+ -]/g)) {
                //return false;
                alert('Nama Kategori hanya boleh di input dengan angka dan huruf dan Karakter Khusus ( _\'+ - )');
                this.value = this.value.replace(/[^a-zA-Z0-9_'+ -]/g, '');
            }
        });
		
		$('#parentid option').click(function(){
			parenttree = $(this).attr('parenttree')
		});
		
		$('#imgdata').on('change',function(ev,data){
			uploadImage($('#uploadimg'), objData,function(){}, function(data){
					if(data.valid){
						$('#txt'+objData.imgId).val(data.filename)
					}
			});			
		});
		
		


		$("#BrandImage").change(function(){
			readURL("imgItem", this);
		});
		
	});
	
	function fSubmit(){
		nicEditors.findEditor('area1').saveContent();
		var data = {parenttree:parenttree};
		var url;
		var objForm = $('#formsave');
		postData(data, url, objForm);
	}

	bkLib.onDomLoaded(function() {
		new nicEditor({maxHeight : 500,iconsPath : '<?php echo base_url(); ?>js/nicedit/nicEditorIcons.gif',fullPanel : true}).panelInstance('area1');
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
			
		</style>
		<script type="text/javascript">
			
			
			</script>

		<style>
			.form-control{
				border-color:#7E7395;
				border-color:#AFACBA;
				font-size:16px
			}
			label{font-weight:normal;}
			.box{
				box-shadow:0px 1px 1px rgba(60, 58, 49, 0.3);
			}
		</style>
        <?php error_reporting(0) ?>
		<?php echo $error_gambar; ?>
		
		<section class="content-header col-md-offset-2">
          <h1>
              Admin <small>JAGAPATI.com</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/menu'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Admin Brand</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          	<div class="row">
				
				<!-- Form Upload Image -->
				<form enctype="multipart/form-data" action="<?php echo base_url(); ?>admin/kategori/uploadimage" method="post" id="uploadimg">
					<input style="display:none" type="file" name="imgdata" id="imgdata">
					<input type="hidden" name="uploadkey" value="<?php echo $uploadKey; ?>">
				</form>
				<form class="form-horizontal" id="formsave" method="post" action="<?php echo site_url('admin/kategori/saveKategori'); ?>">
                    <input type="hidden" name="hdnkey" value="<?php echo $this->encrypt->encode($hdnkey);?>">
					<input type="hidden" name="uploadkey" value="<?php echo $uploadKey; ?>">
					
				 <div class="col-md-2" id="leftCol">
					<div id="sidebar">
					<h3>Menu Brand</h3>
					<a style="margin-bottom:5px" href="<?php echo site_url('admin/kategori') ?>" class="btn btn-success btn-flat"><i class="glyphicon glyphicon-briefcase"></i>&nbsp;&nbsp; Lihat Data Kategori </a>
					<a onclick="fSubmit()" style="margin-bottom:5px" href="#" class="btn bg-primary btn-flat"><i class="glyphicon glyphicon-save"></i>&nbsp;&nbsp; Save Kategori </a>
                    <a style="margin-bottom:5px" href="<?php echo site_url('admin/kategori');?>" class="btn btn-danger btn-flat"><i class="glyphicon glyphicon-briefcase"></i>&nbsp;&nbsp; Cancel </a>
				    </div>
				 </div>	
				 <div class="col-md-7">
					<div class="box">
                       <div class="box-header">
							 <h3 class="box-title"><b>Kategori Info</b></h3>
						 </div>
						  <div class="box-body">                     
                         	 
							<div class="form-group">
							    <label for="exampleInputEmail1" class="col-sm-3 control-label">Parent</label>
							    <div class="col-sm-5">
								  	<select  style="border: 1px solid rgb(210, 214, 222); width:300px;  padding: 6px;" name="textParent" id="parentid" >
										<option value="0">No Parent</option>
										<?php 
											foreach( $parentList as $value ){
												echo "<option parenttree='".$value->parenttree."' value='".$value->kategoriid."' ". ($value->kategoriid==(!empty($parentid)?$parentid:'0')?'selected':'') .">".$value->kategoriname."</option>";
											}
										?>  
									</select>						
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-sm-3 control-label " for="exampleInputEmail1">Kategori Name</label>
								 <div class="col-sm-5">
                      			<input type="text" class="form-control" id="kategoriname"  placeholder="kategori name" name="txtKategoriName" value="<?php echo $kategoriname; ?>" required>
								</div>
							</div>
                              
                            <div class="form-group row">
								<label class="col-sm-3 control-label " for="exampleInputEmail1">Kode Kategori</label>
								 <div class="col-sm-5">
                      			<input type="text" class="form-control" id="kategoriname"  placeholder="kode kategori" name="txtKodeKategori" value="<?php echo $kodekategori; ?>" maxlength="2" required style="text-transform: uppercase;">
                                <p><span style="color:red"><small>*Kode Kategori Max 2 Huruf.</small></span></p>
								</div>
							</div>
	
							<div class="form-group">
								<label class="col-sm-3 control-label" for="exampleInputEmail1">Kategori Content</label>
								<div class="col-sm-9">
								<textarea class="textarea" cols="100" id="area1" name="txtDesc" style="height: 200px;width: 100%;"><?php echo $kategoridesc ; ?></textarea>
								</div>
							</div>
							 
							<div class="form-group">
								<label class="col-sm-3 control-label" for="exampleInputEmail1">Kategori Banner 3:1 </label>
								<div class="col-sm-9">
									<input type="hidden" name="imgbanner3x1" id="txtimgbanner3x1">
									<img id="imgbanner3x1" src="<?php echo $this->imageloader->fKategoriImage($kategori, 'KategoriBanner1') ?>" width="444px" height="148px" >
									<br>
									<small>Silahkan upload gambar 3:1 atau bebas dengan ukuran lebar minimal 800 px </small>
									<br>
									<button type="button" id="" class="btn btn-primary" onclick="upload('imgbanner3x1')">Pilih Gambar</button>
									<br>
								</div>
							</div>
							  
							<div class="form-group">
								<label class="col-sm-3 control-label" for="exampleInputEmail1">Kategori Banner 2:1 </label>
								<div class="col-sm-9">
									<img id="imgbanner2x1" src="<?php echo  $this->imageloader->fKategoriImage($kategori, 'KategoriBanner2') ?>" width="400" height="200px" >
									<input type="hidden" name="imgbanner2x1" id="txtimgbanner2x1">
									<br>
									<small>Silahkan upload gambar 2:1 dengan ukuran 500x250 px </small>
									<br>
									<button type="button" id="" class="btn btn-primary" onclick="upload('imgbanner2x1')">Pilih Gambar</button>
									<br>
								</div>
							</div>
							  
							<div class="form-group">
								<label class="col-sm-3 control-label" for="exampleInputEmail1">Kategori Banner 1:1 </label>
								<div class="col-sm-9">
									<img id="imgbanner1x1" src="<?php echo  $this->imageloader->fKategoriImage($kategori, 'KategoriBanner3') ?>" width="200" height="200px" >
									<input type="hidden" name="imgbanner1x1" id="txtimgbanner1x1">
									<br>
									<small>Silahkan upload gambar 1:1 dengan ukuran 400x400 px</small><br>
									<button type="button" id="" class="btn btn-primary" onclick="upload('imgbanner1x1')">Pilih Gambar</button>
									<br>
								</div>
							</div>

							<div class="form-group">

							</div>
						  </div><!-- /.box-body -->

					
					</div> 
				 </div>
				
				</form>
		 	</div>
</section>

    