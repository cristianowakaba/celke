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
class ViewUsers
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

           $viewUser= new \App\adms\Models\AdmsViewUsers();
           $viewUser->viewUser($this->id);
            // //var_dump($this->id );
            // echo "existe id {$this->id}<br>";
            if($viewUser->getResult()){
                $this->data['viewUser']=$viewUser->getResultBd();
                // //var_dump( $this->data['viewUser']);
                $this->viewUser();
            }else{
                //var_dump($viewUser->getResult() );
                $urlRedirect = URLADM . "list-users/index";
                 header("Location: $urlRedirect");

            }
        }else{
            $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0021: Usuário não encontrado!</p>";
            $urlRedirect = URLADM . "list-users/index";
            header("Location: $urlRedirect");

        }


        

    }
    private function viewUser():void
    {
        $this->data['sidebarActive']="list-users";

        $loadView = new \Core\ConfigView("adms/Views/users/viewUser", $this->data);
        $loadView->loadView();
    }
}

