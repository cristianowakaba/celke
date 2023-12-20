<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/**
 * Controller editar cor
 * @author Cesar <cesar@celke.com.br>
 */
class EditColors
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;
      /** @var array|string|null $id recebeo id do registro */
      private int|string| null $id;


    /**
     * Método editar  cor .
     * Receber os dados do formulário.
     * 
     * Se o parâmetro ID e diferente de vazio e o usuário não clicou no botão editar, instancia a MODELS para recuperar as informações da situação no banco de dados, se encontrar instancia o método "viewEditSitUser". Se não existir redireciona para o listar situações.
     * 
     * Se não existir o usuário clicar no botão acessa o ELSE e instancia o método "editSitUser".
     * 
     * @return void
     */
    public function index(int|string|null $id): void
    {
        $this->dataForm= filter_input_array(INPUT_POST,FILTER_DEFAULT);
       
        if((!empty($id)) and(empty( $this->dataForm['SendEditColor']))){
            var_dump($id);
            var_dump($this->dataForm);
            $this->id = (int)$id;
            $viewColors= new \App\adms\Models\AdmsEditColors();
            $viewColors->viewColor($this->id);
           if($viewColors->getResult()){
            $this->data['form']=$viewColors->getResultBd();
            $this->viewEditColor();
           }else {
            $urlRedirect = URLADM . "list-colors/index";
            header("Location: $urlRedirect");
        }
        }else{
           
            $this->editColor();
        }   
       
    }
     /**
     *
     * 
     */
    private function viewEditColor(): void
    {
        
        
        $loadView = new \Core\ConfigView("adms/Views/colors/editColors", $this->data);
        $loadView->loadView();
    }

    private function editColor():void
    {
        if (!empty($this->dataForm['SendEditColor'])) {
            var_dump($this->dataForm['SendEditColor']);
            unset($this->dataForm['SendEditColor']);
            $viewColor = new \App\adms\Models\AdmsEditColors();
            $viewColor->update($this->dataForm);
            if($viewColor->getResult()){
                $urlRedirect = URLADM . "view-colors/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            }else{
                $this->data['form'] = $this->dataForm;
                $this->viewEditColor();
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro 0010: cor não encontrada!</p>";
            $urlRedirect = URLADM . "list-sits-users/index";
            header("Location: $urlRedirect");
        }
    }
}
