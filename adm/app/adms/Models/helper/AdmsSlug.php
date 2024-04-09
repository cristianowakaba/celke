<?php

namespace App\adms\Models\helper;
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/**
 * Classe genérica para converter o SLUG
 *
 * @author Celke
 */
class AdmsSlug
{
    /** @var string $text Recebe o texto que dever converter para o SLUG */
    private string $text;

    /** @var array $format Recebe o array de caracteres especiais que devem ser substituido */
    private array $format;

    
    public function slug(string $text): string|null
    {
        $this->text = $text;
       
        $this->format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]?;:,\\\'<>°ºª';
        $this->format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr-----------------------------------------------------------------------------------------------';
        $this->text  = strtr(mb_convert_encoding($this->text , 'ISO-8859-1', 'UTF-8'), mb_convert_encoding($this->format['a'], 'ISO-8859-1', 'UTF-8'), $this->format['b']);
        $this->text = str_replace(" ", "-", $this->text);
        $this->text = str_replace(array('-----', '----', '---','--'), '-', $this->text);
        $this->text = strtolower($this->text);
        
        return $this->text;
    }
}
