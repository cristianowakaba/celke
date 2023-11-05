<?php

namespace App\adms\Controllers;

/**
 * Controller da página listar usuarios
 * @author Cesar <cesar@celke.com.br>
 */
class ListUsers
{
    
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    public function index(): void
    {
     
         $this->data = [];

        $loadView = new \Core\ConfigView("adms/Views/users/listUsers", $this->data);
        $loadView->loadView();

    }
}