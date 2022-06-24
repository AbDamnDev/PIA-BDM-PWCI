function publicarNoticia(id,type,container){
    let typeusermanager=container.parent().parent().attr('data-usermanager');
    //alert(typeusermanager);
    let newtype=null;
    if(typeusermanager=="Reporter"){
        //si es reportero le va a dar status terminado
        if(type==3){
            newtype="Terminada";
        }else{ //si esta publicada no podemos hacer nada al menos aqui
            Swal.fire({
                icon: "error",
                title: "Done..",
                text: "No puedes realizar más cambios de status en la noticia",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"});
        }
        //aqui no se muestran las noticias terminadas

    }else if(typeusermanager=="Admin"){
        //si es admin le va a dar status publicado
        if(type==2){//si esta terminada, la podemos publicar
            newtype="Publicada";
        }else{ //si esta publicada no podemos hacer nada
            Swal.fire({
                icon: "error",
                title: "Done..",
                text: "No puedes realizar más cambios de status en la noticia",
                showConfirmButton: true,
                confirmButtonText: "Cerrar"});
        }
        //aqui no se muestran las noticias en redaccion

    }
    if(newtype!=null){
        const data={
            accion:"changeNewsStatus",
            newsID: id,
            newsSetType: newtype
            };
            const dataString= JSON.stringify(data);
            const options={
            method:"POST",
            header: { "Content-Type": "application/json"},
            body: dataString
            };
            fetch('./Includes/news/News/StatusNews_include.php',options)
            .then(handlerResponse)
            .then(respuesta =>{
                if(respuesta.result==="true"){
                    Swal.fire({
                        icon: "success",
                        title: "Done..",
                        text: "Cambio de estatus exitoso",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"}).then(function (result){
                            if(result.value){
                                location.reload();
                            }
                            }); 
                }else{
                    Swal.fire({
                        icon: "error",
                        title: "Done..",
                        text: "Hubo un error",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"});
                }
        
            }).catch(console.error);
    }
    
}

function editarNoticia(id,type, container){
    let typeusermanager=container.parent().parent().attr('data-usermanager');
    let title=new String();
    title=container.parent().parent().attr('data-title');
    title=title.replace(/ /g,"_");
    const data={
        accion:"newsIdRedirect",
        newsID: id,
        };
        const dataString= JSON.stringify(data);
        const options={
        method:"POST",
        header: { "Content-Type": "application/json"},
        body: dataString
        };
    if(typeusermanager=="Reporter"){
        
        if(type==1){ //si esta publicada mejor nos vamos a single page
            window.location='single_page.php?title='+title+'&newsid='+id;
        }else if(type==3){ //si esta en redaccion nos vamos al editor
             window.location='news-editor.php?newsid='+id;     
        }
    }else if(typeusermanager=="Admin"){
        if(type==1){
            window.location='single_page.php?title='+title+'&newsid='+id;
        }else if(type==2){
            window.location='news-editor.php?newsid='+id;    
        }

    }
}
function eliminarNoticia(id,type, container){
    let typeusermanager=container.parent().parent().attr('data-usermanager');
    if(type!=1){
        const data={
            accion:"deleteNews",
            id: id,
            typeUser: typeusermanager
            };
            const dataString= JSON.stringify(data);
            const options={
            method:"POST",
            header: { "Content-Type": "application/json"},
            body: dataString
            };
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
                fetch('./Includes/news/News/DeleteNews_include.php',options)
                .then(handlerResponse)
                .then(respuesta =>{
                    if(respuesta){
                        Swal.fire(
                            'Eliminado exitoso!',
                            'Se ha borrado la noticia',
                            'success'
                          );
                          location.reload();
                    }else{
                        Swal.fire(
                            'Error!',
                            'No se pudo eliminar la noticia',
                            'error'
                          );
                    }
                }).catch(console.error);
              
            }
          });
    }else{
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "No puedes eliminar una noticia ya publicada",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"});
    }
    
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