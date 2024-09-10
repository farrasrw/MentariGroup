function loadimages(config){
	
    //alert("Tes");
	//console.log('j');
	/*
	var bLazy = new Blazy({ 
		container: '.container',
		selector:'.imgload',
		loadInvisible:true,
		error: function(element){
			
			var i = element.parentElement;
			var docWidth = $(document).width();
			if(docWidth <= 600 ){
				
				if(typeof( element.getAttribute('src-small'))!='undefined'){
					element.src =  element.getAttribute('src-small');
				}else{

					
					if(typeof( element.getAttribute('src-large'))!='undefined'  &&  typeof(element.getAttribute('src-large'))=='string' ){
						element.src = element.getAttribute('src-large');
					}
				}
				
			}else{
				
				//console.log(element.getAttribute('src-large'));
				
				if(typeof( element.getAttribute('src-large'))!='undefined' && typeof(element.getAttribute('src-large'))=='string' ){
					
						element.src = element.getAttribute('src-large');
				
				}else{
					element.src = element.src ;
				}
				
			}
			var i = element.parentElement;
			var k = $(i).find('#imgloading');
			if(k.length>0){
				k.remove();
			}
        }
    });
	*/
	
	var defaultConfig = {
			desktopwidth:600
		
	};
	
	if(typeof(config)=='object'){
		
		defaultConfig = jQuery.extend( true, defaultConfig, config );
		
	}
	//alert($('.imgload').attr('src-small'));
	jQuery('.imgload').Lazy({
        
		attribute:'src-large',
		visibleOnly:false,
		beforeLoad: function(element) {
            //console.log('T');
            // called before an elements gets handled
			var docWidth = $('body').width();
			if(docWidth > defaultConfig.desktopwidth ){
				if(typeof(element.attr('src-large'))=='undefined'){
					this.config('attribute', 'src');
				}else{
					this.config('attribute', 'src-large');
				}				
			}else{
				if(typeof(element.attr('src-small'))=='undefined'){
					if(typeof(element.attr('src-large'))=='undefined'){
						this.config('attribute', 'src');
					}else{
						this.config('attribute', 'src-large');
					}
				}else{
					this.config('attribute', 'src-small');
				}			
			}			
        },
        afterLoad: function(element) {
			//console.log(element);
            // called after an element was successfully handled
			var i = element.parent();
			var k = $(i).find('#imgloading');
			if(k.length>0){
				k.remove();
			}
			
        },
		bind: "event"
	});
}