<html>

    

    <head>

        <meta name="viewport" content="width=device-width, minimum-scale=1.0,maximum-scale=1.0">

        <link rel="shortcut icon" href="<?php echo base_url();?>style/images/favicon.ico" type="image/x-icon">

        <title>Cefirra</title>

        

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

				echo '<title>Cefirra</title>';echo "\n\t\t";

				$meta['title'] = 'Cefirra';

			}else{

				echo '<title>'.$meta['title'].'</title>';echo "\n\t\t";

			}

			

			if(!empty($meta)){

				

				//Meta Tag Html

				foreach($meta as $name=>$content){

					if($name=='description' || $name == 'title' || $name=='keywords' || $name=='author'){

						if(empty($content) || $content==null){

							if($name=='title')   	  { echo '<meta name="title" content="Cefirra" />';echo "\n\t\t"; }

							if($name=='keywords')	  { echo '<meta name="keywords" content="Cefira" />';echo "\n\t\t"; }

							if($name=='description')  { echo '<meta name="description" content="Cefirra" />';echo "\n\t\t"; }

						}else{

							echo '<meta name="'.$name.'" content="'.$content.'" />';echo "\n\t\t";

						}

					}

				}

				echo "\n\t\t";

				

				//Meta :Og

				foreach($meta as $name=>$content){



						if( (empty($content) || $content==null) && ($name=='description' || $name == 'title' || $name=='keywords' || $name=='author' || $name=='image' || $name=='image:width' || $name=='image:height' || $name=='type')){

							if($name=='title')   	  echo '<meta property="og:title" content="Cefirra" />';

							if($name=='keywords')	  echo '<meta property="og:keywords" content="Cefirra" />';

							if($name=='description')  echo '<meta property="og:description" content="Cefirra" />';

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

	 <script async src="https://www.googletagmanager.com/gtag/js?id=UA-106831925-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments)};
          gtag('js', new Date());

          gtag('config', 'UA-106831925-1');
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

        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

        

        

            

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

	function tmessagenew(){
            var data;
            var url; 
            var target;
            var objForm = $('#form_message_home');
            postData(data,url,objForm);
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

            

            .navbar-nav>li>a {

                padding-top: 10px;

                padding-bottom: 10px;

                line-height: 20px;

                color: #000;

                font-weight: bold;

            }

            

            .dropdown-menu>li>a {

                display: block;

                padding: 3px 20px;

                clear: both;

                font-weight: normal;

                line-height: 1.42857143;

                color: #000;

                white-space: nowrap;

                font-weight: bold;

            }

            

            @media only screen and (max-device-width: 719px){

                .dropdown-menu>li>a {

                    display: block;

                    padding: 3px 20px;

                    clear: both;

                    font-weight: normal;

                    line-height: 1.42857143;

                    color: #000;

                    white-space: nowrap;

                    font-weight: bold;

                }

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

                <!--<nav class="navbar navbarMenu" role="navigation">

                    

                    <div class="col-md-1 col-xs-3  text-center hidden-sm hidden-md hidden-lg"  id="buttonmenu" style="padding: 5px;">

                        <a href="#" onclick="showmenu(); return false;" id="showMenu" param="1" ><i class="glyphicon glyphicon-menu-hamburger text-black font24 "></i></a>

                    	<div id="headerMenu"></div>

					</div> 

                    <div class="logo col-md-8 col-xs-13 col-sm-7 text-left">

                        <a href="<?php echo base_url(); ?>">

                            <img class="img-responsive" src="<?php echo base_url(); ?>style/images/ceffira/cefirra-logo.png">

                        </a>

                    </div>

                    <div class="col-md-16 col-sm-23 col-xs-24 fontOswald font18 NavMainMenu hidden-xs hidden-lg" >

                            <div class="row menuCaption">

                                <span class="fontRoboto font18">MENU</span><span onclick="hidemenu();" class="closemenu" >X</span>

                                <hr style="margin:0px; margin-top:10px">

                            </div>

                            <ul id="navMain" class="nav navbar-nav fontAvenir" >

                                <li class="noborder"><a href="<?php echo base_url(); ?>aboutus.html"><span>ABOUT US</span></a></li>

                                

                                <li class="dropdown menudropdown">

                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span>PRODUCTS</span></a>



                                  <ul class="dropdown-menu subMenu fontRoboto" style="background-color:white">

                                    <li class="liMenu ">

                                        <div class="row menuCaption">

                                        <span class="fontRoboto font18">PRODUCTS</span><span onclick="hidemenu(true);" class="closemenu">X</span>

                                        <hr style="margin:0px; margin-top:10px">

                                    </div>

                                    <ul class="menuItem">

                                        <li style="height:40%;">

                                            <p><a href='<?php echo base_url(); ?>produk/arco'>ARCO</a></p>

                                            <p><a href='<?php echo base_url(); ?>produk/caesar'>CAESAR</a></p>

                                            <p><a href='<?php echo base_url(); ?>produk/chevy'>CHEVY</a></p>

                                            <p><a href='<?php echo base_url(); ?>produk/kool'>KOOL</a></p>

                                            <p><a href='<?php echo base_url(); ?>produk/kozy'>KOZY</a></p>

                                            <p><a href='<?php echo base_url(); ?>produk/magnum'>MAGNUM</a></p>

                                            <p><a href='<?php echo base_url(); ?>produk/mesh'>MESH</a></p>

                                            <p><a href='<?php echo base_url(); ?>produk/public-seating'>PUBLIC SEATING</a></p>

                                            <p><a href='<?php echo base_url(); ?>produk/sova'>SOVA</a></p>

                                            <p><a href='<?php echo base_url(); ?>produk/visto'>VISTO</a></p>

                                        </li>

                                    </ul>

                                    </li>

                                  </ul>



                                </li>

                                <li class="noborder"><a href="<?php echo base_url(); ?>catalogue.html"><span>CATALOGUE</span></a></li>

                                <li class="noborder"><a href="<?php echo base_url(); ?>projects.html"><span>PROJECTS</span></a></li>

                            </ul>







                    </div>

                    <div class="col-md-2 col-xs-8 NavBarTroli hidden-lg">                        

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

                        </ul>

                    </div>

                </nav>-->

                

                <nav class="navbar navbarMenu" role="navigation">

                    

                    <div class="col-md-1 col-xs-3  text-center hidden-sm hidden-md hidden-lg"  id="buttonmenu" style="padding: 5px;">

                        <a href="#" data-toggle="collapse" data-target="#navbar1" id="showMenu" param="1" ><i class="glyphicon glyphicon-menu-hamburger text-black font24 "></i></a>

                    	<div id="headerMenu"></div>

					</div> 

                    <div class="logo col-md-8 col-xs-13 col-sm-7 text-left">

                        <a href="<?php echo base_url(); ?>">

                            <img class="img-responsive" src="<?php echo base_url(); ?>style/images/ceffira/cefirra-logo.png">

                        </a>

                    </div>

                    <!-- add header -->

                    <div class="navbar-header">

                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar1">

                            <span class="sr-only">Toggle navigation</span>

                            <span class="icon-bar"></span>

                            <span class="icon-bar"></span>

                            <span class="icon-bar"></span>

                        </button>

                        <!--<div class="navbar-brand site-title" style="text-decoration: none;font-size: 24px;font-weight: bold;margin-left: 20px;color: #fff;">Ceffira</div>-->



                    </div>



                    <!-- add menu -->

                    <div class="collapse navbar-collapse " id="navbar1">

                        <ul class="nav navbar-nav hidden-sm hidden-md hidden-lg"> <!-- Items in here won't collapse -->

                            <li><a href="<?php echo base_url(); ?>">HOME</a></li>

                            <li><a href="<?php echo base_url(); ?>aboutus">ABOUT US</a></li>

                            <li class="dropdown">

                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                                   PRODUCTS<span class="caret"></span>

                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    
                                    <?php 
                                    foreach($templatedata['kategori'] as $listKategori){?>
                                       
                                       <li><a href='<?php echo base_url(); ?>produk/<?php echo $listKategori->kategori_url ?>'><?php echo strtoupper($listKategori->kategori_name) ?></a></li>
                                        
                                    <?php } ?>

                                    <!--<li><a href='<?php echo base_url(); ?>produk/arco'>ARCO</a></li>

                                    <li><a href='<?php echo base_url(); ?>produk/caesar'>CAESAR</a></li>

                                    <li><a href='<?php echo base_url(); ?>produk/chevy'>CHEVY</a></li>

                                    <li><a href='<?php echo base_url(); ?>produk/kool'>KOOL</a></li>

                                    <li><a href='<?php echo base_url(); ?>produk/kozy'>KOZY</a></li>

                                    <li><a href='<?php echo base_url(); ?>produk/magnum'>MAGNUM</a></li>

                                    <li><a href='<?php echo base_url(); ?>produk/mesh'>MESH</a></li>

                                    <li><a href='<?php echo base_url(); ?>produk/public-seating'>PUBLIC SEATING</a></li>

                                    <li><a href='<?php echo base_url(); ?>produk/sova'>SOVA</a></li>

                                    <li><a href='<?php echo base_url(); ?>produk/visto'>VISTO</a></li>-->



                                </ul>

                            </li>



                            <li class="noborder"><a href="<?php echo base_url(); ?>catalogue.html"><span>CATALOGUE</span></a></li>

                            <li class="noborder"><a href="<?php echo base_url(); ?>projects.html"><span>PROJECTS</span></a></li>



                        </ul>

                        </div>

            </nav>

                

            </div>

        </div>	

    </div>

    

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

        

        <div class="container hidden-lg">

            <div class="row">

                

                <div class="col-xs-24 padding10" >

                     <div class="padding10" style="border: 1px solid black;">

                      <div class="row text-center">

                           <span class="text-bold font18">CONTACT US</span>

                        </div>

                       <div class="row padding10">

                        <form id="form_message_home" method="post" class="basic-grey" action="<?php echo base_url() ?>sendmessage">

                            <div class="form-group row">

                                <label style="margin-top:0px" for="exampleInputEmail1" class="col-lg-4 control-label">NAME</label>

                                <div class="col-lg-24">

                                    <input type="text" class="form-control input-black" name="txtNama" required="">

                                </div>

                            </div>

                            

                            <div class="form-group row">

                                <label style="margin-top:0px" for="exampleInputEmail1" class="col-lg-4 control-label">NO. HP</label>

                                <div class="col-lg-24">

                                    <input type="text" class="form-control input-black" name="txtHp" required="">

                                </div>

                            </div>



                            <div class="form-group row">

                                <label style="margin-top:0px" for="exampleInputEmail1" class="col-lg-4 control-label">EMAIL</label>

                                <div class="col-lg-24">

                                    <input class="form-control input-black" required="" type="email" name="txtEmail">

                                </div>

                            </div>



                            <div class="form-group row">

                                <label style="margin-top:0px" for="exampleInputEmail1" class="col-sm-4 control-label">MESSAGE</label>

                                <div class="col-lg-24" style="height: 100px;">

                                    <textarea class="form-control input-black" style="height: 100px;" required="" name="txtPesan"></textarea>

                                </div>

                            </div>



                            <div class="row text-center">

                               <span class="input-group-btn">

                                        <button onclick="tmessagenew()" class="btn btn-black background-black" type="button" id="btn-subscribe"><span style="font-size:12px;"><b>SEND</b></span></button>

                                    </span>

                            </div>    

                        </form>

                    </div>

                    </div>

                    </div>

                    

                    <div class="col-xs-24 padding10 text-center" >

                        <div style="width: 100%;">

                           <!--<div style="width: 100%"><iframe width="290" height="290" src="https://www.mapsdirections.info/en/custom-google-maps/map.php?width=290&height=290&hl=ru&q=Varia%20Dimensi+(Varia%20Dimensi)&ie=UTF8&t=&z=18&iwloc=A&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"><a href="https://www.mapsdirections.info/en/custom-google-maps/">Embed Google Map</a> by <a href="https://www.mapsdirections.info/en/">Measure area on map</a></iframe></div><br />-->
                           
                           <div style="width: 100%"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.921399439643!2d106.82284711450211!3d-6.141260595553478!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5fc02bb48dd%3A0xd981d12af7b00ce8!2sVaria+Dimensi!5e0!3m2!1sid!2sid!4v1519894686522" width="365" height="365" frameborder="0" style="border:0" allowfullscreen></iframe></div><br />

                        </div>

                   </div>

                

                <div class=" col-xs-24 padding10 text-center">

                    

                    <span>

                    <b>PT Varia Dimensi</b><br>

                    Jl. Pangeran Jayakarta 26 Blok B No. 12A<br>

                    Jakarta 10730<br>

                    (021) 6298622 / (021) 6009158<br>

                    </span>

                    <br>

                    <br>

                    

                   <span><b>Authorized Dealer :</b></span><br>

                    <img src="<?php echo base_url(); ?>style/images/ceffira/logo-produk.jpg" width="70%">

                    <br>

                    <span><b>Certified By :</b></span><br>

                    <img src="<?php echo base_url(); ?>style/images/ceffira/logo-sertifikasi.jpg" width="70%">

                    <br>

                    <br>

                </div>

            </div>

        </div>

        

	</div>

		

	</body>

	<script type="application/javascript" src="<?php echo base_url(); ?>js/main.js"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>js/owl-carousel/owl.carousel.min.js" defer></script>

</html>









