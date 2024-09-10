<div class="row">
	<div class="col-xs-24">
		<img width="100%" src="<?php echo $this->imageloader->fimageberita($berita,1); ?>" />
	</div>
</div>


<div class="row beritacontent">
	<br>
	<span><?php echo $this->ffunction->formatTanggal($berita->berita_date_publish,1); ?></span>
	<h1 class="font26" style="margin-top:5px" ><b><?php echo $berita->berita_title ?></b></h1>
	<span class="font14" ><?php echo ($berita->berita_author!=''?'Penulis : '.$berita->berita_author:''); ?></span>
	<br>
	<span><?php echo $berita->berita_content;  ?></span>
	<br>
	<br>
</div>