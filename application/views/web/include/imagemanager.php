<link rel="stylesheet" href="<?php  echo base_url(); ?>assets/admin/bootstrap/css/bootstrap.min.css">
<script src="<?php  echo base_url(); ?>assets/admin/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<script src="<?php  echo base_url(); ?>assets/js/jqueryform/jquery.form.min.js"></script>

<script src="<?php echo base_url();  ?>assets/js/core/ajaxupload.js"></script>
<script src="<?php echo base_url();  ?>assets/js/core/ajaxpost.js"></script>

<script>
	

	
$(document).ready(function(){
	
	$('body').on('click','.imgselect',function(){
		parent.tinymce.activeEditor.windowManager.getParams().oninsert({url:$(this).attr('src'),info:$(this).attr('imgname') });
		// close popup window
		parent.tinymce.activeEditor.windowManager.close();
	});
	$('body').on('click','.imgremove',function(){
		var data = {path :$(this).attr('img')};
		var form = $('#formglobal');
		var url = '<?php echo base_url(); ?>admin/berita/removphotoconten';
		 postData(data,url,form,function(is_json, data){
			 if(data.valid){
				 location.reload();
			 }
		 } );
	});
	
	$('#imgb').change(function(){
	var randomid =Math.floor((Math.random() * 9000) + 1000); 
	$('#imgrow').append('<div class="col-xs-3" >'+
						'<div  style="width: 100%; overflow: hidden; text-align: center; height: 120px; margin: auto;position:relative">'+
						'<i  id="imgremove'+randomid+'" class="imgremove glyphicon glyphicon-remove pull-right" style="color: rgb(243, 14, 14); position: absolute; top: 2px; right: 2px; background-color: white;"></i>'+
						'<img id="'+randomid+'" class="imgselect" width="100%" imgname="gambarbaru" src="<?php echo $this->imageloader->getGlobalImage('200x200'); ?>"/>'+
						'</div>'+
						'<div style="display: block; background-color: white; width: 100%; height: 33px;">'+
						'<span id="'+randomid+'-name">upload image ...</span>'+
						'</div>'+
						'</div>' );			
			uploadImage( $('#formimg'), [] ,function(){}, function(data){
				if(data.valid){
					$('body').find('#'+randomid).attr('src',data.path);
					var name =   data.filename; 
					name.replace('<?php echo $dropkey; ?>','');
					if(name.length > 20){
						var t = name.length-20;
						name = name.substr(0, name.length-10-t)+'...'+name.substr(name.length-8, name.length);
					}
					$('body').find('#'+randomid+'-name').html(name);
					$('body').find('#imgremove'+randomid).attr('img',data.shortpath);
				}
			},false);
			
		});
	
})	


</script>
<style>
	.imgremove{cursor:pointer}
</style>
<body>

<form style="display:none" method="post" action="" id="formglobal"></form>
	<br>
	<div class="container">
		<div class="row" id="imgrow" style="margin-bottom:55px">
			<?php 
			
				foreach($imgdb as $value){
			?>
					<div class="col-xs-3" >
						<div style="width: 100%; overflow: hidden; text-align: center; height: 120px; margin: auto;position:relative">
							<i img="<?php echo $value['path']; ?>" class="imgremove glyphicon glyphicon-remove pull-right" style="color: rgb(243, 14, 14); position: absolute; top: 2px; right: 2px; background-color: white;"></i>
							<img class="imgselect" width="100%" imgname="<?php echo $value['name']; ?>" src="<?php echo $value['fullpath']; ?>"/>
						</div>
						<div style="display: block; background-color: white; width: 100%; height: 33px;">
							<span id="imgname"><?php echo $value['name']; ?></span>
						</div>
					</div>
					
			<?php }	?>
			
			<?php 
			
				foreach($imgupload as $value){
			?>
					<div class="col-xs-3" >
						<div style="width: 100%; overflow: hidden; text-align: center; height: 120px; margin: auto;position:relative">
							<i img="<?php echo $value['path']; ?>" class="imgremove glyphicon glyphicon-remove pull-right" style="color: rgb(243, 14, 14); position: absolute; top: 2px; right: 2px; background-color: white;"></i>
							<img class="imgselect" width="100%" imgname="<?php echo $value['name']; ?>" src="<?php echo $value['fullpath']; ?>"/>
						</div>
						<div style="display: block; background-color: white; width: 100%; height: 33px;">
							<span id="imgname"><?php echo $value['name']; ?></span>
						</div>
					</div>
					
			<?php }	?>
			
		</div>
		<div class="row" style="bottom:0px;position: fixed; background-color: rgb(238, 240, 215); padding: 15px; border: 1px solid rgb(209, 206, 206);width:100%">
			  <form style="margin-bottom:0px" class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>admin/berita/uploadimage" id="formimg">
				<input type="hidden" name="uploadkey" value="<?php echo $dropkey;?>"/>
				<input type="hidden" name="uploadtype" value="contentimage"/>
                <div style="margin-bottom:0px" class="form-group">
                  <div class="col-xs-5 pull-right">
					<input id="imgb" type="file" name="fileimg">
                  </div>
                  <label  class="col-xs-3 control-label nobold font16 text-right pull-right">Upload Image</label>
                </div> 
			</form>
			</div>
		</div>
	</div>
	

</body>