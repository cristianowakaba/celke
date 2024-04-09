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
class ListTypesPages
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

       $listTypesPages= new \App\adms\Models\AdmsListTypesPages();
       $listTypesPages->listTypesPages($this->page );
      if ($listTypesPages->getResult()) {
        //var_dump($listSitsPages->getResultBd());
        $this->data['listTypesPages'] = $listTypesPages->getResultBd();
        $this->data['pagination'] = $listTypesPages->getResultPg();
    } else {
        $this->data['listTypesPages'] = [];
        $this->data['pagination'] = "";
    }

    $button =[
        'add_types_pages' => ['menu_controller' =>'add-types-pages', 'menu_metodo' => 'index'],
        'order_types_pages' => ['menu_controller' => 'order-types-pages', 'menu_metodo' => 'index'],
        'view_types_pages' => ['menu_controller' => 'view-types-pages', 'menu_metodo' => 'index'],
        'edit_types_pages' => ['menu_controller' => 'edit-types-pages', 'menu_metodo' => 'index'],
        'delete_types_pages' => ['menu_controller' => 'delete-types-pages', 'menu_metodo' => 'index']];
        $listBotton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBotton->buttonPermission($button);
       
        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu']=$listMenu->itemMenu();
     // var_dump( $this->data['button'] );
      
    $this->data['pag'] = $this->page;
       $this->data['sidebarActive']="list-types-pages";

       $loadView = new \Core\ConfigView("adms/Views/typesPages/listTypesPages", $this->data);
       $loadView->loadView();

    }
}