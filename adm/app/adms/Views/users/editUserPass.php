<?php
if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}

if (isset($this->data['form'][0])) {
    $valorForm = $this->data['form'][0];
}


?>

<h1>Editar Senha </h1>

<?php
echo "<a href='".URLADM."list-users/index'>Listar</a><br>";
if(!empty($valorForm['id'])){
    echo "<a href='".URLADM."view-users/index/".$valorForm['id']."'>Visualizar</a><br><br>";
}

if(isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>
<!--span exibe msg através do javascript-->
<span id="msg"></span>

<form method="POST" action="" id="form-edit-user-pass"> 
<?php
//mandar o id  oculto
    $id = "";
    if (isset($valorForm['id'])) {
        $id = $valorForm['id'];
    }
    ?>
    <input type="hidden" name="id" id="id"  value="<?php echo $id; ?>" ><br><br>   
    <?php
    $password = "";
    if (isset($valorForm['password'])) {
        $password = $valorForm['password'];
    }
    ?>
    <label>Senha:<span style="color:#f00">*</span> </label>
    <input type="password" name="password" id="password" placeholder="Digite a nova senha"onkeyup="passwordStrength()" autocomplete="on" value="<?php echo $password; ?>"required><br><br>

    <span id="msgViewStrength"><br><br></span>

    <span style="color:#f00">* Campo Obrigatório</span><br><br>
 

    <button type="submit" name="SendEditUserPass" value="Salvar">Salvar</button>
</form>

