<?php

namespace App\adms\Controllers;
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/**
 * Controller da página visualizar páginas
 * @author Cesar <cesar@celke.com.br>
 */
class ViewPages
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    /** @var array|string|null $id recebeo id do registro */
    private int|string| null $id;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(int|string|null $id): void
    {
       
        if(!empty($id)){
            // //var_dump($id);
            $this->id = (int)$id;

           $viewPages= new \App\adms\Models\AdmsViewPages();
           $viewPages->viewPages($this->id);
            // //var_dump($this->id );
            // echo "existe id {$this->id}<br>";
            if($viewPages->getResult()){
                $this->data['viewPages']=$viewPages->getResultBd();
                // //var_dump( $this->data['viewUser']);
                $this->viewPages();
            }else{
                //var_dump($viewUser->getResult() );
                $urlRedirect = URLADM . "list-Pages/index";
                 header("Location: $urlRedirect");

            }
        }else{
            $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0161 Página não encontrada!</p>";
            $urlRedirect = URLADM . "list-pages/index";
            header("Location: $urlRedirect");

        }


        

    }
   /**
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewPages(): void
    {
        $button =[
            'list_pages' => ['menu_controller' => 'list-pages', 'menu_metodo' => 'index'],
            'edit_pages' => ['menu_controller' => 'edit-pages', 'menu_metodo' => 'index'],
            'delete_pages' => ['menu_controller' => 'delete-pages', 'menu_metodo' => 'index']];
            $listBotton = new \App\adms\Models\helper\AdmsButton();
            $this->data['button'] = $listBotton->buttonPermission($button);
           
          //var_dump( $this->data['button'] );
          $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu']=$listMenu->itemMenu();
        
        $this->data['sidebarActive'] = "list-pages";
        $loadView = new \Core\ConfigView("adms/Views/pages/viewPages", $this->data);
        $loadView->loadView();
    }
}
