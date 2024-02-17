<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }

/**
 * Controller cadastrar tipo de página.
 * @author Cesar <cesar@celke.com.br>
 */
class AddTypesPages
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

     /**     
     * Método cadastrar situação página 
     * Receber os dados do formulário.
     * Quando o usuário clicar no botão "cadastrar" do formulário da página nova situação página. Acessa o IF e instância a classe "AdmsAddSitsPages" responsável em cadastrar a situação página no banco de dados.
     * Situação cadastrada com sucesso, redireciona para a página listar registros.
     * Senão, instância a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(): void
    {
        
     $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->dataForm['SendAddTypesPages'])) {
           /*  //var_dump($this->dataForm); */
          unset($this->dataForm['SendAddTypesPages']);
           $createTypePages= new \App\adms\Models\AdmsAddTypesPages();
           $createTypePages->create($this->dataForm);
            if ( $createTypePages->getResult()) {
                $urlRedirect = URLADM . "list-types-pages/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewAddTypesPages();
            }
        } else {
            $this->viewAddTypesPages();
        }
       
    }
 /**
     * 
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewAddTypesPages(): void
    {
       
        
        $this->data['sidebarActive']="list-types-Pages";
        $loadView = new \Core\ConfigView("adms/Views/typesPages/addTypesPages", $this->data);
        $loadView->loadView();
    }
}
