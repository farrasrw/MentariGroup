<style>
        .homeimg{
            padding: 10px;
        }
        
        .listhr {
            margin-top: 10px;
            margin-bottom: 10px;
            border: 0;
            border-bottom: 1px solid #000;
        }
        </style>

<?php if(count($banner)> 0){
    foreach($banner as $objBanner){ ?>
        <!--<img class="imgload" src="<?php echo base_url(); ?>style/web/images/banner.jpg?o=c661" src-small="images/banner.jpg?o=c661" width="100%" style="display: block;">-->
        <img class="imgload" src="<?php echo $this->imageloader->getGlobalImage('3x1',false); ?>"  src-small="<?php echo $this->imageloader->fBannerImage($objBanner,'image_mobile','400x400' );?>" src-large="<?php echo $this->imageloader->fBannerImage($objBanner,'image_desktop','990x330');?>" title="<?php echo $objBanner->banner_title; ?>" alt="<?php echo $objBanner->banner_title; ?>-butuhdesain" width="100%" style="display: block;"/>
<?php }}?>
       
        <div class="container">
            <div class="row" style="margin-top:20px;margin-bottom:20px">
               
               <?php 
                foreach($package as $value) {?>
               
                <div class="col-sm-6 col-xs-24 padding10">
                  
                  <!--<img class="imgload hidden-xs hidden-sm" src="<?php echo base_url(); ?>style/images/creative-quotes-steve-jobs-black.jpg" src-small="images/home/creative-quotes-steve-jobs-black.jpg" width="100%" style="display: block;">-->
                    
                    <div style="background-color:#e6e6e6">

                
                    <div class="home-banner-left">
                        <span class="font30" style="font-family:Roboto-Regular;color:black"><b><?php echo $value->project_name; ?></b></span><br><br>
                        <span class="font18" style="color:black">
                        <b><?php echo $value->project_content ?>
                        </b></span><br>
                        <div style="margin-top:10px">
                            <!--<button class="btn-default" type="button" id="btn-explore"><span style="font-size:12px; color:white"><b>BUY</b></span><i class="glyphicon glyphicon-chevron-right" style="color:black;margin-left:10px;"></i></button>-->
                            
                            <style>
                            #btn-addcart {
                                padding: 5px;
                                border: 2px solid #d12229;
                                box-shadow: 0 1px 2px #969696;
                                width: 50%;
                                background-color: #d12229;
                                color: white;
                            }
                            </style>
                            
                            <button type="button" class="btn-default btn-detail" id="btn-addcart" onclick="location.href='mailto:info@butuhdesign.com';"><span class="font14"><b>BUY</b></span></button>
                            <br>
                            <br>
                        </div>
                    </div>
                        </div>
                </div>
                
                <?php } ?>
                
                <!--<div class="col-sm-6 col-xs-24 padding10">
                  
                  <img class="imgload" src="<?php echo base_url(); ?>style/images/creative-quotes-steve-jobs-black.jpg" src-small="images/home/creative-quotes-steve-jobs-black.jpg" width="100%" style="display: block;">

                
                    <div class="home-banner-left">
                        <span class="font30" style="font-family:Roboto-Regular;color:black"><b>PROMOTION</b></span><br><br>
                        <span class="font18" style="color:black">
                        <b><div>LOGO/IDENTITY<br>
                            BUSINESS CARD<br>
                            FLYER/BROCHURE<br>
                            ONLINE ADVERTISING<br>
                            (10.000 VIEWERS)</div>
                        </b></span><br>
                        <div style="margin-top:10px">
                            <button class="btn-default" type="button" id="btn-explore"><span style="font-size:12px; color:white"><b>EXPLORE IT</b></span><i class="glyphicon glyphicon-chevron-right" style="color:black;margin-left:10px;"></i></button>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6 col-xs-24 padding10">
                  
                  <img class="imgload" src="<?php echo base_url(); ?>style/images/creative-quotes-steve-jobs-black.jpg" src-small="images/home/creative-quotes-steve-jobs-black.jpg" width="100%" style="display: block;">

                
                    <div class="home-banner-left">
                        <span class="font30" style="font-family:Roboto-Regular;color:black"><b>COMPANY</b></span><br><br>
                        <span class="font18" style="color:black">
                        <b><div>LOGO/IDENTITY<br>
                            BUSINESS CARD<br>
                            FLYER/BROCHURE<br>
                            ONLINE ADVERTISING<br>
                            (10.000 VIEWERS)</div>
                        </b></span><br>
                        <div style="margin-top:10px">
                            <button class="btn-default" type="button" id="btn-explore"><span style="font-size:12px; color:white"><b>EXPLORE IT</b></span><i class="glyphicon glyphicon-chevron-right" style="color:black;margin-left:10px;"></i></button>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6 col-xs-24 padding10">
                  
                  <img class="imgload" src="<?php echo base_url(); ?>style/images/creative-quotes-steve-jobs-black.jpg" src-small="images/home/creative-quotes-steve-jobs-black.jpg" width="100%" style="display: block;">

                
                    <div class="home-banner-left">
                        <span class="font30" style="font-family:Roboto-Regular;color:black"><b>PRODUCTION</b></span><br><br>
                        <span class="font18" style="color:black">
                        <b><div>LOGO/IDENTITY<br>
                            BUSINESS CARD<br>
                            FLYER/BROCHURE<br>
                            ONLINE ADVERTISING<br>
                            (10.000 VIEWERS)</div>
                        </b></span><br>
                        <div style="margin-top:10px">
                            <button class="btn-default" type="button" id="btn-explore"><span style="font-size:12px; color:white"><b>EXPLORE IT</b></span><i class="glyphicon glyphicon-chevron-right" style="color:black;margin-left:10px;"></i></button>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6 col-xs-24 padding10">
                  
                  <img class="imgload" src="<?php echo base_url(); ?>style/images/creative-quotes-steve-jobs-black.jpg" src-small="images/home/creative-quotes-steve-jobs-black.jpg" width="100%" style="display: block;">

                
                    <div class="home-banner-left">
                        <span class="font30" style="font-family:Roboto-Regular;color:black"><b>PRODUCTION</b></span><br><br>
                        <span class="font18" style="color:black">
                        <b><div>LOGO/IDENTITY<br>
                            BUSINESS CARD<br>
                            FLYER/BROCHURE<br>
                            ONLINE ADVERTISING<br>
                            (10.000 VIEWERS)</div>
                        </b></span><br>
                        <div style="margin-top:10px">
                            <button class="btn-default" type="button" id="btn-explore"><span style="font-size:12px; color:white"><b>EXPLORE IT</b></span><i class="glyphicon glyphicon-chevron-right" style="color:black;margin-left:10px;"></i></button>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6 col-xs-24 padding10">
                  
                  <img class="imgload" src="<?php echo base_url(); ?>style/images/creative-quotes-steve-jobs-black.jpg" src-small="images/home/creative-quotes-steve-jobs-black.jpg" width="100%" style="display: block;">

                
                    <div class="home-banner-left">
                        <span class="font30" style="font-family:Roboto-Regular;color:black"><b>PRODUCTION</b></span><br><br>
                        <span class="font18" style="color:black">
                        <b><div>LOGO/IDENTITY<br>
                            BUSINESS CARD<br>
                            FLYER/BROCHURE<br>
                            ONLINE ADVERTISING<br>
                            (10.000 VIEWERS)</div>
                        </b></span><br>
                        <div style="margin-top:10px">
                            <button class="btn-default" type="button" id="btn-explore"><span style="font-size:12px; color:white"><b>EXPLORE IT</b></span><i class="glyphicon glyphicon-chevron-right" style="color:black;margin-left:10px;"></i></button>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6 col-xs-24 padding10">
                  
                  <img class="imgload" src="<?php echo base_url(); ?>style/images/creative-quotes-steve-jobs-black.jpg" src-small="images/home/creative-quotes-steve-jobs-black.jpg" width="100%" style="display: block;">

                
                    <div class="home-banner-left">
                        <span class="font30" style="font-family:Roboto-Regular;color:black"><b>PRODUCTION</b></span><br><br>
                        <span class="font18" style="color:black">
                        <b><div>LOGO/IDENTITY<br>
                            BUSINESS CARD<br>
                            FLYER/BROCHURE<br>
                            ONLINE ADVERTISING<br>
                            (10.000 VIEWERS)</div>
                        </b></span><br>
                        <div style="margin-top:10px">
                            <button class="btn-default" type="button" id="btn-explore"><span style="font-size:12px; color:white"><b>EXPLORE IT</b></span><i class="glyphicon glyphicon-chevron-right" style="color:black;margin-left:10px;"></i></button>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6 col-xs-24 padding10">
                  
                  <img class="imgload" src="<?php echo base_url(); ?>style/images/creative-quotes-steve-jobs-black.jpg" src-small="images/home/creative-quotes-steve-jobs-black.jpg" width="100%" style="display: block;">

                
                    <div class="home-banner-left">
                        <span class="font30" style="font-family:Roboto-Regular;color:black"><b>PRODUCTION</b></span><br><br>
                        <span class="font18" style="color:black">
                        <b><div>LOGO/IDENTITY<br>
                            BUSINESS CARD<br>
                            FLYER/BROCHURE<br>
                            ONLINE ADVERTISING<br>
                            (10.000 VIEWERS)</div>
                        </b></span><br>
                        <div style="margin-top:10px">
                            <button class="btn-default" type="button" id="btn-explore"><span style="font-size:12px; color:white"><b>EXPLORE IT</b></span><i class="glyphicon glyphicon-chevron-right" style="color:black;margin-left:10px;"></i></button>
                        </div>
                    </div>
                </div>-->

            </div>
        </div>