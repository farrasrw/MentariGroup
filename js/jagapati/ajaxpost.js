function postData(objParam,url,objForm,fSuccess,fBefore){
			
			
                if(typeof(objParam)=='undefined') objParam={};
                if(typeof(url)=='undefined') url=$('#formorder').attr('action');
                if(typeof(objForm)=='undefined') objForm=$('#formglobal');
    
                objForm.ajaxForm({
                    url:url,
                    data:objParam,
                    beforeSend: function(){
						if(jQuery.isFunction(fBefore)){
							var v=fBefore();
							if( v==false ) return false;
						}
                    },
                    success: function(data){
						
						
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
                                alert(data.message);
                            }
							
                            if(typeof(data.redirect) != 'undefined'){
                                window.location.href = data.redirect;
                            }
							
                        }
						
						if(jQuery.isFunction(fSuccess)){
							
							var v = fSuccess(IS_JSON, data);
							if(v==false) return false;
							
						}
						
                    },
                    error:function(){

                    }
                }).submit();
            }
           