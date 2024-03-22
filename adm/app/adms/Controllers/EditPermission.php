<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/**
 * Controller editar permissao
 * @author Cesar <cesar@celke.com.br>
 */
class EditPermission
{

    

   
      /** @var array|string|null $id recebe o id do registro */
      private int|string| null $id;
      /** @var array|string|null $level recebe o nivel de acesso*/
      private int|string| null $level;
      /** @var array|string|null $pag recebeo id do registro */
      private int|string| null $pag;


    
    public function index(int|string|null $id): void
    {
        $this->level = filter_input(INPUT_GET,"level",FILTER_SANITIZE_NUMBER_INT);
        $this->pag = filter_input(INPUT_GET,"pag",FILTER_SANITIZE_NUMBER_INT);
        $this->id =  $id;
      
        if((!empty($this->id)) and(!empty($this->level)) and(!empty($this->pag))){
            $editPermission = new \App\adms\Models\AdmsEditPermission();
            $editPermission->editPermission($this->id);

            $urlRedirect = URLADM . "list-permission/index/{$this->pag}?level={$this->level}";
            header("Location: $urlRedirect");
        }else{
            $_SESSION['msg'] = "<p class='alert-danger'>Erro - 0174: Necessário selecionar a página para liberar a permissão!</p>";
            $urlRedirect = URLADM . "list-access-levels/index";
                header("Location: $urlRedirect");
        }
        
    } 
}
