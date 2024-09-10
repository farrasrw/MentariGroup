<div class="col-xs-8" id="navright" >
	<div id="afixright" style="width: 100%; max-width: 300px; margin-right: 28px; float: right;">
		<div class="row bannerright">
			<div class="col-xs-24">
				<a target="_blank" href="<?php echo (isset($banner['bannerright1'][0]['banner_url'])?$banner['bannerright1'][0]['banner_url']:'#'); ?>"> <img src="<?php echo $this->imageloader->fBannerImage((isset($banner['bannerright1'][0])?$banner['bannerright1'][0]:array()),'image_desktop','300x250'); ?>" width="100%"/></a> 
				<br>
				<br>

			</div>

		</div>
		<div class="row beritaterpopuler" >
			<div class="col-xs-24">
				<ul class="nav nav-tabs">
					<li class="nav active text-center" style="width:50%" ><a class="font18" href="#A" data-toggle="tab"><b>TERKINI</b></a></li>
					<li class="nav text-center" style="width:50%"><a class="font18" href="#B" data-toggle="tab"><b>TERPOPULER</b></a></li>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">
					<div class="tab-pane fade in active" id="A">
						<div class="col-xs-24">
							
							<?php foreach($beritapopuler as $value){ ?>
							<a href="<?php echo base_url().'berita/detail/'.$value->berita_url; ?>.html"> 
								<div class="row listberitaterpopuler">
								<div class="col-xs-24">
									<p class="nomargin font12"><b><?php echo $value->berita_title; ?></b></p>
									<span class="font12 textdesc " style="color:black"><?php echo substr($value->berita_synopsis,0,100); ?> </span>
								</div>
								</div>
							</a>
							<?php } ?>
						</div>
					</div>
					<div class="tab-pane fade" id="B">
						<div class="col-xs-24">
							
							<?php foreach($beritaterkini as $value){ ?>
							<a href="<?php echo base_url().'berita/detail/'.$value->berita_url; ?>.html"> 
								<div class="row listberitaterpopuler">
								<div class="col-xs-24">
									<p class="nomargin font12"><b><?php echo $value->berita_title; ?></b></p>
									<span class="font12 textdesc " style="color:black"><?php echo substr($value->berita_synopsis,0,100); ?> </span>
								</div>
								</div>
							</a>
							<?php } ?>
							
						</div>
					</div>
				</div>
			</div>

		</div>
		<div class="row bannerright">

			<div class="col-xs-24">
				<br>
				<a target="_blank" href="<?php echo (isset($banner['bannerright2'][0]['banner_url'])?$banner['bannerright2'][0]['banner_url']:'#'); ?>"> <img src="<?php echo $this->imageloader->fBannerImage((isset($banner['bannerright2'][0])?$banner['bannerright2'][0]:array()),'image_desktop','300x250'); ?>" width="100%"/></a> 
				<br>
				<br>
				<a target="_blank" href="<?php echo (isset($banner['bannerright3'][0]['banner_url'])?$banner['bannerright3'][0]['banner_url']:'#'); ?>"> <img src="<?php echo $this->imageloader->fBannerImage((isset($banner['bannerright3'][0])?$banner['bannerright3'][0]:array()),'image_desktop','300x250'); ?>" width="100%"/></a> 
			
			</div>

		</div>
	</div>
</div>
