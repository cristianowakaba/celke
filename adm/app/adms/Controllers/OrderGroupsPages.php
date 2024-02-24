<?php

namespace App\adms\Controllers;
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/**
 * Controller da página alterar ordem grupo de páginas
 * @author Cesar <cesar@c  elke.com.br>
 */
class OrderGroupsPages
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
    public function index(int|string|null $id): void
    {
       $this->pag = filter_input(INPUT_GET,"pag",FILTER_SANITIZE_NUMBER_INT);
        if((!empty($id))and(!empty($this->pag))){
            // //var_dump($id);
            $this->id = (int)$id;
            
            $viewOrderGroup= new \App\adms\Models\AdmsOrderGroupsPages();
            $viewOrderGroup->orderGroupsPages($this->id);
            if ($viewOrderGroup->getResult()) {
                $urlRedirect = URLADM . "list-groups-pages/index/{$this->pag}";
                header("Location: $urlRedirect");
            } else {
                $urlRedirect = URLADM . "list-groups-pages/index/{$this->pag}";
                header("Location: $urlRedirect");
            }
       
        }else{
            $_SESSION['msg'] = "<p class='alert-danger'> Erro - 0114: Nivel de acesso não encontrado!</p>";
            $urlRedirect = URLADM . "list-groups-pages/index";
            header("Location: $urlRedirect");

        }

      

    }

    


}

