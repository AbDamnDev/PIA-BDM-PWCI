var fotosGuardadasBD= new Array();
var videoGuardadoBD ;
var commentArray=new Array();
//COMMENT GENERATOR
/*class CommentData{<---STRUCTURE EACH COMMENT MUST HAVE
    Id;
    UserName;
    UserPic;
    Contenido;
    DateTime;
    Parent;
}*/
function commentTemplate(data,btn){
    let comm = document.createElement('div');
    comm.classList.add('comment');
    comm.setAttribute('data-id', data.id);

    let divflexea=document.createElement('div');
    divflexea.classList.add('flexea');

    let divimg=document.createElement('div');
   
    let img= document.createElement('img');
    img.classList.add('userImgComment');
    if(data.userpic!=null){
        img.src=data.userpic;
    }else{
        img.src="images/User.png";
    }
    divimg.append(img);

    let divNameCommDate=document.createElement('div');

    let h5 = document.createElement('h5');
    h5.innerText = data.username;

    let text = document.createElement('text');
    text.innerText = data.contenido;

    let h6 = document.createElement('h6');
    h6.innerText = data.datetime;
    divNameCommDate.append(h5,text,h6);


    //hasta aqui es la clase flexea
    divflexea.append(divimg,divNameCommDate);

    //seccion de botones
    let divbtns=document.createElement('div');
    if(btn==2){
        let btnreply=document.createElement('button');
        btnreply.classList.add('RepplyBTN');
        btnreply.innerHTML='Reply';
        btnreply.setAttribute('id', 'replyComm');
        let btndelete=document.createElement('button');
        btndelete.classList.add('DeleteBTN');
        btndelete.innerHTML='Delete';
        btndelete.setAttribute('id', 'deleteComm');

    divbtns.append(btnreply,btndelete);
    }else if(btn==1){
        let btndelete=document.createElement('button');
        btndelete.classList.add('DeleteBTN');
        btndelete.innerHTML='Delete';
        btndelete.setAttribute('id', 'deleteComm');

    divbtns.append(btndelete);
    }
    

    let responseSpace = document.createElement('div');
    responseSpace.classList.add('Respuestas');
    let subcomment= document.createElement('div');
    subcomment.classList.add('Reply');
    responseSpace.append(subcomment)
    
    comm.append(divflexea,divbtns,responseSpace);
    return comm;
}

class Node{
    children = []

    id;
    username;
    userpic;
    contenido;
    datetime;

    constructor(id = -1, username = '', userpic = '', contenido = '', datetime = ''){
        this.id = id;
        this.username = username;
        this.userpic = userpic;
        this.contenido = contenido;
        this.datetime = datetime;
    }
    
    // O(n) time O(n) space
    traversal(parentElement,btn){
        if( this.id !== -1 ){
            const comment = commentTemplate(this,btn);
            parentElement.append(comment);
            parentElement = comment.querySelector('.Reply');
        }
        
        this.children.forEach(child=>{
            child.traversal(parentElement,btn);
        });
    }

    newChild(nodeToInsert){
        this.children.push(nodeToInsert);
        const subcommentSection = document.querySelector(`.comment[data-id="${this.id}" .subcomment`);
        subcommentSection.append(commentTemplate(nodeToInsert,btn));
    }
}

/**
 * @param {CommentData[]} comments 
 */

// O( v + e ) time O(n) space
// v -> vertices 
// e -> edges
function constructTree(comments){
    mp = {};
    adj = {}; 
    comments.forEach(c => {
        mp[c.Id] = c;
        adj[c.Id] = []
    });
    
    // fill adjacency
    for( let comment of comments ){
        if( comment.Parent !== null &&comment.Parent !== 0){
            adj[comment.Parent].push(comment.Id);
        }
    }

    // topological sorting
    top_level_nodes = [];
    comments.forEach(x=>{
        if( x.Parent === null || x.Parent===0){
            top_level_nodes.push(x.Id);
        }
    });

    // create tree
    let head = new Node();
    head.children.push(...top_level_nodes.map(idx=>dfs(idx, mp, adj)));
    return head;
}

/**
 * DFS SOBRE LOS DATOS TOP LEVEL
 * @param {CommentData} data 
 * @param {{}} adj 
 */
function dfs(idx, mp, adj){
    const data = mp[idx];
    let node = new Node(data.Id, data.UserName, data.UserPic, data.Contenido, data.DateTime);
    adj[data.Id].forEach(idx=>{
        const child = dfs(idx, mp, adj);
        node.children.push(child);
    });
    return node;
}

