<?php

namespace App\adms\Models;
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/**
 * Apagar o usuário no banco de dados
 *
 * @author Celke
 */
class AdmsDeleteUsers
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;
    /**Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;
    /** @var string $delDirectory Recebe o endereço de para apagar  o diretório */
    private string $delDirectory;
    /** $delImg Recebe o endereço de para apagar  a imagem */
    private string $delImg;
    /**
     * recebe os dados do formulario
     *
     * @var array|string|null
     */
    private array|string|null $data;

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

        if ($this->viewUser()) {
            $deleteUser = new \App\adms\Models\helper\AdmsDelete();
            $deleteUser->exeDelete("adms_users", "WHERE id =:id", "id={$this->id}");

            if ($deleteUser->getResult()) {
                $this->deleteImg();
                $_SESSION['msg'] = "<p style='color: green;'>Usuário apagado com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro - 0034: Usuário não apagado com sucesso!</p>";
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }
    /**
     * verifica se existe usuário no banco de dados
     *
     * @return boolean
     */
    private function viewUser(): bool
    {

        $viewUser = new \App\adms\Models\helper\AdmsRead();
        $viewUser->fullRead(
            "SELECT id, image
                        FROM adms_users 
                        WHERE id=:id
                        LIMIT :limit",
            "id={$this->id}&limit=1"
        );

        $this->resultBd = $viewUser->getResult();

        // var_dump($this->resultBd );
        if ($this->resultBd) {
            return true;
        } else {
            $_SESSION['msg'] = "<p style='color:#f00'>Erro - 0035: Usuário não encontrado!</p>";
            return false;
        }
    }
    private function deleteImg(): void
    {
        if ((!empty($this->resultBd[0]['image'])) or ($this->resultBd[0]['image'] != null)) {
            $this->delDirectory = "app/adms/assets/image/users/" . $this->resultBd[0]['id'];
            $this->delImg =  $this->delDirectory . "/" . $this->resultBd[0]['image'];
            /*             remove a imagem
 */
            if (file_exists($this->delImg)) {
                unlink($this->delImg);
            }
            /*             remove o diretório
 */
            if (file_exists($this->delDirectory)) {
                rmdir($this->delDirectory);
            }
        }
    }
}
