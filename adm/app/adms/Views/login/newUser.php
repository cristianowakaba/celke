<?php
if (!defined('C8L6K7E')) {
    /*  header("Location:/"); */
    die("Erro: Página não encontrada!<br>");
}
if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
?>
<div class="container-login">
    <div class="wrapper-login">
        <div class="title">
            <span>Novo Usuário</span>
        </div>

        
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <span id="msg"></span>

        <form method="POST" action="" id="form-new-user" class="form-login">
            <?php
            $name = "";
            if (isset($valorForm['name'])) {
                $name = $valorForm['name'];
            }
            ?>
           <div class="row">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="name" id="name" placeholder="Digite o nome" value="<?php echo $name; ?>" required>
            </div>
            

            <?php
            $email = "";
            if (isset($valorForm['email'])) {
                $email = $valorForm['email'];
            }
            ?>
           <div class="row">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder="Digite o e-mail" value="<?php echo $email; ?>" required>
            </div>
            <?php
            $password = "";
            if (isset($valorForm['password'])) {
                $password = $valorForm['password'];
            }
            ?>
            <label>Senha:<span style="color:#f00">*</span> </label>
            <!--onkeyup="passwordStrength()" calcula a força da senha-->
            <div class="row">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Digite a senha" onkeyup="passwordStrength()" autocomplete="on" value="<?php echo $password; ?>" required>
            </div>
            <span id="msgViewStrength"><br><br></span>

            <span style="color:#f00">* Campo Obrigatório</span>
            <div class="row button">
                <button type="submit" name="SendNewUser" value="Cadastrar">Cadastrar</button>
            </div>
            <div class="signup-link">
                <a href="<?php echo URLADM; ?>">Clique aqui</a> para acessar
            </div>
        </form>
        
    </div>
</div>