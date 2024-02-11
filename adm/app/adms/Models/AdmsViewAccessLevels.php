<?php

namespace App\adms\Models;
if(!defined('C8L6K7E')){
  /*  header("Location:/"); */
die("Erro: Página não encontrada!<br>");
}

/**
 * visualizar o Nivel de acesso do usuario
 */
class AdmsViewAccessLevels
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
    // //var_dump($this->result);
  }
  public function viewAccessLevels(int $id): void
  {
    $this->id = $id;
    // var_dump($this->id);

    $viewAccessLevels= new \App\adms\Models\helper\AdmsRead();
    $viewAccessLevels->fullRead("SELECT id, name, order_levels, created, modified  
                        FROM adms_access_levels 
                        WHERE id=:id AND order_levels >:order_levels
                        LIMIT :limit", "id={$this->id}&order_levels=" . $_SESSION['order_levels'] . "&limit=1");
    $this->resultBd =  $viewAccessLevels->getResult();
    
    // var_dump($this->resultBd );
    if ($this->resultBd) {

      $this->result = true;
    } else {
      print_r($this->resultBd);
      $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0107: Nível de acesso não encontrado!</p>";
      $this->result = false;
    }
  }
}
