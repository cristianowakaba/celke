<?php
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
 ?>
 <!-- Inicio do conteudo do administrativo -->
 <div class="wrapper">
            <div class="row">
                <div class="top-list">
                    <span class="title-content">Listar</span>
                    <div class="top-list-right">
                        <a href="formulario.html" class="btn-success">Cadastrar</a>
                        <!--<button type="button" class="btn-success"><i class="fa-solid fa-square-plus"></i></button>-->
                    </div>
                </div>
                
                <table class="table-list">
                    <thead class="list-head">
                        <tr>
                            <th class="list-head-content">ID</th>
                            <th class="list-head-content">Nome</th>
                            <th class="list-head-content table-sm-none">E-mail</th>
                            <th class="list-head-content table-sm-none">Coluna 1</th>
                            <th class="list-head-content table-md-none">Coluna 2</th>
                            <th class="list-head-content table-lg-none">Coluna 3</th>
                            <th class="list-head-content">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="list-body">
                        <tr>
                            <td class="list-body-content">1</td>
                            <td class="list-body-content">Cesar</td>
                            <td class="list-body-content table-sm-none">cesar@celke.com.br</td>
                            <td class="list-body-content table-sm-none">Coluna 1</td>
                            <td class="list-body-content table-md-none">Coluna 2</td>
                            <td class="list-body-content table-lg-none">Coluna 3</td>
                            <td class="list-body-content">
                                <!--<button type="button" class="btn-primary">Visualizar</button>
                                <button type="button" class="btn-warning">Editar</button>
                                <button type="button" class="btn-danger">Apagar</button>-->
                                <!--<button type="button" class="btn-primary"><i class="fa-solid fa-eye"></i></button>
                                <button type="button" class="btn-warning"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button type="button" class="btn-danger"><i class="fa-solid fa-trash-can"></i></button>-->
                                <div class="dropdown-action">
                                    <button onclick="actionDropdown(1)" class="dropdown-btn-action">Ações</button>
                                    <div id="actionDropdown1" class="dropdown-action-item">
                                        <a href="visualizar.html">Visualizar</a>
                                        <a href="formulario.html">Editar</a>
                                        <a href="#">Apagar</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="list-body-content">2</td>
                            <td class="list-body-content">Cesar 2</td>
                            <td class="list-body-content table-sm-none">cesar2@celke.com.br</td>
                            <td class="list-body-content table-sm-none">Coluna 1</td>
                            <td class="list-body-content table-md-none">Coluna 2</td>
                            <td class="list-body-content table-lg-none">Coluna 3</td>
                            <td class="list-body-content">
                                <!--<button type="button" class="btn-primary">Visualizar</button>
                                <button type="button" class="btn-warning">Editar</button>
                                <button type="button" class="btn-danger">Apagar</button>-->
                                <!--<button type="button" class="btn-primary"><i class="fa-solid fa-eye"></i></button>
                                <button type="button" class="btn-warning"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button type="button" class="btn-danger"><i class="fa-solid fa-trash-can"></i></button>-->
                                <div class="dropdown-action">
                                    <button onclick="actionDropdown(2)" class="dropdown-btn-action">Ações</button>
                                    <div id="actionDropdown2" class="dropdown-action-item">
                                        <a href="visualizar.html">Visualizar</a>
                                        <a href="formulario.html">Editar</a>
                                        <a href="#">Apagar</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="list-body-content">3</td>
                            <td class="list-body-content">Cesar 3</td>
                            <td class="list-body-content table-sm-none">cesar3@celke.com.br</td>
                            <td class="list-body-content table-sm-none">Coluna 1</td>
                            <td class="list-body-content table-md-none">Coluna 2</td>
                            <td class="list-body-content table-lg-none">Coluna 3</td>
                            <td class="list-body-content">
                                <!--<button type="button" class="btn-primary">Visualizar</button>
                                <button type="button" class="btn-warning">Editar</button>
                                <button type="button" class="btn-danger">Apagar</button>-->
                                <!--<button type="button" class="btn-primary"><i class="fa-solid fa-eye"></i></button>
                                <button type="button" class="btn-warning"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button type="button" class="btn-danger"><i class="fa-solid fa-trash-can"></i></button>-->
                                <div class="dropdown-action">
                                    <button onclick="actionDropdown(3)" class="dropdown-btn-action">Ações</button>
                                    <div id="actionDropdown3" class="dropdown-action-item">
                                        <a href="visualizar.html">Visualizar</a>
                                        <a href="formulario.html">Editar</a>
                                        <a href="#">Apagar</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="content-pagination">
                    <div class="pagination">
                        <a href="#">&laquo;</a>
                        <a href="#">1</a>
                        <a href="#">2</a>
                        <a href="#" class="active">3</a>
                        <a href="#">4</a>
                        <a href="#">5</a>
                        <a href="#">&raquo;</a>
                    </div>
                </div>

                <table class="table-list">
                    <thead class="list-head">
                        <tr>
                            <th class="list-head-content">ID</th>
                            <th class="list-head-content">Nome</th>
                            <th class="list-head-content table-sm-none">E-mail</th>
                            <th class="list-head-content">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="list-body">
                        <tr>
                            <td class="list-body-content">1</td>
                            <td class="list-body-content">Cesar</td>
                            <td class="list-body-content table-sm-none">cesar@celke.com.br</td>
                            <td class="list-body-content">
                                <button type="button" class="btn-primary">Visualizar</button>
                                <button type="button" class="btn-warning">Editar</button>
                                <button type="button" class="btn-danger">Apagar</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="list-body-content">2</td>
                            <td class="list-body-content">Cesar 2</td>
                            <td class="list-body-content table-sm-none">cesar2@celke.com.br</td>
                            <td class="list-body-content">
                                <button type="button" class="btn-primary">Visualizar</button>
                                <button type="button" class="btn-warning">Editar</button>
                                <button type="button" class="btn-danger">Apagar</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="list-body-content">3</td>
                            <td class="list-body-content">Cesar 3</td>
                            <td class="list-body-content table-sm-none">cesar3@celke.com.br</td>
                            <td class="list-body-content">
                                <button type="button" class="btn-primary">Visualizar</button>
                                <button type="button" class="btn-warning">Editar</button>
                                <button type="button" class="btn-danger">Apagar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="content-pagination">
                    <div class="pagination">
                        <a href="#">&laquo;</a>
                        <a href="#">1</a>
                        <a href="#">2</a>
                        <a href="#" class="active">3</a>
                        <a href="#">4</a>
                        <a href="#">5</a>
                        <a href="#">&raquo;</a>
                    </div>
                </div>

                <table class="table-list">
                    <thead class="list-head">
                        <tr>
                            <th class="list-head-content">ID</th>
                            <th class="list-head-content">Nome</th>
                            <th class="list-head-content table-sm-none">E-mail</th>
                            <th class="list-head-content table-sm-none">Coluna 1</th>
                            <th class="list-head-content">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="list-body">
                        <tr>
                            <td class="list-body-content">1</td>
                            <td class="list-body-content">Cesar</td>
                            <td class="list-body-content table-sm-none">cesar@celke.com.br</td>
                            <td class="list-body-content table-sm-none">Coluna 1</td>
                            <td class="list-body-content">
                                <button type="button" class="btn-primary"><i class="fa-solid fa-eye"></i></button>
                                <button type="button" class="btn-warning"><i
                                        class="fa-solid fa-pen-to-square"></i></button>
                                <button type="button" class="btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td class="list-body-content">2</td>
                            <td class="list-body-content">Cesar 2</td>
                            <td class="list-body-content table-sm-none">cesar2@celke.com.br</td>
                            <td class="list-body-content table-sm-none">Coluna 1</td>
                            <td class="list-body-content">
                                <button type="button" class="btn-primary"><i class="fa-solid fa-eye"></i></button>
                                <button type="button" class="btn-warning"><i
                                        class="fa-solid fa-pen-to-square"></i></button>
                                <button type="button" class="btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td class="list-body-content">3</td>
                            <td class="list-body-content">Cesar 3</td>
                            <td class="list-body-content table-sm-none">cesar3@celke.com.br</td>
                            <td class="list-body-content table-sm-none">Coluna 1</td>
                            <td class="list-body-content">
                                <button type="button" class="btn-primary"><i class="fa-solid fa-eye"></i></button>
                                <button type="button" class="btn-warning"><i
                                        class="fa-solid fa-pen-to-square"></i></button>
                                <button type="button" class="btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="content-pagination">
                    <div class="pagination">
                        <a href="#">&laquo;</a>
                        <a href="#">1</a>
                        <a href="#">2</a>
                        <a href="#" class="active">3</a>
                        <a href="#">4</a>
                        <a href="#">5</a>
                        <a href="#">&raquo;</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fim do conteudo do administrativo -->
 <?
