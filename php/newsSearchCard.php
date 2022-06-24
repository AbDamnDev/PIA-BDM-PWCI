<?php
    // Devuelve un string con un template para la tarjeta de usuario
    function NewsCardP( $id, $title, $desc, $img,$categories,$keywords,$publishdate){

        //ya no ocupa type aqui todas son publicadas
        /*quite el 
        href del boton de edicion 
         <i class='fa-solid fa-check'></i>
         <button type='button' class='news-card-button btn-reset accept-btn' onclick='goToNotice({$id},{$title})'>  <i> Ver </i> </button>
        <a href='news-editor.php'><a>*/
        return "<div class='news-card news-card-publshed' 
                data-id='{$id}' 
                data-title='{$title}'>

                <img class='news-card-img' src='{$img}'/>
                <div class='news-card-info'>
                    <h6>{$publishdate}</h6>
                    <h4 class='news-card-name'>{$title}</h4>
                    <p class='news-card-description'>{$desc}</p>
                    <p class='news-card-description'>{$keywords}</p>
                    <p class='news-card-description'>{$categories}</p>
                </div> 
                <div class='news-card-button-container'>
                <button type='button' class='news-card-button btn-reset accept-btn' onclick='goToNotice({$id},$(this))'>  <i> Ver </i> </button>
                </div>
            </div>";
    }
?>
