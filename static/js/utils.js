function confirmarExclusao(){
    return confirm('Deseja realmente excluir?')
}

function openModal(){
    document.getElementsByClassName('modal')[0].style.display = "flex";
}

function closeModal(){
    document.getElementsByClassName('modal')[0].style.display = "none";
}

function validarForm(form){
    let message = "";
    let retorno = true;

    if(form.nome != undefined){
        if(form.nome.value==""){
            message = "Nome não preechido!";
            retorno = false;
        }
    }

    if(retorno){
        if(form.usuario != undefined){
            if(form.usuario.value==""){
                message = "Usuário não preechido!";
                retorno = false;
            }
        }
    }

    if(retorno){
        if(form.senha != undefined){
            if(form.senha.value==""){
                message = "Senha não preechido!";
                retorno = false;
            }
        }
    }

    if(retorno){
        if(form.confirma != undefined){
            if(form.confirma.value==""){
                message = "Confirme a senha!";
                retorno = false;
            }
        }
    }

    if(retorno){
        if((form.confirma != undefined) && (form.senha != undefined)){
            if(form.confirma.value !== form.senha.value){
                message = "Senha não conferem!";
                retorno = false;
            }
        }
    }

    if(retorno){
        if(form.dataEmprestimo != undefined){
            if(form.dataEmprestimo.value==""){
                message = "Data de emprestimo não preechido!";
                retorno = false;
            }
        }
    }

    if(retorno){
        if(form.dataEmprestimo != undefined){
            if(form.dataEmprestimo.value==""){
                message = "Data de emprestimo não preechido!";
                retorno = false;
            }
        }
    }

    if(retorno){
        if(form.nomeDestinatario != undefined){
            if(form.nomeDestinatario.value==""){
                message = "Nome destinatário não preechido!";
                retorno = false;
            }
        }
    }

    if(retorno){
        if(form.emailDestinatario != undefined){
            if(form.emailDestinatario.value==""){
                message = "Email destinatário não preechido!";
                retorno = false;
            }
        }
    }

    if(form.slug != undefined){
        if(form.slug.value==""){
            message = "Nome não preechido!";
            retorno = false;
        }
    }


    if(!retorno){
        setMessageError(message);
    }

    return retorno;
}

function setMessageError(message){
    document.getElementById("label_error").textContent = message;
    document.getElementById("label_error").setAttribute("style", "display:inline");
}
