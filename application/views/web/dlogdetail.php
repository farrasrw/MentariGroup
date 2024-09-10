<script>
$(document).ready(function(){
    
    
    var baseurl='<?php echo base_url(); ?>';
    
    //alert(baseurl);
    
		$("#facebook-share").click(function(){
			window.open("https://www.facebook.com/sharer/sharer.php?u="+baseurl+"dlog/detail/<?php echo $dlogdetail->berita_url ?>", "myWindow", "width=500, height=500");
		});

		$("#twitter-share").click(function(){
			var theUrl=""+baseurl+"/dlog/detail/<?php echo $dlogdetail->berita_url ?>";
			window.open("https://twitter.com/intent/tweet?original_referer="+baseurl+"dlog/detail/<?php echo $dlogdetail->berita_url ?>&tw_p=tweetbutton&url="+theUrl+"&text=<?php echo $dlogdetail->berita_url ?>", "myWindow", "width=500, height=500");

		});

		$("#google-share").click(function(){
			window.open("https://plus.google.com/share?url="+baseurl+"dlog/detail/<?php echo $dlogdetail->berita_url ?>", "myWindow", "width=500, height=500");
		});
	
	})
</script>

<div class="container">
    <div class="row padding10">

        <div class="col-lg-12 col-md-12 col-sm-24 col-xs-24 itemartikel">
            <div class="row relative artikelfloat  shinewhite">
                <center><a class="text-black" href="<?php echo base_url(); ?>dlog/detail/<?php echo $dlogdetail->berita_url ?>">
                    <div class="col-lg-24 img7-6">
                        <img class="imgload" src="<?php echo $this->imageloader->getGlobalImage('3x1',false); ?>"  src-small="<?php echo $this->imageloader->fimageberita($dlogdetail,2);?>" src-large="<?php echo $this->imageloader->fimageberita($dlogdetail,2);?>" title="<?php echo $dlogdetail->berita_title; ?>" alt="<?php echo $dlogdetail->berita_title; ?>-butuhdesain" width="100%" style="display: block;"/>
                    </div>
                    <!--<h4 class="col-lg-24 bgblack font30 padding10"><?php //echo
                         //$dlogdetail->berita_title; ?><br><br><?php //echo number_format($dlogdetail->berita_price); ?></h4>-->
                </a></center>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-24 col-xs-24 padding40">
           <span class="text-bold font30 text-bold"><?php echo $dlogdetail->berita_title; ?></span>
            <div class="row">
                <div style="text-align: justify;margin-top:20px" id="detaildlog">
                    <span><?php echo $dlogdetail->berita_content; ?>
                    </span>
                </div>
            </div>
            <div class="row">
                      <br>

                      <div class="col-lg-24 col-xs-24 text-right" style="margin-bottom:5px">

                        <a id="facebook-share" class="sh-fb-ab" style="cursor:pointer;"><img src="<?php echo $this->config->item('base_url_media'); ?>style/web/images/sosmed/facebook.png" width="35px" /></a>
                          
                        <a id="twitter-share" class="sh-tw-ab" style="cursor:pointer;"><img src="<?php echo $this->config->item('base_url_media'); ?>style/web/images/sosmed/twitter.png" width="35" /></a>
                          
                        <a id="google-share" class="sh-gp-ab" style="cursor:pointer;"><img src="<?php echo $this->config->item('base_url_media'); ?>style/web/images/sosmed/google.png" width="35" /></a>
                          
                        <!--<a id="google-share" class="sh-gp-ab" style="cursor:pointer;"><img src="<?php //echo $this->config->item('base_url_media'); ?>style/web/images/sosmed/email.png" width="35" /></a>-->

                        <?php $strLink=base_url().'dlog/detail/'.$dlogdetail->berita_url; ?>

                        <!-- line sharer -->
                        <a class="hidden-lg hidden-sm" href="http://line.me/R/msg/text/?<?php echo $strLink; ?>" target="_blank">
                        <img src="<?php echo $this->config->item('base_url_media'); ?>style/web/images/sosmed/line.png" width="35" />
                        </a>

                        <!-- whatsapp sharer -->
                        <a class="hidden-lg hidden-sm" href="whatsapp://send?text=<?php echo $strLink ?>" target="_blank">
                        <img src="<?php echo $this->config->item('base_url_media'); ?>style/web/images/sosmed/whatsapp.png" width="35" />
                        </a>
                          
                        <!-- whatsapp sharer -->
                        <a class="hidden-lg hidden-sm" href="bbmi://api/share?message=<?php echo $strLink ?>" target="_blank">
                        <img src="<?php echo $this->config->item('base_url_media'); ?>style/web/images/sosmed/bbm.png" width="35" />
                        </a>


                    </div>
                    </div>
        </div>
    </div>
</div>