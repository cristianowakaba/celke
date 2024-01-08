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
class AdmsDeleteSitsUsers
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
    public function deleteSitUser(int $id): void
    {
        $this->id = (int) $id;
//verifica se existe a situação do usuário cadastrada no banco de dados e se asituação não esta sendo utilizada por nenhum usuario.
        if(($this->viewSitUser())and($this->checkStatus())){
            $deleteUser = new \App\adms\Models\helper\AdmsDelete();
            $deleteUser->exeDelete("adms_sits_users", "WHERE id =:id", "id={$this->id}");
    
            if ($deleteUser->getResult()) {
                $_SESSION['msg'] = "<p class='alert-success'>Situação apagada com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-success'>Err 0031: Situação não apagada com sucesso!</p>";
                $this->result = false;
            }
        }else{
            $this->result = false;
        }
        
    }
/**
 * verifica se existe a situação no banco de dados
 *
 * @return boolean
 */
    private function viewSitUser(): bool
    {

        $viewSitUser = new \App\adms\Models\helper\AdmsRead();
        $viewSitUser->fullRead(
            "SELECT id
                            FROM adms_sits_users                           
                            WHERE id=:id
                            LIMIT :limit",
            "id={$this->id}&limit=1"
        );

        $this->resultBd = $viewSitUser->getResult();
        if ($this->resultBd) {
            return true;
        } else {
            $_SESSION['msg'] =  "<p class='alert-danger'>Erro - 0032:  Situação não encontrada!</p>";
            return false;
        }
    }
    /**
     * verifica status se tem algum usuário usando a chave estrangeira 
     *adms_sits_user_id
     * @return boolean
     */
    private function checkStatus():bool
    {
        $viewUserAdd = new \app\adms\Models\helper\AdmsRead();
        $viewUserAdd->fullRead("SELECT id FROM adms_users WHERE adms_sits_user_id =:adms_sits_user_id LIMIT :limit", "adms_sits_user_id={$this->id}&limit=1");
        if($viewUserAdd->getResult()){
            $_SESSION['msg'] =  "<p class='alert-danger'>Erro - 0033: Situação não pode ser apagada, ha usuários com essa situação!</p>";
            return false;
        }else{
            return true;
        }
    }
}
