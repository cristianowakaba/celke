<?php

namespace App\adms\Models;
if(!defined('C8L6K7E')){
  /*  header("Location:/"); */
die("Erro: Página não encontrada!<br>");
}

/**
 * EDITAR a senha do usuários do banco de dados
 */
class AdmsEditUsersPassword
{


  /**recebe true se executar com sucesso e false se houver erro */
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
/**
 * faz a consulta instanciando helper AdmsRead, atribui o  $this->resultBd = $viewUser->getResult(); se tiver resultado atribui  $this->result = true; senão retorna false.
 *
 * @param integer $id
 * @return void
 */
  public function viewUser(int $id): void
  {
    $this->id = $id;

    $viewUser = new \App\adms\Models\helper\AdmsRead();
    $viewUser->fullRead(
      "SELECT id
                            FROM adms_users
                            WHERE id=:id
                            LIMIT :limit",
      "id={$this->id}&limit=1"
    );

    $this->resultBd = $viewUser->getResult();
    if ($this->resultBd) {
      $this->result = true;
    } else {
      $_SESSION['msg'] =  "<p class='alert-danger'>Erro - 0052: Usuário não encontrado!</p>";
      $this->result = false;
    }
  }

  public function update(array $data = null): void
  {

    $this->data = $data;
    /* //var_dump($this->data); */
    

    $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
    $valEmptyField->valField($this->data);
    if ($valEmptyField->getResult()) {
     
      $this->valInput();
      
     
    } else {
      $this->result = false;
    }
  }
  /** 
   * Instanciar o helper "AdmsValPassword" para validar a senha
   
   * @return void
   */
  private function valInput(): void
  {

    $valPassword = new \App\adms\Models\helper\AdmsValPassword();
    $valPassword->validatePassword($this->data['password']);

 
    if ($valPassword->getResult())  {
      $this->edit();
    } else {
      $this->result = false;
    }
  }
  private function edit(): void
  {
    $this->data['password'] = password_hash($this->data['password'], PASSWORD_DEFAULT);
    // //var_dump($this->data);
    $this->data['modified'] = date("y-m-d H:i:s");
   
   
    // //var_dump($this->data);
    $upUser = new \App\adms\Models\helper\AdmsUpdate();
    $upUser->exeUpdate("adms_users", $this->data, "WHERE id=:id", "id={$this->data['id']}");
    if ($upUser->getResult()) {
      $_SESSION['msg'] = "<p class='alert-success'> a senha do usuário editado com sucesso!</p>";
      $this->result = true;
    } else {
      $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0053: a senha do usuário não editada com sucesso!</p>";
      $this->result = false;
    }
  }
}
