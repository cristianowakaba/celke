<?php

namespace App\adms\Controllers;
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/**
 * Controller da página visualizar cores
 * @author Cesar <cesar@celke.com.br>
 */
class viewConfEmails
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    /** @var array|string|null $id recebeo id do registro */
    private int|string| null $id;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(int|string|null $id): void
    {
       
        if(!empty($id)){
            // //var_dump($id);
            $this->id = (int)$id;

          
            $viewConfEmails= new \App\adms\Models\AdmsViewConfEmails();
            $viewConfEmails->ViewConfEmails($this->id);
            // //var_dump($this->id );
            // echo "existe id {$this->id}<br>";
            if( $viewConfEmails->getResult()){
                $this->data['viewConfEmails']= $viewConfEmails->getResultBd();
                // //var_dump( $this->data['viewSitUser']);
                $this->viewConfEmails();
            }else{
               
                $urlRedirect = URLADM . "list-conf-emails/index";
                header("Location: $urlRedirect");

            }
        }else{
            $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0091: email não encontrado!</p>";
            $urlRedirect = URLADM . "list-conf-emails/index";
            header("Location: $urlRedirect");

        }

      

    }
    /**
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewConfEmails(): void
    {
        $this->data['sidebarActive']="list-conf-emails";
        $loadView = new \Core\ConfigView("adms/Views/confEmails/viewConfEmails", $this->data);
        $loadView->loadView();
    }


}

