<?php
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
echo "<h2>Listar Usuários</h2>";
echo "<a href='".URLADM."add-users/index'>Cadastrar</a><br><br>";
// var_dump($this->data['listUsers']);
if(isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

foreach($this->data['listUsers'] as $user){

// var_dump($user);
    extract($user);
    echo "ID: $id <br>";
    echo "Nome: $name_usr <br>";
    echo "email: $email <br>";
    echo "Situação:<span style='color:$color'>$name_sit </span> <br>";
    //quando clicar no link, manda o id como parametro
    echo "<a href='".URLADM."view-users/index/$id'>Visualizar</a><br>";
    echo "<a href='".URLADM."edit-users/index/$id'>Editar</a><br>";
    echo "<a href='".URLADM."delete-users/index/$id'>Apagar</a><br>";
    echo "<hr>";
   


    // echo "ID:".$user['id']."<br>";
    // echo "name:".$user['name']."<br>";
    // echo "email:".$user['email']."<br><hr>";
}