<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')) {
    /*  header("Location:/"); */
    die("Erro: Página não encontrada!<br>");
}
/**
 * Controller editar cor
 * @author Cesar <cesar@celke.com.br>
 */
class EditConfEmails
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;
    /**
     * Método editar e-mail.
     * Receber os dados do formulário.
     * 
     * Se o parâmetro ID e diferente de vazio e o usuário não clicou no botão editar, instancia a MODELS para recuperar as informações do e-mail no banco de dados, se encontrar instancia o método "viewEditConfEmails". Se não existir redireciona para o listar e-mail.
     * 
     * Se não existir o e-mail clicar no botão acessa o ELSE e instancia o método "editConfEmails".
     * 
     * @return void
     */
    public function index(int|string|null $id): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if ((!empty($id)) and (empty($this->dataForm['SendEditConfEmails']))) {

            $this->id = (int)$id;
            $viewConfEmails = new \App\adms\Models\AdmsEditConfEmails();
            $viewConfEmails->viewConfEmails($this->id);
            if ($viewConfEmails->getResult()) {
                $this->data['form'] = $viewConfEmails->getResultBd();
                $this->viewEditConfEmails();
            } else {
                $urlRedirect = URLADM . "list-conf-emails/index";
                header("Location: $urlRedirect");
            }
        } else {

            $this->editConfEmails();
        }
    }
    /**
     *
     * 
     */
    private function viewEditConfEmails(): void
    {
        $this->data['sidebarActive']="list-conf-emails";

        $loadView = new \Core\ConfigView("adms/Views/confEmails/editConfEmails", $this->data);
        $loadView->loadView();
    }

    private function editConfEmails(): void
    {
        if (!empty($this->dataForm['SendEditConfEmails'])) {
            unset($this->dataForm['SendEditConfEmails']);
            $editConfEmails = new \App\adms\Models\AdmsEditConfEmails();
            $editConfEmails->update($this->dataForm);
            if ($editConfEmails->getResult()) {
                $urlRedirect = URLADM . "view-conf-emails/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditConfEmails();
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro - 0094: Configuração de email não encontrada!</p>";
            $urlRedirect = URLADM . "list-conf-emails/index";
            header("Location: $urlRedirect");
        }
    }
}
