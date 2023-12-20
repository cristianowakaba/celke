<?php

namespace App\adms\Models\helper;

if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }

/**
 * Classe gernérica para redimensionar imagem  
 *
 * @author Celke
 */
class AdmsUploadImgRes
{
    /**
     * recebe os dados da imagem
     * @var array
     */
    private array $imageData;
    /**
     * recebe o caminho do diretório
     *
     */
    private string $directory;
    /**
     * recebe o nome da imagem
     * 
     */
    private string $name;
    /**
     * recebe a largura da imagem para  redimencionar
     * 
     */
    private int $width;
    /**
     * recebe a altura da imagem para redimencionar
     * 
     */
    private int $height;

    private $newImage;
    private bool $result;
    private $imgResize;

    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * recebe os dados da imagem,diretório ,name,largura e altura.instancia valDirectory() 
     * @param array $imageData
     * @param string $directory
     * @param string $name
     * @param integer $width
     * @param integer $height
     * @return void
     */
    public function upload(array $imageData, string $directory, string $name, int $width, int $height): void
    {
        $this->imageData = $imageData;
        $this->directory = $directory;
        $this->name = $name;
        $this->width = $width;
        $this->height = $height;

        var_dump($this->imageData);
        var_dump($this->directory);
        var_dump($this->name);
        var_dump($this->width);
        var_dump($this->height);

        $this->valDirectory();
    }
    /**
     
     * MÉTODO VALIDAR DIRETÓRIO se cair no primeiro if verifica se existe  $this->directory e se não é diretório e instancia $this->createDir().segundo elseif se não existir $this->directory instancia $this->createDir() . terceiro else faz upload
     
     * @return void
     */
    private function valDirectory(): void
    {
       

        if ((file_exists($this->directory)) and (!is_dir($this->directory))) {
            $this->createDir();
        } elseif (!file_exists($this->directory)) {
            $this->createDir();
        } else {
            $this->uploadFile();
        }
    }
    /**
     * MÉTODO CRIAR DIRETÓRIO, cria o diretório, após verifica se o diretorio existe ou seja se foi criado, se não foi criado apresenta um erro, se foi criado instancia  o método de upload $this->uploadFile();
     *
     * @return void
     */
    private function createDir(): void
    {
        mkdir($this->directory, 0755);
        if (!file_exists($this->directory)) {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro 0075: Upload da imagem não realizado com sucesso. Tente novamente!</p>";
            $this->result = false;
        } else {
            $this->uploadFile();
        }
    }
    /**
     * verifica se for for tipo jpg instancia $this->uploadFileJpeg(),  se for tipo png instancia   $this->uploadFilePng(); se não for nenhum apresenta uma msg para selecionar imagem jpg ou png
     *
     * @return void
     */
    private function uploadFile(): void
    {

        switch ($this->imageData['type']) {
            case 'image/jpeg':
            case 'image/pjpeg':
                $this->uploadFileJpeg();
                break;
            case 'image/png':
            case 'image/x-png':
                $this->uploadFilePng();
                break;
            default:
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro 0076: Necessário selecionar imagem JPEG ou PNG!</p>";
                $this->result = false;

                /*  $_SESSION['msg'] = "<p style='color: #f00;'>acessou helper redimensionar imagem!</p>";
                $this->result= false; */
        }
    }
    /**
     * usa a função  imagecreatefromjpeg para criar uma nova imagem com base na imagem enviada, após instancia  $this->redImg() para redimencionar e envia para o servidor.
     *
     * @return void
     */
    private function uploadFileJpeg(): void
    {
        $this->newImage = imagecreatefromjpeg($this->imageData['tmp_name']);

        $this->redImg();

        // Enviar a imagem para servidor
        if (imagejpeg($this->imgResize, $this->directory . $this->name, 100)) {
            $_SESSION['msg'] = "<p style='color: green;'>Upload da imagem realizado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro 0077: Upload da imagem não realizado com sucesso. Tente novamente!</p>";
            $this->result = false;
        }
    }

    private function uploadFilePng(): void
    {
        $this->newImage = imagecreatefrompng($this->imageData['tmp_name']);

        $this->redImg();

        // Enviar a imagem para servidor
        if (imagepng($this->imgResize, $this->directory . $this->name, 1)) {
            $_SESSION['msg'] = "<p style='color: green;'>Upload da imagem realizado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro 0078: Upload da imagem não realizado com sucesso. Tente novamente!</p>";
            $this->result = false;
        }
    }
    /**
     * obtem largura,altura e cria uma imagerm cor preta coma funcao imagecreatetruecolor apos redimensiona  a imagem com função  imagecopyresampled
     *
     * @return void
     */
    private function redImg(): void
    {
        // Obter a largura da image
        $width_original = imagesx($this->newImage);

        // Obter a altura da image
        $height_original = imagesy($this->newImage);

        // Criar uma imagem modelo  de cor preta com as dimensões definidas para nova imagem
        $this->imgResize = imagecreatetruecolor($this->width, $this->height);

        // Copiar e redimensionar parte da imagem enviada pelo usuário e interpola com a imagem tamanho modelo
        imagecopyresampled($this->imgResize, $this->newImage, 0, 0, 0, 0, $this->width, $this->height, $width_original, $height_original);
    }
}
