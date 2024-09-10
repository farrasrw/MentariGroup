<script>
function tmessage(){
            var data;
            var url; 
            var target;
            var objForm = $('#form_message');
            postData(data,url,objForm);
        }
</script>

<script>
    $(document).ready(function() {

        var winWidth = window.innerWidth ;
        if(winWidth >=798 ){
            $('.dropdown-toggle').addClass('disabled');
        }


        $('.dropdown-menu').on({
            "click":function(e){
              if($('window').innerWidth() <= 719){
                e.stopPropagation();
              }

            }
        });

        var shown = $.cookie('dialogShown');

        loadimages();

        $('.slide-banner').owlCarousel({
            items: 1,
            autoPlay: 5000,
            autoplayHoverPause: true,
            itemsDesktop: [1024,1],
            itemsTablet:[768,1],
            itemsMobile:[480,1],
            autoHeight:false,
            navigation: true,
            /*navigationText: [
              "<i class='glyphicon glyphicon-menu-left'></i>",
              "<i class='glyphicon glyphicon-menu-right'></i>"
            ],*/
            navigationText: [
              "",
              ""
            ],
            touchDrag               : false,
            mouseDrag               : false
        });

});
</script>

<style>

    .themeNav .owl-controls .owl-buttons .owl-prev {
        left: -5px;
        position: absolute;
        top: 30%;
        background: url(<?php echo base_url(); ?>/style/images/arrows-2x.png) no-repeat -30px 0 !important;
        width: 160px !important;
        height: 180px !important;
    }

    .themeNav .owl-controls .owl-buttons .owl-next {
        right: -5px;
        position: absolute;
        top: 30%;
        background: url(<?php echo base_url(); ?>/style/images/arrows-2x.png) no-repeat -110px 0 !important;
        width: 160px !important;
        height: 180px !important;
    }

    .owl-theme .owl-controls .owl-page span {
        display: block;
        width: 15px;
        height: 15px;
        margin: 5px 3px;
        filter: Alpha(Opacity=50);
        opacity: 0.5;
        -webkit-border-radius: 20px;
        -moz-border-radius: 20px;
        border-radius: 20px;
        background: white;
    }
    
    .themeNav .owl-controls .owl-pagination {
        position: absolute;
        bottom: 10px;
        width: 100%;
        padding-top: 0;
        right: 0;
        display: block;
    }

    .devidecaption {
        font-size: 20px;
        margin: 12px 0px;
        background-image: url(/style/web/images/line-black.png);
        background-repeat: repeat-x;
        background-position: center;
        display: none;

        border-color: black;
    }

    .devidecaption span {
        background-color: #fff;
    }

    .hrPromo {
        border-color: black;
        margin-top: 5px;
        margin-bottom: 5px;
        border-width: 4px;
    }
        
    #input-subscribe {
        height: 40px;
        width: 100%;
        border-radius: 0px;
        border: 2px solid #ccc;
        margin-right: 5px;
        position: initial;
    }
    
    #btn-subscribe {
        width: 150px;
        padding: 10px;
        border: 2px solid #000;
        box-shadow: 0 1px 2px #969696;
        height: 40px;
    }

    .input-black {
        border: 1px solid black !important;
    }
    
     @media only screen and (max-device-width: 719px) {
        
        .owl-theme .owl-controls .owl-page span {
            display: block;
            width: 10px;
            height: 10px;
            margin: 5px 3px;
            filter: Alpha(Opacity=50);
            opacity: 0.5;
            -webkit-border-radius: 20px;
            -moz-border-radius: 20px;
            border-radius: 10px;
            background: white;
        }
         
         .themeNav .owl-controls .owl-buttons .owl-prev {
            left: -5px;
            position: absolute;
            top: 20%;
            background: url(<?php echo base_url(); ?>/style/images/arrows-2x.png) no-repeat -30px 0 !important;
            width: 160px !important;
            height: 180px !important;
        }

        .themeNav .owl-controls .owl-buttons .owl-next {
            right: -5px;
            position: absolute;
            top: 20%;
            background: url(<?php echo base_url(); ?>/style/images/arrows-2x.png) no-repeat -110px 0 !important;
            width: 160px !important;
            height: 180px !important;
        }
    }

}
</style>

