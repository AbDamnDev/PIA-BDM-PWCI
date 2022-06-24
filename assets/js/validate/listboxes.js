$(document).ready(function() {
    $('#btnRight').click(function(e) {
        var selectedOpts = $('#lstBox1 option:selected');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }

        $('#lstBox2').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });

    $('#btnLeft').click(function(e) {
        var selectedOpts = $('#lstBox2 option:selected');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }

        $('#lstBox1').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });

    $('#categorias').on('change', function (e) {
        var optionSelected = $('#categorias option:selected').val();
        if (optionSelected>0){
            getCatInfo(optionSelected);
        }
    });
});

//$('#selectorId option:selected').val();
function createCat(){
    if($('#color').val()!=""&&$('#nombre').val()!=""){
        const data={
            accion:"createCat",
            color: $('#color').val(),
            nombre: $('#nombre').val()
            };
            const dataString= JSON.stringify(data);
            const options={
            method:"POST",
            header: { "Content-Type": "application/json"},
            body: dataString
            };
            fetch('Includes/news/CreateCat_include.php',options).then(handlerResponse)
            .then(respuesta=>{
                if(respuesta){
                    location.reload();
                }else{
                    alert("hubo un error al obtener los datos de la categoria");
                }
            }).catch(console.error);
    }else{
        alert("No puedes registrar una categoría con datos vacíos");
    }
       
}
function getCatInfo(optionSelected){
        const data={
        accion:"getCat",
        catNumber: optionSelected
        };
        const dataString= JSON.stringify(data);
        const options={
        method:"POST",
        header: { "Content-Type": "application/json"},
        body: dataString
        };
        fetch('./Includes/news/GetCat_include.php',options)
        .then(handlerResponse)
        .then(respuesta =>{
            if(respuesta.result==="true"){
                //alert("si llega bien"+respuesta.data[0].EMAIL);
                $("#nombreCM").val(respuesta.data[0].DESCRIPTION);
                $("#color2").val(respuesta.data[0].COLOR);
                $("#idcat").val(respuesta.data[0].CATEGORY_ID);
            }else{
                alert("hubo un error al obtener los datos de la categoria");
            }
    
        }).catch(console.error);
}
function modCat(){
    if($('#color2').val()!=""&&$('#nombreCM').val()!="" && $('#idcat').val()!="0"){
        const data={
            accion:"modCat",
            color: $('#color2').val(),
            nombre: $('#nombreCM').val(),
            id: $('#idcat').val()
            };
            const dataString= JSON.stringify(data);
            const options={
            method:"POST",
            header: { "Content-Type": "application/json"},
            body: dataString
            };
            fetch('./Includes/news/ModCat_include.php',options)
            .then(handlerResponse)
            .then(respuesta =>{
                if(respuesta.result==="true"){
                    Swal.fire({
                        icon: "success",
                        title: "Done..",
                        text: "Categoria Modificada exitosamente",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"}).then(function (result){
                            if(result.value){
                                window.reload();
                            }
                            }); 
                }else{
                    alert("hubo un error al modificar la categoria");
                }
        
            }).catch(console.error);
    }else{
        alert("No puedes modificar una categoría con datos vacíos");
    }
}

function delCat(){
    if($('#color2').val()!=""&&$('#nombreCM').val()!="" && $('#idcat').val()!="0"){
        const data={
            accion:"delCat",
            id: $('#idcat').val()
            };
            const dataString= JSON.stringify(data);
            const options={
            method:"POST",
            header: { "Content-Type": "application/json"},
            body: dataString
            };
            fetch('./Includes/news/DelCat_include.php',options)
            .then(handlerResponse)
            .then(respuesta =>{
                if(respuesta.result==="true"){
                    alert("llega bien");
                }else{
                    alert("error");
                }
        
            }).catch(console.error);
    }else{
        alert("No puedes modificar una categoría con datos vacíos");
    }
}

function ordCats(){
    var arrayCat=new Array();
    $('#lstBox2 option').each(function(){
        arrayCat.push($(this).val());
    });
    
    if(arrayCat.length>0 && $('#lstBox1').children().length == 0){
        //alert("funciona otravez"+ arrayCat);

        const data={
            accion:"ordCats",
            cats: arrayCat
            };
            const dataString= JSON.stringify(data);
            const options={
            method:"POST",
            header: { "Content-Type": "application/json"},
            body: dataString
            };
            fetch('./Includes/news/ModCat_include.php',options)
            .then(handlerResponse)
            .then(respuesta =>{
                if(respuesta.result==="true"){
                    Swal.fire({
                        icon: "success",
                        title: "Done..",
                        text: "Categorias Ordenadas exitosamente",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"}).then(function (result){
                            if(result.value){
                                location.reload();
                            }
                            }); 
                }else{
                    alert("hubo un error al ordenar las categorias");
                }
        
            }).catch(console.error);

    }

}
function resetPage(){
    location.reload();
}

async function  handlerResponse(res){
    const content=await res.text();
    try{
        const jsonData = JSON.parse(content);
        return jsonData;
    }catch(e){
        alert(content);
        return {result:false};
    }
}

