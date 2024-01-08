<?php

namespace App\adms\Models;
if(!defined('C8L6K7E')){
  /*  header("Location:/"); */
die("Erro: Página não encontrada!<br>");
}

/**
 * Editar situação usuário no banco de dados
 */
class AdmsEditSitsUsers
{


  /**recebe true se executar com sucesso e false se houver Erro - */
  private bool $result = false;
  /**Recebe os registros do banco de dados */
  private array|null $resultBd;
  /** @var array|string|null $id recebeo id do registro */
  private int|string| null $id;
  /**
   * 
   * // @var array|string|null $data Recebe a sinformações do formulário 
   */
  private array|string|null $data;
/**
 * $dataExitVal recebe os campos que devem ser retirados da validação
 *
 * @var array|null
 */
  private array|null $dataExitVal;

  
  private array $listRegistryAdd;






  /**
   * retorna true quando eecutar o processo com sucesso ou false quando houver erro
   *
   * @return boolean
   */
  function getResult(): bool
  {
    return $this->result;
  }
  /**
   * retorna os detalhes do registro
   *
   * @return array|null
   */
  function getResultBd(): array|null
  {
    return $this->resultBd;
  }

  public function viewSitUser(int $id): void
  {
    $this->id = $id;

    $viewUser = new \App\adms\Models\helper\AdmsRead();
    $viewUser->fullRead(
      "SELECT id, name, adms_color_id
                            FROM adms_sits_users
                            WHERE id=:id
                            LIMIT :limit",
            "id={$this->id}&limit=1"
    );

    $this->resultBd = $viewUser->getResult();
    if ($this->resultBd) {
      $this->result = true;
    } else {
      $_SESSION['msg'] =  "<p class='alert-danger'>Erro - 0045: Situação não encontrada!</p>";
      $this->result = false;
    }
  }

  public function update(array $data = null): void
  {

    $this->data = $data;
    // //var_dump( $this->data);
 

    $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
    $valEmptyField->valField($this->data);
    if ($valEmptyField->getResult()) {
      $this->edit();
      
     
    } else {
      $this->result = false;
    }
  }

  private function edit(): void
  {
    // //var_dump($this->data);
    $this->data['modified'] = date("y-m-d H:i:s");
    
   
    // //var_dump($this->data);
    $upSitUser = new \App\adms\Models\helper\AdmsUpdate();
    $upSitUser->exeUpdate("adms_sits_users", $this->data, "WHERE id=:id", "id={$this->data['id']}");
    if ($upSitUser->getResult()) {
      $_SESSION['msg'] = "<p class='alert-success'>Situação editada com sucesso!</p>";
      $this->result = true;
    } else {
      $_SESSION['msg'] = "<p class='alert-success'>Erro - 0046: Situação não editada com sucesso!</p>";
      $this->result = false;
    }
  }
  /**
    * instancia a helper que faz a leitura dos registros no BD , atribui a um objeto com uma posicao sit e atribui chave sit e valor objeto criado ao atributo $this->listRegistryAdd
    *
    * @return array
    */
    public function listSelect(): array
    {
        $list = new \App\adms\Models\helper\AdmsRead();
        $list->fullRead("SELECT id id_col, name name_col FROM adms_colors ORDER BY name ASC");
        $registry['col'] = $list->getResult();
       /*  //var_dump($registry['col']); */
        $this->listRegistryAdd = ['col' => $registry['col']];
         //var_dump($this->listRegistryAdd); 
        return $this->listRegistryAdd;
    }
}
