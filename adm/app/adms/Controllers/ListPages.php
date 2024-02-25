<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller listar cores
 * @author Cesar <cesar@celke.com.br>
 */
class ListPages
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    /** @var string|int|null $page Recebe o número página */
    private string|int|null $page;

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

  

    /**
     * Método listar páginas.
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

        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $listPages = new \App\adms\Models\AdmsListPages();
        $listPages->listPages($this->page);
        if($listPages->getResult()){
            $this->data['listPages'] = $listPages->getResultBd();
            $this->data['pagination'] = $listPages->getResultPg();

        } else { 
            $this->data['listPages'] = [];                      
        }
        
      

        $this->data['pag'] = $this->page;
        $this->data['sidebarActive'] = "list-pages"; 
        $loadView = new \Core\ConfigView("adms/Views/pages/listPages", $this->data);
        $loadView->loadView();
    }
}
