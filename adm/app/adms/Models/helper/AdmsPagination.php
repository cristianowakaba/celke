<?php

namespace App\adms\Models\helper;

if (!defined('C8L6K7E')) {
    /*  header("Location:/"); */
    die("Erro: Página não encontrada!<br>");
}


/**
 * Classe gernérica para páginar os registros do banco de dados
 *
 * @author Celke
 */
class AdmsPagination
{
    /** @var string|int|null $page Recebe o numero da página que o usuário está */
    private int $page;
    /** @var int $limitResult  recebe a quantidade de registros que deve retornar do banco de dados  por página */
    private int $limitResult;
    /**
     * a partir de que registro vai exibir
     *
     * @var int
     */
    private int $offset;
    private string $query;
    private string|null $parseString;
    private array $resultBd;
    private string|null $result;
    /**
     * recebe o total de páginas do projeto
     *
     * @var integer
     */
    private int $totalPages;
    /**
     * recebe o maximo de links que vai ser apresntado antes e depois da página atual
     *
     * @var integer
     */
    private int $maxLinks = 2;
    /**
     * recebe o link ('URLADM', 'http://localhost/projetosalao/adm/');

     *
     * @var string
     */
    private string $link;
    /**
     * RECEBE A VARIAVEL, pode ser ?pesquisa= celke  por exemplo
     *
     * @var string|null
     */
    private string|null $var;

    function getOffset(): int
    {
        return $this->offset;
    }
    function getResult(): string|null
    {
        return $this->result;
    }

    function __construct(string $link, string|null $var = null)
    {
        $this->link = $link;

        $this->var = $var;
        //var_dump($this->link);
    }
    public function condition(int $page, int $limitResult): void
    {
        $this->page = (int) $page ? $page : 1;
        $this->limitResult = (int) $limitResult;
        //var_dump($this->page);
        //var_dump($this->limitResult);
        //pega a pagina que o usuario esta e multiplica pelo numero limite de registros por página e subtrai pelo mesmo numero de registros this->limitResult  exemplo   o usuário esta na pagina 2 e vai retornar 5 resultados por pagina, 2x5 =10 diminui o limite por pagina - 5  vai retornar apartir do cinco  se eu to na segunda vai aparecer 6,7,8,9,10
        $this->offset = (int) ($this->page * $this->limitResult) - $limitResult;

        //var_dump($this->offset);
    }
    public function pagination(string $query, string|null $parseString = null): void
    {
        $this->query = (string) $query;
        $this->parseString = (string) $parseString;
        //var_dump($this->query);
        //var_dump($this->parseString);

        $count = new \App\adms\Models\helper\AdmsRead();
        $count->fullRead($this->query, $this->parseString);
        $this->resultBd = $count->getResult();
        $this->pageInstruction();
    }
    /**
     * pega o numero de registros que vem do banco de dados  e divide pelo numero de registros que é para aparecer em cada página. 
     * usa o ceil para arredondar para cima se for decimal pq não existe página quebrada.
     * se o total de páginas é maior ou igual a página que o usuario está acessa o if e instancia o metodo layoutPagination. senão redireciona para o listar usuários
    
     * @return void
     */
    private function pageInstruction(): void
    {
        // var_dump($this->resultBd[0]['num_result']);

        //pega o numero de registros no banco de dados e divide pelo numero de registro que deve ter a página, por exemplo retorna 40 registros e quer ter 10 por pagina o totalPage serade 4 páginas
        $this->totalPages = (int) ceil($this->resultBd[0]['num_result'] / $this->limitResult);
        //var_dump($this->totalPages);
        //verifica se o total de páginas é maior ou igual a que o usuario esta, se for menor redireciona por exemplo tem 4 paginas e o usuario quer ir na página 5 redireciona.
        if ($this->totalPages >= $this->page) {
            $this->layoutPagination();
        } else {
            header("Location: {$this->link}");
        }
    }
    /**
     * exibe os links da páginação.
     *
     * @return void
     */
    private function layoutPagination(): void
    {
        $this->result = "<ul>";

        $this->result .= "<li><a href='{$this->link}{$this->var}'>Primeira</a></li>";
        //atribui a $beforePage o resultado da página que o usuario esta - maxLink  exemplo usuário esta na página 6-2 vai das 4 ai compara a página que o usuário esta que no exemplo é a 6 subtri 1 (6-1) resultado 5 e verifica se 5 é maior ou igual ao  $beforePage que seria 4 se sim  incrementa $beforePage++ ou seja vaiu ter o link 4,5 antes da página atual que é 6

        //mas antes apresnto um if pra verificar se $beforePage é maior ou igual a 1 senão apresenta páginas negativas
        for ($beforePage = $this->page - $this->maxLinks; $beforePage <= $this->page - 1; $beforePage++) {
            if ($beforePage >= 1) {
                //vai incrementar o gerando os links  até achagar na página anterior a atual ou seja no exmplo um link 4 e um link 5
                $this->result .= "<li><a href='{$this->link}/$beforePage{$this->var}'>$beforePage</a></li>";
            }
        }
        //var_dump($this->result);
        $this->result .= "<li>{$this->page}</li>";
        // $afterPage recebe a página atual +1 ex página atual 6 +1= 7 ai compara se a página atual somado com o maxLinks ou seja no exemplo 6+2  =8 ai compara se 8 for maior ou igual ao afterpage, acrescenta afterPage++ ou seja vai  criar a página 7 e página 8 mas antes verifica e so executa se o total de página for maior ou igual ap afterPage para não criar link infinitos
        for ($afterPage = $this->page + 1; $afterPage <= $this->page + $this->maxLinks; $afterPage++) {
            if ($afterPage <= $this->totalPages) {
                $this->result .= "<li><a href='{$this->link}/$afterPage{$this->var}'>$afterPage</a></li>";
            }
        }

        $this->result .= "<li><a href='{$this->link}/{$this->totalPages}{$this->var}'>Última</a></li>";

        $this->result .= "</ul>";
    }
}
