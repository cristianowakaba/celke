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
class AdmsDeleteColors
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
    public function deleteColor(int $id): void
    {
        $this->id = (int) $id;
//verifica se existe a cor esta cadastrada no banco de dados e se asituação não esta sendo utilizada por nenhum usuario.
        if(($this->viewColor())and($this->checkColorUsed())){
            $deleteUser = new \App\adms\Models\helper\AdmsDelete();
            $deleteUser->exeDelete("adms_Colors", "WHERE id =:id", "id={$this->id}");
    
            if ($deleteUser->getResult()) {
                $_SESSION['msg'] = "<p style='color: green;'>Cor apagada com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Cor não apagada com sucesso!</p>";
                $this->result = false;
            }
        }else{
            $this->result = false;
        }
        
    }
/**
 * Metodo verifica se a cor esta cadastrada na tabela e envia o resultado para a função deleteColor
 *
 * @return boolean
 */
    private function viewColor(): bool
    {

        $viewColor = new \App\adms\Models\helper\AdmsRead();
        $viewColor->fullRead(
            "SELECT id
                            FROM       adms_colors                          
                            WHERE id=:id
                            LIMIT :limit",
            "id={$this->id}&limit=1"
        );

        $this->resultBd = $viewColor->getResult();
        if ($this->resultBd) {
            return true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Cor não encontrada!</p>";
            return false;
        }
    }
    /**
     * Metodo verifica se tem situação cadastrados usando a cor a ser excluida, caso tenha a exclusão não é permitida
     * O resultado da pesquisa é enviada para a função deleteColor
     * @return boolean
     */
    private function checkColorUsed():bool
    {
        $viewColorUsed = new \App\adms\Models\helper\AdmsRead();
        $viewColorUsed->fullRead("SELECT id FROM adms_sits_users WHERE adms_color_id =:adms_color_id LIMIT :limit", "adms_color_id={$this->id}&limit=1");
        if( $viewColorUsed->getResult()){
            $_SESSION['msg'] = "<p style='color: #f00'>Erro:Cor não pode ser apagada, ha usuários com essa situação!</p>";
            return false;
        }else{
            return true;
        }
    }
}
