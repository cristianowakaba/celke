<?php

echo "<h2>Listar Usuários</h2>";
// var_dump($this->data['listUsers']);
if(isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

foreach($this->data['listUsers'] as $user){

    // var_dump($user);
    extract($user);
    echo "ID: $id <br>";
    echo "Nome: $name <br>";
    echo "email: $email <br>";
    //quando clicar no link, manda o id como parametro
    echo "<a href='".URLADM."view-users/index/$id'>Visualizar</a><br>";
    echo "<hr>";


    // echo "ID:".$user['id']."<br>";
    // echo "name:".$user['name']."<br>";
    // echo "email:".$user['email']."<br><hr>";
}