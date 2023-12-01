<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/**
 * Controller da página editar senha usuário.
 * @author Cesar <cesar@celke.com.br>
 */
class EditUsersPassword
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;
      /** @var array|string|null $id recebeo id do registro */
      private int|string| null $id;


    /**
     * se o usuario clicar no botao entra no else e instancia o editUserPass
     * 
     * @return void
     */
    public function index(int|string|null $id): void
    {
        $this->dataForm= filter_input_array(INPUT_POST,FILTER_DEFAULT);
       
        if((!empty($id)) and(empty( $this->dataForm['SendEditUserPass']))){
            var_dump($id);
            $this->id = (int)$id;
            $viewUserPass= new \App\adms\Models\AdmsEditUsersPassword();
           $viewUserPass->viewUser($this->id);
           if($viewUserPass->getResult()){
            $this->data['form']=$viewUserPass->getResultBd();
            $this->viewEditUserPass();
           }
        }else{
           
            $this->editUserPass();
        }   
       
    }
     /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewEditUserPass(): void
    {
        $loadView = new \Core\ConfigView("adms/Views/users/editUserPass", $this->data);
        $loadView->loadView();
    }

    private function editUserPass():void
    {
       
        if(!empty($this->dataForm['SendEditUserPass'])){
            unset($this->dataForm['SendEditUserPass']);
            $editUserPass = new \App\adms\Models\AdmsEditUsersPassword();
            $editUserPass->update($this->dataForm);
            if($editUserPass->getResult()){
                $urlRedirect = URLADM . "view-users/index/".$this->dataForm['id'];
            header("Location: $urlRedirect");
            }else{
                $this->data['form'] =$this->dataForm;
                $this->viewEditUserPass();
            }

        }else{
             $_SESSION['msg'] = "<p style='color:#f00;'>Erro: Usuário não encontrado controller EditUsers!</p>";
            $urlRedirect = URLADM . "list-users/index";
            header("Location: $urlRedirect");
        }
    }
}
