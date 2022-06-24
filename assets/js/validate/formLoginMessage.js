$(document).ready(function() {
	
  $("#formRegID").validate({
      rules:{
          nombre:{
              required: true,
              minlength: 4,
              pattern: "[A-Za-zñÑáéíóúÁÉÍÓÚ\s]+"
          },
          telefono:{
              required: true,
              minlength: 10,
              maxlength:10,
              pattern: "[0-9]+"
          },
          correoCrear:{
              required: true,
              minlegth: 3,
              email:true
          },
          nomUs:{
              required: true,
              minlength: 5,
              pattern: "[A-Za-z0-9\_\-\.]+"
          },
          fechNac:{
              required: true
          },
          contrasena1:{
              required: true,
              minlength: 8,
              pattern: "[A-Za-z0-9\_\-\.]+"
          },
          contrasena2:{
              required: true,
              minlength: 8,
              pattern: "[A-Za-z0-9\_\-\.]+"
          }
        
      },
      messages:{
          nombre:{
              required: "Escribe tu nombre",
              minlength: "Debes escribir mínimo 4 caracteres",
              pattern: "Solo puedes escribir letras de A-Z, la ñ, acentos y espacios"
              
          },
          telefono:{
              required: "Escribe tu número de teléfono",
              minlength: "Debes escribir 10 dígitos",
              maxlength:"Debes escribir solo 10 dígitos",
              pattern: "Solo puedes escribir dígitos del 0 al 9"
          },
          correoCrear:{
              required: "Escribe tu correo",
              pattern:"[A-Za-z0-9_-.@]+",
              email: "Tu email debe tener la siguiente forma: example@mail.com"
          },
          nomUs:{
              required: "Escribe tu nombre de usuario",
              minlength: "Debes escribir mínimo 5 caracteres",
              pattern: "Solo puedes escribir letras de A-Z, guion, guion bajo y punto"
          },
          fechNac:{
               required: "Escoge una fecha de nacimiento"
          },
          contrasena1:{
              required: "Escribe tu contraseña",
              minlength: "Debes escribir mínimo 8 caracteres",
              pattern: "[A-Za-z0-9¡”#$%&/=’?¡¿:;,.-_+*{][}]+"
          },
          contrasena2:{
              required: "Escribe tu contraseña nuevamente",
              minlength: "Debes escribir mínimo 8 caracteres",
              pattern: "[A-Za-z0-9_-.]+"
          }
      }
      
  });
});