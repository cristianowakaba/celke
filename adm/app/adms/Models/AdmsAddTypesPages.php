<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')) {
    /*  header("Location:/"); */
    die("Erro: Página não encontrada!<br>");
}

/** Cadastrar tipo da página no banco de dados
 */
class AdmsAddTypesPages
{
    /**recebe as informações do formulario */
    private array|null $data;
    /**recebe a ultima ordem cadastrada */
    private array|null $resultadoBd;

    /**recebe true se executar com sucesso e false se houver Erro - */
    private $result;

    /** @var array $dataExitVal Recebe as informações que serão retiradas da validação*/
    private array $dataExitVal;


    function getResult()
    {
        return $this->result;
        // //var_dump($this->result);
    }
    /** 
     * Recebe os valores do formulário.
     * Instancia o helper "AdmsValEmptyField" para verificar se todos os campos estão preenchidos 
     * Verifica se todos os campos estão preenchidos e instancia o método "valInput" para validar os dados dos campos
     * Retorna FALSE quando algum campo está vazio
     * 
     * @param array $data Recebe as informações do formulário
     * 
     * @return void
     */
    public function create(array $data = null)
    {
        $this->data = $data;
        $this->dataExitVal['obs'] = $this->data['obs'];
        unset($this->data['obs']);
        // //var_dump($this->data);

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            $this->add();
        } else {
            $this->result = false;
        }
    }


    /**
     *Cadastrar usuário no banco de dados
     * Retorna TRUE quando cadastrar o usuário com sucesso
     * Retorna FALSE quando não cadastrar o usuário
     *
     * @return void
     */
    private function add(): void
    {
        if ($this->viewLastTypesPages()) {
        $this->data['obs'] = $this->dataExitVal['obs'];

        $this->data['created'] = date("Y-m-d H:i:s");


        //var_dump( $this->data);

        $createTypePage = new \App\adms\Models\helper\AdmsCreate();
        $createTypePage->exeCreate("adms_types_pgs", $this->data);

        if ($createTypePage->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Tipo De página cadastrada com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0134: Tipo De página não cadastrada com sucesso!</p>";
            $this->result = false;
        }
    }
    }
    /** 
     * Metodo para verificar qual he a ultima ordem que esta cadastrada no banco de dados
     */
    private function viewLastTypesPages()
    {
        $viewLastTypesPages = new \App\adms\Models\helper\AdmsRead();
        $viewLastTypesPages->fullRead("SELECT order_type_pg FROM adms_types_pgs
                                        ORDER BY order_type_pg DESC LIMIT 1");

        $this->resultadoBd = $viewLastTypesPages->getResult();
        if ($this->resultadoBd) {
            $this->data['order_type_pg'] = $this->resultadoBd[0]['order_type_pg'] + 1;
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro - 0135: Tipo de página não cadastrado com sucesso. Tente mais tarde!</div>";
            return false;
        }
    }
}
