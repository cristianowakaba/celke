<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/**
 * Controller apagar tipo de página 
 * @author Cesar <cesar@celke.com.br>
 */
class DeleteTypesPages
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
            
            $DeleteTypesPages= new \App\adms\Models\AdmsDeleteTypesPages();
            $DeleteTypesPages->DeleteTypesPages($this->id);    
                 
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0142: Necessário selecionar um typo de página!</p>";
        }

        $urlRedirect = URLADM . "list-types-Pages/index";
        header("Location: $urlRedirect");

    }
}
