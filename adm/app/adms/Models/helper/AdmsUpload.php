<?php

namespace App\adms\Models\helper;
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
/**
 * Classe genérica para upload
 *
 * @author Celke
 */
class AdmsUpload
{

    private string $directory;
    private string $tmpName;
    private string $name;


    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }
/**
 * metodo do helper de upload, recebe o diretório,tempName e o nome da imagem ja covertido com metodo slug, intancia o valDirectory() que valida o diretório e cria se não existir
 *
 * @param string $directory
 * @param string $tmpName
 * @param string $name
 * @return void
 */
    public function upload(string $directory, string $tmpName, string $name): void
    {
        $this->directory = $directory;
        $this->tmpName = $tmpName;
        $this->name = $name;

        if($this->valDirectory()){
            $this->uploadFile();
        }else{
            $this->result = false;
        }
    }
/**
 * valida o diretório se não existe ou não é diretorio, crie o diretório function,após verifics denovo se nãao existir retorna false e msg de erro
 *
 * @return boolean
 */
    private function valDirectory():bool
    {
        if ((!file_exists($this->directory)) and (!is_dir($this->directory))) {
            mkdir($this->directory, 0755);
            if ((!file_exists($this->directory)) and (!is_dir($this->directory))) {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Upload não realizado com sucesso. Tente novamente!</p>";
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }
    }
/**
 * move a imagem(upload) do local que esta(tmpName,) para o diretório criado.
 *
 * @return void
 */
    private function uploadFile(){
        if (move_uploaded_file($this->tmpName, $this->directory . $this->name)) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Upload não realizado com sucesso. Tente novamente!</p>";
            $this->result = false;
        }
    }

}
