<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Editar grupo de página
 *
 * @author Celke
 */
class AdmsEditGroupsPages
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var array|null $dataExitVal Recebe os campos que devem ser retirados da validação */
    private array|null $dataExitVal;

    /** @return bool Retorna true quando executar o processo com sucesso e false quando houver erro */
    function getResult(): bool
    {
        return $this->result;
    }

    /** @return bool Retorna os detalhes do registro */
    function getResultBd(): array|null
    {
        return $this->resultBd;
    }

    /**
     * Metodo recebe como parametro o ID que será usado para verificar se tem o registro cadastrado no banco de dados
     * @param integer $id
     * @return void
     */
    public function viewGroupPages(int $id): void
    {
        $this->id = $id;
        // var_dump($this->id);

        $viewGroupPages= new \App\adms\Models\helper\AdmsRead();
        $viewGroupPages->fullRead("SELECT id,name,order_group_pg
         from adms_groups_pgs
         WHERE id=:id
                            LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultBd =  $viewGroupPages->getResult(); 
    
        
        if ($this->resultBd) {
            $this->result = true;
        } else {
          var_dump($this->resultBd);
            $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0148 : tipo de página não encontrada!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo recebe as informações do usuário que serão validadas
     * Instancia o helper AdmsValEmptyField para validar os campos do formulário     
     * Retira o campo opcional "nickname" da validação
     * Chama o metodo valInput para validar os campos especificos do formulário
     * @param array|null $data
     * @return void
     */
    public function update(array $data = null): void
    {
        $this->data = $data;


        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            $this->edit();
        } else {
            $this->result = false;
        }
    }

   

    /**
     * Metodo envia as informações editadas para o banco de dados
     * @return void
     */
    private function edit(): void
    {
        $this->data['modified'] = date("Y-m-d H:i:s");
        

        $upUser = new \App\adms\Models\helper\AdmsUpdate();
        $upUser->exeUpdate("adms_groups_pgs", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($upUser->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>tipo de página editado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0149: Usuário não editado com sucesso!</p>";
            $this->result = false;
        }
    }
}