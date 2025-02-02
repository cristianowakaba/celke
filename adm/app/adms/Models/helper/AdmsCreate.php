<?php

namespace App\adms\Models\helper;

use PDO;
use PDOException;

/**
 * Classe gernérica para cadastrar registro no banco de dados
 *
 * @author Celke
 */
class AdmsCreate extends AdmsConn
{
    /** @var string $table Recebe o nome da tabela */
    private string $table;

    /** @var array $data Recebe os dados que devem ser inseridos no BD */
    private array $data;

    /** @var string|null $result Retorna o status do cadastro */
    private string|null $result = null;

    /** @var object $insert Recebe a QUERY preparada */
    private object $insert;

    /** @var string $query Recebe a QUERY */
    private string $query;

    /** @var object $conn Recebe a conexão com o BD */
    private object $conn;

    /**
     * Retornar o status do cadastro, retorna o último id quando cadatrar com sucesso e null quando houver erro
     * @return string|null Retorna o último id inserido
     */
    function getResult():string
    {
        return $this->result;
    }

    /**
     * executar o Cadatrar no banco de dados, AdmsNewUser vai istanciar a classe e mandar os dados
     * 
     * @param string $table Recebe o nome da tabela
     * @param array $data Recebe os dados do formulário
     * @return void
     */
    public function exeCreate(string $table, array $data):void
    {
        $this->table = $table;
        $this->data = $data;
        //var_dump($this->table);
        // var_dump($this->data);
        $this->exeReplaceValues();        
    }

    /**
     * pega os dados e separa por virgula para ser o nome da coluna, acrescenta os dois pontos ara ser o valor que recebe
     * Cria a QUERY de forma dinamica e os links da QUERY
     * 
     * @return void
     */
    private function exeReplaceValues(): void
    {
        $coluns = implode(', ', array_keys($this->data));
        
        $values = ':' . implode(', :', array_keys($this->data));
        //var_dump($values);
        // var_dump($this->data);
        $this->query = "INSERT INTO {$this->table} ($coluns) VALUES ($values)";
        //var_dump($this->query);
        $this->exeInstruction();
    }

    /**
     * Executa a QUERY. 
     * Quando executa a query com sucesso retorna o último id inserido, senão retorna null.
     * 
     * @return void
     */
    private function exeInstruction(): void
    {
        $this->connection();
        try{
            $this->insert->execute($this->data);
            // var_dump($this->data);
            $this->result = $this->conn->lastInsertId();
            
        }catch(PDOException $err){
            $this->result = null;
        }
    }

    /**
     * Obtem a conexão com o banco de dados da classe pai "Conn".
     * Prepara uma instrução para execução e retorna um objeto de instrução.
     * 
     * @return void
     */
    private function connection(): void
    {
        $this->conn = $this->connectDb();
        $this->insert = $this->conn->prepare($this->query);
    }
}
