<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/**
 * Controller da página listar usuarios
 * @author Cesar <cesar@celke.com.br>
 */
class ListUsers
{
    
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;
    
    /** @var string|int|null $page Recebe o numero da página que o usuário está */
    private string|int|null $page;

    public function index(string|int|null $page = null): void
    {
        $this->page = (int) $page ? $page:1;
        // //var_dump($this->page);

       $listUsers= new \App\adms\Models\AdmsListUsers();
       $listUsers->listUsers($this->page);
       if($listUsers->getResult()){
        ////var_dump($listUsers->getResultPg());
        $this->data['listUsers'] = $listUsers->getResultBd();
        $this->data['pagination']= $listUsers->getResultPg();
     
       }else{
        $this->data['listUsers'] = [];
       
       }
     
       // //var_dump($this->data);
       $this->data['sidebarActive']="list-users";
        $loadView = new \Core\ConfigView("adms/Views/users/listUsers", $this->data);
        $loadView->loadView();

    }
}