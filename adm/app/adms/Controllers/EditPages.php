<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/**
 * Controller da página editar  páginas.
 * @author Cesar <cesar@celke.com.br>
 */
class EditPages
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
       
        if((!empty($id)) and(empty( $this->dataForm['SendEditPages']))){
            //var_dump($id);
            $this->id = (int)$id;
            $viewPages= new \App\adms\Models\AdmsEditPages();
           $viewPages->viewPages($this->id);
           if($viewPages->getResult()){
            $this->data['form']=$viewPages->getResultBd();
            $this->viewEditPages();
           }else {
            $urlRedirect = URLADM . "list-pages/index";
            header("Location: $urlRedirect");
        }
        }else{
           
            $this->editPages();
        }   
       
    }
      /**
     * Instanciar a MODELS e o método "listSelect" responsável em buscar os dados para preencher o campo SELECT 
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewEditPages(): void
    {
        $listSelect = new \App\adms\Models\AdmsEditPages();
        $this->data['select'] = $listSelect->listSelect();
       // var_dump( $this->data['select'] );
       $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu']=$listMenu->itemMenu();
        
        $this->data['sidebarActive'] = "list-pages";
        $loadView = new \Core\ConfigView("adms/Views/pages/editPages", $this->data);
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
    private function editPages(): void
    {
        if(!empty($this->dataForm['SendEditPages'])){
            unset($this->dataForm['SendEditPages']);
            $editPages = new \App\adms\Models\AdmsEditPages();
            $editPages->update($this->dataForm);
            if( $editPages->getResult()){
                $urlRedirect = URLADM . "view-pages/index/".$this->dataForm['id'];
            header("Location: $urlRedirect");
            }else{
                $this->data['form'] =$this->dataForm;
                $this->viewEditPages();
            }

        }else{
             $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0164: Usuário não encontrado!</p>";
            $urlRedirect = URLADM . "list-pages/index";
            header("Location: $urlRedirect");
        }
    }
}
