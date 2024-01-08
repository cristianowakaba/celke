<?php
if(!defined('C8L6K7E')){
    /*  header("Location:/"); */
 die("Erro: Página não encontrada!<br>");
 }
 $sidebar_active="";
 if(isset($this->data['sidebarActive'])){
    $sidebar_active=$this->data['sidebarActive'];
    
 }
?>
 <!-- Inicio Conteudo -->
 <div class="content">
        <!-- Inicio da Sidebar -->
        <div class="sidebar">

        <?php $dashboard ="";
        // //var_dump($sidebar_active);
        
        if($sidebar_active=="dashboard"){
            $dashboard="active";
            
            }?>

            <a href="<?php echo URLADM;?>dashboard/index" class="sidebar-nav <?php echo $dashboard;?>"><i class="icon fa-solid fa-house"></i><span>Dashboard</span></a>

            <?php $list_users="";
        
        if($sidebar_active=="list-users"){
            $list_users="active";
            }?>

          
            <a href="<?php echo URLADM;?>list-users/index" class="sidebar-nav <?php echo $list_users?>" ><i class="icon fa-solid fa-users"></i><span>Usuário</span></a>

            <?php $list_sits_users="";
        
        if($sidebar_active=="list-sits-users"){
            $list_sits_users = "active";
            }?>
            

            <a href="<?php echo URLADM; ?>list-sits-users/index" class="sidebar-nav <?php echo $list_sits_users; ?>"><i class="icon fa-solid fa-user-check"></i><span>Situação do Usuário</span></a>

            <?php $list_colors="";
        
        if($sidebar_active=="list-colors"){
            $list_colors = "active";
            }?>

            <a href="<?php echo URLADM; ?>list-colors/index" class="sidebar-nav <?php echo 
            $list_colors; ?>"><i class="icon fa-solid fa-palette"></i><span>Cores</span></a>

<?php $list_conf_email="";
        
        if($sidebar_active=="list-conf-emails"){
            $list_conf_email = "active";
            }?>

            
            <a href="<?php echo URLADM; ?>list-conf-emails/index" class="sidebar-nav <?php echo 
            $list_conf_email; ?>"><i class="icon fa-solid fa-envelope"></i><span>Configurações de E-mail</span></a>
           
            <a href="<?php echo URLADM;?>logout/index" class="sidebar-nav"><i class="icon fa-solid fa-arrow-right-from-bracket"></i><span>Sair</span></a>

        </div>
        <!-- Fim da Sidebar -->
<?php 
////var_dump($sidebar_active)?>





<!-- <a href="<?php echo URLADM;?>dashboard/index">Dashboard</a><br>
<a href="<?php echo URLADM;?>list-users/index">Usuários</a><br>
<a href="<?php echo URLADM; ?>list-sits-users/index">Situações</a><br>
<a href="<?php echo URLADM; ?>list-colors/index">Cores</a><br>
<a href="<?php echo URLADM; ?>list-conf-emails/index">Configurações de E-mail</a><br>
<a href="<?php echo URLADM;?>view-profile/index">Perfil</a><br>
<a href="<?php echo URLADM;?>logout/index">Sair</a><br> -->



<!-- 
<button class="dropdown-btn">
                <i class="icon fa-solid fa-users"></i><span>Dropdown</span><i class="fa-solid fa-caret-down"></i>
            </button>
            <div class="dropdown-container">
                <a href="#" class="sidebar-nav"><i class="icon fa-solid fa-user-check"></i><span>Link 1</span></a>
                <a href="sidebar_dropdown.html" class="sidebar-nav"><i class="icon fa-solid fa-user-gear"></i><span>Link 2</span></a>
                <a href="#" class="sidebar-nav"><i class="icon fa-solid fa-chalkboard-user"></i><span>Link 3</span></a>
            </div>

            <button class="dropdown-btn">
                <i class="icon fa-solid fa-globe"></i><span>Dropdown</span><i class="fa-solid fa-caret-down"></i>
            </button>
            <div class="dropdown-container">
                <a href="#" class="sidebar-nav"><i class="icon fa-solid fa-car-rear"></i><span>Link 1</span></a>
                <a href="#" class="sidebar-nav"><i class="icon fa-solid fa-bus"></i><span>Link 2</span></a>
                <a href="#" class="sidebar-nav"><i class="icon fa-solid fa-plane"></i><span>Link 3</span></a>
                <a href="sidebar_dropdown2.html" class="sidebar-nav"><i class="icon fa-solid fa-ship"></i><span>Link 4</span></a>
            </div>
 -->