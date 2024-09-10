<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>js/DataTables/css/jquery.dataTables.min.css" />
<script src="<?php echo base_url() ?>js/DataTables/js/jquery.dataTables.min.js" type="text/javascript"></script>-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>js/DataTables/css/jquery.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>js/DataTables/css/dataTables.responsive.css">

<script src="<?php echo base_url() ?>js/DataTables/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>js/DataTables/js/dataTables.responsive.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/tinymce/js/tinymce/tinymce.min.js"></script>



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
            "sAjaxSource": "<?php echo base_url(); ?>admin/project/listprojectdata",
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
    
    $(document).ready(function() {
            $('#projectname').val('');
            $('#textarea1').val('');
        
        if (typeof(tinyMCE) != 'undefined') {  
          $('#textarea1').val('');  // Removes all paragraphs in the active editor   
        }

        });
    
	
	function saveProject(){
		//var data;
        var data= { 
            projectcontent : tinyMCE.get('textarea1').getContent(),
        };
		var url;
		var objform =$('#formproject');
		postData(data,url,objform, function(){
			
			contoj.fnDraw();
		});
	}
	
	function tambahproject(){
		$('#formproject').attr('action','<?php echo base_url(); ?>admin/project/saveaddproject');
		$('#titleBox').html('Sialahkan Tambah project');
		$('#projectname').val('');
		$('#hdnkey').val('<?php echo $this->ffunction->encode($hdnkey); ?>');
	}
	
	function editproject(v,katagoriname){
		$('#formproject').attr('action','<?php echo base_url(); ?>admin/project/saveeditproject');
		$('#titleBox').html('Edit project');
		$('#hdnkey').val(v);
		$('#projectname').val(katagoriname);
        $('#textarea1').val(katagoriname);
		
		
		
	}
	
	$(function (){
        $('#datetimepicker').datepicker({
		  autoclose: true,
		  format:'yyyy-mm-dd'
		});
    });
    
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
			//file_picker_callback : elFinderBrowser,
			//file_picker_types: 'image',
			//content_css: '/assets/admin/dist/css/stylecontent.css',
    	  //importcss_append: true,
		  //importcss_file_filter: "/assets/admin/dist/css/stylecontent.css",

			templates: [
					{title: 'Test template 1', content: 'Test 1'},
					{title: 'Test template 2', content: 'Test 2'}
			],
        
        
		


        });
	
</script>
        <?php error_reporting(0) ?>

<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tambah project
        <small>silahkan kelola package dengan mengisi form di bawah dengan lengkap</small>
      </h1>
    </section>

<section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Add package</h3>
                                  
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post" action="<?php echo base_url(); ?>admin/project/<?php echo ($viewstate=='add'?'saveaddproject':'saveeditproject');  ?>" id="formproject">
                  <div class="box-body">
                    <input id="hdnkey" type="hidden" name="hdnkey" value="<?php echo $this->ffunction->encode($hdnkey); ?>"/>                  
                    <div class="form-group row">
                     <div class="col-sm-6">
                      <label for="exampleInputEmail1">package Name</label>
                      <input id="projectname" class="form-control" required name="projectname"  placeholder="Project Name" type="text" value="<?php echo $project->project_name;  ?>">
                       </div>
                    </div>
                    
                    <div class="form-group row">
                     <div class="col-sm-12">
                      <label for="exampleInputEmail1">Package Content</label>
                      <textarea id="textarea1" name="projectcontent" ><?php echo $project->project_content ?></textarea> 
                       </div>
                    </div>
                    
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                      <button type="button" class="btn btn-danger btn-flat" onclick="saveProject();" >Save package</button>
                    <a class="btn btn-success btn-flat" href="<?php echo base_url(); ?>admin/project">Cancel</a>
                    
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
				  <h3 class="box-title">Data Project</h3>
				</div>
                <div class="box-body">
                    <table id="contoj" class="data display datatable"  cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Id</th>
								<th>package Name</th>
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
