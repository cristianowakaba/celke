<?php

namespace App\adms\Models;

if(!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Apagar cor no banco de dados
 *
 * @author Celke
 */
class AdmsDeleteTypesPages
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

   
    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }
/**
 * verifica se existe a situação do usuário cadastrada no banco de dados e se asituação não esta sendo utilizada por nenhum usuario.
 * se existir a situação e ela não estiver sendo utilizada instancia a helper para deletar o registros
 * @param integer $id
 * @return void
 */
    public function deleteTypesPages(int $id): void
    {
        $this->id = (int) $id;

        if(($this->viewTypesPages())and($this->checkStatusUsed())){
           $deleteTypesPages = new \App\adms\Models\helper\AdmsDelete();
           $deleteTypesPages->exeDelete("adms_types_pgs", "WHERE id =:id", "id={$this->id}");
    
            if ($deleteTypesPages->getResult()) {
                $_SESSION['msg'] = "<p class='alert-success'>Cor apagada com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro 0141: tipo de página não apagada com sucesso!</p>";
                $this->result = false;
            }
        }else{
            $this->result = false;
        }
        
    }
/**
 * Metodo verifica se o typo de página esta cadastrada na tabela e envia o resultado para a função deleteColor
 *
 * @return boolean
 */
    private function viewTypesPages(): bool
    {

        $viewTypesPages = new \App\adms\Models\helper\AdmsRead();
        $viewTypesPages->fullRead(
            "SELECT id
                            FROM       adms_types_pgs                          
                            WHERE id=:id
                            LIMIT :limit",
            "id={$this->id}&limit=1"
        );

        $this->resultBd = $viewTypesPages->getResult();
        if ($this->resultBd) {
            return true;
        } else {
            $_SESSION['msg'] =  "<p class='alert-danger'>Erro 0139: tipo de página não encontrada!</p>";
            return false;
        }
    }
    /**
     * Metodo verifica se tem situação cadastrados usando a cor a ser excluida, caso tenha a exclusão não é permitida
     * O resultado da pesquisa é enviada para a função deleteColor
     * @return boolean
     */
    private function checkStatusUsed():bool
    {
        $viewTypesPagesUsed = new \App\adms\Models\helper\AdmsRead();
        $viewTypesPagesUsed->fullRead("SELECT id FROM adms_pages 
        WHERE adms_types_pgs_id =:adms_types_pgs_id 
        LIMIT :limit", "adms_types_pgs_id ={$this->id}&limit=1");

        if(  $viewTypesPagesUsed->getResult()){
            $_SESSION['msg'] =  "<p class='alert-danger'>Erro 0140:Cor não pode ser apagada,  há páginas cadastradas com esse tipo!</p>";
            return false;
        }else{
            return true;
        }
    }
}
