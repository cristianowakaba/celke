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

<form method="POST" action="" id="form-edit-user"> 
<?php
//mandar o id  oculto
    $id = "";
    if (isset($valorForm['id'])) {
        $id = $valorForm['id'];
    }
    ?>
    <input type="hidden" name="id" id="id"  value="<?php echo $id; ?>" ><br><br>   
    <?php
    $name = "";
    if (isset($valorForm['name'])) {
        $name = $valorForm['name'];
    }
    ?>
    <label>Nome:<span style="color:#f00">*</span> </label>
    <input type="text" name="name" id="name" placeholder="Digite o nome completo" value="<?php echo $name; ?>"><br><br>
    <?php
    $nickname = "";
    if (isset($valorForm['nickname'])) {
        $nickname= $valorForm['nickname'];
    }
    ?>
    <label>Apelido: </label>
    <input type="text" name="nickname" id="nickname" placeholder="Digite o apelido" value="<?php echo $nickname; ?>" ><br><br>
    
    <?php
    $email = "";
    if (isset($valorForm['email'])) {
        $email = $valorForm['email'];
    }
    ?>
    <label>E-mail:<span style="color:#f00">*</span> </label>
    <input type="email" name="email" id="email" placeholder="Digite o seu melhor e-mail" value="<?php echo $email; ?>"required ><br><br>
    <?php
    $user = "";
    if (isset($valorForm['user'])) {
        $email = $valorForm['user'];
    }
    ?>
    <label>Usuário:<span style="color:#f00">*</span></label>
    <input type="text" name="user" id="user" placeholder="Digite o Usuário para acessar o adm" value="<?php echo $email; ?>"required ><br><br>
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

    <span style="color:#f00">* Campo Obrigatório</span><br><br>
 

    <button type="submit" name="SendEditUser" value="Salvar">Salvar</button>
</form>

