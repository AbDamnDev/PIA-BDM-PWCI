<link rel="stylesheet" type="text/css" href="assets/css/user-modal.css">
<link rel="stylesheet" type="text/css" href="assets/css/user-card.css">
<div class="user-modal-darkener">
    <article class="user-modal">
        <button 
            class="btn-reset user-modal-close"
            onclick="CloseModal()"
        >
            <i class="fa-solid fa-xmark"></i>
        </button>
        <div class="user-modal-pic-holder">
            <div class="user-modal-type-banner"></div>
            <img class="user-modal-pic" alt="imagen usuario">
        </div>
        <h2 class="user-modal-name"> Username </h2>
        <form  name="formUsType" id="formUsType" method="POST" action="Includes/users/ModUser_include.php">
            <div class="user-modal-type-wrapper">
                <h4> Type </h4>
                <div class="user-modal-type-options">
                    <label 
                        data-type=1
                        onclick="ClickRadio(1)"    
                    >
                        <input class="radioTypeUs" type="radio" name="type" value=1>
                        <p class="user-modal-type-option user-modal-option-admin">
                            <i class='fa-solid fa-circle'></i> 
                            <span>Admin</span>
                        </p>
                    </label>
                    <label 
                        data-type=2
                        onclick="ClickRadio(2)" 
                    >
                        <input class="radioTypeUs" type="radio" name="type" value=2>
                        <p class="user-modal-type-option user-modal-option-reporter">
                            <i class='fa-solid fa-circle'></i> 
                            <span>Reporter</span>
                        </p>
                    </label>
                    <label 
                        data-type=3
                        onclick="ClickRadio(3)" 
                    >
                        <input class="radioTypeUs" type="radio" name="type" value=3>
                        <p class="user-modal-type-option user-modal-option-user">
                            <i class='fa-solid fa-circle'></i> 
                            <span>User</span>
                        </p>
                    </label>
                </div>
            </div>
            <input name="usIDCard" type="hidden" value="0" id="usIDCard"/>
            <input name="accion" type="hidden" value="changeUsType" id="changeUS"/>
            <div class="user-modal-btn-container">
                <button class="btn-reset user-modal-btn user-modal-submit-btn" onclick='editTypeUser()' >Edit</button>
                <button class="btn-reset user-modal-btn user-modal-cancel-btn" id="BButton" onclick='blockUnblock()'>Block</button>
            </div>
        </form>
    </article>
</div>
<script>
    function OpenModal(id){
        //Obtener datos necesitados del la tarjeta
        const editedCard = document.querySelector(`.user-card[data-id='${id}']`);
        const cardpic  = editedCard.querySelector('.user-card-img');
        const cardname = editedCard.getAttribute('data-name');
        const cardtype = editedCard.getAttribute('data-type');
        const cardUsStatus= editedCard.getAttribute('data-state');

        //obtener datos necesitados y a modifical del modal
        const modal         = document.querySelector('.user-modal-darkener');
        const modalpic      = modal.querySelector('.user-modal-pic');
        const modalbanner   = modal.querySelector('.user-modal-type-banner');
        const modalname     = modal.querySelector('.user-modal-name');
        const modalradio    = modal.querySelector(`[data-type='${cardtype}']`);
        const cardoption    = modalradio.querySelector('.user-modal-type-option');
        const modalbuttontype =modal.querySelector('user-modal-cancel-btn');
        const artModal =document.querySelector('user-modal-class');


        let color = '';
        switch(cardtype){
            case '1':
                color = 'var(--admin-color)';
                break;
            case '2':
                color = 'var(--reporter-color)';
                break;
            case '3':
                color = 'var(--user-color)';
                break;
        }

        if(cardUsStatus=="A"){
            $('#BButton').text("Block");
        }else if(cardUsStatus=="B"){
            $('#BButton').text("Unblock");
        }
        modal.classList.add('user-modal-darkener-active');
        modalname.innerText = cardname;
        modalpic.src = cardpic.src;
        modalbanner.style.backgroundColor = color;
        $('#usIDCard').val(id);
        modalradio.click();
    }
    function CloseModal(){
        const modal = document.querySelector('.user-modal-darkener');
        modal.classList.remove('user-modal-darkener-active');
    }
    function ClickRadio(type){
        let color = '';
        switch(type){
            case 1:
                color = 'var(--admin-color)';
                break;
            case 2:
                color = 'var(--reporter-color)';
                break;
            case 3:
                color = 'var(--user-color)';
                break;
        }
        
        const modal         = document.querySelector('.user-modal-darkener');
        const modalbanner   = modal.querySelector('.user-modal-type-banner');
        modalbanner.style.backgroundColor = color;
    }
    function DeleteUser(id){
        const data={
        accion:"deleteUser",
        user: id
        };
    const dataString= JSON.stringify(data);
    const options={
        method:"POST",
        header: { "Content-Type": "application/json"},
        body: dataString
    };
    fetch('Includes/users/DelUser_include.php',options).catch(console.error);

    }
    function edituser(){
        $('#formUsType').submit();
    }
    function blockUnblock(){
        var option=$('#BButton').text();
        var opsend;
        if(option==="Block"){
            opsend="B";
        }else{
            opsend="A";
        }
        const data={
        accion:"blockUnblock",
        option: opsend,
        user: $('#usIDCard').val()
        };
        const dataString= JSON.stringify(data);
        const options={
            method:"POST",
            header: { "Content-Type": "application/json"},
            body: dataString
        };
        fetch('Includes/users/BlockUnbUser_include.php',options).catch(console.error);

    }
</script>
<?php
    // Devuelve un string con un template para la tarjeta de usuario
    function UserCard( $id, $name, $img, $type, $state){

        $color;
        switch( $type ){
            case 1:
                $color  = "user-card-admin";
                break;
            case 2:
                $color  = "user-card-reporter";
                break;
            case 3:
                $color  = "user-card-user";
                break;
        }

        return "
            <div 
                class='user-card {$color}'
                data-id='{$id}'
                data-name='{$name}'
                data-type={$type}
                data-state={$state}
            >
                <img class='user-card-img' src='{$img}'/>
                <div class='user-card-info'>
                    <h4 class='user-card-name'>{$name}</h4>
                </div> 
                <div class='user-card-button-container'>
                    <button class='user-card-btn btn-reset edit-btn' onclick='OpenModal({$id})'> <i class='fa-solid fa-pen-to-square'></i> </button>
                    <button class='user-card-btn btn-reset delete-btn'  onclick='DeleteUser({$id})'> <i class='fa-solid fa-minus'></i>  </button>
                </div>
            </div>
        ";
    }

?>