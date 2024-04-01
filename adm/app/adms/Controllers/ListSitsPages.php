<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/**
 * Controller da página listar Situação da página
 * @author Cesar <cesar@celke.com.br>
 */
class ListSitsPages
{
    
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    /** @var string|int|null $page Recebe o número página */
    private string|int|null $page;
     
       /**
     * Método listar situação páginas.
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

       $listSitsPages= new \App\adms\Models\AdmsListSitsPages();
       $listSitsPages->listSitsPages($this->page );
      if ($listSitsPages->getResult()) {
        //var_dump($listSitsPages->getResultBd());
        $this->data['listSitsPages'] = $listSitsPages->getResultBd();
        $this->data['pagination'] = $listSitsPages->getResultPg();
    } else {
        $this->data['listSitsPages'] = [];
        $this->data['pagination'] = "";
    }

    $button =[
        'add_sits_pages' => ['menu_controller' => 'add-sits-pages', 'menu_metodo' => 'index'],
        'view_sits_pages' => ['menu_controller' => 'view-sits-pages', 'menu_metodo' => 'index'],
        'edit_sits_pages' => ['menu_controller' => 'edit-sits-pages', 'menu_metodo' => 'index'],
        'delete_sits_pages' => ['menu_controller' => 'delete-sits-pages', 'menu_metodo' => 'index']];
        $listBotton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBotton->buttonPermission($button);
       
     // var_dump( $this->data['button'] );
      
       $this->data['sidebarActive']="list-sits-pages";

       $loadView = new \Core\ConfigView("adms/Views/sitsPages/listSitPages", $this->data);
       $loadView->loadView();

    }
}