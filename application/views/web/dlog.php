<div class="container">
    <div class="row padding10">

        <?php if(count($dlog)>0){
            foreach($dlog as $objDlog){?>
                <div class="col-lg-8 col-md-8 col-sm-24 col-xs-24 itemartikel">
                    <div class="row relative artikelfloat  shinewhite">
                        <center><a class="text-black" href="<?php echo base_url(); ?>dlog/detail/<?php echo $objDlog->berita_url ?>">
                            <div class="col-lg-24 img7-6">
                                <img class="imgload" src="<?php echo $this->imageloader->getGlobalImage('3x1',false); ?>"  src-small="<?php echo $this->imageloader->fimageberita($objDlog,2);?>" src-large="<?php echo $this->imageloader->fimageberita($objDlog,2);?>" title="<?php echo $objDlog->berita_title; ?>" alt="<?php echo $objDlog->berita_title; ?>-butuhdesain" width="100%" style="display: block;"/>
                            </div>
                            <h4 class="col-lg-24 bgblack font30-md font20-xs padding10"><?php echo $objDlog->berita_title ?><br><br>
                                <!--<span class="font20">Start IDR <?php// echo number_format($objDlog->berita_price); ?></span>-->
                            </h4>
                        </a></center>
                    </div>
                </div>

        <?php }}?>

    </div>
            
            <style>
            /* pagination */
.pagination>.active>a, .pagination>.active>span, .pagination>.active>a:hover, .pagination>.active>span:hover, .pagination>.active>a:focus, .pagination>.active>span:focus {
    z-index: 3;
    color: #fff;
    background-color: black;
    border-color: black;
    cursor: default;
}
                          
.pagination>li>a:hover, .pagination>li>span:hover, .pagination>li>a:focus, .pagination>li>span:focus {
    z-index: 2;
    color: black;
    background-color: #eee;
    border-color: #ddd;
}
.pagination>li>a, .pagination>li>span {
    position: relative;
    float: left;
    padding: 6px 12px;
    line-height: 1.42857143;
    text-decoration: none;
    color: black;
    background-color: #fff;
    border: 1px solid #ddd;
    margin-left: -1px;
}
a:hover, a:focus {
    color: black;
    text-decoration: underline;
}
                      
.pagination>li:last-child>a, .pagination>li:last-child>span {
    border-bottom-right-radius: 0px;
    border-top-right-radius: 0px;
}
            </style>
            
    <div class="row text-center" id="sec-paging">
            <!--<hr class="listhr">
              <div class="col-xs-24 text-center">
                <center>
                    <nav class="">
                    <ul class="pagination">
                        <li class="disabled"></li>
                        <li class="active">
                            <a rel="nofollow" href="#">1<span class="sr-only"></span></a>
                        </li>
                        <li>
                            <a rel="nofollow" href="#" data-ci-pagination-page="2">2</a>
                        </li>
                        <li>
                            <a rel="nofollow" href="#" data-ci-pagination-page="2">3</a>
                        </li>
                        <li>
                            <a rel="nofollow" href="#" data-ci-pagination-page="2">4</a>
                        </li>
                        <li>
                            <a rel="nofollow" href="#" data-ci-pagination-page="2">5</a>
                        </li>
                        <li>
                            <a rel="nofollow" href="#">&gt;</a>&nbsp;
                        </li>
                    </ul>
                    </nav>

                </center>
              </div>-->
              <?php echo $this->pagination->create_links(); ?>
    </div>
            
</div>