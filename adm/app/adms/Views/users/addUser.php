<?php
if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
?>

<h1>Cadastrar Usuário</h1>

<?php
if(isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>
<span id="msg"></span>

<form method="POST" action="" id="form-add-user">    
    <?php
    $name = "";
    if (isset($valorForm['name'])) {
        $name = $valorForm['name'];
    }
    ?>
    <label>Nome: </label>
    <input type="text" name="name" id="name" placeholder="Digite o nome completo" value="<?php echo $name; ?>"required ><br><br>
    
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

    <?php
    $password = "";
    if (isset($valorForm['password'])) {
        $password = $valorForm['password'];
    }
    ?>
    <label>Senha: </label>
    <!--onkeyup="passwordStrength()" calcula a força da senha-->
    <input type="password" name="password" id="password" placeholder="Digite a senha" onkeyup="passwordStrength()" autocomplete="on"  value="<?php echo $password; ?>"required><span id="msgViewStrength"><br><br></span>
 

    <button type="submit" name="SendAddUser" value="Cadastrar">Cadastrar</button>
</form>
<p><a href="<?php echo URLADM; ?>">Clique aqui</a> para acessar</p>
