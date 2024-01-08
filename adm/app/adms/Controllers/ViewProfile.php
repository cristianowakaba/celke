<?php

namespace App\adms\Controllers;
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/**
 * Controller da página visualizar perfil
 * @author Cesar <cesar@celke.com.br>
 */
class ViewProfile
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(int|string|null $id): void
    {
      
        
           $viewProfile= new \App\adms\Models\AdmsViewProfile();
           $viewProfile->viewProfile();
          
            if($viewProfile->getResult()){
                $this->data['viewProfile']=$viewProfile->getResultBd();
                // //var_dump( $this->data['viewUser']);
                $this->loadViewProfile();
            }else{
               
                $urlRedirect = URLADM . "login/index";
                header("Location: $urlRedirect");

            }
      

    }
    private function loadViewProfile(): void
    {

        $loadView = new \Core\ConfigView("adms/Views/users/viewProfile", $this->data);
        $loadView->loadView();
    }
}
