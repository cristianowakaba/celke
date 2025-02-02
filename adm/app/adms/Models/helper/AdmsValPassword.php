<?php

namespace App\adms\Models\helper;
/**
 * classe responsável por validar a senha
 */
class AdmsValPassword
{
    /**recebe a senha que será validada */
    private string $password;
    private bool $result=false;
   
    function getResult():bool
    {
        return $this->result;
    }
    /**valida a senha, verifica espaço em branco e aspas, vai ser instanciada na AdmsNewUser */
   public function validatePassword(string $password):void
{
    $this->password = $password;
    if(stristr($this->password,"'")){
        $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Caracter(') utilizado na senha invalido!</p>";
        $this->result= false;
    }else{
        if(stristr($this->password," ")){
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: proibido utilizar espaço em branco no campo senha!</p>";
            $this->result= false;

        }else{
             $this->valExtensPassord();
        }
    }

}
/**verifica para ter no minimo 6 caracteres */
    private function valExtensPassord():void
    {
        if(strlen($this->password)<6){
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: A senha deve ter no minimo 6 caracteres!</p>";
            $this->result= false;
        }else{
            $this->valValuePassord();
        }
    }
    /**verifica para a senha conter letras números e caracteres especiais permitidos */
    private function valValuePassord():void
    {
        if(preg_match('/^(?=.*[0-9])(?=.*[a-zA-Z])[a-zA-Z0-9-@#$%;*]{6,}$/',$this->password)){
            $this->result= true;
        }else{
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: A senha deve ter letras e  numeros!</p>";
        }
    }
}