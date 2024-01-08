<?php
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }

echo "<h2>Perfil</h2>";

if (!empty($this->data['viewProfile'])) {
     echo "<a href='".URLADM."edit-profile/index'>Editar</a><br>";
     echo "<a href='".URLADM."edit-profile-password/index'>Editar Senha</a><br>";
     echo "<a href='".URLADM."edit-profile-image/index'>Editar Imagem</a><br><br>";

   
}


if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
if (!empty($this->data['viewProfile'])) {
    ////var_dump( $this->data['viewProfile'][0]);
    extract($this->data['viewProfile'][0]);
    // se existe no banco de dados e existe no servidor
    if ((!empty($image)) and (file_exists("app/adms/assets/image/users/" . $_SESSION['user_id'] . "/$image"))) {
        echo "<img src='" . URLADM . "app/adms/assets/image/users/" . $_SESSION['user_id'] . "/$image' width='100' height ='100'><br><br>";
    }else{
        echo "<img src='" . URLADM . "app/adms/assets/image/users/icon_user.png' width='100' height ='100'><br><br>";
    }
    echo "Nome: $name<br>";
    echo "Apelido: $nickname<br>";
    echo "Email: $email<br>";
    
}
