/*
    tipo 0 = visível
    tipo 1 = esconder
*/

function mudarTipoLogin(elemento) {
    if (elemento.type == 'password') {
        document.getElementById('userPassword').type = 'text'
    } else {
        document.getElementById('userPassword').type = 'password'
    }
}

function mudarTipoCriarConta (id) {
    if (id == 1) {
        document.getElementById('userPassord')
        if (document.getElementById('userPassord').type == 'pasword') {
            document.getElementById('userPassord').type = 'text'
        } else {
            document.getElementById('userPassord').type = 'password'
        }
    }
    if (id == 2) {
        if (document.getElementById('userPassordConfirm').type == 'password') {
            document.getElementById('userPassordConfirm').type = 'text'
        } else {
            document.getElementById('userPassordConfirm').type = 'password'
        }
    }
}