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
function valLogin(){
	let usuario=$('#nomUsIniciar').val();
	let password=$('#contrasena').val();
	if((usuario!==null && usuario.length>3)&&
	(password!==null && password.length>7)){
		/*Swal.fire(
		  'Exitoso',
		  'iniciando sesión',
		  'sucess'
		);*/
		$('#validateIn').val("true");
		$('#formLogID').submit();
	}else{
		Swal.fire(
		  'Error',
		  'Verifica que no hayas dejado campos en blanco, e intenta de nuevo',
		  'error'
		);
	}
}

function valRegister(){
		if($('#nameMessage').hasClass("Valid")&& $('#telMessage').hasClass("Valid")&&
		$('#emailMessage').hasClass("Valid") && $('#usernameMessage').hasClass("Valid") &&
	 	$('#dateMessage').hasClass("Valid")&& ($('#strengthMessage').hasClass("Good")|
	 	$('#strengthMessage').hasClass("Strong"))&& $('#myequalMessage').hasClass("AlikeE")){
			Swal.fire(
			  'success',
			  'Registrando',
			  'sucess'
			);
			
		$('#formRegID').submit();
	}else{
		Swal.fire(
		  'Error',
		  'Verifica que no hayas dejado campos en blanco, y cumplas con las especificaciones',
		  'error'
		);
	}
}

function valModUser(){
	$('#nameMessage').html(checkNE('^[ñÑa-zA-ZÁ-ÿ ]+$','#nameMessage',$('#nombreUP').val()));
	$('#telMessage').html(checkNE('^[0-9]{10}$','#telMessage',$('#telUP').val()));
	$('#emailMessage').html(checkNE('^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+)\.+([a-zA-Z0-9]{2,4})+$','#emailMessage',$('#emailUP').val()));
	$('#usernameMessage').html(checkNE('^[A-Za-z0-9._-]+$','#usernameMessage',$('#nomUsUP').val()));
	$('#dateMessage').html(checkDate('#dateMessage',$('#fechNacUP1').val()));

	if($('#nameMessage').hasClass("Valid")&& $('#telMessage').hasClass("Valid")&&
		$('#emailMessage').hasClass("Valid") && $('#usernameMessage').hasClass("Valid") &&
	 	$('#dateMessage').hasClass("Valid")){
		
			let pass1U=$('#contrasena1UP').val();
			let pass2U=$('#contrasena2UP').val();
			if((pass1U!=="" && pass1U.length>7)&&
				(pass2U!=="" && pass2U.length>7)){
					
					if(($('#strengthMessage').hasClass("Good")|$('#strengthMessage').hasClass("Strong"))&& $('#myequalMessage').hasClass("AlikeE")
					&&($('#fotoMessage').hasClass("Valid")|$('#fotoMessage').text()==="")){
						Swal.fire(
						  'success',
						  'Guardando Cambios',
						  'sucess'
						);
						$('#formUser').submit();
					}else{
						Swal.fire(
						  'Error',
						  'Verifica que no hayas dejado campos en blanco, y cumplas con las especificaciones',
						  'error'
						);
					}
			}else if(pass1U==="" &&pass2U===""){
					if($('#fotoMessage').hasClass("Valid")|$('#fotoMessage').text()===""){
						Swal.fire(
						  'success',
						  'Guardando Cambios',
						  'sucess'
						);
						$('#formUser').submit();
						
					}else{
						Swal.fire(
						  'Error',
						  'Verifica que no hayas dejado campos en blanco, y cumplas con las especificaciones',
						  'error'
						);
					}
				
			}else{
						Swal.fire(
						  'Error',
						  'Verifica que no hayas dejado campos en blanco, y cumplas con las especificaciones',
						  'error'
						);
			}
			
	}else{
		Swal.fire(
		  'Error',
		  'Verifica que no hayas dejado campos en blanco, y cumplas con las especificaciones',
		  'error'
		)
	}
	
}