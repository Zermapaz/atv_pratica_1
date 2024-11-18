const express = require('express');
const mysql = require('mysql');
const bodyParser = require('body-parser');
const cors = require('cors');

const app = express();
const port = 3000;

app.use(cors());
app.use(bodyParser.json());
app.use(express.static('public')); // Serve arquivos estáticos da pasta public

// Configuração da conexão com o MySQL
const db = mysql.createConnection({
    host: 'localhost',
    user: 'seu_usuario', // Substitua pelo seu usuário do MySQL
    password: 'sua_senha', // Substitua pela sua senha do MySQL
    database: 'suporte_tecnico' // Substitua pelo nome do seu banco de dados
});

// Conectar ao banco de dados
db.connect(err => {
    if (err) {
        console.error('Erro ao conectar ao MySQL:', err);
        return;
    }
    console.log('Conectado ao MySQL!');
});

// Endpoint para cadastrar clientes
app.post('/clientes', (req, res) => {
    const { nome, email, telefone } = req.body;
    db.query('INSERT INTO clientes (nome, email, telefone) VALUES (?, ?, ?)', [nome, email, telefone], (err, results) => {
        if (err) {
            return res.status(500).send(err);
        }
        res.status(201).json({ id: results.insertId, nome, email, telefone });
    });
});

// Iniciar o servidor
app.listen(port, () => {
    console.log(`Servidor rodando em http://localhost:${port}`);
});