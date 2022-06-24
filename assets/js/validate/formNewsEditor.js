var contenedor_imagen =null;
var contenedor_video=null;
var fotosGuardadasBD= new Array();
var fotosBorradasBD= new Array();
var CategoriasGuardadasBD = new Array();
var CategoriasBorradasBD = new Array();
var videoGuardadoBD ;
function valNews(){
	let savebtn=$("#Guardar").text();
	if(savebtn=="Regresar como borrador"){
		//alert("vas a regresarlo como borrador");
		let id=$('#idnoticia').val();
		let newtype="En Redacción";
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
                        text: "Se ha regresado la noticia como borrador",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"}).then(function (result){
                            if(result.value){
								window.location='news-dashboard.php';
                            }
                            }); 
                }else{
                    Swal.fire({
                        icon: "error",
                        title: "Done..",
                        text: "Hubo un error al regresar la noticia",
                        showConfirmButton: true,
                        confirmButtonText: "Cerrar"});
                }
        
            }).catch(console.error);
	}else{
		let categories=$(".ParaNotitas").children();
			let photos=new Array();
			var filelist = document.getElementById("foto").files || [];
			for (var i = 0; i < filelist.length; i++) {
				//console.log('found file ' + i + ' = ' + filelist[i].name);
				photos.push(filelist[i].name);
			}
			let video=$("#video")[0].files[0] //files
			let autor=$('#autor').val();
			let namae=document.getElementById('nomUs');
			if(autor==="0"){
				$('#autor').val(namae.textContent);
			}
			var arrayCat=new Array();
			$('.ParaNotitas .CategoriaEnEditor p').each(function(){
				arrayCat.push($(this).attr("cat-id")); 
			});
			var arrayEtq=new Array();
			$('.ParaEtiquetas .CategoriaEnEditor').each(function(){
				arrayEtq.push($(this).find("text").text()); 
			});
		if($('#idnoticia').val()==0){
			/*$("#titulo").val();
			$("#etiquetas").val();
			$("#fechaAcon").val();
			$("#lugarAcon").val();
			$("#descNoticia").val();
			$("#cuerpoNoticia").val();*/
			
			
			if(checkEmptyNews($("#titulo").val())&& arrayCat.length>0&& photos.length>0 &&checkEmptyNews(video.name)
			&& arrayEtq.length>0 && checkEmptyNews($("#fechaAcon").val()) && checkEmptyNews($("#lugarAcon").val())
			&& checkEmptyNews($("#descripcion").val()) && checkEmptyNews($("#cuerpo").val()) && checkEmptyNews($('#autor').val())){
				$("#noticiaNueva").submit();
			}else{
				Swal.fire(
				'Error',
				'Verifica que no hayas dejado campos en blanco, e intenta de nuevo',
				'error'
				);
			}
		}else{
			$("#accionNoticia").val('modNews');
			let totalphotos=0;
			$('.ParaFotos .FotoEnEditor').each(function(){
				totalphotos++;
			});
			let totalvideos=0;
			$('.ParaFotos .FotoEnEditor').each(function(){
				totalvideos++;
			});
			if(checkEmptyNews($("#titulo").val())&& arrayCat.length>0 && totalphotos>0 && totalvideos>0 &&
			arrayEtq.length>0 && checkEmptyNews($("#fechaAcon").val()) && checkEmptyNews($("#lugarAcon").val())
			&& checkEmptyNews($("#descripcion").val()) && checkEmptyNews($("#cuerpo").val()) && checkEmptyNews($('#autor').val())){
				$("#noticiaNueva").submit();
			}else{
				Swal.fire(
				'Error',
				'Verifica que no hayas dejado campos en blanco, e intenta de nuevo',
				'error'
				);
			}
		}
	}
	
	
}
function checkNE(regex, input){
	const nameRegularExp = new RegExp(regex);
	if(nameRegularExp.test(input)){
		return true;
	}else{
		return false;
	}
}
function eliminarNoticia(){
	let newsid=$('#idnoticia').val();
	const data={
		accion:"deleteNews",
		id: newsid
		};
		const dataString= JSON.stringify(data);
		const options={
		method:"POST",
		header: { "Content-Type": "application/json"},
		body: dataString
		};
		fetch('./Includes/news/News/DeleteNews_include.php',options)
		.then(handlerResponse)
		.then(respuesta =>{
			if(respuesta){
				Swal.fire({
					icon: "success",
					title: "Done..",
					text: "Noticia eliminada exitosamente",
					showConfirmButton: true,
					confirmButtonText: "Cerrar"}).then(function (result){
						if(result.value){
							window.location="news-dashboard.php";
						}
						}); 
			}else{
				alert("hubo un error al eliminar la noticia");
			}
	
		}).catch(console.error);
}
function publicarNoticia(){
	let newsid=$('#idnoticia').val();
	const data={
		accion:"changeNewsStatus",
		newsID: newsid,
        newsSetType: "Publicada"
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
					text: "Se ha publicado la noticia",
					showConfirmButton: true,
					confirmButtonText: "Cerrar"}).then(function (result){
						if(result.value){
							window.location='news-dashboard.php';
						}
						}); 
			}else{
				Swal.fire({
					icon: "error",
					title: "Done..",
					text: "Hubo un error al publicar la noticia",
					showConfirmButton: true,
					confirmButtonText: "Cerrar"});
			}
	
		}).catch(console.error);
}
function valEdComment(){
	let comtext=$('#comentario').val()
	if(!(comtext==="")){
		$('#comentarioEditor').submit();
	}else{
		Swal.fire(
		  'Error',
		  'Verifica que no hayas dejado campos en blanco, e intenta de nuevo',
		  'error'
		);
	}
	
}
function checkEmptyNews(input){
	if(input==="" || input===null || input.lenght===0){
		return false;
	}else{
		return true;
	}
}
function resetImagesF(){
	$("#foto").val(null);
}
function resetVideoF(){
	$("#video").val(null);
}
function getNewsInfo(){
		let id=$('#idnoticia').val();
		if(id>0){
			const data={
				accion:"getNewsInfo",
				idnews: id
				};
				const dataString= JSON.stringify(data);
				const options={
				method:"POST",
				header: { "Content-Type": "application/json"},
				body: dataString
				};
				fetch('./Includes/news/News/GetNews_include.php',options)
				.then(handlerResponse)
				.then(respuesta =>{
					if(respuesta.result==="true"){
						//alert("llega bien");
						$('#autor').val(respuesta.newsInfo[0].SIGN);
						$('#autorID').val(respuesta.newsInfo[0].CREATED_BY);
						let isEditable=true;
						if(respuesta.newsInfo[0].CREATED_BY!=respuesta.userRequest){
							//si no es el que creo la noticia bloqueamos todos los inputs pa editar
							$('#titulo').prop('readonly',true);
							$('#categorias').remove(); //combobox no se deshabilita, mejor "quitarlo"
							$('#etiquetas').remove();
							$('#fechaAcon').prop('readonly',true);
							$('#lugarAcon').prop('readonly',true);
							$('#descripcion').prop('readonly',true);
							$('#cuerpo').prop('readonly',true);
							$('#foto').remove();	//file no se deshabilita, mejor "quitarlo"
							$('#video').remove();	//file no se deshabilita, mejor "quitarlo"
							$('#resetImages').remove();
							$('#resetVideo').remove();
							isEditable=false;
							$('#Guardar').text("Regresar como borrador");
						}

						$('#titulo').val(respuesta.newsInfo[0].TITLE);
						var keywords= new String();
						keywords=respuesta.newsInfo[0].KEY_WORDS;
						let arrayKeyW=new Array();
						arrayKeyW=keywords.split(',');
						for(let i=0;i<arrayKeyW.length;i++){
							if(isEditable){
								$('.ParaEtiquetas').append('<div class="CategoriaEnEditor"><p></p><text>'+arrayKeyW[i]+'</text><button id="btnDelete" type="button" >X</button></div>');
							}else{
								$('.ParaEtiquetas').append('<div class="CategoriaEnEditor"><p></p><text>'+arrayKeyW[i]+'</text></div>');
							}
						}
						let categsid=respuesta.newsInfo[0].CATEGORIES_ID;
						let arrayCatID=new Array()
						arrayCatID=categsid.split(",");
						let categsname=respuesta.newsInfo[0].CATEGORIES_NAME;
						let arrayCatName=new Array();
						arrayCatName=categsname.split(",");
						for(let i=0;i<arrayCatID.length;i++){
							if(isEditable){
							$('.ParaNotitas').append('<div class="CategoriaEnEditor"><p cat-id='+arrayCatID[i]+'></p><text>'+arrayCatName[i]+'</text><button id="btnDeleteCat" type="button" >X</button></div>');
							}else{
							$('.ParaNotitas').append('<div class="CategoriaEnEditor"><p cat-id='+arrayCatID[i]+'></p><text>'+arrayCatName[i]+'</text></div>');
							}
							CategoriasGuardadasBD.push(arrayCatID[i]); 
						}
						document.getElementById("fechaAcon").valueAsDate = new Date(respuesta.newsInfo[0].DATE_OF_EVENTS);
						$('#lugarAcon').val(respuesta.newsInfo[0].PLACE_OF_EVENTS);
						$('#descripcion').val(respuesta.newsInfo[0].DESCRIPTION);
						$('#cuerpo').val(respuesta.newsInfo[0].TEXT);
						for(i=0;i<respuesta.images.length;i++){
							if(isEditable){
							$('.ParaFotos').append('<div class="FotoEnEditor" data-src="'+respuesta.images[i].NEWS_PHOTO+'" data-ismain='+respuesta.images[i].IS_MAIN_IMAGE+' data-photoID='+respuesta.images[i].NEWS_PHOTO_ID+'><p></p><text >Foto '+(i+1)+'</text><button id="btnDeleteImage" type="button">X</button></div>');
							}else{
							$('.ParaFotos').append('<div class="FotoEnEditor" data-src="'+respuesta.images[i].NEWS_PHOTO+'" data-ismain='+respuesta.images[i].IS_MAIN_IMAGE+' data-photoID='+respuesta.images[i].NEWS_PHOTO_ID+'><p></p><text >Foto '+(i+1)+'</text></div>');	
							}
						}
						$('.ParaFotos .FotoEnEditor').each(function(){
							let objF={
								src: null,
								isMain: null,
								id: null
							}
							objF.src=$(this).attr("data-src");
							objF.isMain=$(this).attr("data-ismain");
							objF.id=$(this).attr("data-photoID");
							fotosGuardadasBD.push(objF); 
						});
						$('#seeImage').attr('src',fotosGuardadasBD[0].src);
						//SET VIDEO
						let videopath=new String();
						videopath=respuesta.newsInfo[0].NEWS_VIDEO_PATH;
						videoGuardadoBD=respuesta.newsInfo[0].NEWS_VIDEO_PATH;
						let position=videopath.search("/Proyecto-BDM-PWCI/Videos/");
						if(position!=-1){
							//"Proyecto-BDM-PWCI"+
							let finalPath= videopath.substring(position);
							if(isEditable){
							$('.ParaVideos').append('<div class="VideoEnEditor" data-src="'+finalPath+'" data-videoID='+respuesta.newsInfo[0].NEWS_VIDEO_ID+'><p></p><text >VIDEO '+1+'</text><button id="btnDeleteImage" type="button">X</button></div>');
							}else{
							$('.ParaVideos').append('<div class="VideoEnEditor" data-src="'+finalPath+'" data-videoID='+respuesta.newsInfo[0].NEWS_VIDEO_ID+'><p></p><text >VIDEO '+1+'</text></div>');
							}
							let videoinput=document.getElementById('videoPreviewP');
							var source=document.createElement('source');
							source.src=finalPath;
							source.type="video/mp4";
							videoinput.appendChild(source);
							videoinput.load();
						}
						if(respuesta.newsInfo[0].NEWS_EDITOR_COMMENT!=null){
							$('#staticComent').attr('data-idcmeditor',respuesta.newsInfo[0].NEWS_EDITOR_COMMENT);
							$('#staticComent').text(respuesta.editorComment);
							if($('#idcomentEditor').length){ //si esta seteado el form del comentario del editor
								$('#idcomentEditor').val(respuesta.newsInfo[0].NEWS_EDITOR_COMMENT);
								$('#comentario').val(respuesta.editorComment);
							}
						}else{
							$('#staticComent').text("Sin comentarios por parte del editor");
						}
						
					}else{
						alert("error en el request");
					}
			
				}).catch(console.error);
		}
	
}

