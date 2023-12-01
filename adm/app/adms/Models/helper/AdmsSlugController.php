<?php

namespace App\adms\Models\helper;
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/**
 * classe generica para tratar a controller e o método
 */
class AdmsSlugController {
   
	
	/** @var string $urlSlugController Recebe o controller tratada */
    private string $urlSlugController;
    /** @var string $urlSlugMetodo Recebe o metodo tratado */
    private string $urlSlugMetodo;
	public $result;
	/**
     * Converter o valor obtido da URL "view-users" e converter no formato da classe "ViewUsers".
     * Utilizado as funções para converter tudo para minúsculo, converter o traço pelo espaço, converter cada letra da primeira palavra para maiúsculo, retirar os espaços em branco
     *
     * @param string $slugController Nome da classe
     * @return string Retorna a controller "view-users" convertido para o nome da Classe "ViewUsers"
     */
  

    public function slugController(string $slugController):string
    {
        $this->urlSlugController = $slugController;
        
        
        // Converter para minusculo
        $this->urlSlugController = strtolower($this->urlSlugController);
        // Converter o traco para espaco em braco
        $this->urlSlugController = str_replace("-", " ", $this->urlSlugController);
        // Converter a primeira letra de cada palavra para maiusculo
        $this->urlSlugController = ucwords($this->urlSlugController);
        // Retirar espaco em branco        
        $this->urlSlugController = str_replace(" ", "", $this->urlSlugController);
        
        return $this->urlSlugController;
        
    }

    /**
     * Tratar o método
     * Instanciar o método que trata a controller
     * Converter a primeira letra para minusculo
     *
     * @param string $urlSlugMetodo
     * @return string
     */
    public function slugMetodo(string $urlSlugMetodo): string
    {
        
        $this->urlSlugMetodo = $this->slugController($urlSlugMetodo);
        //Converter para minusculo a primeira letra
        $this->urlSlugMetodo = lcfirst($this->urlSlugMetodo);
       
         return $this->urlSlugMetodo;
	 }
}