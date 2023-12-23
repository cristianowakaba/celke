<?php

namespace App\adms\Models;
if(!defined('C8L6K7E')){
  /*  header("Location:/"); */
die("Erro: Página não encontrada!<br>");
}

/**
 * visualiza configuração do email
 */
class AdmsViewConfEmails
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
  public function viewConfEmails(int $id): void
  {
    $this->id = $id;
    // var_dump($this->id);

    $viewConfEmails= new \App\adms\Models\helper\AdmsRead();
    $viewConfEmails->fullRead("SELECT id, title, name, email, host, username, smtpsecure, port, created, modified
                      FROM adms_confs_emails 
                      WHERE id=:id
                        LIMIT :limit",
                        "id={$this->id}&limit=1");

    $this->resultBd = $viewConfEmails->getResult();
    
    
    // var_dump($this->resultBd );
    if ($this->resultBd) {

      $this->result = true;
    } else {
      $_SESSION['msg'] = "<p style='color:#f00'>Erro - 0090: E-mail não encontrado!</p>";
      $this->result = false;
    }
  }
}
