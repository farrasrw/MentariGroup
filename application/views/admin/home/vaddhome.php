<!-- JS File Upload -->
<script type="text/javascript" src="<?php echo base_url(); ?>js/topindo/imageloader.js"></script>

<!-- Tagit -->
<!--<link rel="stylesheet" type="text/css" href="<?php //echo base_url();?>js/Tagit/css/jquery-ui-base-1.8.20.css">
<link rel="stylesheet" type="text/css" href="<?php //echo base_url();?>js/Tagit/css/tagit-dark-grey.css">
<script type="text/javascript" src="<?php //echo base_url();?>js/Tagit/tagit.js"></script>
<script type="text/javascript" src="<?php //echo site_url('admin/inventory/tagit'); ?>"></script>-->

<!--DataTables-->
<script src="<?php echo base_url() ?>js/DataTables/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>js/DataTables/js/dataTables.responsive.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>js/DataTables/css/jquery.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>js/DataTables/css/dataTables.responsive.css">
<!--End dataTables-->

<!-- Tagit -->
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/Tagit2/css/jquery.tagit.css">
<script type="text/javascript" src="<?php echo base_url();?>js/Tagit2/tag-it.min.js"></script>

<!-- JS Date Time Picker -->   
<link href="<?php echo base_url() ?>js/datetimepicker/css/jquery.datetimepicker.css" rel="stylesheet" type="text/css" />	
<script type="text/javascript" src="<?php echo base_url() ?>js/datetimepicker/jquery.datetimepicker.js"></script>

<!-- Tiny Mce -->
<script type="text/javascript" src="<?php echo base_url() ?>js/tinymce/tinymce.min.js"></script>

<!-- Nicedit -->
<script type="text/javascript" src="<?php echo base_url() ?>js/nicedit/nicEdit.js"></script>

<!-- Dropzone -->
<link href="<?php echo base_url() ?>js/dropzone/css/basic.css" rel="stylesheet">
<link href="<?php echo base_url() ?>js/dropzone/css/dropzone.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url() ?>js/dropzone/dropzone.min.js"></script>

