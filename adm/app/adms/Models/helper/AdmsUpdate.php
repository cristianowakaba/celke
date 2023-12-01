<?php

namespace App\adms\Models\helper;
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
use PDO;
use PDOException;

/**
 * Classe gernérica para editar registro no banco de dados
 *
 * @author Celke
 */
class AdmsUpdate extends AdmsConn
{
    /**recebe o nome da tabela 'adms_users'*/
    private string $table;
    /**recebe os termos 'WHERE id=:id' */
    private string|null $terms;
/**recebe a posicão 'conf_email' => string '$2y$10$DVpQzreVZEuqqKojQmf0VOtRZSeefXUN6AxcP9b2DJnMZ.e2nuETO' */
    private array $data;
    /**recebe o valor da parsestring convertida em array */
    private array $value = [];
    /**recebe o resultado se for true ou false */
    private string|null|bool $result;
       /**recebe a query preparada e executa */
    private object $update;
       /**possui a query */
    private string $query;
       /**possui a conexão com banco de dados*/
    private object $conn;
    
    

   /**retorna o resultado se for true ou false */
    function getResult(): string|null|bool
    {
        return $this->result;
    }
   /**recebe o nome da tabela, dados, termos, parsestring */
    public function exeUpdate(string $table, array $data, string|null $terms = null, string|null $parseString = null): void
    {
        $this->table = $table;
        $this->data = $data;
        $this->terms= $terms;
        var_dump( $table);
        var_dump($data);
        var_dump($terms);
        var_dump($parseString);
/**função nativa php parse_str converte para um array */
        parse_str($parseString,$this->value);

        var_dump($this->value);
        $this->exeReplaceValues();
    }
       /**pega os dado e usa o foreach para atribuir um array chave=> valor */
    private function exeReplaceValues():void
    {
        foreach($this->data as $key => $value){
            var_dump($key);
            var_dump($value);
            $values[]= $key . "=:" . $key;

        }
        var_dump($values);
        // transforma em string
        $values= implode(', ',$values);
        var_dump($values);

        $this->query = "UPDATE {$this->table} SET {$values} {$this->terms}";
        var_dump($this->query);
        $this->exeInstruction();
    }
    /**executa a instrução conecta banco de dados instancia metodo qu eprepar a e metodo que executa substituindo valores pelos links */
    private function exeInstruction():void
    {
        var_dump($this->data);
        var_dump($this->value);
        $this->connection();
        try{
            
            $this->update->execute(array_merge($this->data, $this->value));
            $this->result=true;
        }catch(PDOException $err){
          $this->result=null;
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
        $this->update = $this->conn->prepare($this->query);
    }
}
