<?php

namespace App\adms\Models\helper;
/**
 * classe responsável por validar email unico
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
            $_SESSION['msg'] ="<p style ='color:#f00;'>E-mail invalido!</p>";
            $this->result= false;
        }
    }    
}
