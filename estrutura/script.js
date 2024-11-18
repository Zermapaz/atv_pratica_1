async function cadastrarCliente(event) {
    event.preventDefault();
    const nome = document.getElementById('nome').value;
    const email = document.getElementById('email').value;
    const telefone = document.getElementById('telefone').value;

    const response = await fetch('http://localhost:3000/clientes', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ nome, email, telefone })
    });

    const mensagemDiv = document.getElementById('mensagem');

    if (response.ok) {
        const result = await response.json();
        mensagemDiv.innerHTML = `Cliente cadastrado com sucesso! ID: ${result.id}`;
        document.getElementById('cadastroCliente').reset(); // Limpa o formulário
    } else {
        mensagemDiv.innerHTML = 'Erro ao cadastrar cliente.';
    }
}