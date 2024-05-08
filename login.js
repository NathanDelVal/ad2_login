document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('button').addEventListener('click', (e) => {

        e.preventDefault();

        form =  e.target.closest('form');
        toggleCadastro = form.querySelector('input#isCadastro');
        nome = form.querySelector('input#nome');    

        if(Number(e.target.getAttribute('data-cadastro')) == false) {
            e.target.innerText = 'Fazer Login';
        } else {
            e.target.innerText = 'Fazer Cadastro';
        };

        if(nome.getAttribute('type') == 'hidden') {
            nome.setAttribute('type', 'text');
        } else {
            nome.setAttribute('type', 'hidden');
        }

        e.target.setAttribute('data-cadastro', Number(!Boolean(Number(e.target.getAttribute('data-cadastro')))));
        toggleCadastro.value = Number(!Boolean(Number(toggleCadastro.value)));
    })
})