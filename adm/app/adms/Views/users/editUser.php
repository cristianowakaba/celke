<?php
if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}

if (isset($this->data['form'][0])) {
    $valorForm = $this->data['form'][0];
}


?>

<h1>Editar  Usuário</h1>

<?php
if(isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>
<span id="msg"></span>

<form method="POST" action="" id="form-add-user"> 
<?php
//mandar o id  oculto
    $id = "";
    if (isset($valorForm['id'])) {
        $name = $valorForm['id'];
    }
    ?>
    <input type="hidden" name="id" id="id"  value="<?php echo $id; ?>" ><br><br>   
    <?php
    $name = "";
    if (isset($valorForm['name'])) {
        $name = $valorForm['name'];
    }
    ?>
    <label>Nome: </label>
    <input type="text" name="name" id="name" placeholder="Digite o nome completo" value="<?php echo $name; ?>"required ><br><br>
    <?php
    $nickname = "";
    if (isset($valorForm['nickname'])) {
        $nickname= $valorForm['nickname'];
    }
    ?>
    <label>Apelido: </label>
    <input type="text" name="nickname" id="nickname" placeholder="Digite o apelido" value="<?php echo $nickname; ?>"required ><br><br>
    
    <?php
    $email = "";
    if (isset($valorForm['email'])) {
        $email = $valorForm['email'];
    }
    ?>
    <label>E-mail: </label>
    <input type="email" name="email" id="email" placeholder="Digite o seu melhor e-mail" value="<?php echo $email; ?>"required ><br><br>
    <?php
    $user = "";
    if (isset($valorForm['user'])) {
        $email = $valorForm['user'];
    }
    ?>
    <label>Usuário: </label>
    <input type="text" name="user" id="user" placeholder="Digite o Usuário para acessar o adm" value="<?php echo $email; ?>"required ><br><br>

   
 

    <button type="submit" name="SendEditUser" value="Salvar">Salvar</button>
</form>

