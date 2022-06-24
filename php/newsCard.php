<?php
    // Devuelve un string con un template para la tarjeta de usuario
    function NewsCard( $id, $title, $desc, $img, $type,$TYPEUSER){
        $color;
        $typename;
        switch( $type ){
            case 1:
                $color  = "news-card-publshed";
                $typename = "Published";
                break;
            case 2:
                $color  = "news-card-onreview";
                $typename = "On Review"; //TERMINADA O EN REVISION
                break;
            case 3:
                $color  = "news-card-draft";
                $typename = "Draft"; // EN REDACCION
                break;
        }
        /*quite el 
        href del boton de edicion 
        <a href='news-editor.php'><a>*/
        return "
            <div 
                class='news-card {$color}' 
                data-id='{$id}' 
                data-title='{$title}'
                data-type='{$type}'
                data-userManager='{$TYPEUSER}'
            >
                <img class='news-card-img' src='{$img}'/>
                <div class='news-card-info'>
                    <h4 class='news-card-name'>{$title}</h4>
                    <p class='news-card-description'>{$desc}</p>
                    <p class='{$color}'>
                        <i class='fa-solid fa-circle'></i> 
                        <span>{$typename}</span>
                    </p>
                </div> 
                <div class='news-card-button-container'>
                    <button class='news-card-button btn-reset accept-btn' onclick='publicarNoticia({$id},{$type},$(this))'>
                        <i class='fa-solid fa-check'></i>
                    </button>
                     
                    <button class='news-card-button btn-reset edit-btn' onclick='editarNoticia({$id},{$type},$(this))'> 
                        <i class='fa-solid fa-pen-to-square'></i> 
                    </button>
                    
                    <button class='news-card-button btn-reset delete-btn' onclick='eliminarNoticia({$id},{$type},$(this))'> 
                        <i class='fa-solid fa-minus'></i>  
                    </button>
                </div>
            </div>
        ";
    }
?>


