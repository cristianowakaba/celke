<?php

namespace App\adms\Models\helper;
/**
 * classe responsável por validar os campos vazio do formulario,o AdmsNewUser vai instancia-lá
 */
class AdmsValEmptyField
{
    /**
     * recebe os dados do formulario
     */
    private array|null $data;
    private bool $result;
/** retorna true se não tiver erro e false se houver erro */
    function getResult()
    {
        return $this->result;
    }
/**método da classe AdmsValEmptyField para validar os campos  */
    public function valField(array $data = null): void
    {
        $this->data = $data;
        //retira as tags
        $this->data = array_map('strip_tags', $this->data);
        //retirar espaço em branco do inicio e final
        $this->data = array_map('trim', $this->data);
//verifica se tem campo vazio no array
        if(in_array('', $this->data)){
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Necessário preencher todos os campos!</p>";
            $this->result = false;
        }else{
            $this->result = true;
        }
    }
}
