<?php

namespace Core;
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/**
 * Configurações básicas do site.
 *
 * @author Cesar <cesar@celke.com.br>
 */

abstract class Config
{
    /**
     * Possui as constantes com as configurações.
     * Configurações de endereço do projeto.
     * Página principal do projeto.
     * Credenciais de acesso ao banco de dados
     * E-mail do administrador.
     * 
     * @return void
     */
    protected function configAdm(): void
    {
        define('URL', 'http://localhost/projetosalao/');
        define('URLADM', 'http://localhost/projetosalao/adm/');

        define('CONTROLLER', 'Login');
        define('METODO', 'index');
        define('CONTROLLERERRO', 'Login');

        define('HOST', 'localhost');
        define('USER', 'root');
        define('PASS', '');
        define('DBNAME', 'celke');
        define('PORT', 3306);

        define('EMAILADM', 'cristianowakaba@gmail.com');
    }
}
