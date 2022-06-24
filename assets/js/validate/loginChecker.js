$(document).ready( function (){
	
	//--------funciones para validar---------
	function checkStrength(message,password){
		var strength = 0;
        if (password.length < 8) {
            $(message).removeClass();
            $(message).addClass('Short');
            return 'Too short';
        }
        if (password.length > 8) strength += 1;
        // If password contains both lower and uppercase characters, increase strength value.
        if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1;
        // If it has numbers and characters, increase strength value.
        if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1;
        // If it has one special character, increase strength value.
        if (password.match(/([!,%,&,@,#,$,^,*,?,_,~,/,=,´,¡,¿,:,,,.,-,+,{,},[,],¿])/)) strength += 1;
        // If it has two special characters, increase strength value.
        if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~,/,=,´,¡,¿,:,,,.,-,+,{,},[,],¿].*[!,%,&,@,#,$,^,*,?,_,~,/,=,´,¡,¿,:,,,.,-,+,{,},[,],¿])/)) strength += 1;
        // Calculated strength value, we can return messages
        // If value is less than 2
        if (strength < 2) {
            $(message).removeClass();
            $(message).addClass('Weak');
            return 'Weak';
        } 
        else if (strength === 2) {
            $(message).removeClass();
            $(message).addClass('Good');
            return 'Good';
        }
        else {
            $(message).removeClass();
            $(message).addClass('Strong');
            return 'Strong';
        }
    }
    
    function checkMatch(message,pass1,pass2){
       // let pass1=$("#contrasena1").val();
        if(pass1.length===pass2.length&&pass1.length>0&&pass1.length!==null){
            if(pass1===pass2){
                $(message).removeClass();
                $(message).addClass('AlikeE');
                return 'Alike';
            }else{
                $(message).removeClass();
                $(message).addClass('UnlikeE');
                return 'Unlike';
            }
            
        }else{
            $(message).removeClass();
            $(message).addClass('UnlikeE');
            return 'Unlike';
        }
    }
	
	function checkNE(regex,id, input){
		
		const nameRegularExp = new RegExp(regex);
		if(nameRegularExp.test(input)){
			$(id).removeClass();
	        $(id).addClass('Valid');
			return 'Good';
		}else{
			$(id).removeClass();
	        $(id).addClass('Invalid');
			return 'Wrong';
		}
			
	}
	
	function checkDate(idmessage,input){
		if(input!==null && input.length>0){
			var Fecha1 = new Date(input);
	        Fecha1.valueOf();
	        if (isNaN(Fecha1)){
				$(idmessage).removeClass();
		        $(idmessage).addClass('Invalid');
				return 'Fecha no válida';
			}else{
				Hoy = new Date();//Fecha actual del sistema
 
		        var AnyoFecha = Fecha1.getFullYear();
		        var MesFecha = Fecha1.getMonth()+1;
		        var DiaFecha = Fecha1.getDate();
		
		        var AnyoHoy = Hoy.getFullYear();
		        //var MesHoy = Hoy.getMonth()+1;
		        //var DiaHoy = Hoy.getDate();
		        
		        if((DiaFecha<1||DiaFecha>31)||(MesFecha<1||MesFecha>12)||(AnyoFecha<1900||AnyoFecha>AnyoHoy)){
		            $(idmessage).removeClass();
			        $(idmessage).addClass('Invalid');
					return 'Fecha no válida';
		        }
		        if (!(AnyoFecha<1900 || AnyoFecha>AnyoHoy)){
			        if (AnyoFecha < AnyoHoy&&AnyoHoy-AnyoFecha>=13){
			            $(idmessage).removeClass();
				        $(idmessage).addClass('Valid');
						return 'Fecha válida';
			        }
			        else{
						$(idmessage).removeClass();
				        $(idmessage).addClass('Invalid');
						return 'Los usuarios deben ser mayores de 13 años';
				      
				    }  
		        }
		        else{
		            $(idmessage).removeClass();
				    $(idmessage).addClass('Invalid');
					return 'El año no es válido';
		        }
						
				
				
			}
			
		}else{
			$(idmessage).removeClass();
	        $(idmessage).addClass('Invalid');
			return 'Seleccione una fecha';
		}
		
	}
		
	
	
	//---------------inputs login-----------
	
	$('#contrasena1').keyup(function () { //si no funciona usar keypress
        $('#strengthMessage').html(checkStrength('#strengthMessage', $('#contrasena1').val()));
    });
   
    $('#contrasena2').keyup(function () { 
        $('#myequalMessage').html(checkMatch('#myequalMessage',$("#contrasena1").val(),$('#contrasena2').val()));
    });
    
    $('#nombre').keyup(function(){
		$('#nameMessage').html(checkNE('^[ñÑa-zA-ZÁ-ÿ ]+$','#nameMessage',$('#nombre').val()));
	});
	
	$('#telefono').keyup(function(){
		$('#telMessage').html(checkNE('^[0-9]{10}$','#telMessage',$('#telefono').val()));
	
	});
	$('#correoCrear').keyup(function(){
		//^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$
		//^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$
		$('#emailMessage').html(checkNE('^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+)\.+([a-zA-Z0-9]{2,4})+$','#emailMessage',$('#correoCrear').val()));
	
	});
	
	$('#nomUs').keyup(function(){
		$('#usernameMessage').html(checkNE('^[A-Za-z0-9._-]+$','#usernameMessage',$('#nomUs').val()));
	});
	
	$('#fechNac').change(function(){
		$('#dateMessage').html(checkDate('#dateMessage',$('#fechNac').val()));
	
	});
	
	//-----------inputs modificar Usuario
	$("#profPicFile").change(function(e) {

	    for (var i = 0; i < e.originalEvent.srcElement.files.length; i++) {
	
	        var file = e.originalEvent.srcElement.files[i];
	
	        
	        var reader = new FileReader();
	        reader.onloadend = function() {
	            $('#ProfPic').attr("src",reader.result); 
	            
	        };
	        reader.readAsDataURL(file);
	         	 $('#fotoMessage').removeClass();
				 $('#fotoMessage').addClass('Valid');
				 $('#fotoMessage').text('Imagen Válida');
	    }
	});
	
	$('#contrasena1UP').keyup(function () { //si no funciona usar keypress
        $('#strengthMessage').html(checkStrength('#strengthMessage', $('#contrasena1UP').val()));
    });
   
    $('#contrasena2UP').keyup(function () { 
        $('#myequalMessage').html(checkMatch('#myequalMessage',$("#contrasena1UP").val(),$('#contrasena2UP').val()));
    });
    
    $('#nombreUP').keyup(function(){
		$('#nameMessage').html(checkNE('^[ñÑa-zA-ZÁ-ÿ ]+$','#nameMessage',$('#nombreUP').val()));
	});
	
	$('#telUP').keyup(function(){
		$('#telMessage').html(checkNE('^[0-9]{10}$','#telMessage',$('#telUP').val()));
	
	});
	$('#emailUP').keyup(function(){
		//^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$
		//^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$
		$('#emailMessage').html(checkNE('^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+)\.+([a-zA-Z0-9]{2,4})+$','#emailMessage',$('#emailUP').val()));
	
	});
	
	$('#nomUsUP').keyup(function(){
		$('#usernameMessage').html(checkNE('^[A-Za-z0-9._-]+$','#usernameMessage',$('#nomUsUP').val()));
	});
	
	$('#fechNacUP').change(function(){
		$('#dateMessage').html(checkDate('#dateMessage',$('#fechNacUP1').val()));
	
	});
		
	

	
});
	
	
	
	
	
	
