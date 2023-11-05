<?php

echo "<h2>Listar Usuários</h2>";
// var_dump($this->data['listUsers']);
if(isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

foreach($this->data['listUsers'] as $user){

    var_dump($user);
    extract($user);
    echo "ID: $id <br>";
    echo "Name: $name <br>";
    echo "email: $email <br>";


    // echo "ID:".$user['id']."<br>";
    // echo "name:".$user['name']."<br>";
    // echo "email:".$user['email']."<br><hr>";
}