$(document).ready(function(){
	getNewsInfo();
	contenedor_imagen = document.getElementById('imageContainer');
	contenedor_video=document.getElementsByClassName('contenedor__video');
	$("#noticiaNueva").submit(function(event){
        event.preventDefault();
        var form = document.getElementById('noticiaNueva');
        var formData = new FormData(form);
		var arrayCat=new Array();
		$('.ParaNotitas .CategoriaEnEditor p').each(function(){
			arrayCat.push($(this).attr("cat-id")); 
		});
		var arrayEtq=new Array();
		$('.ParaEtiquetas .CategoriaEnEditor').each(function(){
			arrayEtq.push($(this).find("text").text()); 
		});
		var myetiquetas=arrayEtq.toString();
		formData.append('myCategories',arrayCat);
		formData.append('myEtiquetas',myetiquetas);
		formData.append('photosBDDeleted',JSON.stringify(fotosBorradasBD));
		formData.append('categoriesBD',CategoriasGuardadasBD);
		formData.append('categoriesBDDeleted',CategoriasBorradasBD);
		formData.append('videoBD',videoGuardadoBD);
        const data = {};
  		formData.forEach((value, key) => (data[key] = value));
		let actionNews=$("#accionNoticia").val();
		const dataString= JSON.stringify(data);
		if(actionNews=="agregarNoticia"){
			$.ajax({
				url     : "./Includes/news/News/CreateNews_include.php",
				method  : "POST",
				data    : formData,
				contentType:false,
				cache:false,
				processData: false
			}).done(function (data, textEstado, jqXHR){
				//alert(data);
				if(data=="true"){
					Swal.fire({
						icon: "success",
						title: "Done..",
						text: "Noticia insertada exitosamente",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"}).then(function (result){
							if(result.value){
								location.reload();
							}
							}); 
				}else{
					Swal.fire({
						icon: "Error",
						title: "Done..",
						text: "Hubo un error porque:"+ data,
						showConfirmButton: true,
						confirmButtonText: "Cerrar"});
				}
				
			}).fail(function (data, textEstado, jqXHR){
				alert("la solicitud fallos porque: " + textEstado);
				console.log("la solicitud fallos porque: " + textEstado);
			});
		}else{ 
			$.ajax({
				url     : "./Includes/news/News/ModNews_include.php",
				method  : "POST",
				data    : formData,
				contentType:false,
				cache:false,
				processData: false
			}).done(function (data, textEstado, jqXHR){
				data=JSON.parse(data);
				if(data.result=="true"){
					Swal.fire({
						icon: "success",
						title: "Done..",
						text: "Noticia modificada exitosamente, imagenes: "+data.images+"  ,video: "+data.video,
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
						text: "Hubo un error porque: noticia:  "+ data.result+" imagenes: "+data.images+" ,video: "+data.videos,
						showConfirmButton: true,
						confirmButtonText: "Cerrar"});
				}
				
			}).fail(function (data, textEstado, jqXHR){
				alert("la solicitud fallos porque: " + textEstado);
				console.log("la solicitud fallos porque: " + textEstado);
			});
		}
       

	});
	$('#comentarioEditor').submit(function(event){
		event.preventDefault();
		var form = document.getElementById('comentarioEditor');
        var formData = new FormData(form);
		formData.append('accion','insertEditorComment');
		let id=$('#idnoticia').val();
		formData.append('newsID',id);
		$.ajax({
            url     : "./Includes/news/News/ModNews_include.php",
            method  : "POST",
            data    : formData,
            contentType:false,
            cache:false,
            processData: false
        }).done(function (data, textEstado, jqXHR){
			//alert(data);
			if(data=="true"){
				Swal.fire({
					icon: "success",
					title: "Done..",
					text: "Comentario insertado exitosamente",
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
					text: "Hubo un error porque:"+ data,
					showConfirmButton: true,
					confirmButtonText: "Cerrar"});
			}
			
        }).fail(function (data, textEstado, jqXHR){
			alert("la solicitud fallos porque: " + textEstado);
        	console.log("la solicitud fallos porque: " + textEstado);
        });
	});
	$('#categorias').on('change', function (e) {
        var optionSelected = $('#categorias option:selected').val();
        if (optionSelected>0){
            //getCatInfo(optionSelected);
			var arrayCat=new Array();
			var textSelected = $('#categorias option:selected').text();
			$('.ParaNotitas .CategoriaEnEditor').each(function(){
				arrayCat.push($(this).find("text").text()); 
			});
			var repeated=false;
			arrayCat.forEach(function(cat){
				if(cat==textSelected){
					repeated=true;
				}
			});
			if(!repeated){
				$('.ParaNotitas').append('<div class="CategoriaEnEditor"><p cat-id='+optionSelected+'></p><text>'+textSelected+'</text><button id="btnDelete" type="button" >X</button></div>');
			}
			$('#categorias').val($(this).find('option:first').val());
			
        }
    });
	$('#etiquetas').on("keydown",function(event){
		//event.preventDefault();
		if(event.keyCode==13 ||event.keyCode==32 ){ //si presiona un espacio o un enter
			var textEtiq="";
			var textEtiq=$('#etiquetas').val();
			var arrayEtq=new Array();
			$('.ParaEtiquetas .CategoriaEnEditor').each(function(){
				arrayEtq.push($(this).find("text").text()); 
			});
			var repeated=false;
			arrayEtq.forEach(function(etiq){
				if(textEtiq==etiq){
					repeated=true;
				}
			});
			if(!repeated){
				if(checkNE('^#[a-zA-Z0-9_.+-]+$',textEtiq)){
					$('.ParaEtiquetas').append('<div class="CategoriaEnEditor"><p></p><text>'+textEtiq+'</text><button id="btnDelete" type="button" >X</button></div>');
				}else{
					alert("el formato de la etiqueta debe ser #A-Za-z0-9.-_");
				}
				
			}
			$('#etiquetas').val("");
		}
	});

	$("body").on("click","#btnDelete", function (){
		
		$(this).parent().remove();
	});

	$("body").on("click","#btnDeleteCat", function (){
		let cont=$(this).parent().children();
		let pcont=cont[0];
		let catToDelete=pcont.getAttribute('cat-id');
		for(i=0;i<CategoriasGuardadasBD.length;i++){
			if(CategoriasGuardadasBD[i]==catToDelete){
				CategoriasBorradasBD.push(CategoriasGuardadasBD[i]);
			}
		}
		$(this).parent().remove();
	});

	$("body").on("click","#btnDeleteImage", function (){
		let imageToDelete=$(this).parent().attr('data-src');
		let foundInBD=false;
		let deletedImage=false;
		for(i=0;i<fotosGuardadasBD.length;i++){
			if(fotosGuardadasBD[i].src.length==imageToDelete.length){
				foundInBD=true;
				let borrada=fotosGuardadasBD.splice(i,1);
				fotosBorradasBD.push(borrada);
				deletedImage=true;
			}
		}
		if(!foundInBD){
				
					var filelist = document.getElementById("foto").files || []; // <-- reference your file input here
					var fileBuffer = new DataTransfer();
					$.each(filelist, function(i,file){

						var reader = new FileReader();
			
						reader.addEventListener("load", function () {
							// convierte la imagen a una cadena en base64
							if(reader.result.length!=imageToDelete.length){
								fileBuffer.items.add(file);
								document.getElementById("foto").files = fileBuffer.files;
							}
							reader.result;
						  }, false);
						reader.readAsDataURL(file);
					});
					deletedImage=true;
			
		}
		if(deletedImage){
			$(this).parent().remove();
			let currentImageList=new Array();
			$('.ParaFotos .FotoEnEditor').each(function(){
				currentImageList.push($(this).attr("data-src"));
			});
			if(currentImageList.length>0){
				$('#seeImage').attr('src',currentImageList[0]);
			}else{
				$('#seeImage').attr('src','images/no-image.jpg');
			}
		}
		
	});
	$('#prevImage').on('click',function(){
			let currentImage=$('#seeImage').attr('src');
			let listNumb=null;
			let currentImageList=new Array();
			$('.ParaFotos .FotoEnEditor').each(function(){
				currentImageList.push($(this).attr("data-src"));
			});
			if(currentImage!='images/no-image.jpg'){
				for(i=0;i<currentImageList.length;i++){
					if(currentImage==currentImageList[i]){
						listNumb=i-1;
					}
				}
				if(listNumb!=null){
					if(listNumb!=-1){
						$('#seeImage').attr('src',currentImageList[listNumb]);
					}
				}
			}else{
				if(currentImageList.length>0){
					$('#seeImage').attr('src',currentImageList[0]);
				}
			}
			

	});
	$('#nextImage').on('click',function(){
		let currentImage=$('#seeImage').attr('src');
		let listNumb=null;
		let currentImageList=new Array();
		$('.ParaFotos .FotoEnEditor').each(function(){
			currentImageList.push($(this).attr("data-src"));
		});
		if(currentImage!='images/no-image.jpg'){
			for(i=0;i<currentImageList.length;i++){
				if(currentImage==currentImageList[i]){
					listNumb=i+1;
				}
			}
			if(listNumb!=null){
				if(listNumb<currentImageList.length){
					$('#seeImage').attr('src',currentImageList[listNumb]);
				}
			}
		}else{
			if(currentImageList.length>0){
				if(currentImageList.length==1){
					$('#seeImage').attr('src',currentImageList[0]);
				}else{
					$('#seeImage').attr('src',currentImageList[currentImageList.length-1]);
				}
				
			}
		}

	});
	$("#foto").change(function(e) {

		$.each(e.originalEvent.srcElement.files, function(i,file){
			//var file = e.originalEvent.srcElement.files[i];
	        var reader = new FileReader();

			reader.addEventListener("load", function () {
				// convierte la imagen a una cadena en base64
				$('.ParaFotos').append('<div class="FotoEnEditor" data-src="'+reader.result+'" data-ismain=0 data-photoID=0 ><p></p><text >'+file.name+'</text><button id="btnDeleteImage" type="button">X</button></div>');
			  }, false);
	        reader.readAsDataURL(file);
		});
	});

	$("#video").change(async function(e){
		const vidDat= await toBase64(e.target.files[0]);
		let videoinput=document.getElementById('videoPreviewP');
		var source=document.createElement('source');
		source.src=vidDat;
		//source.type="video/mp4";
		videoinput.prepend(source);
		videoinput.load();
	});

	$('#closeManageVideos').on('click', function(){
		contenedor_imagen.style.display="none";
    	contenedor_video[0].style.display = "none";
	});
	$('#manageVideos').on('click', function(){
		contenedor_video[0].style.display = "block";
		contenedor_imagen.style.display = "none";
		contenedor_video[0].style.display = "block";
		let videoinput=document.getElementById('videoPreviewP');
		videoinput.load();
		videoinput.play();
		//$('#videoContainer').show();
	});
});
function manageImagesF(){
	//contenedor_video.style.display = "none";
	contenedor_imagen.style.display="block";
}
function closeManageImagesF(){
	//contenedor_video.style.display = "none";
    contenedor_imagen.style.display = "none";
}
function manageVideosF(){
	contenedor_video.style.display="block";
	contenedor_imagen.style.display = "none";
}
function closeManageVideosF(){
	contenedor_imagen.style.display="block";
    contenedor_video.style.display = "none";
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

function toBase64 (file){   
	return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => resolve(reader.result);
    reader.onerror = error => reject(error);
});
}

async function Main() {
   const file = document.querySelector('#myfile').files[0];
   console.log(await toBase64(file));
}