<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller listar permissoes
 * @author Cesar <cesar@celke.com.br>
 */
class ListPermission
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    /** @var string|int|null $page Recebe o numero pagina */
    private string|int|null $page;

    /** @var string|int|null $level Recebe o id do nivel de acesso */
    private string|int|null $level;

    /**
     * Metodo listar permissoes.
     * 
     * Instancia a MODELS responsavel em buscar os registros no banco de dados.
     * Se encontrar registro no banco de dados envia para VIEW.
     * Senao redireciona para a pagina listar nivel de acesso
     *
     * @return void
     */
    public function index(string|int|null $page = null)
    {
        $this->level = filter_input(INPUT_GET, 'level', FILTER_SANITIZE_NUMBER_INT);
        $this->page = (int) $page ? $page : 1;

        $listPermission = new \App\adms\Models\AdmsListPermission();
        $listPermission->listPermission($this->page, $this->level);
        if ($listPermission->getResult()) {
            $this->data['listPermission'] = $listPermission->getResultBd();
            $this->data['viewAccessLevel'] = $listPermission->getResultBdLevel();
            $this->data['pagination'] = $listPermission->getResultPg();
            $this->data['pag']= $this->page ;
            $this->viewPermission();
        } else {
            //$this->data['listUsers'] = [];
            //$this->data['pagination'] = null;
            $urlRedirect = URLADM . "list-access-levels/index";
            header("Location: $urlRedirect");
        }
        
    }

    /**
     * Instanciar a classe responsavel em carregar a View e enviar os dados para View.
     * 
     */
    private function viewPermission(): void
    {
        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu']=$listMenu->itemMenu();
        $this->data['sidebarActive'] = "list-access-levels";

        $loadView = new \Core\ConfigView("adms/Views/permission/listPermission", $this->data);
        $loadView->loadView();
    }
}
