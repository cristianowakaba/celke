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
class ViewColors
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

          
            $viewColors = new \App\adms\Models\AdmsViewColors();
            $viewColors->viewColors($this->id);
            // var_dump($this->id );
            // echo "existe id {$this->id}<br>";
            if( $viewColors->getResult()){
                $this->data['viewColors']= $viewColors->getResultBd();
                // var_dump( $this->data['viewSitUser']);
                $this->viewColors();
            }else{
               
                $urlRedirect = URLADM . "list-colors/index";
                header("Location: $urlRedirect");

            }
        }else{
            $_SESSION['msg'] = "<p style='color:#f00;'>Erro 0019: Cor não encontrada!</p>";
            $urlRedirect = URLADM . "list-colors/index";
            header("Location: $urlRedirect");

        }

      

    }
    /**
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewColors(): void
    {
        $loadView = new \Core\ConfigView("adms/Views/colors/viewColors", $this->data);
        $loadView->loadView();
    }


}

