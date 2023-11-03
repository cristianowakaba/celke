<?php

namespace App\adms\Controllers;

/**
 * Controller da página recuperar senha
 */
class RecoverPassword
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data=null;
    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;
    /**
     * Instanciar a classe Responsavel por carregar a view e enviar os dados para view.
     *
     * @return void
     */
     public function index():void
    {
        $this->dataForm = filter_input_array(INPUT_POST,FILTER_DEFAULT);
        if(!empty( $this->dataForm['SendRecoverPass'])){
            unset($this->dataForm['SendRecoverPass']);
          $recoverPass = new \App\adms\Models\AdmsRecoverPassword();
          $recoverPass->recoverPassword($this->dataForm);

          if($recoverPass->getResult()){
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
            
          }else{
            $this->data['form']= $this->dataForm;
            $this->viewRecoverPass();
          }

           
        }else{
            $this->viewRecoverPass();
        }
      
    }
    /**
     * Carrega view recuperar senha
     *
     * @return void
     */
    private function viewRecoverPass():void
    {
        $loadView = new \Core\ConfigView("adms/Views/login/recoverPassword",$this->data);
        $loadView->loadViewLogin();
    }
}