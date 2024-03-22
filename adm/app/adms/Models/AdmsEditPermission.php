<?php

namespace App\adms\Models;
if(!defined('C8L6K7E')){
  /*  header("Location:/"); */
die("Erro: Página não encontrada!<br>");
}

/**editar permissãode acesso a página
 */
class AdmsEditPermission
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
  public function editPermission(int $id): void
  {
    $this->id = $id;

    $viewPermission = new \App\adms\Models\helper\AdmsRead();
    $viewPermission->fullRead(
      "SELECT lev_pag.id, lev_pag.permission
                            FROM adms_levels_pages lev_pag
                            INNER JOIN adms_access_levels AS lev ON lev.id =lev_pag.adms_access_level_id
                            WHERE lev_pag.id=:id
                            AND lev.order_levels >:order_levels                       
                                 LIMIT :limit",
            "id={$this->id}&order_levels=".$_SESSION['order_levels']."&limit=1"
    );

    $this->resultBd = $viewPermission->getResult();
    if ($this->resultBd) {
      $this->edit()
;      //$this->result = true;
     // var_dump($this->resultBd);
    } else {
      
      $_SESSION['msg'] =  "<p class='alert-danger'>Erro - 0175: Necessário selecionar uma página válida</p>";
      $this->result = false;
    }
  }

  private function edit():void
  {
    var_dump($this->resultBd);
    if($this->resultBd[0]['permission'] ==1){
      $this->data['permission']= 2;
    }else{
      $this->data['permission']= 1;
    }
    $this->data['modified'] = date("Y-m-d H:i:s");
  
    $upPermission = new \App\adms\Models\helper\AdmsUpdate();
    $upPermission->exeUpdate("adms_levels_pages", $this->data, "WHERE id=:id", "id={$this->id}");
    if ($upPermission->getResult()) {
      $_SESSION['msg'] = "<p class='alert-success'>Permissão editada com sucesso!</p>";
      $this->result = true;
    } else {
      $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0176: Permission não editada com sucesso!</p>";
      $this->result = false;
    }
  }
 
}
