<?php

namespace App\adms\Models;
if(!defined('C8L6K7E')){
  /*  header("Location:/"); */
die("Erro: Página não encontrada!<br>");
}

/**
 * Editar situação cor
 */
class AdmsEditColors
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
  /**
   * instancia a helper e busca no banco de dados a cor name  e id e da o retorno
   *
   * @param integer $id
   * @return void
   */
  public function viewColor(int $id): void
  {
    $this->id = $id;

    $viewUser = new \App\adms\Models\helper\AdmsRead();
    $viewUser->fullRead(
      "SELECT id, name, color
                            FROM adms_colors
                            WHERE id=:id
                            LIMIT :limit",
            "id={$this->id}&limit=1"
    );

    $this->resultBd = $viewUser->getResult();
    if ($this->resultBd) {
      $this->result = true;
      // var_dump($this->resultBd);
    } else {
      $_SESSION['msg'] = "<p style='color: #f00'>Erro - 0036: Cor não encontrada!</p>";
      $this->result = false;
    }
  }

  public function update(array $data = null): void
  {

    $this->data = $data;
    var_dump( $this->data);
 

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
    var_dump($this->data);
    $this->data['modified'] = date("y-m-d H:i:s");
    
   
    var_dump($this->data);
    $upColor = new \App\adms\Models\helper\AdmsUpdate();
    $upColor->exeUpdate("adms_colors", $this->data, "WHERE id=:id", "id={$this->data['id']}");
    if ($upColor->getResult()) {
      $_SESSION['msg'] = "<p style='color: green;'>Cor editada com sucesso!</p>";
      $this->result = true;
    } else {
      $_SESSION['msg'] = "<p style='color: #f00;'>Erro - 0037: Cor não editada com sucesso!</p>";
      $this->result = false;
    }
  }
 
}
