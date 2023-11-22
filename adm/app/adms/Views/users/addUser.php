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
    <label>Nome:<span style="color:#f00">*</span> </label>
    <input type="text" name="name" id="name" placeholder="Digite o nome completo" value="<?php echo $name; ?>" ><br><br>
    
    <?php
    $email = "";
    if (isset($valorForm['email'])) {
        $email = $valorForm['email'];
    }
    ?>
    <label>E-mail:<span style="color:#f00">*</span> </label>
    <input type="email" name="email" id="email" placeholder="Digite o seu melhor e-mail" value="<?php echo $email; ?>" ><br><br>
    <?php
    $user = "";
    if (isset($valorForm['user'])) {
        $email = $valorForm['user'];
    }
    ?>
    <label>Usuário:<span style="color:#f00">*</span> </label>
    <input type="text" name="user" id="user" placeholder="Digite o Usuário para acessar o adm" value="<?php echo $email; ?>" ><br><br>
    <?php
   
    ?>
<!-- se o usuario preencher o campo situacao com a mesma situacao que vem do banco de dados maném pré selecionado, senão fica aparecendo selecione -->
    <label>Situação:<span style="color: #f00;">*</span> </label>
    <select name="adms_sits_user_id" id="adms_sits_user_id">
        <option value="">Selecione</option>
        
        <?php
       foreach($this->data['select']['sit'] as $sit){
            extract($sit);
            if((isset($valorForm['adms_sits_user_id'])) and ($valorForm['adms_sits_user_id'] == $id_sit)){
                echo "<option value='$id_sit' selected>$name_sit</option>";
            }else{
                echo "<option value='$id_sit'>$name_sit</option>";
            }
        } 
        ?>
    </select><br><br>

    <?php
    $password = "";
    if (isset($valorForm['password'])) {
        $password = $valorForm['password'];
    }
    ?>
    <label>Senha:<span style="color:#f00">*</span> </label>
    <!--onkeyup="passwordStrength()" calcula a força da senha-->
    <input type="password" name="password" id="password" placeholder="Digite a senha" onkeyup="passwordStrength()" autocomplete="on"  value="<?php echo $password; ?>">
    <span id="msgViewStrength"><br><br></span>
 
    <span style="color:#f00">* Campo Obrigatório</span><br><br>

    <button type="submit" name="SendAddUser" value="Cadastrar">Cadastrar</button>
</form>

