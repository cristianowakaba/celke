<?php

namespace App\adms\Controllers;
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/**
 * Controller da página editar nova senha
 * 
 */
class UpdatePassword
{

    /** @var array|string|null $key Recebe a chave para cadastrar nova senha */
    private array|string|null $key;
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];
    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;



    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(): void
    {
        //recebe a chave na url
        $this->key = filter_input(INPUT_GET, "key", FILTER_DEFAULT);
        // //var_dump($this->key);
        //recebe todos os dados do formulário
       $this->dataForm= filter_input_array(INPUT_POST,FILTER_DEFAULT);
       // //var_dump( $this->dataForm);

        if ((!empty($this->key)) and (empty($this->dataForm['SendUpPass'])) ) {
            $this->validateKey();
        } else {
           $this->updatePassword();
              }

        // $loadView = new \Core\ConfigView("adms/Views/erro/erro", $this->data);
        // $loadView->loadView();
    }
    /**
     * se tiver a chave e não tiver clicado através do botão e sim pelo link instancia validateKey que instancia a models que intancia a helper e faz a consulta no banco de dados verificando se a chave que vem pela url é igual a chave que ta salva se for carrega o formulario para carregar  a nova senha
     *
     * @return void
     */
    private function validateKey(): void
    {
        $valKey  = new \App\adms\Models\AdmsUpdatePassword();
        $valKey->valKey($this->key);
        if ($valKey->getResult()) {
           $this->viewUpdatePassword();
        
        } else {
            $urlRedirect = URLADM . "login/index";
        header("Location: $urlRedirect");
        }
    }
    // se for diferente de vazio a posição SendUPpass adiciona uma posição['key'] e atribui o valor da $key,intancia a AdmsUpdatePassword() eo método editPassword($this->dataForm).
    private function updatePassword():void
    {
        if(!empty($this->dataForm['SendUpPass'])){
            unset($this->dataForm['SendUpPass']);
            $this->dataForm['key']=$this->key;
          
            $upPassword  = new \App\adms\Models\AdmsUpdatePassword();
            $upPassword->editPassword($this->dataForm);
           if($upPassword->getResult()){
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
           }else{
            $this->viewUpdatePassword();
           }

          
        }else{
            $_SESSION['msg']= "<p style='color:#f00;'>Erro - 0018: Link invalido, solicite novo link <a href='" .URLADM ."recover-password/index'>Clique aqui</a>!</p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");

        }

    }
    /**
     * método para carregar a View
     *
     * @return void
     */
    private function viewUpdatePassword():void
    {
        $loadView = new \Core\ConfigView("adms/Views/login/updatePassword", $this->data);
        $loadView->loadViewLogin();
    }

}
