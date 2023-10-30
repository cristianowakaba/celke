<?php

namespace App\adms\Controllers;

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


    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(): void
    {
        $this->key = filter_input(INPUT_GET, "key", FILTER_DEFAULT);
        // var_dump($this->key);
        if (!empty($this->key)) {
            $this->validateKey();
        } else {
            echo "sem chave";
        }

        // $loadView = new \Core\ConfigView("adms/Views/erro/erro", $this->data);
        // $loadView->loadView();
    }

    private function validateKey(): void
    {
        $valKey  = new \App\adms\Models\AdmsUpdatePassword();
        $valKey->valKey($this->key);
        if ($valKey->getResult()) {
            $loadView = new \Core\ConfigView("adms/Views/login/updatePassword", $this->data);
        $loadView->loadView();
        
        } else {
            $urlRedirect = URLADM . "login/index";
        header("Location: $urlRedirect");
        }
    }
}
