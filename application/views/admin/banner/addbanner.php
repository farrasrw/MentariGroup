
<?php 
//error_reporting(0) ?>
<?php
$arrConfigBanner = $this->enums->enumsBannerPos();

	if(!empty($banner_pos )){
			$arrBannerSelect = $this->enums->enumsBannerPos($banner_pos); 
	}else{
	 		$arrBannerSelect = array();	
	}
	$bolShowBannerMenu =false;
?>

<link href="<?php echo base_url() ?>js/datetimepicker/css/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url() ?>js/datetimepicker/jquery.datetimepicker.js"></script>

<!-- JS File Upload -->
<script type="text/javascript" src="<?php echo base_url(); ?>js/imageloader.js"></script>

<!-- Tiny Mce -->
<script type="text/javascript" src="<?php echo base_url() ?>js/tinymce/tinymce.min.js"></script>

<!-- Nicedit -->
<script type="text/javascript" src="<?php echo base_url() ?>js/nicedit/nicEdit.js"></script>


<script type="text/javascript">
	
	var availableTags;
	var objData={};
	var strSizeinfo = '<?php echo $banner_imagesize; ?>';
	var txtleft ='left:0px';
	var txttop	='top:0px';
	
	$(function (){
		
		$('#imgbannermenulive').css('width',$('#imgbannermenulive').width()*0.8);
		$('#dtBannerSchedule').datetimepicker({ timepicker: true, format:'Y-m-d H:i' });
		$('#dtBannerScheduleOff').datetimepicker({ timepicker: true, format:'Y-m-d H:i' });
		$('#selectposition option').click(function(){
			
						strSizeinfo =$(this).attr('sizeinfo');
			var posName  = $(this).val();
			var objsize  = JSON.parse($(this).attr('sizeinfo'));
			var arraddon  = JSON.parse($(this).attr('addon'));
			var htmlimg ='';
			var htmladdon ='';
			var htmladdonbannermenu='';
			
			var arrsize  = Object.keys(objsize).map(function (key) {
				return objsize[key];
			});
			
			var objKey = Object.keys(objsize).map(function (key) {
				return key;
			});
			
			if(arrsize.length > 0){
				
				$.each(arrsize, function(index,value){
					htmlimg = htmlimg + templateImg( posName +'-'+objKey[index], value,$(this).attr('addon'));
				});
				htmlimg = '<div class="col-xs-offset-3 text-danger" style="padding-left:10px">'+$(this).attr('ket')+'<br></div><br>'+htmlimg;
			}
			
			if( typeof(arraddon)=='object' && arraddon.length > 0){
				$.each(arraddon, function(index,value){
					if(value=='tag'){
						htmladdon = htmladdon + templateTag();
					}else if(value=='kategori'){
						htmladdon = htmladdon + templateKategori();
					}else if(value=='news'){
						htmladdon = htmladdon + templateNews();
					}
					
					if(value=='bannermenu'){
						htmladdonbannermenu =  templateImageMenu();
					}
					
				})
			}
			
			var result = htmladdon+htmlimg+htmladdonbannermenu;			
			$('#formimg').html(result);
			
		});
		$('#imgdata').change(function(){
			
			uploadImage($('#uploadimg'), objData,function(){}, function(data){
				if(data.valid){
					$('#txt'+objData.imgId).val(data.filename);
					var addon = $('#selectposition option:selected').attr('addon');
					if(typeof(addon)!='undefined'){
						arrAddon = JSON.parse(addon);
						$.each(arrAddon, function(index,value){
							if(value=='bannermenu'){
								$('body').find('#imgbannermenulive').attr('src',data.path+'?rand='+Math.floor((Math.random() * 100) + 1) );
								$('body').find('#imgbannermenulive').removeAttr('width');
								setTimeout(function(){
									var imgwidth = $('body').find('#imgbannermenulive').width()*0.62;
									$('body').find('#imgbannermenulive').attr('width',imgwidth);
									$('body').find('#imgbannermenulive').show();
								}, 1000);
							}
						});
					}
				}
			});
			
		});
		
	});
	
	function upload( imgname, strImgId, addon ){
		$('#imgdata').val('');
		$('#imgdata').trigger('click');
		objData={imgId:strImgId, imgbannername:imgname, addon:addon};
	}
	
	function fSubmit(){
		nicEditors.findEditor('area1').saveContent();
		var data={sizeinfo:strSizeinfo};
		var url ;
		var objForm = $('#formsave') ;
		postData(data,url,objForm);
		
	}
	
	
	function templateImg(bannerName, sizevalue, banneraddon){
		
		if(typeof(banneraddon)=='undefined') banneraddon='';
		
		var id = sizevalue[0]+'x'+sizevalue[1];
		var sizeWidth  = sizevalue[0];
		var sizeHeight = sizevalue[1];
		var sizeimg = parseInt($('#formimg').width()) - (30/100)*parseInt($('#formimg').width()) ;
		
		if((sizeWidth/sizeHeight)==3){
			var sizeWidth  = sizeimg;
			var sizeHeight = sizeimg/3;
		}else if((sizeWidth/sizeHeight)==2){
			var sizeWidth  = sizeimg;
			var sizeHeight = sizeimg/2;
		}else if((sizeWidth/sizeHeight)==1){
			var sizeWidth  = 250;
			var sizeHeight = 250;
		}else{
			var sizeWidth  = (sizeWidth>sizeimg?sizeimg:sizeWidth);
			var sizeHeight = 'auto';
		}
		
		var html = 	'<div class="form-group">'+
				   	'<label class="col-sm-3 control-label" >Image Banner '+bannerName+' </label>'+
				   	'<div class="col-sm-9">'+
					'<input type="hidden" name="imgbanner'+id+'" id="txtimgbanner'+id+'">'+
					'<img id="imgbanner'+id+'" src="<?php echo base_url(); ?>media/images/noimage/allnoimage/500x500.jpg" width="'+sizeWidth+'" height="'+sizeHeight+'">'+
					'<br><small class="text-muted"> silahkan upload gambar dengan ukuran  '+id+' px </small><br>'+
					'<button type="button" id="" class="btn btn-danger " onclick="upload(\''+bannerName+'\',\'imgbanner'+id+'\',\''+banneraddon+'\')">Pilih Gambar</button>'+
					'<br></div></div>';
		return html;
		
	}
	
	function templateTag(){
		
		var  text = '<div class="form-group">'+
					'<label for="exampleInputEmail1" class="col-sm-3 control-label">Tag Terkait</label>'+
					'<div class="col-sm-7"><select class="form-control" name="tagselect" id="tagselect">'+
					'<option>-Tidak Ada Tag-</option>'+
					'<?php 
						foreach($TagList as $value){
							echo '<option value="'.$this->fcommerce->encode($value->tag_name).'">'.str_replace("'",'',$value->tag_name).'</option>';
						}
					?></select><small>(optional) Jika Banner Berkaitan Dengan Tag Tertentu Silahkan di Pilih</small><br></div></div>';
		return text;
	}
	
	function templateKategori(){
		
		var  text = '<div class="form-group">'+
					'<label for="exampleInputEmail1" class="col-sm-3 control-label">Kategori</label>'+
					'<div class="col-sm-7"><select class="form-control" name="kategoriselect" id="kategoriselect">'+
					'<option>-Tidak Ada Kategori-</option>'+
					'<?php 
						foreach($KategoriList as $value){
							echo '<option value="'.$this->fcommerce->encode($value->kategori_id).'">'.$value->kategori_name.'</option>';
						}
					?></select><small>(optional) Jika Banner Berkaitan Dengan Kategori Tertentu Silahkan di Pilih</small><br></div></div>';
		return text;
	}
	
	function templateNews(){
		
		var  text = '<div class="form-group">'+
					'<label for="exampleInputEmail1" class="col-sm-3 control-label">Kategori</label>'+
					'<div class="col-sm-7"><input type="text" class="form-control" value="<?php //echo $newsid; ?>" name="newsid">'+
														'<small>(optional) Jika Banner Berkaitan Dengan Artikel Tertentu Silahkan Isi</small><br>'+
														'<br></div></div>';
		return text;
	}
	
	
	function templateImageMenu(){
		var text = 	'<span>Preview</span><div style="width:100%; height:203px; background-image:url(\'<?php echo base_url(); ?>style/images/templateimages/templatemenu.jpg\')">'+
						'<table style="width:100%"><tr>'+
								'<td style="display: block; margin: 71px 14px; width: 150px; position: relative;">'+
									'<img id="imgbannermenulive" src="" style="display:none; z-index: 1; position: absolute; top: -38px; right: -24px;">'+
								'</td><td></td>'+
						'</tr></table>'+
					'</div>';
		return text;
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
            <li class="active">Admin Banner</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          	<div class="row">
				<!-- Form Upload Image -->
				<form enctype="multipart/form-data" action="<?php echo base_url(); ?>admin/banner/uploadimage" method="post" id="uploadimg">
					<input style="display:none" type="file" name="imgdata" id="imgdata">
					<input type="hidden" name="uploadkey" value="<?php echo $uploadKey; ?>">
				</form>
				
				<form class="form-horizontal" method="post" name="formDetail" id="formsave" action="<?php echo base_url(); ?>admin/banner/saveBanner">
				
				 <div class="col-md-2" id="leftCol">
					<div id="sidebar">
					<h3>Menu Banner</h3>
					<a style="margin-bottom:5px" href="<?php echo site_url('admin/banner') ?>" class="btn btn-success btn-flat"><i class="glyphicon glyphicon-briefcase"></i>&nbsp;&nbsp; Lihat Data Banner </a>
					<a onclick="fSubmit()" style="margin-bottom:5px" href="#" class="btn bg-navy btn-flat"><i class="glyphicon glyphicon-save"></i>&nbsp;&nbsp; Save Banner </a>
                    <a style="margin-bottom:5px" href="<?php echo site_url('admin/banner');?>" class="btn btn-danger btn-flat"><i class="glyphicon glyphicon-briefcase"></i>&nbsp;&nbsp; Cancel </a>
				    </div>
				 </div>
					
				 <div class="col-md-7">
					<div class="box">
                         <div class="box-header">
							 <h3 class="box-title"><b>Banner Info</b></h3>
						 </div>
						  <div class="box-body">
				            <input type="hidden" id="hdnKey" name="hdnKey" value="<?php echo $this->encrypt->encode($Key); ?>">
							<input type="hidden" name="uploadkey" value="<?php echo $uploadKey; ?>">
                            <div class="form-group">
							  <label for="exampleInputEmail1" class="col-sm-3 control-label">Judul Banner</label>
							  <div class="col-sm-7">
								<input type="text" class="form-control"  placeholder="enter Banner title" name="txtBannerTitle" value="<?php echo $banner_title; ?>" required>
							  	<small class="text-muted">Isi Field ini Dengan Title / Caption Banner</small>
							  </div>
							</div>
                              
                            <!--<div class="form-group">
							    <label for="exampleInputEmail1" class="col-sm-3 control-label">Banner Menu</label>
							    <div class="col-sm-5">
                                    <select class="form-control" name="txtMenuType" value="<?php echo $banner_typemenu ?>" required>
                                       <?php 
                                        echo"
                                            <option value='0' ".($banner_typemenu==0?'selected':'').">Menu Left</option>
                                            <option value='1' ".($banner_typemenu==1?'selected':'').">Menu Right</option>"; ?>
                                      </select>
								</div>
							</div>
                              
                            <div class="form-group">
							    <label for="exampleInputEmail1" class="col-sm-3 control-label">Text Color</label>
							    <div class="col-sm-5">
                                    <select class="form-control" name="txtColor" value="<?php echo $banner_color ?>" required>
                                       <?php 
                                        echo"
                                            <option value='0' ".($banner_color==0?'selected':'').">Black</option>
                                            <option value='1' ".($banner_color==1?'selected':'').">White</option>"; ?>
                                      </select>
								</div>
							</div>
                              
                            <div class="form-group">
							  <label for="exampleInputEmail1" class="col-sm-3 control-label">Target Id <small>(optional)</small></label>
							  <div class="col-sm-7">
								<input type="text" class="form-control"  placeholder="enter Target Id" name="txtTargetId" value="<?php echo $target_id; ?>" >
							  	<small class="text-muted">isi dengan promo id</small>
							  </div>
							</div>-->
                              
							<div class="form-group">
								<label class="col-sm-3 control-label" for="exampleInputEmail1">Banner Content</label>
								<div class="col-sm-9">
								<textarea class="textarea" cols="100" id="area1" name="txtBannerDesc" style="height: 200px;width: 100%;"><?php echo $banner_desc ; ?></textarea>
								</div>
							</div>
							 
                            <div class="form-group">
                                  <label class="col-sm-3 control-label"  for="exampleInputEmail1">Tanggal Mulai</label>
                                  <div class="col-sm-5">
                                      <input type="text" class="form-control" id="dtBannerSchedule" placeholder="" name="dtBannerSchedule" value="<?php echo $banner_schedule; ?>" >
                                  	  <small class="text-muted">Isi Field ini Untuk menentukan Tgl Penayangan Banner </small>
								  </div>
                             </div>
							  
							<div class="form-group">
                                  <label class="col-sm-3 control-label"  for="exampleInputEmail1">Tanggal Selesai</label>
                                  <div class="col-sm-5">
                                      <input type="text" class="form-control" id="dtBannerScheduleOff" placeholder="" name="dtBannerScheduleOff" value="<?php echo $banner_scheduleoff; ?>" >
                                  	  <small class="text-muted">Isi Field ini jika Banner Memliliki Batas Waktu Penayangan</small>
								  </div>
                             </div>
						  	
							<div class="form-group row">
								<label class="col-sm-3 control-label " for="exampleInputEmail1">Banner Url</label>
								 <div class="col-sm-8">
								  <input type="text" class="form-control"  placeholder="ex : http://www.mentarigroup.com/" name="txtBannerUrl" value="<?php echo $banner_url; ?>" required>
                                 <small class="text-muted">Isi Field ini Dengan Link Url Banner akan di Alihkan  Jika di Klik  </small>
								</div>
							</div>
							
							<div class="form-group row">
                                <label class="col-sm-3 control-label" for="exampleInputEmail1">Posisi Banner</label>
                                <div class="col-sm-8">
							    <select class="form-control" id="selectposition" <?php echo (!empty($banner_pos)?'disabled':'name="txtBannerPos"' ); ?> name="txtBannerPos" value="<?php echo $banner_pos ?>" required>
								    <?php
										foreach ($arrConfigBanner as $strValue => $arrvalueItem){
											if($banner_pos==$strValue) $arrSelectBanner = $strValue; 
											echo "<option addon='".(isset($arrvalueItem['addon'])?json_encode($arrvalueItem['addon']):'[]')."' sizeinfo='".json_encode($arrvalueItem['size'])."' ket=\"".$arrvalueItem['keterangan']."\" value=\"".$strValue."\" ".($banner_pos == $strValue ? "selected" : "").">".$arrvalueItem['title']."</option>";
										}
									?>
								</select>
                                <small class="text-muted">Silahkan Pilih Posisi Banner  </small>
							    </div>
								<div class="col-xs-8 col-xs-offset-3" id="positioninfo">
								
								</div>
							</div>
							   
							<div class="col-xs-24" id="formimg">
								<?php
								
								    if(isset($arrBannerSelect[$banner_pos]['addon'])){
										
										foreach($arrBannerSelect[$banner_pos]['addon'] as $value){
											if($value=='tag'){
												
												?>
													<div class="form-group">
													<label for="exampleInputEmail1" class="col-sm-3 control-label">Tag Terkait</label>
													<div class="col-sm-7"><select class="form-control" name="tagselect" id="tagselect">
													<option>-Tidak Ada Tag-</option>
													<?php 
														foreach($TagList as $valuetag){
														echo '<option '.($tag_name==$valuetag->tag_url?'selected':'').' value="'.$this->fcommerce->encode($valuetag->tag_url).'">'.$valuetag->tag_name.'</option>';
														}
													?></select><small>(optional) Jika Banner Berkaitan Dengan Tag Tertentu Silahkan di Pilih</small><br></div></div>
												<?php
												
											}else if($value=='kategori'){
												?>
													<div class="form-group">
													<label for="exampleInputEmail1" class="col-sm-3 control-label">Kategori</label>
													<div class="col-sm-7"><select class="form-control" name="kategoriselect" id="kategoriselect">
													<option>-Tidak Ada Kategori-</option>
													<?php 
														foreach($KategoriList as $valuekategori){
														echo '<option '.($kategori_id==$valuekategori->kategori_id?'selected':'').' value="'.$this->fcommerce->encode($valuekategori->kategori_id).'">'.$valuekategori->kategori_name.'</option>';
														}
													?></select><small>(optional) Jika Banner Berkaitan Dengan Kategori Tertentu Silahkan di Pilih</small><br></div></div>
												<?php
											}else if($value=='bannermenu'){
												$bolShowBannerMenu =true;
											}
										}
									}
									
									
								if(isset($arrBannerSelect[$banner_pos]['size'])){
									//$objBannerSize = json_decode($bannerimagesize);
									foreach($arrBannerSelect[$banner_pos]['size'] as $field=>$value){
											
										$imgid = $value[0].'x'.$value[1];
										$sizeimg = (600 - (30/100)* 600) ;
										if(($value[0]/$value[1])==3){
											$sizeWidth  = $sizeimg;
											$sizeHeight = $sizeimg/3;
										}else if(($value[0]/$value[1])==2){
											$sizeWidth   = $sizeimg;
											$sizeHeight = $sizeimg/2;
										}else if(($value[0]/$value[1])==1){
											$sizeWidth  = 250;
											$sizeHeight = 250;
										}else{
											$sizeWidth  = ($sizeWidth>$sizeimg?$sizeimg:$sizeWidth);
											$sizeHeight = 'auto';
											
										}
										
										?>
                            
											<div class="form-group">
											<label class="col-sm-3 control-label" >Image Banner <?php echo $field; ?> </label>
											<div class="col-sm-9">
											<input type="hidden" name="imgbanner<?php echo $imgid; ?>" id="txtimgbanner<?php echo $imgid; ?>">
											<img id="imgbanner<?php echo $imgid; ?>" src="<?php echo $this->imageloader->fBannerImage($Banner,$field, $imgid ); ?>" <?php echo 'width="'.$sizeWidth.'" height="'.$sizeHeight.'"' ?> >
											<br><small class="text-muted"> silahkan upload gambar dengan ukuran minimal  <?php echo $imgid.' px'; ?> </small><br>
											
											<button type="button" id="" class="btn btn-danger" onclick="upload('<?php echo $banner_pos.'-'.$field;  ?>','imgbanner<?php echo $imgid ?>' );" >Pilih Gambar</button>
											<br></div>
											</div>
										<?php
										
									}
								
								}
								
								
									if($bolShowBannerMenu){
										?>
											<div style="width:100%; height:203px; background-image:url('<?php echo base_url(); ?>style/images/templateimages/templatemenu.jpg')">
												<table style="width:100%"><tr>
														<td style="display: block; margin: 71px 14px; width: 150px; position: relative;">
															<img id="imgbannermenulive" src="<?php echo $this->imageloader->fBannerImage($Banner,$field); ?>" style="z-index: 1; position: absolute; top: -38px; right: -24px;">
														</td><td></td>
												</tr></table>
											</div>
								
										<?php	
									}
								?>
								
								
							</div>
						 
						  </div>
					</div> 
				 </div>
				 
				</form>
		 	</div>
		</section>

    

