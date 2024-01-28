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
class ListSitsUsers
{
    
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    /** @var string|int|null $page Recebe o número página */
    private string|int|null $page;
       /** @var array $dataForm Recebe os dados do formulario */
       private array|null $dataForm;

       /** @var string|null $searchName Recebe o nome da situacao */
       private string|null $searchName;
       /**
     * Método listar situação usuário.
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
/* //pega o que os dados do formulario 
array 
  'search_name' => string 'tivo' (length=4)
  'SendSearchSitUser' => string 'Pesquisar' (length=9) */
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        //var_dump($this->dataForm);
        //pega o que o usuario digitare
        $this->searchName = filter_input(INPUT_GET, 'search_name', FILTER_DEFAULT);
        //var_dump($this->searchName);

       $listSitsUsers= new \App\adms\Models\AdmsListSitsUsers();
       $listSitsUsers->listSitsUsers($this->page );
       if (!empty($this->dataForm['SendSearchSitUser'])) {
        $this->page = 1;
        $listSitsUsers->listSearchSitsUsers($this->page, $this->dataForm['search_name']);
        $this->data['form'] = $this->dataForm;
    } elseif ((!empty($this->searchName))) {
        $listSitsUsers->listSearchSitsUsers($this->page, $this->searchName);
        $this->data['form']['search_name'] = $this->searchName;
    } else {
        $listSitsUsers->listSitsUsers($this->page);
    }
    
    if ($listSitsUsers->getResult()) {
        $this->data['listSitsUsers'] = $listSitsUsers->getResultBd();
        $this->data['pagination'] = $listSitsUsers->getResultPg();
    } else {
        $this->data['listSitsUsers'] = [];
        $this->data['pagination'] = "";
    }

        
      
       $this->data['sidebarActive']="list-sits-users";

       $loadView = new \Core\ConfigView("adms/Views/sitsUser/listSitUser", $this->data);
       $loadView->loadView();

    }
}