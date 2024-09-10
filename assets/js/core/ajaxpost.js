function postData(objParam,url,objForm,fSuccess,fBefore, loading ){
			
			    if(typeof(loading)=='undefined') loading = true ;
                if(typeof(objParam)=='undefined') objParam={};
                if(typeof(url)=='undefined') url=$('#formorder').attr('action');
                if(typeof(objForm)=='undefined') objForm=$('#formglobal');
    			var imageloading = baseurl+'style/images/load.gif';
	
                objForm.ajaxForm({
                    url:url,
                    data:objParam,
                    beforeSend: function(){
						if(loading){
							var loadingHtml = '<div style="top:0px;left:0px;display:table; position: fixed; width: 100%; height: 100%; background-color: rgba(252, 252, 252, 0.8); z-index: 10000;" class="bckdr" ><p style="display:table-cell; vertical-align:middle; text-align:center"><img src="'+imageloading+'" /><br><span class="text-muted" >loading</span></p></div>';
							$('body').prepend(loadingHtml);
						}
						if(jQuery.isFunction(fBefore)){
							var v=fBefore();
							if( v==false ) {
								$('body').find('.bckdr').remove();
								return false;
							}
						}
                    },
                    success: function(data){
						var intTimeOut = 1000;
                        var IS_JSON = true;
                        try
                        {
                            var data = JSON.parse(data);
                        }
                        catch(err)
                        {
                            IS_JSON = false;
                        }  

                        if(IS_JSON){
							
                            if(typeof(data.message)!='undefined' ){
								
								setTimeout(function(){
									
								 	$('body').find('.bckdr').remove();
								 	alertify.alert(data.message,function () { 
										if(typeof(data.redirect) != 'undefined'){
											window.location.href = data.redirect;
										}
									});
									
								}, intTimeOut);
								
                            }else{
								
								setTimeout(function(){
									$('body').find('.bckdr').remove();
									if(typeof(data.redirect) != 'undefined'){
										window.location.href = data.redirect;
									}
								},intTimeOut);
							}
							
                            
							
                        }else{
							setTimeout(function(){
								$('body').find('.bckdr').remove()
							},intTimeOut);
						}
						
						if(jQuery.isFunction(fSuccess)){
							
							var v = fSuccess(IS_JSON, data);
							if(v==false) return false;
							
						}
						
						//$('body').find('.bckdr').remove();
						
                    },
                    error:function(){
												var intTimeOut = 1000;

						setTimeout(function(){
								$('body').find('.bckdr').remove();
								alertify.alert('Error Conection');
						},intTimeOut);
                    }
                }).submit();
				
}
            
           