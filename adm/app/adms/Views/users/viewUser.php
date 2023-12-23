<?php
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
 
echo "<h2>Detalhes do Usuário!</h2><br>";

echo "<a href='".URLADM."list-users/index'>Listar</a><br>";
if(!empty($this->data['viewUser'])){
    // var_dump($this->data['viewUser']);
    echo "<a href='".URLADM."edit-users/index/".$this->data['viewUser'][0]['id']."'>Editar</a><br>";
    echo "<a href='".URLADM."edit-users-password/index/".$this->data['viewUser'][0]['id']."'>Editar Senha</a><br>";
    echo "<a href='".URLADM."edit-users-image/index/".$this->data['viewUser'][0]['id']."'>Editar Imagem</a><br>";
    echo "<a href='".URLADM."delete-users/index/".$this->data['viewUser'][0]['id']."'onclick= 'return confirm(\"Tem certeza que deseja excluir este registro?\")'>Apagar</a><br><br>";
}


if(isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
if(!empty( $this->data['viewUser'])){
 //var_dump( $this->data['viewUser'][0]);
extract( $this->data['viewUser'][0]);
if ((!empty($image)) and (file_exists("app/adms/assets/image/users/$id/$image"))) {
    echo "<img src='" . URLADM . "app/adms/assets/image/users/$id/$image' width='100' height ='100'><br><br>";
}else{
    echo "<img src='" . URLADM . "app/adms/assets/image/users/icon_user.png' width='100' height ='100'><br><br>";
}
echo "ID: $id<br>";
echo "NOME: $name_usr<br>";
echo "USUÁRIO: $user<br>";
echo "SITUACÃO DO USUÁRIO: <span style='color:$color;'>$name_sit</span><br>";

// função para converter data criacao para padrões normais
echo "CADASTRADO:".date('d/m/Y H:i:s',strtotime($created))."<br>";
echo "EDITADO: ";
// no modified tem que ver se existe antes de converter pq não verificar imprime a data errada
if(!empty($modified)){
    echo date('d/m/Y H:i:s',strtotime($modified))."<br>";
}
echo  "<br>";
}