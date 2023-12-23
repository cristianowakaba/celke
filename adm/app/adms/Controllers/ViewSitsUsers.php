<?php

namespace App\adms\Controllers;
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/**
 * Controller da página visualizar usuarios
 * @author Cesar <cesar@celke.com.br>
 */
class ViewSitsUsers
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
            // var_dump($id);
            $this->id = (int)$id;

          
            $viewSitUser = new \App\adms\Models\AdmsViewSitsUsers();
            $viewSitUser->viewSitUser($this->id);
            // var_dump($this->id );
            // echo "existe id {$this->id}<br>";
            if( $viewSitUser->getResult()){
                $this->data['viewSitUser']= $viewSitUser->getResultBd();
                // var_dump( $this->data['viewSitUser']);
                $this->viewSitUser();
            }else{
               
                $urlRedirect = URLADM . "list-users/index";
                header("Location: $urlRedirect");

            }
        }else{
            $_SESSION['msg'] = "<p style='color:#f00;'>Erro - 0020: Usuário não encontrado!</p>";
            $urlRedirect = URLADM . "list-users/index";
            header("Location: $urlRedirect");

        }

      

    }
     private function viewSitUser(): void
    {
     
        $loadView = new \Core\ConfigView("adms/Views/sitsUser/viewSitUser", $this->data);
        $loadView->loadView();
    }

 


}

