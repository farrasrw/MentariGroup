<div class="col-xs-8" id="navright" >
	<div id="afixright" style="width: 100%; max-width: 300px; margin-right: 28px; float: right;">
		<div class="row beritaterpopuler" >
			<div class="col-xs-24 devidertitle nomargin">
				<h4><b>BERITA TERPOPULER</b></h4>
			</div>
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
		<div class="row bannerright">

			<div class="col-xs-24">
				<a target="_blank" href="<?php echo (isset($banner['bannerright1'][0]['banner_url'])?$banner['bannerright1'][0]['banner_url']:'#'); ?>"><img src="<?php echo $this->imageloader->fBannerImage((isset($banner['bannerright1'][0])?$banner['bannerright1'][0]:array()),'image_desktop','300x250'); ?>" width="100%"/></a> 
				<br>
				<br>
					<a target="_blank" href="<?php echo (isset($banner['bannerright2'][0]['banner_url'])?$banner['bannerright2'][0]['banner_url']:'#'); ?>"><img src="<?php echo $this->imageloader->fBannerImage((isset($banner['bannerright2'][0])?$banner['bannerright2'][0]:array()),'image_desktop','300x250'); ?>" width="100%"/></a> 
				<br>
				<br>
					<a target="_blank" href="<?php echo (isset($banner['bannerright3'][0]['banner_url'])?$banner['bannerright3'][0]['banner_url']:'#'); ?>"><img src="<?php echo $this->imageloader->fBannerImage((isset($banner['bannerright3'][0])?$banner['bannerright3'][0]:array()),'image_desktop','300x250'); ?>" width="100%"/></a> 
			</div>

		</div>
	</div>
</div>
