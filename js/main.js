		
		
		$('.menusearch').find('.serchbox').css('left','-'+$('.navMainMenu').width()+'px');

		imgresload();

		function setimagesslide(event){
			
			$.each(this._items, function (i) {
				console.log(jQuery(this).width());
				jQuery(this).find('.imgslide').css('height', (jQuery(this).width()/2)+'px' );
			});
			
			
			
			
		}
		

		function imgresload(objElement){
			
			if(typeof(objElement)=="undefined"){
				var obj = $('.img2-1');
			}else{
				
				if(typeof(objElement)=='object'){
					var obj = objparam.find('.img2-1');
				}else{
					var obj = $(objElement).find('.img2-1');
				}
			}
			
			obj.each(function() {
				$(this).css('height',( $(this).find('img').width()/2)+'px');
			});
		}
		
		$('body').on( "mouseenter mouseleave",'.navMainMenu > li',function(){
				if($(window).width() > 797 ){
					if( !$(this).hasClass('open') ){
						$('#menuNavHeader li').removeClass('open');
					}
				}
			});

		$(document).ready(function(){
			
			setTimeout(function(){
				if($(body).find('#mainconten').height() > $('#navright').height()){
					$("#afixright").affix({offset: {top:720, bottom:55} });
				}
				$("#afixtop").affix({offset: {top:170} });
			},1000);
		})
		