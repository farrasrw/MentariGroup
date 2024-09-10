<style>
.listhr-tosca {
            margin-top: 10px;
            margin-bottom: 10px;
            border: 0;
            border-bottom: 1px solid #22a24d;
            margin-left: 30px;
        }
    
    .text-tosca{
                    color: #22a24d;
                }
    
#about img {
    width: 100% !important;
}
</style>

<div class="container-fluid" id="body">

<div class="row">
   <img class="imgload"
        src="<?php echo base_url(); ?>style/images/tentangkami/struktur-organisasi-banner.jpg?o=d59c"
        src-small="<?php echo base_url(); ?>style/images/tentangkami/struktur-organisasi-banner.jpg?o=d59c"
        title="banner" alt="banner" width="100%" style="display: block;">
</div>

<div class="container padding10" style="max-width:900px;">

<div class="row">
            <div class="col-lg-24 col-xs-24 col-xs-24 padding20">
               <span class="font16-md font16-xs text-bold text-tosca"><?php echo strtoupper($title); ?></span>
               <hr class="listhr-tosca">
            </div>
        </div>

<div class="row padding10" id="about">
<span><?php echo $data[0]->content; ?></span>
</div>
</div>
</div>