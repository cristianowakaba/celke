<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }

/**
 * Controller cadastrar páginas.
 * @author Cesar <cesar@celke.com.br>
 */
class AddPages
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

 /**
     * Método cadastrar pagina
     * Receber os dados do formulário.
     * Quando o usuário clicar no botão "cadastrar" do formulário da nova página. 
     * 
     * @return void
     */
    public function index(): void
    {
        
     $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->dataForm['SendAddPages'])) {
           /*  //var_dump($this->dataForm); */
          unset($this->dataForm['SendAddPages']);
           $createSitUser= new \App\adms\Models\AdmsAddColors();
            $createSitUser->create($this->dataForm);
            if ($createSitUser->getResult()) {
                $urlRedirect = URLADM . "list-colors/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewAddColor();
            }
        } else {
            $this->viewAddColor();
        }
       
    }
 /**
     * Instanciar a MODELS e o método "listSelect" responsável em buscar os dados para preencher o campo SELECT 
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewAddColor(): void
    {
  
        
        $this->data['sidebarActive']="list-colors";
        $loadView = new \Core\ConfigView("adms/Views/colors/addColors", $this->data);
        $loadView->loadView();
    }
}
