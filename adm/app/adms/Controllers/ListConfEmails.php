<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }

/**
 * Controller listar configuração de emails
 * @author Cesar <cesar@celke.com.br>
 */
class ListConfEmails
{
   /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
   private array|string|null $data;

   /** @var array $dataForm Recebe os dados do formulario */
   private array|null $dataForm;

   /** @var string|int|null $page Recebe o número página */
   private string|int|null $page;

   /** @var string|null $searchName Recebe o nome ou e-mail */
   private string|null $searchName;

    /**
     * Método listar configuração de emails.
     * 
     * Instancia a MODELS responsável em buscar os registros no banco de dados.
     * Se encontrar registro no banco de dados envia para VIEW.
     * Senão enviar o array de dados vazio.
     *
     * @return void
     */

    public function index(string|int|null $page = null): void
    {
        $this->page = (int) $page ? $page:1;
        // //var_dump($this->page);

        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $this->searchName = filter_input(INPUT_GET, 'search_name', FILTER_DEFAULT);

       $listConfEmails= new \App\adms\Models\AdmsListConfEmails();
       if(!empty($this->dataForm['SendSearchConfEmail']
       )){
        $this->page = 1;
        $listConfEmails->listSearchConfEmails($this->page, $this->dataForm['search_name']);
        $this->data['form'] = $this->dataForm;
       }elseif((!empty($this->searchName))){
        $listConfEmails->listSearchConfEmails($this->page, $this->searchName);
            $this->data['form']['search_name'] = $this->searchName;
        } else {
            $listConfEmails->listConfEmails($this->page);
        }
        if($listConfEmails->getResult()){
            $this->data['listConfEmails'] = $listConfEmails->getResultBd(); 
            $this->data['pagination'] = $listConfEmails->getResultPg();
        }else{
            $this->data['listConfEmails'] = [];
            $this->data['pagination'] = "";
        }
        $button =[
            'add_conf_emails' => ['menu_controller' =>'add-conf-emails', 'menu_metodo' => 'index'],
            'view_conf_emails' => ['menu_controller' => 'view-conf-emails', 'menu_metodo' => 'index'],
            'edit_conf_emails' => ['menu_controller' => 'edit-conf-emails', 'menu_metodo' => 'index'],
            'delete_conf_emails' => ['menu_controller' => 'delete-conf-emails', 'menu_metodo' => 'index']];
            $listBotton = new \App\adms\Models\helper\AdmsButton();
            $this->data['button'] = $listBotton->buttonPermission($button);

            //var_dump(  $this->data['button']);
        $this->data['sidebarActive'] = "list-conf-emails"; 
        $loadView = new \Core\ConfigView("adms/Views/confEmails/listConfEmails", $this->data);
        $loadView->loadView();
    }
}



 