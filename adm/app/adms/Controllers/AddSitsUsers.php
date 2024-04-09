<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }

/**
 * Controller cadastrar situação do usuario usuário.
 * @author Cesar <cesar@celke.com.br>
 */
class AddSitsUsers
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

 /**
     * Método cadastrar situação usuário 
     * Receber os dados do formulário.
     * Quando o usuário clicar no botão "cadastrar" do formulário da página novo usuário. Acessa o IF e instância a classe "AdmsAddUsers" responsável em cadastrar o usuário no banco de dados.
     * Usuário cadastrado com sucesso, redireciona para a página listar registros.
     * Senão, instância a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(): void
    {
        
     $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->dataForm['SendAddSitUser'])) {
           /*  //var_dump($this->dataForm); */
          unset($this->dataForm['SendAddSitUser']);
           $createSitUser= new \App\adms\Models\AdmsAddSitsUsers();
            $createSitUser->create($this->dataForm);
            if ($createSitUser->getResult()) {
                $urlRedirect = URLADM . "list-sits-users/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewAddSitUser();
            }
        } else {
            $this->viewAddSitUser();
        }
       
    }
 /**
     * Instanciar a MODELS e o método "listSelect" responsável em buscar os dados para preencher o campo SELECT 
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewAddSitUser(): void
    {
        $listSelect = new \App\adms\Models\AdmsAddSitsUsers();
        $this->data['select'] = $listSelect->listSelect();
        //var_dump($this->data['select']);
        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu']=$listMenu->itemMenu();
        
        $this->data['sidebarActive']="list-sits-users";
        $loadView = new \Core\ConfigView("adms/Views/sitsUser/addSitUser", $this->data);
        $loadView->loadView();
    }
}
