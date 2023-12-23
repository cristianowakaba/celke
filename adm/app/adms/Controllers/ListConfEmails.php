<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/**
 * Método listar configuração de emails.
     * 
     * Instancia a MODELS responsável em buscar os registros no banco de dados.
     * Se encontrar registro no banco de dados envia para VIEW.
     * Senão enviar o array de dados vazio.
     *
 */
class ListConfEmails
{
    
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;
    
    /** @var string|int|null $page Recebe o numero da página que o usuário está */
    private string|int|null $page;

    public function index(string|int|null $page = null): void
    {
        $this->page = (int) $page ? $page:1;
        // var_dump($this->page);

       $listColors= new \App\adms\Models\AdmsListConfEmails();
       $listColors->ListConfEmails($this->page);
       if ($listColors->getResult()){
       
        $this->data['listConfEmails'] = $listColors->getResultBd();
        $this->data['pagination']=  $listColors->getResultPg();
     
       }else{
        $this->data['listConfEmails'] = [];
       
       }
     

        $loadView = new \Core\ConfigView("adms/Views/confEmails/listConfEmails", $this->data);
        $loadView->loadView();

    }
}