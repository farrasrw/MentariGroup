<script type="text/javascript">
    function fSubmit(){
		with (document.formDetail){
			submit();
		}
	}
</script>

<section class="content-header">
         <?php error_reporting(0) ?>
          <h1>
            Admin <small>JAGAPATI.com</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin/menu'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Admin</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-2" id="leftCol">
					<div id="sidebar">
					<h3>Menu Admin</h3>
					<a style="margin-bottom:5px" href="<?php echo site_url('admin/admin');?>" class="btn btn-success"><i class="glyphicon glyphicon-briefcase"></i>&nbsp;&nbsp; Lihat Data Admin</a>
					<a onclick="fSubmit()" style="margin-bottom:5px" href="#" class="btn bg-primary"><i class="glyphicon glyphicon-save"></i>&nbsp;&nbsp; Save Admin </a>
                    <a style="margin-bottom:5px" href="<?php echo site_url('admin/admin');?>" class="btn btn-danger"><i class="glyphicon glyphicon-briefcase"></i>&nbsp;&nbsp; Cancel </a>
					 </div>
				 </div>
            
            <div class="col-md-8">
              <!-- general form elements -->
              <div class="box box-success">
                <div class="box-header">
                 <?php if ($AdminId != ""){ ?>
                    <h3 class="box-title">Edit Admin</h3>
                 <?php } else {?>
                 <?php   ?>
                    <h3 class="box-title">Add Admin</h3>
                 <?php } ?>
                 
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" name="formDetail" id="formDetail" method="post" action="<?php echo site_url('admin/admin/saveAdmin'); ?>" onsubmit="fSubmit();">
                  <div class="box-body">
                  <?php if ($AdminId != ""){ ?>
	                    <input type="hidden" id="txtAdminID" name="txtAdminID" value="<?php echo $AdminId; ?>">
                     <?php } ?>
                     
                         <input type="hidden" id="dropkey" name="dropkey" value="<?php echo $DropKey; ?>" />
				        <input type="hidden" id="hdnKey" name="hdnKey" value="<?php echo $this->encrypt->encode($Key); ?>">
				        <input type="hidden" name="txtAdminID" value="<?php echo $AdminId ?>"/>
                     
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label for="exampleInputEmail1">Kode Admin</label>
                            <input type="text" class="form-control" id="txtAdminID" name="txtAdminID" value="<?php echo $Kode; ?>" readonly>
                        </div>
                    </div> 
                    
                    <div class="form-group row">
                     <div class="col-sm-6">
                      <label for="exampleInputEmail1">Nama</label>
                      <input type="text" class="form-control"  placeholder="nama admin" name="txtNama" value="<?php echo $AdminName; ?>" required>
                       </div>
                       
                       <div class="col-sm-6">
                      <label for="exampleInputEmail1">Username</label>
                      <input type="text" class="form-control"  placeholder="password admin" name="txtUsername" value="<?php echo $AdminEmail; ?>" required>
                       </div>
                       
                    </div>
                    
                    <div class="form-group row">
                    <div class="col-sm-6">
                      <label for="exampleInputEmail1">Password</label>
                          <input type="password" class="form-control"  placeholder="password admin" name="txtPassword" value="<?php echo $AdminPass; ?>" required>
                       </div>
                    
                    <div class="col-sm-6">
                      <label for="exampleInputEmail1">Status</label>
                      <select class="form-control" name="txtStatus" value="<?php echo $AdminSts ?>" required>
                       <?php 
                        echo"
                            <option value=''>--Pilih Status--</option>
                            <option value='1' ".($AdminSts==1?'selected':'').">Active</option>
                            <option value='2' ".($AdminSts==2?'selected':'').">Non Active</option>"; ?>
                      </select>
                       </div>
                    </div>
                  </div><!-- /.box-body -->

                  <!--<div class="box-footer">
                    <input class="btn btn-success" type="submit" name="btnSave" value="Save" />
                    <a class="btn btn-danger" href="<?php //echo site_url('admin/admin');?>">Cancel</a>
                    
                  </div>-->
                </form>
              </div><!-- /.box -->
			  </div>
			  </div>
</section>