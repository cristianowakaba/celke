<?php

namespace App\adms\Models;


/**
 * EDITAR a imagem do usuários do banco de dados
 */
class AdmsEditUsersImage
{


  /**recebe true se executar com sucesso e false se houver erro */
  private bool $result = false;
  /**Recebe os registros do banco de dados */
  private array|null $resultBd;
  /** @var array|string|null $id recebeo id do registro */
  private int|string| null $id;
  /**
   * 
   * // @var array|string|null $data Recebe a sinformações do formulário 
   */
  private array|string|null $data;
  /** @var array|null $dataImagem Recebe os dados da imagem */
  private array|null $dataImagem;
  /** @var string $directory Recebe o endereço de upload da imagem */
  private string $directory;

  /** @var string $delImg Recebe o endereço da imagem que deve ser excluida */
  private string $delImg;
  /** @var string $nameImg Recebe o slug/nome da imagem */
  private string $nameImg;






  /**
   * retorna true quando eecutar o processo com sucesso ou false quando houver erro
   *
   * @return boolean
   */
  function getResult(): bool
  {
    return $this->result;
  }
  /**
   * retorna os detalhes do registro
   *
   * @return array|null
   */
  function getResultBd(): array|null
  {
    return $this->resultBd;
  }

  public function viewUser(int $id): bool
  {
    $this->id = $id;

    $viewUser = new \App\adms\Models\helper\AdmsRead();
    $viewUser->fullRead(
      "SELECT id, image
                            FROM adms_users
                            WHERE id=:id
                            LIMIT :limit",
      "id={$this->id}&limit=1"
    );

    $this->resultBd = $viewUser->getResult();
    if ($this->resultBd) {
      $this->result = true;
      return true;
    } else {
      $_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
      $this->result = false;
      return false;
    }
  }

  public function update(array $data = null): void
  {
    $this->data = $data;
    var_dump($this->data);
    $this->dataImagem = $this->data['new_image'];
    unset($this->data['new_image']);

    $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
    $valEmptyField->valField($this->data);
    if ($valEmptyField->getResult()) {
      /*           valida se tiver a posição name quer dizer que tem a imagem
 */
      if (!empty($this->dataImagem['name'])) {
        //$this->result = false;
        $this->valInput();
      } else {
        $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Necessário selecionar uma imagem!</p>";
        $this->result = false;
      }
    } else {
      $this->result = false;
    }
  }
  /** 
   * Verificar se existe o usuário com o ID recebido
   * Retorna FALSE quando houve algum erro
   * 
   * @return void
   */
  private function valInput(): void
  {
    $valExtImg = new \App\adms\Models\helper\AdmsValExtImg();
    $valExtImg->validateExtImg($this->dataImagem['type']);

    if (($this->viewUser($this->data['id'])) and ($valExtImg->getResult())) {
      $this->result = false;
      $this->upload();
    } else {

      $this->result = false;
    }
  }
  /**
   * instancia a slug  atribui o caminho do diretório,instancia a helper de upload
   *
   * @return void
   */
  private function upload(): void
  {
    $slugImg = new \App\adms\Models\helper\AdmsSlug();
    $this->nameImg = $slugImg->slug($this->dataImagem['name']);

    $this->directory = "app/adms/assets/image/users/" . $this->data['id'] . "/";

    /* $uploadImg = new \App\adms\Models\helper\AdmsUpload();
    $uploadImg->upload($this->directory, $this->dataImagem['tmp_name'], $this->nameImg); */

    //envia os parametros pra helper
    $uploadImgRes = new \App\adms\Models\helper\AdmsUploadImgRes();
    $uploadImgRes->upload($this->dataImagem, $this->directory,  $this->nameImg, 300, 300);
    if ($uploadImgRes->getResult()) {
      $this->edit();
    } else {
      $this->result = false;
    }
  }
  /**
   * edita o nome da imagam no banco de dados
   *
   * @return void
   */
  private function edit(): void
  {
    // var_dump($this->data);
    // pega o name da imagem e atribui na posição image para salvar na coluna image no banco
    $this->data['image'] = $this->nameImg;
    $this->data['modified'] = date("y-m-d H:i:s");

    $upUser = new \App\adms\Models\helper\AdmsUpdate();
    $upUser->exeUpdate("adms_users", $this->data, "WHERE id=:id", "id={$this->data['id']}");
    if ($upUser->getResult()) {
      $this->deleteImage();
    } else {
      $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não editado com sucesso!</p>";
      $this->result = false;
    }
  }
  /* deleta a imagem antiga se o usuário fizer novo upload
 if (file_exists($this->delImg)) {
            unlink($this->delImg);
        } essa parte verifica se existe, se existir unlink  apaga, após apagar apresenta mensagem
 */
  private function deleteImage(): void
  {
    // se for diferente de vazio o resultado que vem do Banco de dados com o nome da imagem que foi salva ou mão for nulo e a imagem que esta fazendo upload tiver nome diferente da que esta no banco de dados atribui o caminho a  $this->delImg.
    /*  ai verifica se existir arquivo no caminho  $this->delImg deleta.
  isso serve para se o usuario fizer upload por exemplo imagem celke.jpg mas ja tiver uma imagem no diretorio com mesmo nome ele deleta antiga e salva a nova, sem os if de verificacão ele deletaria e ficariao diretório sem imagem
  // */
    if (((!empty($this->resultBd[0]['image'])) or ($this->resultBd[0]['image'] != null)) and ($this->resultBd[0]['image'] != $this->nameImg)) {
      $this->delImg = "app/adms/assets/image/users/" . $this->data['id'] . "/" . $this->resultBd[0]['image'];
      if (file_exists($this->delImg)) {
        unlink($this->delImg);
      }
    }


    $_SESSION['msg'] = "<p style='color: green;'>Imagem editada com sucesso!</p>";
    $this->result = true;
  }
}
