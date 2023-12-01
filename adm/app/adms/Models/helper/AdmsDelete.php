<?php

namespace App\adms\Models\helper;
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
use PDO;
use PDOException;

/**
 * Classe gernérica para apagar registro no banco de dados
 *
 * @author Celke
 */
class AdmsDelete extends AdmsConn
{
    /**recebe o nome da tabela 'adms_users'*/
    private string $table;
    /**recebe os termos 'WHERE id=:id' */
    private string|null $terms;
/**recebe a posicão 'conf_email' => string '$2y$10$DVpQzreVZEuqqKojQmf0VOtRZSeefXUN6AxcP9b2DJnMZ.e2nuETO' */
   
    private array $value = [];
    /**recebe o resultado se for true ou false */
    private string|null|bool $result;
       /**recebe a query preparada e executa */
    private object $delete;
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
    public function exeDelete(string $table,  string|null $terms = null, string|null $parseString = null): void
    {
        $this->table = $table;
        
        $this->terms= $terms;
     
/**função nativa php parse_str converte para um array */
        parse_str($parseString,$this->value);
        var_dump($this->value);
        $this->query ="DELETE FROM {$this->table} {$this->terms}";

        $this->exeInstruction();

      
    }
   
    /**executa a instrução conecta banco de dados instancia metodo qu eprepar a e metodo que executa substituindo valores contidos em $this->value  pelos links */
    private function exeInstruction():void
    {
       
        $this->connection();
        try{
            $this->delete->execute($this->value);
            
            $this->result=true;
        }catch(PDOException $err){
          $this->result=false;
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
        $this->delete = $this->conn->prepare($this->query);
    }
}
