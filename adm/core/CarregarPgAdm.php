<?php

namespace Core;

use App\adms\Controllers\ViewUsers;

/**s
 * Verificar se existe a classe
 * Carregar a CONTROLLER
 * @author Cesar <cesar@celke.com.br>
 */
class CarregarPgAdm
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

    private array $listPgPublic;
    private array $listPgPrivate;


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
        // var_dump($this->urlMetodo);
        // var_dump( $this->urlParameter);
        

        //unset($_SESSION['user_id']);
        $this->pgPublic();
        //é conferido se a página é publica ou privada, e atribuida q url ao atributo ex:$this->classLoad = "\\App\\adms\\Controllers\\" . $this->urlController; abaixo verifica se classe existe instancia o metodo
        if (class_exists($this->classLoad)) {
            // var_dump($this->classLoad);
            $this->loadMetodo();
        } else {
            //die("Erro - 003: Por favor tente novamente. Caso o problema persista, entre em contato o administrador " . EMAILADM);

            //instancia a classe AdmsSlug para tratar a controller,
            $urlController = new \App\adms\Models\helper\AdmsSlugController();
            //envio a constatente CONTROLLER(Login) para fazer o tratamento deixar primeira letra maiuscula
           $this->urlController= $urlController->slugController(CONTROLLER);
            
            //instancia a classe para tratar o método;
            $urlMetodo = new \App\adms\Models\helper\AdmsSlugController();
            // trata o método index para deixar a primeira letra minuscula
            $this->urlMetodo=$urlMetodo->slugMetodo(METODO);
            $this->urlParameter="";
            // função recursiva,chama a classe novamente após o tratamento assim entra no if para ser redirecionado posteriormente para página login
            $this->loadPage($this->urlController, $this->urlMetodo, $this->urlParameter);
        }
    }
    private function loadMetodo():void
    {
        $classLoad = new $this->classLoad();
        //var_dump($classLoad);
        if(method_exists( $classLoad,$this->urlMetodo)){
           //  var_dump($this->urlMetodo);
            $classLoad->{$this->urlMetodo}($this->urlParameter);
            
        }else{
            die("Erro - 003: Por favor tente novamente. Caso o problema persista, entre em contato o administrador " . EMAILADM);
        }
    }
     /**
     * Verificar se a página é pública e carregar a mesma
     *
     * @return void
     */
    private function pgPublic(): void
    {
        $this->listPgPublic = ["Login", "Erro", "Logout", "NewUser","ConfEmail","NewConfEmail","RecoverPassword","UpdatePassword",];

        if (in_array($this->urlController, $this->listPgPublic)) {
            $this->classLoad = "\\App\\adms\\Controllers\\" . $this->urlController;
            // var_dump($this->urlController);
        
        } else {
            $this->pgPrivate();
        }
    }
/**
     * Verificar se a página é privada e chamar o método para verificar se o usuário está logado
     *
     * @return void
     */
    private function pgPrivate():void
    {
      
        $this->listPgPrivate = ["Dashboard", "ListUsers","ViewUsers","AddUsers","EditUsers","EditUsersPassword","EditUsersImage","DeleteUsers","ViewProfile","ViewProfile","EditProfile"];
        // var_dump($this->urlController);
        if(in_array($this->urlController, $this->listPgPrivate)){
            $this->verifyLogin();
        }else{
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Página não encontrada!</p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }

    /**
     * Verificar se o usuário está logado e carregar a página
     *
     * @return void
     */
    private function verifyLogin(): void
    {
        if((isset($_SESSION['user_id'])) and (isset($_SESSION['user_name']))  and (isset($_SESSION['user_email'])) ){
            $this->classLoad = "\\App\\adms\\Controllers\\" . $this->urlController;
            // var_dump($this->classLoad);
        }else{
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Para acessar a página realize o login!</p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }
}
