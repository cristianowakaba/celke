<?php
if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}

if (isset($this->data['form'][0])) {
    $valorForm = $this->data['form'][0];
}


?>

<h1>Editar  Imagem</h1>

<?php
echo "<a href='" . URLADM . "view-profile/index'>Perfil</a><br><br>";

if(isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>
<!--span exibe msg através do javascript-->
<span id="msg"></span>
<!-- TENÇÃO ESSA PARTE É OBRIGATÓRIA PARA TRABALHAR COM IMAGEM enctype="multipart/form-data">  -->
<form method="POST" action="" id="form-edit-prof-img" enctype="multipart/form-data"> 

   
  <!--  atencão imagem tipo file -->
    <label>Imagem:<span style="color:#f00">*</span> 300x300 </label>
    <input type="file" name="new_image" id="new_image"><br><br>
   
    

    <span style="color:#f00">* Campo Obrigatório</span><br><br>
 

    <button type="submit" name="SendEditProfImage" value="Salvar">Salvar</button>
</form>

