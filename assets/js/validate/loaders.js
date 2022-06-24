function cargarInfoUsuario(){
    const data={
        accion:"getUserInfo"
    };
    const dataString= JSON.stringify(data);
    const options={
        method:"POST",
        header: { "Content-Type": "application/json"},
        body: dataString
    };
    fetch('./Includes/users/GetUser_include.php',options)
    .then(res=>res.json())
    .then(respuesta =>{
        if(respuesta.result==="true"){
            //alert("si llega bien"+respuesta.data[0].EMAIL);
            $("#nombreUP").val(respuesta.data[0].USER_FULL_NAME);
            document.getElementById("fechNacUP1").valueAsDate = new Date(respuesta.data[0].BIRTHDATE);
            $("#nomUsUP1").val(respuesta.data[0].USERNAME);
            $("#telUP").val(respuesta.data[0].PHONE);
            $("#emailUP").val(respuesta.data[0].EMAIL);
            if(respuesta.data[0].PROFILE_PIC!=null){
                $('#ProfPic').attr("src", respuesta.data[0].PROFILE_PIC);
            }else{
                $('#ProfPic').attr("src","images/User.png");
            }
        }else{
            alert("hubo un error al obtener los datos del usuario");
        }

    }

    ).catch(console.error);


}
function getSession(){
    var fd=new FormData();
    fd.append('accion','getSession');
    const data={
        accion:"getSession"
    }
    const dataString= JSON.stringify(data);
    const options={
        method:'POST',
        header: { 'Content-Type': 'application/json', 'Accept': 'application/json',},
        body: fd
    };
    $.ajax({
        url : "./Includes/users/GetUser_include.php",
        data : dataString,
        contentType: "application/json",
        method: "POST",
        cache:false,
        processData: false
    }).done(function (data, textEstado, jqXHR){
        if(data.user!=null){
            //alert("usuario: "+ data.user);
            cargarInfoUsuario(data.user);
        }else{
            alert("error, el usuario sale nulo");
        }
    }).fail(function (data, textEstado, jqXHR){
        console.log("la solicitud fallos porque: " + textEstado);
    });
}

$(document).ready(function(){
    cargarInfoUsuario();
    
    $("#formUser").submit(function(event){
        event.preventDefault();
        var form = document.getElementById('formUser');
        var formData = new FormData(form);
        
        $.ajax({
            url     : 'Includes/users/ModUser_include.php',
            method  : "POST",
            data    : formData,
            contentType:false,
            cache:false,
            processData: false
        }).done(function (data, textEstado, jqXHR){
            
        }).fail(function (data, textEstado, jqXHR){
        console.log("la solicitud fallos porque: " + textEstado);
        });
    }); 
});