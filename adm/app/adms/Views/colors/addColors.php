<?php
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }

if(isset($this->data['form'])){

    $valorForm =$this->data['form'];
}
?>

<h1>Cadastrar Cor</h1>

<?php
echo "<a href='" . URLADM . "list-Colors/index'>Listar Cores</a><br><br>";

//var_dump($this->data['select']);

if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>
<span id="msg"></span>
<form method="POST" action="" id="form-add-color">
    <?php
    $name = "";
    if (isset($valorForm['name'])) {
        $name = $valorForm['name'];
    }
    ?>
    <label>Nome:<span style="color: #f00;">*</span> </label>
    <input type="text" name="name" id="name" placeholder="Digite o nome da Cor" value="<?php echo $name; ?>"required ><br><br>

    <?php
    $color = "";
    if (isset($valorForm['color'])) {
        $color = $valorForm['color'];
    }
    ?>
    <label>Cor:<span style="color: #f00;">*</span> </label>
    <input type="text" name="color" id="color" placeholder="Cor em hexadecimal" value="<?php echo $color; ?>"required><br><br>

    <span style="color: #f00;">* Campo Obrigatório</span><br><br>

    <button type="submit" name="SendAddColor" value="Cadastrar">Cadastrar</button>
</form>