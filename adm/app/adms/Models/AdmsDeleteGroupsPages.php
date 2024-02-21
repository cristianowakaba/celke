<?php

namespace App\adms\Models;

if(!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Apagar grupo de páginas no banco de dados
 *
 * @author Celke
 */
class AdmsDeleteGroupsPages
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
    public function deleteGroupesPages(int $id): void
    {
        $this->id = (int) $id;

        if(($this->viewGroupsPages())and($this->checkStatusUsed())){
           $deleteGroupsPages = new \App\adms\Models\helper\AdmsDelete();
           $deleteGroupsPages->exeDelete("adms_groups_pgs", "WHERE id =:id", "id={$this->id}");
    
            if ($deleteGroupsPages->getResult()) {
                $_SESSION['msg'] = "<p class='alert-success'>Grupo de página apagada com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro 0152: Grupo de página não apagado com sucesso!!</p>";
                $this->result = false;
            }
        }else{
            $this->result = false;
        }
        
    }
/**
 * Metodo verifica se o typo de página esta cadastrada na tabela e envia o resultado para a função deletegroupspages
 *
 * @return boolean
 */
    private function viewGroupsPages(): bool
    {

        $viewTypesPages = new \App\adms\Models\helper\AdmsRead();
        $viewTypesPages->fullRead(
            "SELECT id
                            FROM adms_groups_pgs                      
                            WHERE id=:id
                            LIMIT :limit",
            "id={$this->id}&limit=1"
        );

        $this->resultBd = $viewTypesPages->getResult();
        if ($this->resultBd) {
            return true;
        } else {
            $_SESSION['msg'] =  "<p class='alert-danger'>Erro 0150: grupo de página não encontrada!</p>";
            return false;
        }
    }
      /**
     * Metodo verifica se tem páginas cadastradas usando o grupo de página a ser excluido, caso tenha a exclusão não é permitida
     * O resultado da pesquisa é enviada para a função deleteGroupsPages
     * @return boolean
     */
    private function checkStatusUsed():bool
    {
        $viewGroupsPagesUsed = new \App\adms\Models\helper\AdmsRead();
        $viewGroupsPagesUsed->fullRead("SELECT id FROM adms_pages
        WHERE adms_groups_pgs_id =:adms_groups_pgs_id 
        LIMIT :limit", "adms_groups_pgs_id ={$this->id}&limit=1");

        if(  $viewGroupsPagesUsed->getResult()){
            $_SESSION['msg'] =  "<p class='alert-danger'>Erro 0151 : Grupo de página não pode ser apagado, há páginas cadastradas com esse grupo!!</p>";
            return false;
        }else{
            return true;
        }
    }
}
