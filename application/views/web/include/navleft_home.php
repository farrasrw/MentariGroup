<script>
function tmessage(){
            var data;
            var url; 
            var target;
            var objForm = $('#form_message');
            postData(data,url,objForm);
        }
</script>

<style>
.list-group-level1 .list-group-item {
    padding-left: 0px;
}
.list-group-item {
    position: relative;
    display: block;
    padding: 5px 0px;
    margin-bottom: -1px;
    background-color: #fff;
}
</style>

               <div class="row">
                    <div  class="col-xs-24 padding10 text-center">
                    <div id="main-menu" class="list-group">
                       <a href="<?php echo base_url(); ?>aboutus" class="list-group-item"><b>ABOUT US</b></a>
                        <a href="#sub-menu" class="list-group-item active" data-toggle="collapse" data-parent="#main-menu"><b>PRODUCTS</b><!--<span class="caret"></span>--></a>
                        <div class="collapse list-group-level1" id="sub-menu">
                           
                           <?php 
                                foreach($kategori as $listKategori){?>

                                   <a href="<?php echo base_url(); ?>produk/<?php echo $listKategori->kategori_url ?>" class="list-group-item nomargin" data-parent="#sub-menu"><?php echo strtoupper($listKategori->kategori_url) ?></a>
                                    
                                <?php } ?>
                            <!--<a href="<?php echo base_url(); ?>produk/arco" class="list-group-item nomargin" data-parent="#sub-menu">ARCO</a>
                            <a href="<?php echo base_url(); ?>produk/caesar" class="list-group-item nomargin" data-parent="#sub-menu">CAESAR</a>
                            <a href="<?php echo base_url(); ?>produk/chevy" class="list-group-item nomargin" data-parent="#sub-menu">CHEVY</a>
                            <a href="<?php echo base_url(); ?>produk/kool" class="list-group-item nomargin" data-parent="#sub-menu">KOOL</a>
                            <a href="<?php echo base_url(); ?>produk/kozy" class="list-group-item nomargin" data-parent="#sub-menu">KOZY</a>
                            <a href="<?php echo base_url(); ?>produk/magnum" class="list-group-item nomargin" data-parent="#sub-menu">MAGNUM</a>
                            <a href="<?php echo base_url(); ?>produk/mesh" class="list-group-item nomargin" data-parent="#sub-menu">MESH</a>
                            <a href="<?php echo base_url(); ?>produk/public-seating" class="list-group-item nomargin" data-parent="#sub-menu">PUBLIC SEATING</a>
                            <a href="<?php echo base_url(); ?>produk/sova" class="list-group-item nomargin" data-parent="#sub-menu">SOVA</a>
                            <a href="<?php echo base_url(); ?>produk/visto" class="list-group-item nomargin" data-parent="#sub-menu">VISTO</a>-->
                        </div>
                        <a href="<?php echo base_url(); ?>catalogue" class="list-group-item nomargin"><b>CATALOGUE</b></a>
                        <a href="<?php echo base_url(); ?>projects" class="list-group-item nomargin"><b>PROJECTS</b></a>
                    </div>    
                </div>
                    
                    <div class="col-xs-24" style="padding:0px 17px 0px 17px" >
                     <div class="padding10" style="border: 1px solid black;">
                      <div class="row text-center">
                           <span class="text-bold font18">CONTACT US</span>
                        </div>
                       <div class="row padding10">
                        <form id="form_message" method="post" class="basic-grey" action="<?php echo base_url() ?>sendmessage">
                            <div class="form-group row">
                                <label style="margin-top:0px" for="exampleInputEmail1" class="col-lg-4 control-label">NAME</label>
                                <div class="col-lg-24">
                                    <input type="text" class="form-control input-black" name="txtNama" value="" required="">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label style="margin-top:0px" for="exampleInputEmail1" class="col-lg-4 control-label">NO. HP</label>
                                <div class="col-lg-24">
                                    <input type="text" class="form-control input-black" name="txtHp" value="" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label style="margin-top:0px" for="exampleInputEmail1" class="col-lg-4 control-label">EMAIL</label>
                                <div class="col-lg-24">
                                    <input class="form-control input-black" required="" type="email" name="txtEmail" value="">
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
                                        <button onclick="tmessage()" class="btn btn-black background-black" type="button" id="btn-subscribe"><span style="font-size:12px;"><b>SEND</b></span></button>
                                    </span>
                            </div>    
                        </form>
                    </div>
                    </div>
                    </div>
                    
                    <div class="col-xs-24" style="padding:17px" >
                        <div style="width: 100%;">
                           <div style="width: 100%"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.921399439643!2d106.82284711450211!3d-6.141260595553478!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5fc02bb48dd%3A0xd981d12af7b00ce8!2sVaria+Dimensi!5e0!3m2!1sid!2sid!4v1519894686522" width="365" height="365" frameborder="0" style="border:0" allowfullscreen></iframe></div>
                        </div>
                   </div>
                   
                   <div class="col-xs-24 padding10 text-center" >
                       
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