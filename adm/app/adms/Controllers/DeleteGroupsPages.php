<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/**
 * Controller apagar grupo de página 
 * @author Cesar <cesar@celke.com.br>
 */
class DeleteGroupsPages
{

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;
    /**
     * Método apagar situação usuário
     * Se existir o ID na URL instancia a MODELS para excluir o registro no banco de dados
     * Senão criar a mensagem de erro
     * Redireciona para a página listar situação usuários
     *
     * @param integer|string|null|null $id Receber o id do registro que deve ser excluido
     * @return void
     */
    public function index(int|string|null $id = null): void
    {

        if (!empty($id)) {
            $this->id = (int) $id;
            
            $deleteGroupsPages= new \App\adms\Models\AdmsDeleteGroupsPages();
            $deleteGroupsPages->deleteGroupesPages($this->id);    
                 
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0153: Necessário selecionar um typo de página!</p>";
        }

        $urlRedirect = URLADM . "list-Groups-Pages/index";
        header("Location: $urlRedirect");

    }
}
