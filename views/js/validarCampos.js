function validarCampos() {
    const nome = login.userName.value || false
    const senha = login.userPassword.value || false

    if ((!nome) || (!senha)) {
        // erro
        document.getElementById('aviso').classList.add('avisoOn')
        document.getElementById('aviso').classList.remove('avisoOff')
        console.log("1", nome, senha);
    } else {
        // submit
        document.getElementById('btSb').type = "submit"
        document.getElementById('aviso').click()
    }
}