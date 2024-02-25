<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Alterar ordem do tipo de página no banco de dados
 *
 * @author Celke
 */
class AdmsOrderGroupsPages
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;
    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var array|null $resultBdPrev Recebe os registros do banco de dados */
    private array|null $resultBdPrev;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * @return bool Retorna os detalhes do registro
     */
    function getResultBd(): array|null
    {
        return $this->resultBd;
    }
    // SÓ DESCOMENTAR O VARDUMP E O REDIRECIONAMENTO DA OrderTypesPages que da pra ver os dados.

    /**
     * Metodo para alterar ordem do tipo de página
     * Recebe o ID do tipo de página que sera usado como parametro na pesquisa
     * Retorna FALSE se houver algum erro.
     * @param integer $id
     * @return void
     */
    public function orderGroupsPages(int $id): void
    {
        $this->id = $id;
//exemplo  id= 8
        $orderGroupsPages = new \App\adms\Models\helper\AdmsRead();
        $orderGroupsPages->fullRead("SELECT id, order_group_pg
                            FROM  adms_groups_pgs
                            WHERE id=:id 
                            LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultBd = $orderGroupsPages->getResult();
        if ($this->resultBd) {
            var_dump( $this->resultBd);
             $this->viewPrevOrderGroups();
            var_dump($this->resultBd[0]['order_group_pg']); 
            var_dump( $this->resultBd);

        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0154: Tipo de página não encontrado!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo para recuperar o ordem do grupo de páginas superior
     * Retorna FALSE se houver algum erro.
     * @return void
     */
    private function viewPrevOrderGroups(): void
    {
        // exemplo $this->resultBd[0]['order_group_pg']  o id retorna 8 entao vai pegar um numero a menos  WHERE order_group_pg <:order_group_pg. ou seja o 7

        $prevOrderGroups = new \App\adms\Models\helper\AdmsRead();
        $prevOrderGroups->fullRead("SELECT id, order_group_pg
                            FROM adms_groups_pgs
                            WHERE order_group_pg <:order_group_pg
                            ORDER BY order_group_pg DESC 
                            LIMIT :limit", "order_group_pg={$this->resultBd[0]['order_group_pg']}&limit=1");

        $this->resultBdPrev = $prevOrderGroups->getResult();
        var_dump($this->resultBdPrev);
        if ($this->resultBdPrev) {
            var_dump($this->resultBdPrev);
            $this->editMoveDown();
            
        } else {
           
            $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0155: Tipo de grupo de páginas não encontrado!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo para alterar a ordem do nivel de acesso superior para ser inferior
     * Retorna FALSE se houver algum erro.
     * @return void
     */
    /**
     * Metodo para alterar a ordem do tipo de ordem grupo 
     * 
     * 
     * 
     * superior para ser inferior
     * Retorna FALSE se houver algum erro.
     * @return void
     */
    private function editMoveDown(): void
    {
        //pega o id 8 e adiciona uma posição no $this->data que vai ser enviada na query junto com o modified
        $this->data['order_group_pg'] = $this->resultBd[0]['order_group_pg'];
        $this->data['modified'] = date("Y-m-d H:i:s");

// aqui manda a query  com o id 8 que esta no $this->data['order_group_pg'] para substituir o id 7 que esta no $this->resultBdPrev[0]['id']}. se for true vai instanciar o  $this->editMoveUp();que vai pegar o id 7 this->resultBdPrev[0]['order_type_pg']; e inserir na query onde tem o id 8 "id={$this->resultBd[0]['id']}"

        $moveDown = new \App\adms\Models\helper\AdmsUpdate();
        $moveDown->exeUpdate("adms_groups_pgs", $this->data, "WHERE id=:id", "id={$this->resultBdPrev[0]['id']}");

        if ($moveDown->getResult()) {
            $this->editMoveUp();
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0156 :Ordem do tipo de página não editado com sucesso!</p>";
            $this->result = false;
        }
    }
    /**
     * Metodo para alterar a ordem do tipo de página inferior para ser superior
     * Retorna FALSE se houver algum erro.
     * @return void
     */
    private function editMoveUp(): void
    {
      //  $this->editMoveUp();que vai pegar o id 7 this->resultBdPrev[0]['order_type_pg']; e inserir na query onde tem o id 8 "id={$this->resultBd[0]['id']}"

        $this->data['order_group_pg'] = $this->resultBdPrev[0]['order_group_pg'];
        $this->data['modified'] = date("Y-m-d H:i:s");
        var_dump($this->data['order_group_pg']);

        $moveUp = new \App\adms\Models\helper\AdmsUpdate();
        $moveUp->exeUpdate("adms_groups_pgs", $this->data, "WHERE id=:id", "id={$this->resultBd[0]['id']}");

        if ($moveUp->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Ordem do tipo de página editado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro - 157: Ordem do tipo de página não editado com sucesso!</p>";
            $this->result = false;
        }
    }
}
