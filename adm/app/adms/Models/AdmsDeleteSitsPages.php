<?php

namespace App\adms\Models;

if(!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Apagar situação no banco de dados
 *
 * @author Celke
 */
class AdmsDeleteSitsPages
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
    public function deleteSitPage(int $id): void
    {
        $this->id = (int) $id;
        var_dump( $this->id);
//verifica se existe a situação do usuário cadastrada no banco de dados e se asituação não esta sendo utilizada por nenhum usuario.
        if(($this->viewSitPage())and($this->checkStatusUsed())){
            $deletePages = new \App\adms\Models\helper\AdmsDelete();
            $deletePages->exeDelete("adms_sits_pgs", "WHERE id =:id", "id={$this->id}");
    
            if ($deletePages->getResult()) {
                $_SESSION['msg'] = "<p class='alert-success'>Situação apagada com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-success'>Erro - 0130: Situação não apagada com sucesso!</p>";
                $this->result = false;
            }
        }else{
            $this->result = false;
        }
        
    }
/**
     * Metodo verifica se a situação esta cadastrada na tabela e envia o resultado para a função deleteSitPages
     * @return boolean
     */
    private function viewSitPage(): bool
    {

        $viewSitUser = new \App\adms\Models\helper\AdmsRead();
        $viewSitUser->fullRead(
            "SELECT id
                            FROM adms_sits_pgs                           
                            WHERE id=:id
                            LIMIT :limit",
            "id={$this->id}&limit=1"
        );

        $this->resultBd = $viewSitUser->getResult();
        if ($this->resultBd) {
            return true;
        } else {
            $_SESSION['msg'] =  "<p class='alert-danger'>Erro - 0128:  Situação de página não encontrada!</p>";
            return false;
        }
    }
       /**
     * Metodo verifica se tem páginas cadastradas usando a situação a ser excluida, caso tenha a exclusão não é permitida
     * O resultado da pesquisa é enviada para a função deleteSitPages
     * @return boolean
     */
    private function checkStatusUsed():bool
    {
        $viewPagesAdd = new \app\adms\Models\helper\AdmsRead();
        $viewPagesAdd->fullRead("SELECT id FROM adms_pages WHERE adms_sits_pgs_id =:adms_sits_pgs_id LIMIT :limit", "adms_sits_pgs_id={$this->id}&limit=1");
        if($viewPagesAdd->getResult()){
            $_SESSION['msg'] =  "<p class='alert-danger'>Erro - 0129: Situação não pode ser apagada, ha páginas cadastradas com essa situação!</p>";
            return false;
        }else{
            return true;
        }
    }
}
