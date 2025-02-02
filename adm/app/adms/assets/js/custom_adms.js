const formNewUser = document.getElementById("form-new-user");
if (formNewUser) {
    formNewUser.addEventListener("submit", async(e) => {
        //Receber o valor do campo
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
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo e-mail!</p>";
            return;
        }

        //Receber o valor do campo
        var password = document.querySelector("#password").value;
        // Verificar se o campo esta vazio
        if (password === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo senha!</p>";
            return;
        }
        //verificar se o campo senha possui 6 caracteres
        if (password.length<6) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: a senha deve ter no minimo 6 caracteres!</p>";
            return;
        }
           //verificar se o campo senha não possui  numeros repetidos
           if (password.match(/([1-9]+)\1{1,}/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: a senha não deve ter numero repetido!</p>";
            return;
        }
           //verificar se o campo senha possui letras. if !password se não existir letra apresenta a msg
           if (!password.match(/[A-Za-z]/)) {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: a senha deve ter pelo menos uma letra!</p>";
            return;
        }
    });
}

const formLogin = document.getElementById("form-login");
if (formLogin) {
    formLogin.addEventListener("submit", async(e) => {

        //Receber o valor do campo
        var user = document.querySelector("#user").value;
        // Verificar se o campo esta vazio
        if (user === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo usuário!</p>";
            return;
        }

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
//verifica se o campo estiver vazio aparece umamsg de erro
const formNewConfEmail = document.getElementById("form-new-conf-email");
if (formNewConfEmail) {
    formNewConfEmail.addEventListener("submit", async(e) => {

        //Receber o valor do campo
        var email = document.querySelector("#email").value;
        // Verificar se o campo esta vazio
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo e-mail!</p>";
            return;
        }
      
    });
}
//verifica se o campo estiver vazio aparece uma msg de erro
/**const formRecoverPass = document.getElementById("form-recover-pass");
if (formRecoverPass) {
    formRecoverPass.addEventListener("submit", async(e) => {

        //Receber o valor do campo
        var email = document.querySelector("#email").value;
        // Verificar se o campo esta vazio
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo e-mail!</p>";
            return;
        }
      
    }); 
}*/