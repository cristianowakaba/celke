<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')) {
    /*  header("Location:/"); */
    die("Erro: Página não encontrada!<br>");
}
/**método SyncPagesLevels
 * instranciar a classe responsável em sincronizar o nivel de acesso e as páginas
 * @author Cesar <cesar@celke.com.br>
 */
class SyncPagesLevels
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    /**
     * Instantiar a classe responsavel em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(): void
    {
        $syncPagesLevels = new \App\adms\Models\AdmsSyncPagesLevels();
        $syncPagesLevels->syncPagesLevels(); 
        $urlRedirect = URLADM . "list-access-levels/index";
                header("Location: $urlRedirect");
       
    }
}