function loadImagesVideoComments(){
    let newsid =$('#newsBox').attr('data-newsid');
    if(newsid>0){
        const data={
            accion:"getNewsInfo",
            idnews: newsid
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
                    //SET VIDEO
                    let videopath=new String();
                    videopath=respuesta.newsInfo[0].NEWS_VIDEO_PATH;
                    videoGuardadoBD=respuesta.newsInfo[0].NEWS_VIDEO_PATH;
                    let position=videopath.search("/Proyecto-BDM-PWCI/Videos/");
                    if(position!=-1){
                        let finalPath= videopath.substring(position);
                        let videoinput=document.getElementById('videoPreviewP');
                        var source=document.createElement('source');
                        source.src=finalPath;
                        source.type="video/mp4";
                        videoinput.appendChild(source);
                        videoinput.load();
                    }
                    //set images
                    for(i=0;i<respuesta.images.length;i++){
                       let objF={
                            src: null,
                            isMain: null,
                            id: null
                        }
                        objF.src=respuesta.images[i].NEWS_PHOTO;
                        objF.isMain=respuesta.images[i].IS_MAIN_IMAGE;
                        objF.id=respuesta.images[i].NEWS_PHOTO_ID;
                        if(objF.isMain==1){
                            fotosGuardadasBD.unshift(objF); 
                        }else{
                            fotosGuardadasBD.push(objF); 
                        }
                        
                    }
                    $('#seeImage').attr('src',fotosGuardadasBD[0].src);
                    $('#imageText').html('Imagen (1/ '+(fotosGuardadasBD.length)+')');
                    //get comments    
                    getComments(newsid);
    
                }else{
                    alert("hubo un error inesperado");
                }
            }).catch(console.error);
    }
    
}
function getComments(id){
    const data={
        accion:"getNewsComments",
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
                for(let i=0; i<respuesta.comments.length;i++){
                    let objC={
                        Id: respuesta.comments[i].COMMENT_ID,
                        UserName: respuesta.comments[i].USERNAME,
                        UserPic: respuesta.comments[i].USER_PIC,
                        Contenido: respuesta.comments[i].COMMENT_TEXT,
                        DateTime: respuesta.comments[i].COMMENT_DATE,
                        Parent: respuesta.comments[i].COMMENT_PARENT,
                    }
                    commentArray.push(objC);
                }
                const tree = constructTree(commentArray);
                let buttons=0;
                if ($("#comment_form").length &&$('#likebtn').length) { //si estan los comentarios y boton de like es usuario registrado
                    buttons=2; //ambos botones de delete y reply
                }else if($('#likebtn').length){// si solo estan los likes es o admin o reportero
                    buttons=1; //solo el de delete
                }else{ //si no hay ninguno es usuario no registrado
                    buttons=0; //ningun boton
                }
                //comment_section
                tree.traversal(document.querySelector('.comment_section'),buttons);

            }else{
                //no comments yet
            }
        }).catch(console.error);

}
function updateLikes(){
    let newsid =$('#newsBox').attr('data-newsid');
        const data={
            accion:"getLikes",
            idnews: newsid,
        };
        const dataString= JSON.stringify(data);
        const options={
            method:"POST",
            header: { "Content-Type": "application/json"},
            body: dataString
        };
        fetch('./Includes/news/Comments/Likes_include.php',options)
        .then(handlerResponse)
        .then(respuesta =>{
            if(respuesta.result=="true"){
                $('#numlikes').text('Numero total de likes : '+respuesta.likes);
            }else{

            }
        }).catch(console.error);
}
$(document).ready(function(){
    loadImagesVideoComments();

    $('#prevImage').on('click',function(){
		let currentImage=$('#seeImage').attr('src');
		let listNumb=null;
		
		for(i=0;i<fotosGuardadasBD.length;i++){
			if(currentImage==fotosGuardadasBD[i].src){
				listNumb=i-1;
			}
		}
		if(listNumb!=null){
			if(listNumb!=-1){
				$('#seeImage').attr('src',fotosGuardadasBD[listNumb].src);
                $('#imageText').html('Imagen ('+(listNumb+1)+' / '+(fotosGuardadasBD.length)+')');
			}
		}

	});
	$('#nextImage').on('click',function(){
		let currentImage=$('#seeImage').attr('src');
		let listNumb=null;
		
		for(i=0;i<fotosGuardadasBD.length;i++){
			if(currentImage==fotosGuardadasBD[i].src){
				listNumb=i+1;
			}
		}
		if(listNumb!=null){
			if(listNumb<fotosGuardadasBD.length){
				$('#seeImage').attr('src',fotosGuardadasBD[listNumb].src);
                $('#imageText').html('Imagen ('+(listNumb+1)+' / '+(fotosGuardadasBD.length)+')');
			}
		}

	});
    //comment_form
    $('#comment_form').submit(function(event){
        event.preventDefault();
        var form = document.getElementById('comment_form');
        var formData = new FormData(form);
        let newsid =$('#newsBox').attr('data-newsid');
        formData.append('accion','insertNewComment');
        formData.append('newsid',newsid);
        formData.append('parent',null);
        const data = {};
  		formData.forEach((value, key) => (data[key] = value));
          $.ajax({
            url     : "./Includes/news/Comments/CreateComm_include.php",
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
        
	});
    let enviandose = false;
    $(document).on("submit","#comment_formReply", function(event){
        event.preventDefault();
        event.stopImmediatePropagation();
        if(enviandose){
            return;
        } enviandose=true;
        var form = document.getElementById('comment_formReply');
        var formData = new FormData(form);
        $.ajax({
            url     : "./Includes/news/Comments/CreateComm_include.php",
            method  : "POST",
            data    : formData,
            contentType:false,
            cache:false,
            processData: false
        }).done(function (data, textEstado, jqXHR){
            if(data=="true"){
                Swal.fire({
                    icon: "success",
                    title: "Done..",
                    text: "Comentario insertado exitosamente",
                    showConfirmButton: true,
                    confirmButtonText: "Cerrar"}).then(function (result){
                        if(result.value){
                            enviandose=false;
                            $('#comment_formReply').remove();
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
    });

    $('#likebtn').on('click',function(){
        //primero obtengo la imagen del like pa saber si ya esta puesto o no
        let finallike;
        let islike=1;
        let currentlike=new String($('#likeimg').attr('src'));
        if(currentlike.localeCompare('images/like.png')==0){
            //si es el like original, le damos like al post
            finallike='images/like2.png';
            islike=1;
        }else{
            //quitamos el like
            finallike='images/like.png';
            islike=0;
        }
        let newsid =$('#newsBox').attr('data-newsid');
        const data={
            accion:"setUnsetLike",
            idnews: newsid,
            like:islike
        };
        const dataString= JSON.stringify(data);
        const options={
            method:"POST",
            header: { "Content-Type": "application/json"},
            body: dataString
        };
        fetch('./Includes/news/Comments/Likes_include.php',options)
        .then(handlerResponse)
        .then(respuesta =>{
            if(respuesta.result==="true"){
                //actualizamos la imagen
                $('#likeimg').attr('src',finallike);
                //update like number
                updateLikes();
            }else{
                alert("error");
            }
        }).catch(console.error);
        
        
	});
    $("body").on("click","#replyComm", function (){
        if ($("#comment_formReply").length == 1) {
            $("#comment_formReply").parent().remove();
        }
        let comment=$(this).parent().parent();
        let commentid=comment.attr('data-id');
        let divhijos=comment.children();
        let respuestadiv=divhijos[2];
        let newsid =$('#newsBox').attr('data-newsid');
        let str='<div class="NewComment Respuesta" >';
        str+='<form id="comment_formReply">';
        str+='<input type="hidden" name="parent" value="'+commentid+'" /> ';
        str+='<input type="hidden" name="accion" value="insertNewComment" /> ';
        str+='<input type="hidden" name="newsid" value="'+newsid+'" />';
        str+='<textarea maxlength="200" name="commenttext" id="commenttextreply" placeholder="Comenta algo..."></textarea>';
        str+='<button type="submit" id="buttonCommentReply" class="RepplyBTN">Comentar</button>';
        str+='</form></div>';
        if(respuestadiv!=null){
            respuestadiv.innerHTML=str;
        }else{
            alert("error");
        }
        
	});
    $("body").on("click","#deleteComm", function (){
		let comment=$(this).parent().parent();
        let commentid=comment.attr('data-id');
        let newsid =$('#newsBox').attr('data-newsid');
        const data={
            accion:"DeleteComment",
            idnews: newsid,
            commid:commentid
        };
        const dataString= JSON.stringify(data);
        const options={
            method:"POST",
            header: { "Content-Type": "application/json"},
            body: dataString
        };
        fetch('./Includes/news/Comments/DeleteComm_include.php',options)
        .then(handlerResponse)
        .then(respuesta =>{
            if(respuesta.result=="true"){
               location.reload();
            }else{
                alert("no se pudo borrar el comentario");
            }
        }).catch(console.error);


	});

});

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