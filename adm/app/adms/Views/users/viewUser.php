<?php

echo "<h2>Detalhes do Usuário!</h2><br>";

if(isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
if(!empty( $this->data['viewUser'])){
 //var_dump( $this->data['viewUser'][0]);
extract( $this->data['viewUser'][0]);
echo "ID: $id<br>";
echo "NOME: $name_usr<br>";
echo "USUÁRIO: $user<br>";
echo "IMAGEM: $image<br>";
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