// Permitir retorno no navegador no formulário após o erro
if (window.history.replaceState) {
    // Substituir a entrada atual no histórico por uma entrada vazia para evitar o retorno após um erro
    window.history.replaceState(null, null, window.location.href);
}

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
        document.getElementById("msgViewStrength").innerHTML = "<p class='alert-danger'>Senha Fraca</p>";
    } else if ((strength >= 30) && (strength < 50)) {
        document.getElementById("msgViewStrength").innerHTML = "<p class='alert-warning'>Senha Média</p>";
    } else if ((strength >= 50) && (strength < 69)) {
        document.getElementById("msgViewStrength").innerHTML = "<p class='alert-primary'>Senha boa</p>";
    } else if (strength >= 70) {
        document.getElementById("msgViewStrength").innerHTML = "<p class='alert-success'>Senha Forte</p>";
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
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo nome!</p>";
            return;
        }

        // Obter o valor do campo de e-mail
        var email = document.querySelector("#email").value;

        // Verificar se o campo de e-mail está vazio e exibir mensagem de erro
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML ="<p class='alert-danger'>Erro: Necessário preencher o campo e-mail!</p>";
            return;
        }

        // Obter o valor do campo de senha
        var password = document.querySelector("#password").value;

        // Verificar se o campo de senha está vazio e exibir mensagem de erro
        if (password === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo senha!</p>";
            return;
        }

        // Verificar se a senha tem pelo menos 6 caracteres e exibir mensagem de erro
        if (password.length < 6) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: A senha deve ter no mínimo 6 caracteres!</p>";
            return;
        }

        // Verificar se a senha não possui números repetidos e exibir mensagem de erro
        if (password.match(/([1-9]+)\1{1,}/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: A senha não deve ter número repetido!</p>";
            return;
        }

        // Verificar se a senha possui pelo menos uma letra e exibir mensagem de erro
        if (!password.match(/[A-Za-z]/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: A senha deve ter pelo menos uma letra!</p>";
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
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo usuário!</p>";
            return;
        }

        // Receber o valor do campo de senha
        var password = document.querySelector("#password").value;
        // Verificar se o campo de senha está vazio e exibir mensagem de erro
        if (password === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo senha!</p>";
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
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo e-mail!</p>";
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
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo e-mail!</p>";
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
            document.getElementById("msg").innerHTML = "<p class='alert-danger'>Erro: Necessário preencher o campo senha!</p>";
            return;
        } else {
            // Limpar mensagem de erro se todas as validações passarem
            document.getElementById("msg").innerHTML = "<p></p>";
            return;
        }
    });
}
