<?php

namespace App\adms\Controllers;
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/**
 * Controller da página visualizar tipos de página
 * @author Cesar <cesar@celke.com.br>
 */
class ViewTypesPages
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

          
            $viewSitPage = new \App\adms\Models\AdmsViewTypesPages();
            $viewSitPage->viewTypesPages($this->id);
            // //var_dump($this->id );
            // echo "existe id {$this->id}<br>";
            if(  $viewSitPage->getResult()){
                $this->data['viewTypePage']=  $viewSitPage->getResultBd();
               // var_dump( $this->data['viewSitPages']);
                $this->viewtypePage();
            }else{
               
                $urlRedirect = URLADM . "list-types-pages/index";
                header("Location: $urlRedirect");

            }
        }else{
            $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0133: situação da página não encontrada!</p>";
            $urlRedirect = URLADM . "list-types-pages/index";
            header("Location: $urlRedirect");

        }

      

    }
     private function viewtypePage(): void
    {
        $button =[
            'list_types_pages' => ['menu_controller' =>'list-types-pages', 'menu_metodo' => 'index'],
            'edit_types_pages' => ['menu_controller' => 'edit-types-pages', 'menu_metodo' => 'index'],
            'delete_types_pages' => ['menu_controller' => 'delete-types-pages', 'menu_metodo' => 'index']];
            $listBotton = new \App\adms\Models\helper\AdmsButton();
            $this->data['button'] = $listBotton->buttonPermission($button);
           
            $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu']=$listMenu->itemMenu();
        
         // var_dump( $this->data['button'] );
        $this->data['sidebarActive']="list-types-pages";
     
        $loadView = new \Core\ConfigView("adms/Views/typesPages/viewTypesPages", $this->data);
        $loadView->loadView();
    }

 


}

