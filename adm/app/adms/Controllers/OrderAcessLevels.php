<?php

namespace App\adms\Controllers;
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/**
 * Controller da página alterar ordem nível de acesso
 * @author Cesar <cesar@c  elke.com.br>
 */
class OrderAccessLevels
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;
  /**
   * recebe o numero da página
   *
   * @var array|string|null
   */
    private array|string|null $pag;

    /** @var array|string|null $id recebeo id do registro */
    private int|string| null $id;
    /**
     * metodo alterar ordem nivel de acesso
     * @return void
     */
    public function index(int|string|null $id = null): void
    {
        $this->pag = filter_input(INPUT_GET, "pag", FILTER_SANITIZE_NUMBER_INT);

        if ((!empty($id)) and (!empty($this->pag))) {
            $this->id = (int) $id;

            $viewAccessLevel = new \App\adms\Models\AdmsOrderAccessLevels();
            $viewAccessLevel->orderAccessLevels($this->id);
            if ($viewAccessLevel->getResult()) {
                $urlRedirect = URLADM . "list-access-levels/index/{$this->pag}";
                header("Location: $urlRedirect");
            } else {
                $urlRedirect = URLADM . "list-access-levels/index/{$this->pag}";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'> Erro - 0114: Nivel de acesso não encontrado!</p>";
            $urlRedirect = URLADM . "list-access-levels/index";
            header("Location: $urlRedirect");

        }

      

    }

    


}

