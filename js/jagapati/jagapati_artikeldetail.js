
	
	$(document).ready(function(){
		$("#facebook-share").click(function(){
			window.open("https://www.facebook.com/sharer/sharer.php?u="+baseurl+"artikel/<?php echo $berita[0]->newsurl ?>", "myWindow", "width=500, height=500");
		});

		$("#twitter-share").click(function(){
			var theUrl=""+baseurl+"/artikel/<?php echo $berita[0]->newsurl ?>";
			window.open("https://twitter.com/intent/tweet?original_referer="+baseurl+"artikel/<?php echo $berita[0]->newsurl ?>&tw_p=tweetbutton&url="+theUrl+"&text=<?php echo $berita[0]->newstitle ?>", "myWindow", "width=500, height=500");

		});

		$("#google-share").click(function(){
			window.open("https://plus.google.com/share?url="+baseurl+"artikel/<?php echo $berita[0]->newsurl ?>", "myWindow", "width=500, height=500");
		});


		$("#slideartikel").owlCarousel({
			items : 4,
			itemsDesktop:[960,4],
			itemsMobile:[480,1],
			lazyLoad : true,
			navigation :true,
			pagination:false		
		});	
		$("#owlSlideBerita").owlCarousel({
			items : 1,
			lazyLoad : true,
			navigation :true,
			pagination:true,
			singleItem:true,
			responsive: true,
			slideSpeed : 300,
			navigationText: [
			  "<i class='glyphicon glyphicon-chevron-left'></i>",
			  "<i class='glyphicon glyphicon-chevron-right'></i>"
			]
		});
		
	
	})