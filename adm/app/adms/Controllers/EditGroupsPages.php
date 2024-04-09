<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/**
 * Controller da página editar grupos de páginas.
 * @author Cesar <cesar@celke.com.br>
 */
class EditGroupsPages
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;
      /** @var array|string|null $id recebeo id do registro */
      private int|string| null $id;


    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View..
     * Quando o usuário clicar no botão "cadastrar" do formulário da página novo usuário. Acessa o IF e instância a classe "AdmsAddUsers" responsável em cadastrar o usuário no banco de dados.
     * Usuário cadastrado com sucesso, redireciona para a página listar registros.
     * Senão, instância a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(int|string|null $id): void
    {
        $this->dataForm= filter_input_array(INPUT_POST,FILTER_DEFAULT);
       
        if((!empty($id)) and(empty( $this->dataForm['SendEditGroupsPages']))){
            //var_dump($id);
            $this->id = (int)$id;
            $viewGroupPage= new \App\adms\Models\AdmsEditGroupsPages();
            $viewGroupPage->viewGroupPages($this->id);
           if($viewGroupPage->getResult()){
            $this->data['form']=$viewGroupPage->getResultBd();
            $this->viewEditGroupsPages();
           }else {
            $urlRedirect = URLADM . "list-groups-pages/index";
            header("Location: $urlRedirect");
        }
        }else{
           
            $this->editGroupsPages();
        }   
       
    }
    /**     
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewEditGroupsPages(): void
    { 
        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu']=$listMenu->itemMenu();
        $this->data['sidebarActive'] = "list-groups-pages";
        $loadView = new \Core\ConfigView("adms/Views/groupsPages/editGroupsPages", $this->data);
        $loadView->loadView();
    }
 /**
     * Editar tipo de página.
     * Se o usuário clicou no botão, instancia a MODELS responsável em receber os dados e editar no banco de dados.
     * Verifica se editou corretamente o tipo no banco de dados.
     * Se o usuário não clicou no botão redireciona para página listar tipo.
     *
     * @return void
     */
    
    private function editGroupsPages(): void
    {
        if(!empty($this->dataForm['SendEditGroupsPages'])){
            unset($this->dataForm['SendEditGroupsPages']);
            $editGroupsPages = new \App\adms\Models\AdmsEditGroupsPages();
            $editGroupsPages->update($this->dataForm);
            if( $editGroupsPages->getResult()){
                $urlRedirect = URLADM . "view-groups-pages/index/".$this->dataForm['id'];
            header("Location: $urlRedirect");
            }else{
                $this->data['form'] =$this->dataForm;
                $this->viewEditGroupsPages();
            }

        }else{
             $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0138: Grupo de página não encontrada!</p>";
            $urlRedirect = URLADM . "list-groups-pages/index";
            header("Location: $urlRedirect");
        }
    }
}
