<!-- Tagit -->
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/js/Tagit2/css/jquery.tagit.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/Tagit2/tag-it.min.js"></script>





<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/tinymce/js/tinymce/tinymce.min.js"></script>

<!-- Dropzone -->
<link href="<?php echo base_url() ?>assets/js/dropzone/css/basic.css" rel="stylesheet">
<link href="<?php echo base_url() ?>assets/js/dropzone/css/dropzone.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/dropzone/dropzone.min.js"></script>



<script>
	
	function elFinderBrowser (callback, value, meta) {
			tinymce.activeEditor.windowManager.open({
				file: '<?php echo base_url(); ?>admin/about/imagemanager/<?php echo $dropkey; ?>/<?php echo ($hdnkey!='tambahabout'?$hdnkey:''); ?>',// use an absolute path!
				title: 'Image Manager',
				width: 700,	
				height: 400,
				resizable: 'no'
			}, {
				oninsert: function (file) {
					var url, reg, info;

					// URL normalization
					url = file.url;
					reg = /\/[^/]+?\/\.\.\//;
					while(url.match(reg)) {
						url = url.replace(reg, '/');
					}
					
					// Make file info
					info = file.name;

					
					// Provide image and alt text for the image dialog
					if (meta.filetype == 'image') {
						callback(url, {alt: info});
					}

					
				}
			});
			return false;
		}
		
	tinymce.init({
            selector: "#textarea1",
			min_height: 300,
					relative_urls: false,
			remove_script_host: false,
			plugins: [
                "importcss advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker textpattern"
			],

			toolbar1: "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
			toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor",
			toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft",

			menubar: false,
			toolbar_items_size: 'small',

			style_formats: [
					{title: 'Bold text', inline: 'b'},
					{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
					{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
					{title: 'Example 1', inline: 'span', classes: 'example1'},
					{title: 'Example 2', inline: 'span', classes: 'example2'},
					{title: 'Table styles'},
					{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
			],
			file_picker_callback : elFinderBrowser,
			file_picker_types: 'image',
			content_css: '/assets/admin/dist/css/stylecontent.css',
    	importcss_append: true,
		  importcss_file_filter: "/assets/admin/dist/css/stylecontent.css",

			templates: [
					{title: 'Test template 1', content: 'Test 1'},
					{title: 'Test template 2', content: 'Test 2'}
			]
		


        });
	
	function savedirektori(){
		
		var data= { 
            content_about : tinyMCE.get('textarea1').getContent(),
        };
		var url;
		var objform = $('#formabout');
		postData(data,url,objform);
	}
	
</script>
        <?php error_reporting(0) ?>

<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tambah About
        <small></small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      	<div class="row">
      	
      	<div class="col-md-2" id="leftCol">
					<div id="sidebar">
					<h3>Menu Content</h3>
					<a style="margin-bottom:5px" href="<?php echo base_url(); ?>admin/about/index.html" class="btn btn-success btn-flat"><i class="glyphicon glyphicon-briefcase"></i>&nbsp;&nbsp; Lihat Data</a>
					<a onclick="savedirektori()" style="margin-bottom:5px" href="#" class="btn bg-navy btn-flat"><i class="glyphicon glyphicon-save"></i>&nbsp;&nbsp; Save Content</a>
                    <a style="margin-bottom:5px" href="<?php echo base_url(); ?>admin/about/index.html" class="btn btn-danger btn-flat"><i class="glyphicon glyphicon-briefcase"></i>&nbsp;&nbsp; Cancel </a>
					 </div>
				 </div>
      	
			<div class="col-md-10">
			<div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Harap Isi Form Dengan Lengkap</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>admin/about/<?php echo ($viewstate=='add'?'saveaddabout':'saveeditabout');  ?>" id="formabout">
				<input type="hidden" name="hdnkey" id="hdnkey" value="<?php echo $this->ffunction->encode($hdnkey); ?>"/>
				<input type="hidden" name="dropkey" value="<?php echo $dropkey; ?>"/>
				<!--<input type="hidden" name="imageheader" value="" id="imageheader" />-->
				
				<div class="box-body">
                
                <div class="form-group">
                  <div class="col-xs-2">
                        <label  class="col-sm-3 control-label nobold font16">Type</label>
                    </div>
                  
                  <div class="col-sm-10">
                    <select name="txtType"  required class="form-control">
						<option value="0" <?php echo ($about->about_type==0?'selected':''); ?>>Latar belakang</option>  
						<option value="1" <?php echo ($about->about_type==1?'selected':''); ?>>Visi</option> 
                        <option value="2" <?php echo ($about->about_type==2?'selected':''); ?>>Nilai perusahaan</option> 
                        <option value="3" <?php echo ($about->about_type==3?'selected':''); ?>>Struktur Organisasi</option> 
                        <option value="4" <?php echo ($about->about_type==4?'selected':''); ?>>Dewan & Holding</option> 
                        <option value="5" <?php echo ($about->about_type==5?'selected':''); ?>>Anak Perusahaan</option> 
                        <option value="6" <?php echo ($about->about_type==6?'selected':''); ?>>Misi</option> 
					</select>
                  </div>
                </div>
                    
				<div class="form-group">
                 <div class="col-xs-2" style="padding-top:8px;  margin-bottom:10px">
                     <label  class="col-sm-3 control-label nobold font16">Content</label>
                    </div>
                 <div class="col-xs-10" style="margin-bottom:10px">
                     <textarea id="textarea1" ><?php echo $about->content ?></textarea> 
                 </div>
                </div>
                
                </div>
                </form>

				
         
          </div>
					</div>
		</div>	
    </section>
    <!-- /.content -->

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
            "sAjaxSource": "<?php echo base_url(); ?>admin/about/listaboutdata",
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

<!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
				  <h3 class="box-title">Data</h3>
				</div>
                <div class="box-body">
                    <table id="contoj" class="data display datatable"  cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Id</th>
								<th>Type</th>
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


