<?php

namespace App\adms\Controllers;
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/**
 * Controller da página visualizar situação da página
 * @author Cesar <cesar@celke.com.br>
 */
class ViewSitsPages
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

          
            $viewSitPage = new \App\adms\Models\AdmsViewSitsPages();
            $viewSitPage->viewSitPage($this->id);
            // //var_dump($this->id );
            // echo "existe id {$this->id}<br>";
            if(  $viewSitPage->getResult()){
                $this->data['viewSitPages']=  $viewSitPage->getResultBd();
               // var_dump( $this->data['viewSitPages']);
                $this->viewSitPage();
            }else{
               
                $urlRedirect = URLADM . "list-sits-pages/index";
                header("Location: $urlRedirect");

            }
        }else{
            $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0123: situação da página não encontrada!</p>";
            $urlRedirect = URLADM . "list-sits-pages/index";
            header("Location: $urlRedirect");

        }

      

    }
     private function viewSitPage(): void
    {
        $button =[
            'list_sits_pages' => ['menu_controller' => 'list-sits-pages', 'menu_metodo' => 'index'],
            'view_sits_pages' => ['menu_controller' => 'view-sits-pages', 'menu_metodo' => 'index'],
            'edit_sits_pages' => ['menu_controller' => 'edit-sits-pages', 'menu_metodo' => 'index'],
            'delete_sits_pages' => ['menu_controller' => 'delete-sits-pages', 'menu_metodo' => 'index']];
            $listBotton = new \App\adms\Models\helper\AdmsButton();
            $this->data['button'] = $listBotton->buttonPermission($button);
            
            $listMenu = new \App\adms\Models\helper\AdmsMenu();
            $this->data['menu']=$listMenu->itemMenu();

         // var_dump( $this->data['button'] );
        $this->data['sidebarActive']="list-sits-pages";
     
        $loadView = new \Core\ConfigView("adms/Views/sitsPages/viewSitPages", $this->data);
        $loadView->loadView();
    }

 


}

