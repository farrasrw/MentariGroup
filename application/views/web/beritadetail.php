<script>
$(document).ready(function(){
    
    var baseurl='<?php echo base_url(); ?>';
    
    //alert(baseurl);
    
		$("#facebook-share").click(function(){
			window.open("https://www.facebook.com/sharer/sharer.php?u="+baseurl+"berita/detail/<?php echo $data[0]->berita_url ?>", "myWindow", "width=500, height=500");
		});

		$("#twitter-share").click(function(){
			var theUrl=""+baseurl+"/berita/detail/<?php echo $data[0]->berita_url ?>";
			window.open("https://twitter.com/intent/tweet?original_referer="+baseurl+"berita/detail/<?php echo $data[0]->berita_url ?>&tw_p=tweetbutton&url="+theUrl+"&text=<?php echo $data[0]->berita_url ?>", "myWindow", "width=500, height=500");

		});

		$("#google-share").click(function(){
			window.open("https://plus.google.com/share?url="+baseurl+"berita/detail/<?php echo $data[0]->berita_url ?>", "myWindow", "width=500, height=500");
		});
	
	})
</script>

<div class="container-fluid">
   <div class="row">
       <img class="imgload"
            src="<?php echo base_url(); ?>style/images/banner_menu.jpg?o=d59c"
            src-small="<?php echo base_url(); ?>style/images/banner_menu.jpg?o=d59c"
            title="banner" alt="banner" width="100%" style="display: block;">
    </div>


<div class="container">
    <div class="row padding10">

        <div class="col-lg-12 col-md-12 col-sm-24 col-xs-24 itemartikel">
            <div class="row relative artikelfloat  shinewhite">
                <center><a class="text-black" href="#">
                    <div class="col-lg-24 img7-6">
                        <img class="imgload" src="<?php echo $this->imageloader->getGlobalImage('3x1',false); ?>"  src-small="<?php echo $this->imageloader->fimageberita($data[0],2);?>" src-large="<?php echo $this->imageloader->fimageberita($data[0],2);?>" title="<?php echo $data[0]->berita_title; ?>" alt="<?php echo $data[0]->berita_title; ?>-butuhdesain" width="100%" style="display: block;"/>
                    </div>
                    <!--<h4 class="col-lg-24 bgblack font30 padding10"><br><br></h4>-->
                </a></center>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-24 col-xs-24 padding40">
           <span class="text-bold font30 text-bold"><?php echo strtoupper($data[0]->berita_title); ?></span>
            <div class="row">
                <div style="text-align: justify;margin-top:20px" id="detaildlog">
                    <?php echo $data[0]->berita_content; ?>
                </div>
            </div>
            <div class="row">
                      <br>

                      <div class="col-lg-24 col-xs-24 text-right" style="margin-bottom:5px">

                        <a id="facebook-share" class="sh-fb-ab" style="cursor:pointer;"><img src="<?php echo base_url(); ?>style/web/images/sosmed/facebook.png" width="35px"></a>
                          
                        <a id="twitter-share" class="sh-tw-ab" style="cursor:pointer;"><img src="<?php echo base_url(); ?>style/web/images/sosmed/twitter.png" width="35"></a>
                          
                        <a id="google-share" class="sh-gp-ab" style="cursor:pointer;"><img src="<?php echo base_url(); ?>style/web/images/sosmed/google.png" width="35"></a>
                          
                        <!--<a id="google-share" class="sh-gp-ab" style="cursor:pointer;"><img src="style/web/images/sosmed/email.png" width="35" /></a>-->

                        
                        <!-- line sharer -->
                        <a class="hidden-lg hidden-sm" href="http://line.me/R/msg/text/?<?php echo base_url(); ?>berita/detail/<?php echo $data[0]->berita_url ?>" target="_blank">
                        <img src="<?php echo base_url(); ?>style/web/images/sosmed/line.png" width="35">
                        </a>

                        <!-- whatsapp sharer -->
                        <a class="hidden-lg hidden-sm" href="whatsapp://send?text=<?php echo base_url(); ?>berita/detail/<?php echo $data[0]->berita_url ?>" target="_blank">
                        <img src="<?php echo base_url(); ?>style/web/images/sosmed/whatsapp.png" width="35">
                        </a>
                          
                        <!-- whatsapp sharer -->
                        <a class="hidden-lg hidden-sm" href="bbmi://api/share?message=<?php echo base_url(); ?>berita/detail/<?php echo $data[0]->berita_url ?>" target="_blank">
                        <img src="<?php echo base_url(); ?>style/web/images/sosmed/bbm.png" width="35">
                        </a>


                    </div>
                    </div>
        </div>
    </div>
</div>
</div>