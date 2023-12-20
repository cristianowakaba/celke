<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/**
 * Controller da página Confirmar Email
 * @author Cesar <cesar@celke.com.br>
 */
class ConfEmail
{
      /** @var array|string|null $key Recebe a chave para confirmar o cadastro */
      private array|string|null $key;
    
    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index():void
    {
        //chave vem pela url após clicar no link dentro do email
        $this->key=filter_input(INPUT_GET,"key",FILTER_DEFAULT);
     echo"chave:{$this->key}";

     if(!empty($this->key)){
        $this->valKey();
     }else{
        $_SESSION['msg'] = "<p style='color: #f00;'>Erro 006: Necessário confirmar o e-mail, solicite novo link <a href='".URLADM."new-conf-email/index'> Clique Aqui</a></p>";
        $urlRedirect = URLADM . "login/index";
        header("Location: $urlRedirect");
     }

    }
    /**instancia a modelsAdmsConfEmail() e o metodo confEmaile enviando o $this->key por parametro  se for true o retorno do gerResult redireciona pro loguin   */
    private function valKey():void
    {
        $confEmail=new \App\adms\Models\AdmsConfEmail();
        $confEmail->confEmail($this->key);
        if($confEmail->getResult()){
            $urlRedirect = URLADM . "login/index";
        header("Location: $urlRedirect");
        }else{
            $urlRedirect = URLADM . "login/index";
        header("Location: $urlRedirect");
        }
    }

}