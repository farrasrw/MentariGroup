<html>
    
    <head>
        <meta name="viewport" content="width=device-width, minimum-scale=1.0,maximum-scale=1.0">
        <link rel="shortcut icon" href="<?php echo base_url();?>style/images/favicon.ico" type="image/x-icon">
        <title>Butuhdesign.com - Advertising | Branding | Digital Marketing | Graphic Design | Printing | Social Media | Website Design</title>
        
        <?php
            $upVersion = "?v=02s99";
        ?>
        
        <script>
            var baseurl = '<?php echo base_url(); ?>';
            var domain  = '<?php echo $this->config->item('domain'); ?>'
        </script>
        
        <!-- META BUILDER BEGIN -->
		<?php 
		
			if(!array_key_exists('title',$meta) || $meta['title']==''){
				echo '<title>Butuhdesign.com - Advertising | Branding | Digital Marketing | Graphic Design | Printing | Social Media | Website Design</title>';echo "\n\t\t";
				$meta['title'] = 'Butuhdesign.com - Advertising | Branding | Digital Marketing | Graphic Design | Printing | Social Media | Website Design';
			}else{
				echo '<title>'.$meta['title'].'</title>';echo "\n\t\t";
			}
			
			if(!empty($meta)){
				
				//Meta Tag Html
				foreach($meta as $name=>$content){
					if($name=='description' || $name == 'title' || $name=='keywords' || $name=='author'){
						if(empty($content) || $content==null){
							if($name=='title')   	  { echo '<meta name="title" content="Butuhdesign.com - Advertising | Branding | Digital Marketing | Graphic Design | Printing | Social Media | Website Design" />';echo "\n\t\t"; }
							if($name=='keywords')	  { echo '<meta name="keywords" content="Butuhdesign.com - Advertising | Branding | Digital Marketing | Graphic Design | Printing | Social Media | Website Design" />';echo "\n\t\t"; }
							if($name=='description')  { echo '<meta name="description" content="Butuhdesign.com - Advertising | Branding | Digital Marketing | Graphic Design | Printing | Social Media | Website Design" />';echo "\n\t\t"; }
						}else{
							echo '<meta name="'.$name.'" content="'.$content.'" />';echo "\n\t\t";
						}
					}
				}
				echo "\n\t\t";
				
				//Meta :Og
				foreach($meta as $name=>$content){

						if( (empty($content) || $content==null) && ($name=='description' || $name == 'title' || $name=='keywords' || $name=='author' || $name=='image' || $name=='image:width' || $name=='image:height' || $name=='type')){
							if($name=='title')   	  echo '<meta property="og:title" content="Butuhdesign.com - Advertising | Branding | Digital Marketing | Graphic Design | Printing | Social Media | Website Design" />';
							if($name=='keywords')	  echo '<meta property="og:keywords" content="Butuhdesign.com - Advertising | Branding | Digital Marketing | Graphic Design | Printing | Social Media | Website Design" />';
							if($name=='description')  echo '<meta property="og:description" content="Butuhdesign.com - Advertising | Branding | Digital Marketing | Graphic Design | Printing | Social Media | Website Design" />';
						}else{
							echo '<meta property="og:'.$name.'" content="'.$content.'" />';
						}
						echo "\n\t\t";
				}

				if(!isset($meta['image'])){
							echo '<meta property="og:image" content="'.$this->imageloader->getGlobalImage('600x300').'" />';echo "\n\t\t";
							echo '<meta property="og:image:width" content="1200" />';echo "\n\t\t";
							echo '<meta property="og:image:height" content="630" />';echo "\n\t\t";
				}
				if(!isset($meta['type'])){
					echo '<meta property="og:type" content="article" />';echo "\n\t\t";
				}

			}			
		?>
        
        <script>
            var baseurl = '';
            var domain  = ''
        </script>
		
		<script type="application/javascript" src="<?php echo base_url(); ?>js/jquery/jquery-1.12.3.min.js<?php echo $upVersion;  ?>"></script>
		<script type="application/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slideout/1.0.1/slideout.min.js<?php echo $upVersion;  ?>"></script>
		
        <script type="application/javascript" src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js<?php echo $upVersion;  ?>"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/loadimages.js<?php echo $upVersion;  ?>" defer></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquerylazy/jquery.lazy.min.js<?php echo $upVersion;  ?>" defer></script>
        
        <script type="text/javascript" src="<?php echo base_url(); ?>js/ajaxpost.js<?php echo $upVersion;  ?>" defer></script>
        <script src="<?php echo base_url(); ?>js/jqueryform/jquery.form.min.js<?php echo $upVersion;  ?>"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/alertify/dist/js/alertify.js<?php echo $upVersion;  ?>" defer></script>
        
        <!--jquery cookie-->
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-cookie/jquery.cookie.js<?php echo $upVersion;  ?>"></script>
                
        <link href="<?php echo base_url(); ?>js/alertify/dist/css/alertify.css<?php echo $upVersion;  ?>" rel="stylesheet" >
		
		<link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css<?php echo $upVersion;  ?>" rel="stylesheet" media="all" />
		
		<link href="<?php echo base_url(); ?>style/web/css/style.css<?php echo $upVersion;  ?>" rel="stylesheet" media="all" type="text/css" />
        
        <link href="<?php echo base_url(); ?>js/owl-carousel/owl.carousel.css<?php echo $upVersion;  ?>" rel="stylesheet"/>
        <link href="<?php echo base_url(); ?>js/owl-carousel/owl.theme.css<?php echo $upVersion;  ?>" rel="stylesheet"/>
        <link href="<?php echo base_url(); ?>js/owl-carousel/owl.transitions.css<?php echo $upVersion;  ?>" rel="stylesheet"/>

        <!-- Font Awesome Icons -->
        <!--<link href="<?php echo base_url(); ?>assets/admin/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />-->
        
        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        
        <script>
          (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-9633168195239593",
            enable_page_level_ads: true
          });
        </script>

        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-93695110-1', 'auto');
          ga('send', 'pageview');

        </script>
        
        
            
        <!-- Load Css And Javascript -->
		
	
	        <script>
            
        function showmenu(){
            $('#iscom-header .NavMainMenu').addClass('showMobile'); 
            $('body').addClass('overflowhidden');
        }
            
        function hidemenu(child){
            if(typeof(child)=='undefined') child = false; 
            if(child){
                $('#iscom-header .NavMainMenu li').removeClass('open'); 
            }else{
                $('#iscom-header .NavMainMenu li').removeClass('open');
                $('#iscom-header .NavMainMenu').removeClass('showMobile'); 
                $('body').removeClass('overflowhidden');
            }
        }
        function hidetroli(){
            $('.trolibagmenu ').removeClass('open');
            $('body').removeClass('overflowhidden');
        }
        function toggleSearch(obj){
    
           
            if(obj.hasClass('open')){
               $('body').removeClass('overflowhidden'); 
            }else{
                hidescroll($('body'),true); 
            }
        }
            
        function hidescroll(obj, onlymobile){
            if(typeof(onlymobile)=='undefined') onlymobile = false ; 
            if(onlymobile){
                if($('window').innerWidth() <= 959){
                    obj.addClass('overflowhidden');
                }
            }else{
                obj.addClass('overflowhidden');
            }
        }
            
            
        $(document).ready(function() {
            
            $('.dropdown-menu').on({
                "click":function(e){
                  if($('window').innerWidth() <= 719){
                    e.stopPropagation();  
                  }    
                  
                }
            });
            
            $('.btnuser-login').on('click', function(){
                $('#modalLogin').modal('show');
            });
            
            //showTroli(true); 
            
            var shown = $.cookie('dialogShown');
            
            if (!shown) {
                setTimeout(function(){
                    $("#modalsubscribe").modal('show');
                },3000);
                
                $.cookie('dialogShown', 'true');
            }
          
            loadimages();
            
            $(".productrelated").owlCarousel({
                items : 3,
                itemsDesktop:[1024,4],
                itemsTablet:[646,3],
                itemsMobile:[480,1],
                lazyLoad : true,
                pagination:false,
                navigation :true,
                navigationText: [
                  "<i class='glyphicon glyphicon-menu-left'></i>",
                  "<i class='glyphicon glyphicon-menu-right'></i>"
                ],
                touchDrag               : false,
                mouseDrag               : false
            });
                
           
            $('#buttonsearch').click(function(){
                $('#formsearch').slideToggle( "fast",function(){
                    $( '#content' ).toggleClass( "moremargin" );
                });
                $('#searchbox').focus()
                $('.openclosesearch').toggle();
            });

        });
            
        function showsearch(){

           if( $('#formsearch').is(":visible")){
               $('#formsearch').hide();
               $('.openclosesearch').toggle();
               $('body').css('overflow','auto');
           }else{
               //$('#formsearch').show();
               $('#formsearch').slideToggle( "fast",function(){
                    $( '#content' ).toggleClass( "moremargin" );
                });
               
               $('.openclosesearch').toggle();
               
               var screen = $(window).width();

                if(screen > 798){
                    $('body').css('overflow','auto');
                }else{
                    $('body').css('overflow','hidden');   
                }
           }
        }
            
        </script>
        
        <style>
           

            .modal {
              text-align: center;
              padding: 0!important;
            }

            .modal:before {
              content: '';
              display: inline-block;
              height: 100%;
              vertical-align: middle;
              margin-right: -4px;
            }

            .modal-dialog {
              display: inline-block;
              text-align: left;
              vertical-align: middle;
            }
            
        </style>
        
	</head>
	<body class="fontRoboto">
	<form style="display:none" id="formglobal" action="" method="post"></form>
    <form style="display:none" id="formglobalget" action="" method="get"></form>
        
    <div id="iscom-header" class="container-fluid">
        <div class="container" id="headermain">
            <div class="row container" id="afixtop">
                <div id="afixborder"></div>
                <nav class="navbar navbarMenu" role="navigation">
                    
                    <div class="col-md-1 col-xs-3  text-center hidden-sm hidden-md hidden-lg"  id="buttonmenu" style="padding: 5px;">
                        <a href="#" onclick="showmenu(); return false;" id="showMenu" param="1" ><i class="glyphicon glyphicon-menu-hamburger text-black font24 "></i></a>
                    	<div id="headerMenu"></div>
					</div> 
                    <div class="logo col-md-6 col-xs-13 col-sm-7 text-left">
                        <a href="<?php echo base_url(); ?>">
                            <img class="img-responsive" src="<?php echo base_url();?>style/web/images/logo_butuhdesain_new.png">
                        </a>
                    </div>
                    <div class="col-md-16 col-sm-23 col-xs-24 fontOswald font18 NavMainMenu hidden-xs" >
                            <div class="row menuCaption">
                                <span class="fontRoboto font18">MENU</span><span onclick="hidemenu();" class="closemenu" >X</span>
                                <hr style="margin:0px; margin-top:10px">
                            </div>
                            <ul id="navMain" class="nav navbar-nav fontAvenir" >
                                <!--<li class="noborder"><a href="index.html"><span>HOME</span></a></li>-->
                                <li class="noborder"><a href="<?php echo base_url(); ?>dlog.html"><span>#DLOG</span></a></li>
                                <li class="noborder"><a href="<?php echo base_url(); ?>tag/project.html"><span>PROJECT</span></a></li>
                                <!--<li class="noborder"><a href="index.html"><span>SERVICE</span></a></li>-->
                                <li class="noborder"><a href="<?php echo base_url(); ?>package"><span>PACKAGE</span></a></li>
                                <li class="noborder"><a href="<?php echo base_url(); ?>jobs"><span>JOBS</span></a></li>
                                <li class="noborder"><a href="<?php echo base_url(); ?>workwithus"><span>WORK WITH US</span></a></li>

                                <!--<li class="dropdown menudropdown">
                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span>BLOG</span></a>

                                  <ul class="dropdown-menu subMenu fontRoboto" style="background-color:white">
                                    <li class="liMenu ">
                                        <div class="row menuCaption">
                                        <span class="fontRoboto font18">BABIES & KIDS</span><span onclick="hidemenu(true);" class="closemenu">X</span>
                                        <hr style="margin:0px; margin-top:10px">
                                    </div>
                                    <ul class="menuItem">
                                        <li style="height:40%;">
                                            <p><a href='#'>Baby Stroller</a></p><p><a href='#'>Baby Box</a></p>                                        </li>
                                    </ul>
                                    </li>
                                  </ul>

                                </li>-->
                            </ul>



                    </div>
                    <div class="col-md-2 col-xs-8 NavBarTroli">                        
                        <ul class="nav navbar-nav fontOswald  NavBarTroli-menu" >
                            <li class="dropdown" onclick="toggleSearch($(this));">
                              <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                  <button type="button" class="btn btn-link text-black font24 padding10"  >
                                    <i class="fa fa-search "></i>
                                  </button>
                              </a>
                              <ul class="dropdown-menu subMenu searchbox" style="background-color:white">
                                <li class="liMenu  padding10">
                                    <form role="search" method="get" action="<?php echo base_url(); ?>search.html"  >
                                        <div id="searchform"  class="input-group">
                                          <input  type="text" class="form-control input-black input-lg nobold font16 text-black fontRoboto" name="q" placeholder="What are you looking for?">
                                          <span class="input-group-btn">
                                            <button class="btn btn-black btn-lg fontRoboto" type="submit">Cari</button>
                                          </span>
                                        </div>
                                    </form>
                                </li>
                              </ul>
                            </li>
                            
                            <!--<li class="dropdown trolibagmenu">
                                  <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                      <button type="button" class="btn btn-link text-black font24 padding10 " onclick="http://192.168.115.71/">
                                        <i class="fa fa-shopping-cart"></i>
                                      </button>
                                  </a>
                                  <div class="trolibagCounter">0</div>
                                  <ul class="dropdown-menu subMenu" style="background-color:white">
                                    <li class="liMenu  col-xs-24">
                                        <div class="trolibag">
                                            <div class="row">
                                                <div class="col-xs-24" style="padding:5px 20px;">
                                                    <span class="fontOswald font16">SHOPING CART</span>
                                                    <span onclick="hidetroli()" class="font22 text-muted pull-right visible-xs cursorpointer" style="font-family:arial; ">X</span>
                                                </div>
                                                <hr class="hr-black col-xs-24" style="margin:10px 0px">
                                                <div class="col-xs-24 ContenTroli" >
                                                </div>
                                                
                                                <div class="col-xs-24 padding10 TotalTroli">
                                                    <hr class="hr-black col-xs-24" style="margin:10px 0px">
                                                    <span class="fontOswald font20 pull-right"><span>TOTAL  &nbsp; &nbsp; &nbsp;</span> <span class="troliTotalPrice"> Rp 0 </span></span>
                                                    <br><br><br><br>
                                                    <button class="btn btn-black col-xs-12 nobold fontOswald background-black pull-right " onclick="window.location.href='http://192.168.115.71/';">CHECKOUT</button>
                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                    </li>
                                  </ul>
                            </li>-->
                        </ul>
                    </div>
                </nav>
            </div>
        </div>	
    </div>
    
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
    
    <div class="container-fluid" id="body">
       
       <?php echo $output ?>
	</div>
		
	</body>
	<script type="application/javascript" src="<?php echo base_url(); ?>js/main.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/owl-carousel/owl.carousel.min.js" defer></script>
</html>




