<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/**
 * Controller da página listar tipos de página
 * @author Cesar <cesar@celke.com.br>
 */
class ListGroupsPages
{
    
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    /** @var string|int|null $page Recebe o número página */
    private string|int|null $page;
     
       /**
     * Método listar tipos de páginas.
     * 
     * Instancia a MODELS responsável em buscar os registros no banco de dados.
     * Se encontrar registro no banco de dados envia para VIEW.
     * Senão enviar o array de dados vazio.
     *
     * @return void
     */

    public function index(string|int|null $page = null): void
    {
        $this->page = (int) $page ? $page : 1;

        $listGroupsPages = new \App\adms\Models\AdmsListGroupsPages();
        $listGroupsPages->listGroupsPages($this->page);
        if ($listGroupsPages->getResult()) {
            $this->data['listGroupsPages'] = $listGroupsPages->getResultBd();
            $this->data['pagination'] = $listGroupsPages->getResultPg();
        } else {
            $this->data['listGroupsPages'] = [];
        }
        $button =[
            'add_groups_pages' => ['menu_controller' =>'add-groups-pages', 'menu_metodo' => 'index'],
            'order_groups_pages' => ['menu_controller' => 'order-groups-pages', 'menu_metodo' => 'index'],
            'view_groups_pages' => ['menu_controller' => 'view-groups-pages', 'menu_metodo' => 'index'],
            'edit_groups_pages' => ['menu_controller' => 'edit-groups-pages', 'menu_metodo' => 'index'],
            'delete_groups_pages' => ['menu_controller' => 'delete-groups-pages', 'menu_metodo' => 'index']];
            $listBotton = new \App\adms\Models\helper\AdmsButton();
            $this->data['button'] = $listBotton->buttonPermission($button);
           
         // var_dump( $this->data['button'] );
          $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu']=$listMenu->itemMenu();

        $this->data['pag'] = $this->page;
        $this->data['sidebarActive'] = "list-groups-pages"; 
        $loadView = new \Core\ConfigView("adms/Views/groupsPages/listGroupsPages", $this->data);
        $loadView->loadView();
    }
}
