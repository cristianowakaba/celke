<?php

namespace App\adms\Controllers;
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/**
 * Controller da página para receber novo link para Confirmar Email
 * @author Cesar <cesar@celke.com.br>
 */
//http://localhost/projetosalao/adm/new-conf-email/index

class NewConfEmail
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /**  método index recebe o email para recuperar o link da view newConf Email e envia para   $newConfEmail =new \App\adms\Models\AdmsNewConfEmail() através do   $newConfEmail->newConfEmail($this->dataForm); após instacia o getResult se for trues redireciona para login se false acrescenta a posição   $newConfEmail->newConfEmail($this->dataForm); e instancia viewNewConfEmail() para carregar a view e imprimir os dados no campo*/
    public function index(): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        //    //var_dump($this->dataForm);
        //verifica se o usuário clicou no botão e enviou os dados, após destroy a posição 'SendNewConfEmail' ficando apenas com a posição que contém o email, após instancia a models e envia o array com o valor do email
        if (!empty($this->dataForm['SendNewConfEmail'])) {
            unset($this->dataForm['SendNewConfEmail']);
            $newConfEmail = new \App\adms\Models\AdmsNewConfEmail();
            $newConfEmail->newConfEmail($this->dataForm);
            // se retornar true redireciona para loguin
            if ($newConfEmail->getResult()) {
                $urlRedirect = URLADM . "login/index";
                header("Location: $urlRedirect");
            } else {
                //não redireciona e carrega a mesma página com o email impresso no campo instanciando a $this->viewNewConfEmail(); que carrega a view
                $this->data['form'] = $this->dataForm;
                $this->viewNewConfEmail();
            }
        } else {
            $this->viewNewConfEmail();
        }
    }
    /**carrega a view  passa por parametro a página e os dados*/
    private function viewNewConfEmail(): void
    {
        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu']=$listMenu->itemMenu();
        
        $loadView = new \Core\ConfigView("adms/Views/login/newConfEmail", $this->data);
        $loadView->loadViewLogin();
    }
}
