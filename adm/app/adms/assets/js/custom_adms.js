// Permitir retorno no navegador no formulário após o erro
if (window.history.replaceState) {
    // Substituir a entrada atual no histórico por uma entrada vazia para evitar o retorno após um erro
    window.history.replaceState(null, null, window.location.href);
}
/* Inicio Dropdown Navbar */
/* let notification = document.querySelector(".notification"); */
let avatar = document.querySelector(".avatar");

dropMenu(avatar);
/* dropMenu(notification); */

function dropMenu(selector) {
    //console.log(selector);
    selector.addEventListener("click", () => {
        let dropdownMenu = selector.querySelector(".dropdown-menu");
        dropdownMenu.classList.contains("active") ? dropdownMenu.classList.remove("active") : dropdownMenu.classList.add("active");
    });
}
/* Fim Dropdown Navbar */

/* Inicio Sidebar Toggle / bars */
let sidebar = document.querySelector(".sidebar");
let bars = document.querySelector(".bars");

bars.addEventListener("click", () => {
    sidebar.classList.contains("active") ? sidebar.classList.remove("active") : sidebar.classList.add("active");
});

window.matchMedia("(max-width: 768px)").matches ? sidebar.classList.remove("active") : sidebar.classList.add("active");
/* Fim Sidebar Toggle / bars */

/** inicio botão dropdown do listar */
function actionDropdown(id) {
    closeDropdownAction();
    document.getElementById("actionDropdown" + id).classList.toggle("show-dropdown-action");
}

window.onclick = function (event) {
    if (!event.target.matches(".dropdown-btn-action")) {
        /*document.getElementById("actionDropdown").classList.remove("show-dropdown-action");*/
        closeDropdownAction();
    }
}

function closeDropdownAction() {
    var dropdowns = document.getElementsByClassName("dropdown-action-item");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i]
        if (openDropdown.classList.contains("show-dropdown-action")) {
            openDropdown.classList.remove("show-dropdown-action");
        }
    }
}


/* Inicio dropdown sidebar */

var dropdownSidebar = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdownSidebar.length; i++) {
    dropdownSidebar[i].addEventListener("click", function () {
        this.classList.toggle("active");
        var dropdownContent = this.nextElementSibling;
        if (dropdownContent.style.display === "block") {
            dropdownContent.style.display = "none";
        } else {
            dropdownContent.style.display = "block";
        }
    });
}
/* Fim dropdown sidebar */