<div class="container-fluid">
<div class="row">
    <div class="col-sm-24 col-xs-24" style="position:relative;">
      <div class="owl-carousel owl-theme themeNav slide-banner">
        
        <?php if(count($banner)> 0){
            foreach($banner as $objBanner){ ?>
                <a href="<?php echo $objBanner->banner_url?>">
                    <div class="banner">
                        <img class="imgload" src="<?php echo $this->imageloader->getGlobalImage('3x1',false); ?>"  src-small="<?php echo $this->imageloader->fBannerImage($objBanner,'image_mobile','400x400' );?>" src-large="<?php echo $this->imageloader->fBannerImage($objBanner,'image_desktop','990x330');?>" title="<?php echo $objBanner->banner_title; ?>" alt="<?php echo $objBanner->banner_title; ?>-butuhdesain" width="100%" style="display: block;"/>
                    </div>
                </a>
        <?php }}?>

      </div>
    </div>
</div>
</div>
       
   <div class="container-fluid" style="background-color:#2d543f;margin-top: -10px;">
       <div class="container">
           <div class="row">
           <div class="col-lg-12 col-xs-24 padding20" style="height:500px;background-color:#5cb680">
               <span class="font16-md font16-xs text-bold text-white">TENTANG KAMI</span>
               <hr class="listhr">
               <div class="row padding10">
                   <div class="col-xs-24 padding20">
                       <img class="imgload" src="<?php echo base_url(); ?>style/images/berita1.png?o=d59c"
            src-small="<?php echo base_url(); ?>style/images/berita1.png?o=d59c"
            title="banner" alt="banner" width="35%" style="display: block;margin-left: 150px;">
                   </div>
                   
                    <div class="text-white" style="text-align: justify;">
                        <span>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.
                        </span>
                    </div>
                </div>
                <div class="row padding10 text-white"><p><a href="<?php echo base_url(); ?>web/berita/detail"><span>Baca Selengkapnya...</span></a></p></div>
           </div>
           <div class="col-lg-12 col-xs-24 padding20" style="height:500px;background-color:#0e7131">
               <span class="font16-md font16-xs text-bold text-white">KAPASITAS PRODUKSI</span>
               <hr class="listhr">
               
               <div class="col-xs-24 padding20">
                       <img class="imgload" src="<?php echo base_url(); ?>style/images/berita2.jpg?o=d59c"
            src-small="<?php echo base_url(); ?>style/images/berita2.jpg?o=d59c"
            title="banner" alt="banner" width="100%" style="display: block;">
                  <br>
                   </div>
                   
                <div class="row padding10 text-white"><p><a href="<?php echo base_url(); ?>web/berita/detail"><span>Baca Selengkapnya...</span></a></p></div>
               
           </div>

        </div>
        </div>
   </div>

       
        <div class="container">            
            
            <div class="row">
            <div class="col-lg-12 col-xs-24 padding20">
               <span class="font16-md font16-xs text-bold text-tosca">TENTANG KAMI</span>
               <hr class="listhr-tosca">
            </div>
            <div class="col-xs-12">
            </div>
        </div>
           
           <div class="row">
           <div class="col-lg-12 col-xs-24">
              <div class="row">
                  <div class="col-xs-8 padding10">
                    <img class="imgload" src="<?php echo base_url(); ?>style/images/palm_oil.png?o=d59c"
                src-small="<?php echo base_url(); ?>style/images/palm_oil.png?o=d59c"
                title="banner" alt="banner" width="100%" style="display: block;">
                </div>
                <div class="col-xs-16 padding20">
                   <br>
                    <p><span class="font20-md font16-xs text-bold text-tosca">PLAM OIL</span></p>
                    <p><span class="font14-md font12-xs text-bold text-tosca"><i>Plantation</i></span></p>
                    <p><span class="font14-md font12-xs text-bold text-tosca"><i>Plam Oil Mills</i></span></p>
                </div>
              </div>
           </div>
           
           <div class="col-lg-12 col-xs-24">
              <div class="row">
                  <div class="col-xs-8 padding10">
                    <img class="imgload" src="<?php echo base_url(); ?>style/images/multi_industri.png?o=d59c"
                src-small="<?php echo base_url(); ?>style/images/multi_industri.png?o=d59c"
                title="banner" alt="banner" width="100%" style="display: block;">
                </div>
                <div class="col-xs-16 padding20">
                   <br>
                    <p><span class="font20-md font16-xs text-bold text-tosca">MULTI INDUSTRY</span></p>
                    <p><span class="font14-md font12-xs text-bold text-tosca"><i>Woven</i></span></p>
                    <p><span class="font14-md font12-xs text-bold text-tosca"><i>Fertilizer</i></span></p>
                </div>
              </div>
           </div>
           
           <div class="col-lg-12 col-xs-24">
              <div class="row">
                  <div class="col-xs-8 padding10">
                    <img class="imgload" src="<?php echo base_url(); ?>style/images/service.png?o=d59c"
                src-small="<?php echo base_url(); ?>style/images/service.png?o=d59c"
                title="banner" alt="banner" width="100%" style="display: block;">
                </div>
                <div class="col-xs-16 padding20">
                   <br>
                    <p><span class="font20-md font16-xs text-bold text-tosca">SERVICES</span></p>
                    <p><span class="font14-md font12-xs text-bold text-tosca"><i>Transportation</i></span></p>
                    <p><span class="font14-md font12-xs text-bold text-tosca"><i>Bulking Station</i></span></p>
                </div>
              </div>
           </div>
           
           <div class="col-lg-12 col-xs-24">
              <div class="row">
                  <div class="col-xs-8 padding10">
                    <img class="imgload" src="<?php echo base_url(); ?>style/images/trading.png?o=d59c"
                src-small="<?php echo base_url(); ?>style/images/trading.png?o=d59c"
                title="banner" alt="banner" width="100%" style="display: block;">
                </div>
                <div class="col-xs-16 padding20">
                   <br>
                    <p><span class="font20-md font16-xs text-bold text-tosca">TRADING</span></p>
                    <p><span class="font14-md font12-xs text-bold text-tosca"><i>Product Other</i></span></p>
                    <p><span class="font14-md font12-xs text-bold text-tosca"><i>Sugar Cane</i></span></p>
                    <p><span class="font14-md font12-xs text-bold text-tosca"><i>Molales</i></span></p>
                </div>
              </div>
           </div>
            
        </div>
        </div>
        
       <div class="container-fluid" style="background-color:#fab142;margin-top:50px;">
       <div class="container">
          
          <div class="row">
            <div class="col-xs-12" style="padding:20px 20px 0px 10px !important">
               <span class="font16-md font16-xs text-bold text-white">BERITA TERBARU</span>
               <hr class="listhr">
            </div>
            <div class="col-xs-12">
            </div>
        </div>
          
           <div class="row">
           
           <?php if(count($berita)>0){
            foreach($berita as $objDlog){?>
           
           
               <div class="col-lg-12 col-xs-24">
                  <div class="row">
                      <div class="col-lg-8 col-xs-24 padding10">
                        <img class="imgload" src="<?php echo $this->imageloader->getGlobalImage('3x1',false); ?>"  src-small="<?php echo $this->imageloader->fimageberita($objDlog,2);?>" src-large="<?php echo $this->imageloader->fimageberita($objDlog,2);?>" title="<?php echo $objDlog->berita_title; ?>" alt="<?php echo $objDlog->berita_title; ?>-butuhdesain" width="100%" style="display: block;"/>
                    </div>
                    <div class="col-lg-16 col-xs-24 padding10">
                       <div class="text-white" style="text-align: justify;">
                            <p><span><?php echo $objDlog->berita_synopsis ?>
                            </span></p>
                            <p><a href="<?php echo base_url(); ?>berita/detail/<?php echo $objDlog->berita_url ?>"><span>Baca Selengkapnya...</span></a></p>
                            <p><span class="text-white"><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $this->imageloader->formatTanggalIndo($objDlog->createdate); ?></span></p>
                        </div>
                    </div>
                  </div>
               </div>
               
            <?php }}?>

        </div>
        </div>
   </div>
   