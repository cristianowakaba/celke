<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/**
 * Controller da página listar cores
 * @author Cesar <cesar@celke.com.br>
 */
class ListColors
{
    
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;
    
    /** @var string|int|null $page Recebe o numero da página que o usuário está */
    private string|int|null $page;

    public function index(string|int|null $page = null): void
    {
        $this->page = (int) $page ? $page:1;
        var_dump($this->page);

       $listColors= new \App\adms\Models\AdmsListColors();
       $listColors->listColors($this->page);
       if ($listColors->getResult()){
       
        $this->data['listColors'] = $listColors->getResultBd();
        $this->data['pagination']=  $listColors->getResultPg();
     
       }else{
        $this->data['listColors'] = [];
       
       }
     

        $loadView = new \Core\ConfigView("adms/Views/colors/listColors", $this->data);
        $loadView->loadView();

    }
}