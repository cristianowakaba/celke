//permitir retorno no navegador
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.herf);
}

//calcular a forca da senha
function passwordStrength() {
    var password = document.getElementById("password").value;

    var strength = 0;
    if ((password.length >= 6) && (password.length <= 7)) {
        strength += 10;
    } else if (password.length > 7) {
        strength += 25;
    }
    if ((password.length >= 6) && (password.match(/[a-z]+/))) {
        strength += 10;
    }
    if ((password.length >= 7) && (password.match(/[A-Z]+/))) {
        strength += 20;
    }
    if ((password.length >= 8) && (password.match(/[@#$%;*]+/))) {
        strength += 25;
    }
    if (password.match(/([1-9]+)\1{1,}/)) {
        strength -= 25;
    }

    viewStrenght(strength);
}

function viewStrenght(strength) {
    //imprimir a força da senha
    if (strength < 30) {
        document.getElementById("msgViewStrength").innerHTML = "<p style='color : #f00;'>Senha Fraca</p>"
    } else if ((strength >= 30) && (strength < 50)) {
        document.getElementById("msgViewStrength").innerHTML = "<p style='color : #ff8c00;'>Senha Média</p>"
    } else if ((strength >= 50) && (strength < 70)) {
        document.getElementById("msgViewStrength").innerHTML = "<p style='color : #7cfc00;'>Senha Boa</p>"
    } else if (strength >= 70) {
        document.getElementById("msgViewStrength").innerHTML = "<p style='color : #008000;'>Senha Forte</p>"
    } else {
        document.getElementById("msgViewStrength").innerHTML = "";
    }

}
const formNewUser = document.getElementById("form-new-user");
if (formNewUser) {
    formNewUser.addEventListener("submit", async (e) => {
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
        if (password.length < 6) {
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
    formLogin.addEventListener("submit", async (e) => {

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
    formNewConfEmail.addEventListener("submit", async (e) => {

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
const formUpdatePass = document.getElementById("form-update-pass");
if (formUpdatePass) {
    formUpdatePass.addEventListener("submit", async (e) => {

        //Receber o valor do campo
        var email = document.querySelector("#password").value;
        // Verificar se o campo esta vazio
        if (email === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo senha!</p>";
            return;
        }

    });
}

const formAddUser = document.getElementById("form-add-user");
if (formAddUser) {
    formAddUser.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var name = document.querySelector("#name").value;
        // Verificar se o campo esta vazio
        if (name === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo nome!.</p>";
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
        var user = document.querySelector("#user").value;
        // Verificar se o campo esta vazio
        if (user === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo Usuário!</p>";
            return;
        }
           //Receber o valor do campo
           var adms_sits_user_id = document.querySelector("#adms_sits_user_id").value;
           // Verificar se o campo esta vazio
           if (adms_sits_user_id === "") {
               e.preventDefault();
               document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo Situação!</p>";
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
        if (password.length < 6) {
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

const formEditUser = document.getElementById("form-edit-user");
if (formEditUser) {
    formEditUser.addEventListener("submit", async (e) => {
        //Receber o valor do campo
        var name = document.querySelector("#name").value;
        // Verificar se o campo esta vazio
        if (name === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo nome!.</p>";
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
        var user = document.querySelector("#user").value;
        // Verificar se o campo esta vazio
        if (user === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo Usuário!</p>";
            return;
        }
            //Receber o valor do campo
            var adms_sits_user_id = document.querySelector("#adms_sits_user_id").value;
            // Verificar se o campo esta vazio
            if (adms_sits_user_id === "") {
                e.preventDefault();
                document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo Situação!</p>";
                return;
            }
    


    });
    
}
const formEditUserPass = document.getElementById("form-edit-user-pass");
if (formEditUserPass ) {
    formEditUserPass .addEventListener("submit", async (e) => {
       

        //Receber o valor do campo
        var password = document.querySelector("#password").value;
        // Verificar se o campo esta vazio
        if (password === "") {
            e.preventDefault();
            document.getElementById("msg").innerHTML = "<p style='color: #f00;'>Erro: Necessário preencher o campo senha!</p>";
            return;
        }
        //verificar se o campo senha possui 6 caracteres
        if (password.length < 6) {
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
