<?php

namespace App\adms\Models;



class AdmsLogin 
{
    private array|null $data;
    
    private $resultBd;
    private $result;

    function getResult(){
        return $this->result;
        
    }

    public function login(array $data = null)
    {
        $this->data = $data;
      

        $viewUser = new \App\adms\Models\helper\AdmsRead(); 
        // retorna todas as colunas
        // $viewUser->exeRead("adms_users", "WHERE user=:user LIMIT :limit", "user={$this->data['user']}&limit=1");
        //retorna somente as colunas indicadas
        $viewUser->fullRead("SELECT id, name, email, password, image,adms_sits_user_id	FROM adms_users WHERE user =:user Or email= :email LIMIT :limit ", "user={$this->data['user']} &email={$this->data['user']}&limit=1");

        $this->resultBd =$viewUser->getResult();
       var_dump($this->resultBd);
        if($this->resultBd){
            // Var_dump( $this->resultBd );
            $this->valEmailPerm();
        }else{
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário ou a senha incorreta!</p>";
            $this->result = false;
        }
        // Instanciar o metodo quando a classe he abstrata e a classe AdmsLogin é filha da classe AdmsConn
        // $this->conn = $this->connectDb();
        
        // $query_val_login = "SELECT id, name, nickname, email, password, image 
        //                 FROM adms_users
        //                 WHERE user =:user
        //                 LIMIT 1";
        // $result_val_login = $this->conn->prepare($query_val_login);
        // $result_val_login->bindParam(':user', $this->data['user'], PDO::PARAM_STR);
        // $result_val_login->execute();

        // $this->resultBd = $result_val_login->fetch();
        // if($this->resultBd){
        //     //var_dump($this->resultBd);
        //     $this->valPassword();
        // }else{
        //     //$_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não encontrado!</p>";
        //     $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário ou a senha incorreta!</p>";
        //     $this->result = false;
        //     //echo $_SESSION['msg'];
        // }
    }
    /**
     * verifica  se o usuario ta com a situação ativa  1 segue em diante, senão redireciona para confirmar email
     *
     * @return void
     */
    private function valEmailPerm():void
    {
        if($this->resultBd[0]['adms_sits_user_id']==1){
            $this->valPassword();
        }elseif(($this->resultBd[0]['adms_sits_user_id']==3)){
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Necessário confirmar o e-mail, solicite novo link <a href='".URLADM."new-conf-email/index'> Clique Aqui</a></p>";
            $this->result=false;
        
        }elseif(($this->resultBd[0]['adms_sits_user_id']==5)){
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: E-mail descadastrado, entre em contato com a empresa!</p>";
            $this->result=false;
        
        }elseif(($this->resultBd[0]['adms_sits_user_id']==2)){
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: E-mail inativo, entre em contato com a empresa!</p>";
            $this->result=false;
        }else{
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: E-mail inativo, entre em contato com a empresa!</p>";
            $this->result=false;
        }
    }
    /**compara senha enviada pleo usuário com a senha que está salva no banco de dados
     * Retorna true quando os dados estão corretos e  salva as informações do usuário na sessão
     * retorna false quando a senha esta incorreta
     */
    private function valPassword():void
    {
        // tem que acrescentar a posição [0] no array
        if(password_verify($this->data['password'], $this->resultBd[0]['password'])){
            $_SESSION['msg'] = "<p style='color: green;'>Login realizado com sucesso!</p>";
            $_SESSION['user_id'] = $this->resultBd[0]['id'];
            $_SESSION['user_name'] = $this->resultBd[0]['name'];
            $_SESSION['user_nickname'] = $this->resultBd[0]['nickname'];
            $_SESSION['user_email'] = $this->resultBd[0]['email'];
            $_SESSION['user_image'] = $this->resultBd[0]['image'];
            $this->result = true;
            //echo $_SESSION['msg'];
        }else{
            //$_SESSION['msg'] = "<p style='color: #f00;'>Erro: Senha incorreta!</p>";
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário ou a senha incorreta!</p>";
            $this->result = false;
            //echo $_SESSION['msg'];
        }
    }
}