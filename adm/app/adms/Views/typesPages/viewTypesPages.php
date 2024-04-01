<?php
if (!defined('C8L6K7E')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}
?>
<!-- Início do conteúdo administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Detalhes do tipo de página</span>
            <div class="top-list-right">
                <?php
                 if( $this->data['button']['list_types_pages']){
               echo "<a href='" . URLADM . "list-types-pages/index'class='btn-info'>Listar</a> ";
                 }
                if (!empty($this->data['viewTypePage'])) {
                    if( $this->data['button']['edit_types_pages']){
                    echo "<a href='" . URLADM . "edit-types-pages/index/" . $this->data['viewTypePage'][0]['id'] ."' class='btn-warning'>Editar</a> ";
                    }
                    if( $this->data['button']['delete_types_pages']){
                    echo "<a href='" . URLADM . "delete-types-pages/index/" . $this->data['viewTypePage'][0]['id'] . "'onclick= 'return confirm(\"Tem certeza que deseja excluir este registro?\")' class='btn-danger'>Apagar</a> ";
                    }
                   
                }
                ?>
            </div>
        </div>

        <div class="content-adm">
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
        </div>

        <div class="content-adm">
            <?php
            if (!empty($this->data['viewTypePage'])) {
                extract($this->data['viewTypePage'][0]);
            ?>
                
                <div class="view-det-adm">
                    <span class="view-adm-title">ID: </span>
                    <span class="view-adm-info"><?php echo $id; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Tipo do Pacote: </span>
                    <span class="view-adm-info"><?php echo $type; ?></span>
                </div>
                <div class="view-det-adm">
                    <span class="view-adm-title">Nome: </span>
                    <span class="view-adm-info"><?php echo $name ?></span>
                </div>
                <div class="view-det-adm">
                    <span class="view-adm-title">Ordem: </span>
                    <span class="view-adm-info"><?php echo $order_type_pg; ?></span>
                </div>
                <div class="view-det-adm">
                    <span class="view-adm-title">Observação: </span>
                    <span class="view-adm-info"><?php echo $obs ?></span>
                </div>


                <div class="view-det-adm">
                    <span class="view-adm-title">Cadastrado: </span>
                    <span class="view-adm-info"><?php echo date('d/m/Y H:i:s', strtotime($created));?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Editado: </span>
                    <span class="view-adm-info">
                        <?php
                        if (!empty($modified)) {
                            echo date('d/m/Y H:i:s', strtotime($modified));
                        } ?>
                    </span>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<!-- Fim do conteúdo administrativo -->
