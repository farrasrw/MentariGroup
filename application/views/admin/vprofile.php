 <section class="content-header">
          <h1>
            Profile
            <small>Administrator</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url('menu'); ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class="active">Administrator</li>
          </ol>
        </section>

        <div class="pad margin no-print">
            <div class="callout callout-danger">
                    <h4>Profile Administrator</h4>
                  </div>
                  
            <div class="box">
            <div class="box-header with-border box-success">
             <?php
             foreach ($admin as $listProfile){
                ?>
              <h3 class="box-title"><b>Nama</b></h3>
            </div>
            <div class="box-body">
                <?php echo $listProfile->AdminName ?>
            </div><!-- /.box-body -->
            
            <div class="box-header with-border">
              <h3 class="box-title"><b>Email</b></h3>
            </div>
            <div class="box-body">
                <?php echo $listProfile->AdminEmail ?>
            </div><!-- /.box-body -->
            
            <div class="box-header with-border">
               <h3 class="box-title"><b>Status</b></h3>
            </div>
            <div class="box-body">
                <?php if($listProfile->AdminSts == '1'){echo "Active";}
                 else {echo "Disable";}?>
            </div>
            
            <div class="box-header with-border">
                <h3 class="box-title"><b>Group</b></h3>
            </div>
            <div class="box-body">
                <?php if($listProfile->AdminGroupId =='1'){ echo "Administrator";}
                 else if($listProfile->AdminGroupId =='2'){echo "User";}
                 else {echo "Member";} ?>
            </div>
            <br>
            <br>
            <br>
          </div><!-- /.box -->
        </div>
        <?php
            } 
        ?>
        
    <div class="clearfix"></div>
</section>