<script type="text/javascript">
	var availableTags;
    //alert(availableTags);
       
	Dropzone.options.myDropzone = {
		addRemoveLinks: true
	};

	$(function () {
        $('#demo3').tagit({
            tagSource:availableTags, 
            singleField:true,
            singleFieldNode: $('#tagit'),
            showAutocompleteOnFocus: true,
            allowSpaces:true,
            allowDuplicates:false,
            triggerKeys:['enter', 'comma', 'tab'],
            beforeTagAdded: function(evt, ui){
                if($.inArray(ui.tagLabel, availableTags) == -1){
                    return false;
                }
            },
            
        });
        
        $('#newsdatepublish').datetimepicker();
		

		tinymce.init({
			mode : "specific_textareas",
			editor_selector : "mceEditor",
			plugins: [
				"advlist autolink lists link image charmap print preview anchor",
				"searchreplace visualblocks code fullscreen",
				"insertdatetime media table contextmenu paste"
			],
			toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
		});
        
        /*var mockFile = JSON.parse('<?php //echo (!empty($imageContent)?json_encode($imageContent):'[]') ?>');
		Dropzone.options.contentimage = {
			serverpath: "<?php //echo $this->config->item('rootPath'); ?>/admin/news/dropzone/read/contentimage",
			serverkey: $('#hdnKey').val(),
			serverdata: mockFile,
			addRemoveLinks: true,
			
			dictAddButton: true,
			dictAddFunc:function(file) {
				insertImage('area1', file.path);
			},
		};
		
		Dropzone.options.myDropzone = {
			serverpath: "<?php //echo $this->config->item('rootPath'); ?>/admin/news/dropzone",
			serverkey: $('#hdnKey').val(),
			addRemoveLinks: true
		};*/
        
        //var mockFile = JSON.parse('<?php //echo (!empty($imageContent)?json_encode($imageContent):'[]') ?>');
		Dropzone.options.contentimage = {
			serverpath: "<?php echo $this->config->item('rootPath'); ?>/admin/news/dropzone",
			serverkey: $('#hdnKey').val(),
			//serverdata: mockFile,
			addRemoveLinks: true,
			
			dictAddButton: true,
			dictAddFunc:function(file) {
				insertImage('area1', file.path);
			},
		};

		$("#NewsImage").change(function(){
			readURL("imgItem", this);
		});
        
        $("#FoodImage").change(function(){
			readURL("imgItemNew", this);
		});
		
	});
    
    function copyImage(soucrce){
        var NewsImage  ='<img width="300px" tmpImage="True/" src="'+soucrce+'"/>';

         $(this).zclip({
            path: '<?php echo base_url();?>js/jquery-zclip-master/ZeroClipboard.swf',
            copy:NewsImage,
             
        });  
        
        $("#copy-link-wrap").trigger('click');  
    }
    
    function insertImage(editor, value){
            
            var StringPos = value.indexOf('style');
            var path = '<?php echo base_url();?>'+value.substring(StringPos);
            var NewsImage  ='<img width="300px" tmpImage="True/" src="'+path+'"/>';
            
            var editor = nicEditors.findEditor(editor);
            var fullConten = editor.getContent();
            editor.setContent( NewsImage+'<br>'+fullConten);            
        }

	bkLib.onDomLoaded(function() {
		new nicEditor({maxHeight : 500,iconsPath : '<?php echo base_url(); ?>js/nicedit/nicEditorIcons.gif',fullPanel : true}).panelInstance('area1');
	});
    
    
    $(document).ready(function(){
        tampilUnit();
    });
    
    //News Inventory
    var dataUnit= <?php echo (!empty($ItemNews)?json_encode($ItemNews):'[]'); ?>;
    var contoj;
	var n;
	var v;
     
	$(function() {
		contoj = $('#contoj').dataTable({
            "responsive":true,
			"processing": true,
			"serverSide": true,
            "searching": false,
            "bLengthChange": false,
            "sDom": '<"top"i>rt<"bottom"flp><"clear">',
			"sAjaxSource": "<?php echo $this->config->item('rootPath'); ?>/admin/news/listProduk",
			"bAutoWidth": true,
			"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
				$('td', nRow).attr('nowrap','nowrap');
				return nRow;

			},
			"fnServerData": function ( sSource, aoData, fnCallback, oSettings ) {
				aoData.push( { "name": n, "value": v} );
				oSettings.jqXHR = $.ajax({
					"dataType": 'json',
					"type": "POST",
					"url": sSource,
					"data": aoData,
					"success": fnCallback
				});
			},
		});
	});
    
    function showDialogUnit(param,paramId){
        $('#myModal').modal('show');
    }
   
    function getValue(obj,strFieldName,strFieldValue,strId){
				var g ='';
				jQuery.grep(obj, function( a,n ) {
					if(a[strFieldName] == strId){
						g=a[strFieldValue];
					}
				});
				return g;
			}

    function tampilUnit(){
        var a='';
		if(dataUnit.length>0){
			$.each(dataUnit, function( index, value ) {
		      	if(value.status!='delete'){
				  a=a+'<tr id="'+dataUnit[index].ItemId+'">';
                  a=a+'<td>'+dataUnit[index].ItemName+'</td>';
                  a=a+'<td>'+ dataUnit[index].KategoriName+'</td>';
                  a=a+'<td><a href="#" onclick="hapusUnit(\''+dataUnit[index].ItemId+'\'); event.preventDefault();"><i class="glyphicon glyphicon-remove"></i></a></td>';
							a=a+'</tr>';
				}
			});
		}else{
			a='<tr><td colspan="6"><center>DATA PRODUK BELUM DI PILIH , SILAHKAN KLIK TAMBAH PRODUK</center></td></tr>'
		}

		$('#tabelUnit tbody').html(a);
		return false;
    }

    function hapusUnit(idUnit){
	   jQuery.grep(dataUnit, function( a,n ) {
           if(a.ItemId == idUnit){
               var UnitId = dataUnit[n].ItemId;
               if(UnitId.substring(0, 3)=='add'){  
				    dataUnit.splice(n,1); 
				}else{
                    dataUnit[n].status='delete';
                    dataUnit.splice(n,1);
				}
				tampilUnit();
				return false;
           }
       });
        return false;
    }
    
    function saveUnit(ItemId, ItemName, KategoriName){
        var arr = [];
	    arr = jQuery.grep(dataUnit, function( a,n ) {
           return a.ItemId == ItemId
       });
        
        
        if(arr.length==0){
            var objProduk = {
					ItemId:ItemId,
					ItemName:ItemName,
					KategoriName:KategoriName,
				};
            dataUnit.push(objProduk);
            $('#myModal').modal('hide');
            tampilUnit();
            return false;
        }else{
            
            $('#myModal').modal('hide');
        }
        
        return false;
    }
    
    function fSubmit(){
		with (document.formDetail){
			//nicEditors.findEditor('area1').saveContent();
			//hdnSetting.value = JSON.stringify(dataUnit);
			submit();
		}
	}
    
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
            .red{
                color:red;
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
              Admin <small>Vesta</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/menu'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Admin News</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          	<div class="row">
				
				<form class="form-horizontal" method="post" name="formDetail" action="<?php echo site_url('admin/beranda/saveHome'); ?>" enctype="multipart/form-data" onsubmit="fSubmit();">
				
				 <div class="col-md-2" id="leftCol">
					<div id="sidebar">
					<h3>Menu News</h3>
					
					<a style="margin-bottom:5px" href="<?php echo site_url('admin/beranda') ?>" class="btn btn-success"><i class="glyphicon glyphicon-briefcase"></i>&nbsp;&nbsp; Lihat Data Home </a>
					<a onclick="fSubmit()" style="margin-bottom:5px" href="#" class="btn bg-primary"><i class="glyphicon glyphicon-save"></i>&nbsp;&nbsp; Save News </a>
                    <a style="margin-bottom:5px" href="<?php echo site_url('admin/beranda');?>" class="btn btn-danger"><i class="glyphicon glyphicon-briefcase"></i>&nbsp;&nbsp; Cancel </a>
					 </div>
				 </div>	
				 <div class="col-md-7">
					<div class="box box-success">
                       <div class="box-header">
							 <h3 class="box-title"><b>Form Home</b></h3>
						 </div>
						  <div class="box-body">
                           
                           <?php if ($HomeId != ""){ ?>
	                            <input type="hidden" id="txtHomeId" name="txtHomeId" value="<?php echo $HomeId; ?>">
                           <?php } ?>
                            
                            <input type="hidden" id="dropkey" name="dropkey" value="<?php echo $DropKey; ?>" />
				            <input type="hidden" id="hdnKey" name="hdnKey" value="<?php echo $this->encrypt->encode($Key); ?>">
				            <input type="hidden" name="txtHomeId" value="<?php echo $HomeId ?>"/>
                            <input type="hidden" id="hdnSetting" name="hdnSetting" value="" />
                             
                            <div class="form-group">
                                  <label class="col-sm-3 control-label"  for="exampleInputEmail1">Tanggal</label>
                                  <div class="col-sm-5">
                                      <input type="text" class="form-control" id="datepicker" placeholder="" name="" value="<?php echo date("l, d F Y H:i:s") ?>" disabled="disable" >
                                  </div>
                             </div>
						  
							<div class="form-group">
							  <label for="exampleInputEmail1" class="col-sm-3 control-label">Home Title<span class="red" style="margin-left:5px;">*</span></label>
							  <div class="col-sm-8">
								<input type="text" class="form-control"  placeholder="enter news title" name="txtHomeTitle" value="<?php echo $HomeTitle; ?>">
							  </div>
							</div>
							
							<div class="form-group row">
							    <label class="col-sm-3 control-label" for="exampleInputEmail1">Status<span class="red" style="margin-left:5px;">*</span></label>
							    <div class="col-sm-5">
							       <select class="form-control" id="select" name="txtStatus" value="<?php echo $HomeStatus ?>">
								        <?php echo"
								        <option value='1' ".($HomeStatus==1?'selected':'')." >Banner Home Big</option>
								        <option value='2' ".($HomeStatus==2?'selected':'').">Banner Content Small</option>";?>							
								    </select>
							    </div>
							</div>
							
							
							<div class="form-group">
                          
                              <center>
                                <img src="<?php echo $this->imageloader->fHomeImage($home,2); ?>" id="imgItem" name="imgItem" width="200px">
                            </center>
                          
							  <label for="exampleInputEmail1" class="col-sm-3 control-label">Home Image<span class="red" style="margin-left:5px;">*</span></label>
							  <div class="col-sm-8">
								<input type="file" class="upload" name="HomeImage" id="NewsImage" value="" />
							  </div>
							</div>
							
						  </div><!-- /.box-body -->
					</div> 
				 </div>
				</form>
		 	</div>
</section>
    