// Calcular a força da senha
function passwordStrength() {
    // Obter o valor do campo de senha
    var password = document.getElementById("password").value;
    var strength = 0;

    // Verificar o comprimento da senha e atribuir pontos de acordo
    if ((password.length >= 6) && (password.length <= 7)) {
        strength += 10;
    } else if (password.length > 7) {
        strength += 25;
    }

    // Verificar se a senha contém letras minúsculas e atribuir pontos
    if ((password.length >= 6) && (password.match(/[a-z]+/))) {
        strength += 10;
    }

    // Verificar se a senha contém letras maiúsculas e atribuir pontos
    if ((password.length >= 7) && (password.match(/[A-Z]+/))) {
        strength += 20;
    }

    // Verificar se a senha contém caracteres especiais e atribuir pontos
    if ((password.length >= 8) && (password.match(/[@#$%;*]+/))) {
        strength += 25;
    }

    // Verificar se a senha contém números repetidos e deduzir pontos
    if (password.match(/([1-9]+)\1{1,}/)) {
        strength -= 25;
    }

    // Chamar a função para exibir a força da senha
    viewStrength(strength);
}

// Exibir a força da senha em um elemento HTML
function viewStrength(strength) {
    if (strength < 30) {
        document.getElementById("msgViewStrength").innerHTML = "<p style='color: #f00;'>Senha Fraca</p>";
    } else if ((strength >= 30) && (strength < 50)) {
        document.getElementById("msgViewStrength").innerHTML = "<p style='color: #ff8c00;'>Senha Média</p>";
    } else if ((strength >= 50) && (strength < 69)) {
        document.getElementById("msgViewStrength").innerHTML = "<p style='color: #7cfc00;'>Senha Boa</p>";
    } else if (strength >= 70) {
        document.getElementById("msgViewStrength").innerHTML = "<p style='color: #008000;'>Senha Forte</p>";
    } else {
        document.getElementById("msgViewStrength").innerHTML = "";
    }
}

// Validar o formulário no evento de envio
const formNewUser = document.getElementById("form-new-user");
if (formNewUser) {
    formNewUser.addEventListener("submit", async (e) => {
        // Obter o valor do campo de nome
        var name = document.querySelector("#name").value;

        // Verificar se o campo de nome está vazio e exibir mensagem de erro
        if (name === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }

        // Obter o valor do campo de e-mail
        var email = document.querySelector("#email").value;

        // Verificar se o campo de e-mail está vazio e exibir mensagem de erro
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo e-mail!</p>";
            return;
        }

        // Obter o valor do campo de senha
        var password = document.querySelector("#password").value;

        // Verificar se o campo de senha está vazio e exibir mensagem de erro
        if (password === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo senha!</p>";
            return;
        }

        // Verificar se a senha tem pelo menos 6 caracteres e exibir mensagem de erro
        if (password.length < 6) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: A senha deve ter no mínimo 6 caracteres!</p>";
            return;
        }

        // Verificar se a senha não possui números repetidos e exibir mensagem de erro
        if (password.match(/([1-9]+)\1{1,}/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: A senha não deve ter número repetido!</p>";
            return;
        }

        // Verificar se a senha possui pelo menos uma letra e exibir mensagem de erro
        if (!password.match(/[A-Za-z]/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: A senha deve ter pelo menos uma letra!</p>";
            return;
        } else {
            // Limpar mensagem de erro se todas as validações passarem
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}


// Formulário de Login
const formLogin = document.getElementById("form-login");
if (formLogin) {
    formLogin.addEventListener("submit", async (e) => {
        // Receber o valor do campo de usuário
        var user = document.querySelector("#user").value;
        // Verificar se o campo de usuário está vazio e exibir mensagem de erro
        if (user === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo usuário!</p>";
            return;
        }

        // Receber o valor do campo de senha
        var password = document.querySelector("#password").value;
        // Verificar se o campo de senha está vazio e exibir mensagem de erro
        if (password === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo senha!</p>";
            return;
        } else {
            // Limpar mensagem de erro se todas as validações passarem
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

// Formulário de Confirmação de Email
const formNewConfEmail = document.getElementById("form-new-conf-email");
if (formNewConfEmail) {
    formNewConfEmail.addEventListener("submit", async (e) => {
        // Receber o valor do campo de e-mail
        var email = document.querySelector("#email").value;
        // Verificar se o campo de e-mail está vazio e exibir mensagem de erro
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo e-mail!</p>";
            return;
        } else {
            // Limpar mensagem de erro se todas as validações passarem
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

// Formulário de Recuperação de Senha
const formRecoverPass = document.getElementById("form-recover-pass");
if (formRecoverPass) {
    formRecoverPass.addEventListener("submit", async (e) => {
        // Receber o valor do campo de e-mail
        var email = document.querySelector("#email").value;
        // Verificar se o campo de e-mail está vazio e exibir mensagem de erro
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo e-mail!</p>";
            return;
        } else {
            // Limpar mensagem de erro se todas as validações passarem
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

// Formulário de Atualização de Senha
const formUpdatePass = document.getElementById("form-update-pass");
if (formUpdatePass) {
    formUpdatePass.addEventListener("submit", async (e) => {
        // Receber o valor do campo de senha
        var email = document.querySelector("#password").value;
        // Verificar se o campo de senha está vazio e exibir mensagem de erro
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo senha!</p>";
            return;
        } else {
            // Limpar mensagem de erro se todas as validações passarem
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

// Formulário de Adição de Usuário
const formAddUser = document.getElementById("form-add-user");
if (formAddUser) {
    formAddUser.addEventListener("submit", async (e) => {
        // Receber o valor do campo de nome
        var name = document.querySelector("#name").value;
        // Verificar se o campo de nome está vazio e exibir mensagem de erro
        if (name === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }

        // Receber o valor do campo de e-mail
        var email = document.querySelector("#email").value;
        // Verificar se o campo de e-mail está vazio e exibir mensagem de erro
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo e-mail!</p>";
            return;
        }

        // Receber o valor do campo de usuário
        var user = document.querySelector("#user").value;
        // Verificar se o campo de usuário está vazio e exibir mensagem de erro
        if (user === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo usuário!</p>";
            return;
        }

        // Receber o valor do campo de situação
        var adms_sits_user_id = document.querySelector("#adms_sits_user_id").value;
        // Verificar se o campo de situação está vazio e exibir mensagem de erro
        if (adms_sits_user_id === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo situação!</p>";
            return;
        }

        // Receber o valor do campo de senha
        var password = document.querySelector("#password").value;
        // Verificar se o campo de senha está vazio e exibir mensagem de erro
        if (password === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo senha!</p>";
            return;
        }

        // Verificar se o campo senha possui 6 caracteres e exibir mensagem de erro
        if (password.length < 6) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: A senha deve ter no mínimo 6 caracteres!</p>";
            return;
        }

        // Verificar se o campo senha não possui números repetidos e exibir mensagem de erro
        if (password.match(/([1-9]+)\1{1,}/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: A senha não deve ter número repetido!</p>";
            return;
        }

        // Verificar se o campo senha possui letras e exibir mensagem de erro
        if (!password.match(/[A-Za-z]/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: A senha deve ter pelo menos uma letra!</p>";
            return;
        } else {
            // Limpar mensagem de erro se todas as validações passarem
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

// Formulário de Edição de Usuário
const formEditUser = document.getElementById("form-edit-user");
if (formEditUser) {
    formEditUser.addEventListener("submit", async (e) => {
        // Receber o valor do campo de nome
        var name = document.querySelector("#name").value;
        // Verificar se o campo de nome está vazio e exibir mensagem de erro
        if (name === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }

        // Receber o valor do campo de e-mail
        var email = document.querySelector("#email").value;
        // Verificar se o campo de e-mail está vazio e exibir mensagem de erro
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo e-mail!</p>";
            return;
        }

        // Receber o valor do campo de usuário
        var user = document.querySelector("#user").value;
        // Verificar se o campo de usuário está vazio e exibir mensagem de erro
        if (user === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo usuário!</p>";
            return;
        }

        // Receber o valor do campo de situação
        var adms_sits_user_id = document.querySelector("#adms_sits_user_id").value;
        // Verificar se o campo de situação está vazio e exibir mensagem de erro
        if (adms_sits_user_id === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo situação!</p>";
            return;
        } else {
            // Limpar mensagem de erro se todas as validações passarem
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}


// Formulário de Edição de Senha do Usuário
const formEditUserPass = document.getElementById("form-edit-user-pass");
if (formEditUserPass) {
    formEditUserPass.addEventListener("submit", async (e) => {

        // Receber o valor do campo de senha
        var password = document.querySelector("#password").value;
        // Verificar se o campo de senha está vazio e exibir mensagem de erro
        if (password === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo senha!</p>";
            return;
        }
        // Verificar se o campo senha possui 6 caracteres e exibir mensagem de erro
        if (password.length < 6) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: A senha deve ter no mínimo 6 caracteres!</p>";
            return;
        }
        // Verificar se o campo senha não possui números repetidos e exibir mensagem de erro
        if (password.match(/([1-9]+)\1{1,}/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: A senha não deve ter número repetido!</p>";
            return;
        }
        // Verificar se o campo senha possui letras e exibir mensagem de erro
        if (!password.match(/[A-Za-z]/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: A senha deve ter pelo menos uma letra!</p>";
            return;
        } else {
            // Limpar mensagem de erro se todas as validações passarem
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

// Formulário de Edição de Perfil do Usuário
const formEditProfile = document.getElementById("form-edit-profile");
if (formEditProfile) {
    formEditProfile.addEventListener("submit", async (e) => {
        // Receber o valor do campo de nome
        var name = document.querySelector("#name").value;
        // Verificar se o campo de nome está vazio e exibir mensagem de erro
        if (name === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }

        // Receber o valor do campo de e-mail
        var email = document.querySelector("#email").value;
        // Verificar se o campo de e-mail está vazio e exibir mensagem de erro
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo e-mail!</p>";
            return;
        }

        // Receber o valor do campo de usuário
        var user = document.querySelector("#user").value;
        // Verificar se o campo de usuário está vazio e exibir mensagem de erro
        if (user === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo usuário!</p>";
            return;
        } else {
            // Limpar mensagem de erro se todas as validações passarem
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

// Formulário de Edição de Senha do Perfil
const formEditProfPass = document.getElementById("form-edit-prof-pass");
if (formEditProfPass) {
    formEditProfPass.addEventListener("submit", async (e) => {

        // Receber o valor do campo de senha
        var password = document.querySelector("#password").value;
        // Verificar se o campo de senha está vazio e exibir mensagem de erro
        if (password === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo senha!</p>";
            return;
        }
        // Verificar se o campo senha possui 6 caracteres e exibir mensagem de erro
        if (password.length < 6) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: A senha deve ter no mínimo 6 caracteres!</p>";
            return;
        }
        // Verificar se o campo senha não possui números repetidos e exibir mensagem de erro
        if (password.match(/([1-9]+)\1{1,}/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: A senha não deve ter número repetido!</p>";
            return;
        }
        // Verificar se o campo senha possui letras e exibir mensagem de erro
        if (!password.match(/[A-Za-z]/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: A senha deve ter pelo menos uma letra!</p>";
            return;
        } else {
            // Limpar mensagem de erro se todas as validações passarem
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

// Formulário de Edição de Imagem do Usuário
const formEditUserImg = document.getElementById("form-edit-user-img");
if (formEditUserImg) {
    formEditUserImg.addEventListener("submit", async (e) => {
        // Receber o valor do campo de nova imagem
        var new_image = document.querySelector("#new_image").value;
        // Verificar se o campo de nova imagem está vazio e exibir mensagem de erro
        if (new_image === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário selecionar uma imagem!</p>";
            return;
        } else {
            // Limpar mensagem de erro se todas as validações passarem
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

// Formulário de Edição de Imagem do Perfil
const formEditProfImg = document.getElementById("form-edit-prof-img");
if (formEditProfImg) {
    formEditProfImg.addEventListener("submit", async (e) => {
        // Receber o valor do campo de nova imagem
        var new_image = document.querySelector("#new_image").value;
        // Verificar se o campo de nova imagem está vazio e exibir mensagem de erro
        if (new_image === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário selecionar uma imagem!</p>";
            return;
        } else {
            // Limpar mensagem de erro se todas as validações passarem
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}

function inputFileValImg() {
    // Receber o valor do campo
    var new_image = document.querySelector("#new_image");

    // Obter o caminho do arquivo a partir do valor do campo
    var filePath = new_image.value;

    // Definir uma expressão regular para verificar as extensões permitidas (.jpg, .jpeg, .png)
    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    // Verificar se a extensão do arquivo corresponde às extensões permitidas
    if (!allowedExtensions.exec(filePath)) {
        // Se a extensão não for permitida, limpar o campo e exibir uma mensagem de erro
        new_image.value = '';
        document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário selecionar uma imagem JPG ou PNG!</p>";
        return;
    } else {
        previewImage(new_image)
        // Se a extensão for permitida, limpar a mensagem de erro (se houver) e retornar
        document.getElementById("msg").innerHTML = "<p></p>";
        return;
    }
}
function previewImage(new_image) {
    if ((new_image.files) && (new_image.files[0])) {
        //FileReader(); ler conteúdo dos arquivos
        var reader = new FileReader();
        //onload- dispara um evento quando qualquer elemento for carregado
        reader.onload = function (e) {
            document.getElementById('preview-img').innerHTML = "<img src='" + e.target.result + "' alt='imagem' style='width: 100px;'>";
        }
    }
    //readAsDataURL- retorna os dados do formato blob como uma URL de dados Blob representa um marquivo
    reader.readAsDataURL(new_image.files[0])
}

const formEditSitUser = document.getElementById("form-add-sit-user");
if (formEditSitUser) {
    formEditSitUser.addEventListener("submit", async(e) => {
        //Receber o valor do campo
        var name = document.querySelector("#name").value;
        // Verificar se o campo esta vazio
        if (name === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }

        //Receber o valor do campo
        var adms_color_id = document.querySelector("#adms_color_id").value;
        // Verificar se o campo esta vazio
        if (adms_color_id === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo Cor!</p>";
            return;
        } else {
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}
const formAddColors = document.getElementById("form-add-color");
if (formAddColors) {
    formAddColors.addEventListener("submit", async(e) => {
        //Receber o valor do campo
        var name = document.querySelector("#name").value;
        // Verificar se o campo esta vazio
        if (name === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }

        //Receber o valor do campo
        var color = document.querySelector("#color").value;
        // Verificar se o campo esta vazio
        if (color === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo cor!</p>";
            return;
        }
    });
}
    const formAddConfEmails = document.getElementById("form-add-conf-emails");
if (formAddConfEmails) {
    formAddConfEmails.addEventListener("submit", async(e) => {
        //Receber o valor do campo
        var title = document.querySelector("#title").value;
        // Verificar se o campo esta vazio
        if (title === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo título!</p>";
            return;
        }
        var name = document.querySelector("#name").value;
        // Verificar se o campo esta vazio
        if (name === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }

        //Receber o valor do campo
        var email = document.querySelector("#email").value;
        // Verificar se o campo esta vazio
        if (email=== "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo email!</p>";
            return;
        }
        //Receber o valor do campo
        var host= document.querySelector("#host").value;
        // Verificar se o campo esta vazio
        if (host=== "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo host!</p>";
            return;
        }
        var username= document.querySelector("#username").value;
        // Verificar se o campo esta vazio
        if (username=== "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo username!</p>";
            return;
        }
        var password= document.querySelector("#password").value;
        // Verificar se o campo esta vazio
        if (password=== "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo password</p>";
            return;
        }
        var smtpsecure= document.querySelector("#smtpsecure").value;
        // Verificar se o campo esta vazio
        if (smtpsecure=== "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo smtpsecure</p>";
            return;
        }
        var port= document.querySelector("#port").value;
        // Verificar se o campo esta vazio
        if (port=== "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo porta</p>";
            return;
        }
    });
}
const formEditConfEmails = document.getElementById("form-edit-conf-emails");
if (formEditConfEmails) {
    formEditConfEmails.addEventListener("submit", async(e) => {
        //Receber o valor do campo
        var title = document.querySelector("#title").value;
        // Verificar se o campo esta vazio
        if (title === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo titulo!</p>";
            return;
        }

        var name = document.querySelector("#name").value;
        // Verificar se o campo esta vazio
        if (name === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }
        
        var email = document.querySelector("#email").value;
        // Verificar se o campo esta vazio
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo email!</p>";
            return;
        }

        var host = document.querySelector("#host").value;
        // Verificar se o campo esta vazio
        if (host === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo host!</p>";
            return;
        }

        var username = document.querySelector("#username").value;
        // Verificar se o campo esta vazio
        if (username === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo usuário!</p>";
            return;
        }

        var smtpsecure = document.querySelector("#smtpsecure").value;
        // Verificar se o campo esta vazio
        if (smtpsecure === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo smtp!</p>";
            return;
        }

        var port = document.querySelector("#port").value;
        // Verificar se o campo esta vazio
        if (port === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo porta!</p>";
            return;
        }
    });
}

const formEditConfEmailsPass = document.getElementById("form-edit-conf-emails-pass");
if (formEditConfEmailsPass) {
    formEditConfEmailsPass.addEventListener("submit", async(e) => {
        //Receber o valor do campo
        var password = document.querySelector("#password").value;
        // Verificar se o campo esta vazio
        if (password === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo senha!</p>";
            return;
        }
    });
}