<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')) {
  /*  header("Location:/"); */
  die("Erro: Página não encontrada!<br>");
}
/**
 * editar configurações de email do banco de dados
 */
class AdmsEditConfEmails
{


 /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
 private bool $result = false;

 /** @var array|null $resultBd Recebe os registros do banco de dados */
 private array|null $resultBd;

 /** @var int|string|null $id Recebe o id do registro */
 private int|string|null $id;

 /** @var array|null $data Recebe as informações do formulário */
 private array|null $data;




  /**
   * 
   *recebe true se executar com sucesso e false se houver erro 
   *
   * @return boolean
   */
  function getResult(): bool
  {
    return $this->result;
  }
  /**
   * retorna os  registros do  BD
   *
   * @return array|null
   */
  function getResultBd(): array|null
  {
    return $this->resultBd;
    // //var_dump($this->result);
  }

   

  /**
   
   *
   * @return void
   */
  public function viewConfEmails(int $id): void
  {
    $this->id = $id;
    ////var_dump($this->page );


    $viewConfEmails = new \App\adms\Models\helper\AdmsRead();
    $viewConfEmails->fullRead("SELECT id, title, name, email, host, username, smtpsecure, port
        FROM adms_confs_emails
        WHERE id=:id
        LIMIT :limit", "id={$this->id}&limit=1");
    $this->resultBd =  $viewConfEmails->getResult();

    if ($this->resultBd) {

      $this->result = true;
    } else {
      $_SESSION['msg'] = "<p style='color:#f00'>Erro - 0093: Configuração de email não encontrada!</p>";
      $this->result = false;
    }
  }
  /**
     * Metodo recebe como parametro a informação que será editada
     * Instancia o helper AdmsValEmptyField para validar os campos do formulário
     * Chama a função edit para enviar as informações para o banco de dados
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
        $upConfEmails = new \App\adms\Models\helper\AdmsUpdate();
        $upConfEmails->exeUpdate("adms_confs_emails", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($upConfEmails->getResult()) {
            $_SESSION['msg'] = "<p style='color: green;'>Configuração de email editada com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro - 0095: Configuração de email não editada com sucesso!</p>";
            $this->result = false;
        }
    }
}
