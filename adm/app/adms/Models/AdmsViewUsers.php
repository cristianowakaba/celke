<?php

namespace App\adms\Models;


/**
 * visualizar o usuários do banco de dados
 */
class AdmsViewUsers
{


  /**recebe true se executar com sucesso e false se houver erro */
  private bool $result=false;
  /**Recebe os registros do banco de dados */
  private array|null $resultBd;
  /** @var array|string|null $id recebeo id do registro */
  private int|string| null $id;





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
    // var_dump($this->result);
  }
  public function viewUser(int $id): void
  {
    $this->id = $id;
    // var_dump($this->id);

    $viewUser = new \App\adms\Models\helper\AdmsRead();
    $viewUser->fullRead("SELECT id, name,nickname,email,user,image,created,modified 
                        FROM adms_users 
                        WHERE id=:id
                        LIMIT :limit",
                        "id={$this->id}&limit=1");

    $this->resultBd = $viewUser->getResult();
    
    // var_dump($this->resultBd );
    if ($this->resultBd) {

      $this->result = true;
    } else {
      $_SESSION['msg'] = "<p style='color:#f00'>Erro: Usuário não encontrado!</p>";
      $this->result = false;
    }
  }
}
