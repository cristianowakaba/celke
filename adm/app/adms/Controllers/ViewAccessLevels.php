<?php

namespace App\adms\Controllers;
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/**
 * Controller da página visualizar Nivel de Acesso
 * @author Cesar <cesar@celke.com.br>
 */
class ViewAccessLevels
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

            $viewAccessLevel= new \App\adms\Models\AdmsViewAccessLevels();
            $viewAccessLevel->viewAccessLevels($this->id);
            // //var_dump($this->id );
            // echo "existe id {$this->id}<br>";
            if($viewAccessLevel->getResult()){
                $this->data['viewAccessLevels']=$viewAccessLevel->getResultBd();
                // //var_dump( $this->data['viewUser']);
                $this->viewAccessLevels();
            }else{
               
                $urlRedirect = URLADM . "list-access-levels/index";
                header("Location: $urlRedirect");

            }
        }else{
            $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0108: Nivel de acesso não encontrado!</p>";
            $urlRedirect = URLADM . "list-access-levels/index";
            header("Location: $urlRedirect");

        }


        

    }
    private function viewAccessLevels():void
    {
        $button =[
           
            'list_access_levels' => ['menu_controller' => 'list-access-levels', 'menu_metodo' => 'index'],
           'edit_access_levels' => ['menu_controller' => 'edit-access-levels', 'menu_metodo' => 'index'],
            'delete_access_levels' => ['menu_controller' => 'delete-access-levels', 'menu_metodo' => 'index']];
            $listBotton = new \App\adms\Models\helper\AdmsButton();
            $this->data['button'] = $listBotton->buttonPermission($button);
           // var_dump(  $this->data['button']);
           $listMenu = new \App\adms\Models\helper\AdmsMenu();
           $this->data['menu']=$listMenu->itemMenu();
           
        $this->data['sidebarActive']="list-access-levels";

        $loadView = new \Core\ConfigView("adms/Views/accessLevels/viewAccessLevel", $this->data);
        $loadView->loadView();
    }
}