echo "<h2>Listar Usuários</h2>";
echo "<a href='".URLADM."add-users/index'>Cadastrar</a><br><br>";
// //var_dump($this->data['listUsers']);
if(isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}

foreach($this->data['listUsers'] as $user){

// //var_dump($user);
    extract($user);
    echo "ID:  <br>";
    echo "Nome: $name_usr <br>";
    echo "email: $email <br>";
    echo "Situação:<span style='color:$color'>$name_sit </span> <br>";
    //quando clicar no link, manda o id como parametro
    echo "<a href='".URLADM."view-users/index/$id'>Visualizar</a><br>";
    echo "<a href='".URLADM."edit-users/index/$id'>Editar</a><br>";
    echo "<a href='".URLADM."delete-users/index/$id' onclick= 'return confirm(\"Tem certeza que deseja excluir este registro?\")'>Apagar</a><br>";
/* ?>

outro jeito de fazer a funcão onclic fora do php

<a href="<?php echo URLADM .'delete-users/index/'.$id ?>" onclick="return confirm('Tem certeza que deseja excluir este registro?')">Apagar</a>

<?php */
    ?
   


    // echo "ID:".$user['id']."<br>";
    // echo "name:".$user['name']."<br>";
    // echo "email:".$user['email']."<br><hr>";
}
echo $this->data['pagination'];