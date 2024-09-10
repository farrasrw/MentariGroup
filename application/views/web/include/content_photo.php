<h1 class="font26"><b><?php echo $berita->berita_title;  ?></b></h1>
<span><?php echo $this->ffunction->formatTanggal($berita->berita_date_publish,1); ?></span>

<br>
<br>

<div class="row ">
	<div class="col-xs-24 beritaphoto">
		<div class="loadingimg"><span class="iloading">Loading </span></div>
		<img class="mainimage" width="100%" src="<?php echo $this->imageloader->fimageberita((isset($photo[0])?$photo[0]:array()),1,'image_name'); ?>" />
	</div>
</div>

<div class="row beritaslide">

	<?php foreach($photo as $value){ ?>
	<div class="item">
		<div class="imgslide">
			<img  width="100%"  slideimage="<?php echo $this->imageloader->fimageberita($value,1,'image_name'); ?>" src="<?php echo $this->imageloader->fimageberita($value,2,'image_name'); ?>"/>
		</div>
	</div>
	<?php } ?>

</div>
<div class="row beritacontent">
	<br>
	<span class="font14" >Penulis : <?php echo $berita->berita_author; ?> </span>
	<br>
	<br>
	<span><?php echo $berita->berita_content; ?></span>
	<br>
	<br>
</div>
