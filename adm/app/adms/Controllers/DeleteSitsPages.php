<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller apagar situação página
 * @author Cesar <cesar@celke.com.br>
 */
class DeleteSitsPages
{

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;
    
    /**
     * Método apagar situação página
     * Se existir o ID na URL instancia a MODELS para excluir o registro no banco de dados
     * Senão criar a mensagem de erro
     * Redireciona para a página listar situação página
     *
     * @param integer|string|null|null $id Receber o id do registro que deve ser excluido
     * @return void
     */
    public function index(int|string|null $id = null): void
    {


        if (!empty($id)) {
            $this->id = (int) $id;
            
            $deleteSitUser = new \App\adms\Models\AdmsDeleteSitsPages();
            $deleteSitUser->deleteSitPage($this->id);    
                 
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0127: Necessário selecionar uma situação!</p>";
        }

        $urlRedirect = URLADM . "list-sits-pages/index";
        header("Location: $urlRedirect");

    }
}
