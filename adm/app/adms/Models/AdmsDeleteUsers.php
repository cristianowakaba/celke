<?php

namespace App\adms\Models;

/**
 * Apagar o usuário no banco de dados
 *
 * @author Celke
 */
class AdmsDeleteUsers
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }
//instancia a helper responsavel por deletar registros no BD e manda nome da tabela termos e parsestring
    public function deleteUser(int $id): void
    {
        $this->id = (int) $id;
        var_dump($this->id);
       $deleteUser = new \App\adms\Models\helper\AdmsDelete();
        $deleteUser->exeDelete("adms_users", "WHERE id =:id", "id={$this->id}"); 

        if ($deleteUser->getResult()) {
            $_SESSION['msg'] = "<p style='color: green;'>Usuário apagado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não apagado com sucesso!</p>";
            $this->result = false;
        }
    }
}
