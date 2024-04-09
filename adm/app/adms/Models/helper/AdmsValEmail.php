<?php

namespace App\adms\Models\helper;
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/**
 * classe responsável por validar email 
 */
class AdmsValEmail
{
    private string $email;
    private bool $result;
   
    function getResult():bool
    {
        return $this->result;
    }
    /** recebe o  email da AdmsValEmail por parametro verifica se é email valido e retorna atraves do getResult true ou false */
    public function validateEmail(string $email):void
    {
        $this->email= $email;
        if(filter_var($this->email,FILTER_VALIDATE_EMAIL)){
            $this->result= true;
        }else{
            $_SESSION['msg'] ="<p style ='color:#f00;'>E-mail invalido!(0079)</p>";
            $this->result= false;
        }
    }    
}
