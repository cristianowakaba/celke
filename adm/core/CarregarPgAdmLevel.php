<?php

namespace Core;

if (!defined('C8L6K7E')) {
    /*  header("Location:/"); */
    die("Erro: Página não encontrada!<br>");
}


/**s
 * Verificar se existe a classe
 * Carregar a CONTROLLER
 * @author Cesar <cesar@celke.com.br>
 */
class CarregarPgAdmLevel
{
    /** @var string $urlController Recebe da URL o nome da controller */
    private string $urlController;
    /** @var string $urlMetodo Recebe da URL o nome do método */
    private string $urlMetodo;
    /** @var string $urlParamentro Recebe da URL o parâmetro */
    private string $urlParameter;
    /** @var string $classLoad Controller que deve ser carregada */
    private string $urlSlugController;
    private string $urlSlugMetodo;
    private string $classLoad;
      /**
     * $resultPage recebe os dados da pagina do banco de dados
     * @var array|null
     */
    private array|null  $resultLevelPage;
    /**
     * $resultPage recebe os dados da permissão de acessar
     
     * @var array|null
     */
    private array|null $resultPage;



    /**
     * Verificar se existe a classe
     * @param string $urlController Recebe da URL o nome da controller
     * @param string $urlMetodo Recebe da URL o método
     * @param string $urlParamentro Recebe da URL o parâmetro
     */

    public function loadPage(string|null $urlController, string|null $urlMetodo, string|null $urlParameter): void
    {
        $this->urlController = $urlController;
        $this->urlMetodo = $urlMetodo;
        $this->urlParameter = $urlParameter;
       // var_dump($this->urlController);
        //var_dump($this->urlMetodo);
        //var_dump( $this->urlParameter);
        $this->searchPage();
    }
    private function searchPage(): void
    {
        $seachPage = new \App\adms\Models\helper\AdmsRead();
        $seachPage->fullRead("SELECT pag.id, pag.publish,typ.type
                             FROM adms_pages AS pag
                             INNER JOIN adms_types_pgs AS typ ON typ.id =pag.adms_types_pgs_id
                             WHERE pag.controller = :controller 
                             AND pag.metodo =:metodo
                             LIMIT :limit ", "controller={$this->urlController}&metodo={$this->urlMetodo}&limit=1");
        $this->resultPage = $seachPage->getResult();
        if ($this->resultPage) {
          //  var_dump($this->resultPage);
            if ($this->resultPage[0]['publish'] == 1) {
                $this->classLoad = "\\App\\".$this->resultPage[0]['type']."\\Controllers\\" . $this->urlController;
                $this->loadMetodo()
;            } else {
               $this->verifyLogin();
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0177: Página não encontrada! verificar se está cadastrado como private</p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }
        /**
     * ConfigController recebe a controller, método e parametro e envia para CarregarPgAdm
     * verifica se classe existe   é atribuido ao atributo o caminho e a $this->urlController   carrega o nome da controller que possui o método index $this->classLoad = "\\App\\adms\\Controllers\\" . $this->urlController;
     * instancia a classe e atribui para o objeto   $classLoad = new $this->classLoad();
     * verifica se o método existe  pois o objeto $classLoad possui o caminho até a controller if(method_exists( $classLoad,$this->urlMetodo))
     *se existe o metodo na classe  $classLoad->{$this->urlMetodo}($this->urlParameter); instancia o método e envia o parametro, como na controller o método index carrega a view ela e carregada e recebe o parametro  $classLoad->{$this->urlMetodo}($this->urlParameter);
     * @return void
     */
    private function loadMetodo(): void
    {
        $classLoad = new $this->classLoad();

        if (method_exists($classLoad, $this->urlMetodo)) {

            $classLoad->{$this->urlMetodo}($this->urlParameter);
        } else {
            die("Erro - - 0178: Por favor tente novamente. Caso o problema persista, entre em contato o administrador " . EMAILADM);
        }
    }
       /**
     * Verificar se o usuário está logado e carregar a página
     *
     * @return void
     */
    private function verifyLogin(): void
    {
        if ((isset($_SESSION['user_id'])) and (isset($_SESSION['user_name']))  and (isset($_SESSION['user_email'])) and ( $_SESSION['adms_access_level_id']) and ( $_SESSION['order_levels'])) {
            // $this->classLoad = "\\App\\adms\\Controllers\\" . $this->urlController;
            $this->searchLelelPage();
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0179: Para acessar a página realize o login!</p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }
    private function searchLelelPage(): void
    {
        $searchLevelPage = new \App\adms\Models\helper\AdmsRead();
        $searchLevelPage->fullRead("SELECT id, permission 
                    FROM adms_levels_pages
                    WHERE adms_page_id =:adms_page_id 
                    AND adms_access_level_id =:adms_access_level_id 
                    AND permission =:permission
                    LIMIT :limit", "adms_page_id={$this->resultPage[0]['id']}&adms_access_level_id=" . $_SESSION['adms_access_level_id'] . "&permission=1&limit=1");
                  
        $this->resultLevelPage = $searchLevelPage->getResult();
  
        if($this->resultLevelPage){
            $this->classLoad = "\\App\\".$this->resultPage[0]['type']."\\Controllers\\" . $this->urlController;
            $this->loadMetodo();
        }else{
            $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0180: Para acessar a página necessaário permissão!</p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }


}