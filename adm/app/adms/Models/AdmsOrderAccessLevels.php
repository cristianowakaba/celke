<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')) {
  /*  header("Location:/"); */
  die("Erro: Página não encontrada!<br>");
}

/**
 * alterar ordem do nível de acesso
 */
class AdmsOrderAccessLevels
{

  /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
  private array|string|null $data;

  /**recebe true se executar com sucesso e false se houver erro */
  private bool $result = false;
  /**Recebe os registros do banco de dados */
  private array|null $resultBd;
  /** @var array|string|null $id recebeo id do registro */
  private int|string| null $id;
  /**Recebe os registros do banco de dados */
  private array|null $resultBdPrev;







  /**
   * retorna true quando eecutar o processo com sucesso ou false quando houver erro
   *
   * @return boolean
   */
  function getResult(): bool
  {
    return $this->result;
  }
  //i
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
   /**
     * Metodo para alterar ordem do nivel de acesso
     * Recebe o ID do nivel de acesso que sera usado como parametro na pesquisa
     * Retorna FALSE se houver algum erro.
     * @param integer $id
     * @return void
     */
  public function orderAccessLevels(int $id): void
  {
    $this->id = $id;
    // //var_dump($this->id);

    $viewAcessLevel = new \App\adms\Models\helper\AdmsRead();

    $viewAcessLevel->fullRead("SELECT id, order_levels
                      FROM adms_access_levels
                      WHERE id=:id AND order_levels > :order_levels
                      LIMIT :limit", "id={$this->id}&order_levels=" . $_SESSION['order_levels'] . "&limit=1");

    $this->resultBd = $viewAcessLevel->getResult();

    if ($this->resultBd) {
      //dump($this->resultBd);
      // var_dump($_SESSION['order_levels']);

      $this->viewPrevAccessLevel();
    } else {
      $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0118 :Nivel de Acesso não encontrado!</p>";
      $this->result = false;
    }
  }
   /**
     * Metodo para recuperar o ordem do nivel de acesso superior
     * Retorna FALSE se houver algum erro.
     * @return void
     */
  private function viewPrevAccessLevel(): void
  {
    $prevAccessLevel = new \App\adms\Models\helper\AdmsRead();
        $prevAccessLevel->fullRead(
            "SELECT id, order_levels 
                        FROM adms_access_levels
                        WHERE order_levels <:order_levels
                        AND order_levels >:order_levels_user
                        ORDER BY order_levels DESC
                        LIMIT :limit",
            "order_levels={$this->resultBd[0]['order_levels']}&order_levels_user=" . $_SESSION['order_levels'] . "&limit=1"
        );

    $this->resultBdPrev = $prevAccessLevel->getResult();
    if ($this->resultBdPrev) {
      //var_dump($this->resultBdPrev);
      $this->result = true;
      $this->editMoveDown();
    } else {
      $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0119 :Nivel de Acesso não encontrado!</p>";
    }
  }
   /**
     * Metodo para alterar a ordem do nivel de acesso superior para ser inferior
     * Retorna FALSE se houver algum erro.
     * @return void
     */
  private function editMoveDown(): void
  {
    $this->data['order_levels'] = $this->resultBd[0]['order_levels'];
    $this->data['modified'] = date("Y-m-d H:i:s");
   // var_dump($this->data);

    $moveDown = new \App\Adms\Models\helper\AdmsUpdate();
    $moveDown->exeUpdate("adms_access_levels", $this->data, "WHERE id =:id", "id={$this->resultBdPrev[0]['id']}");

    if ($moveDown->getResult()) {
      $this->editMoveUp();
    } else {
      $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0120 :Ordem do Nivel de Acesso não editado com sucesso!</p>";
      $this->result = false;
    }
  }
   /**
     * Metodo para alterar a ordem do nivel de acesso inferior para ser superior
     * Retorna FALSE se houver algum erro.
     * @return void
     */
  private function editMoveUp(): void
    {
        $this->data['order_levels'] = $this->resultBdPrev[0]['order_levels'];
        $this->data['modified'] = date("Y-m-d H:i:s");

        $moveUp = new \App\adms\Models\helper\AdmsUpdate();
        $moveUp->exeUpdate("adms_access_levels", $this->data, "WHERE id=:id", "id={$this->resultBd[0]['id']}");

        if ($moveUp->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Ordem do nível de acesso editado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Ordem do nível de acesso não editado com sucesso!</p>";
            $this->result = false;
        }
    }
}
