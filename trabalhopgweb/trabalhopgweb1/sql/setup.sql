
CREATE TABLE IF NOT EXISTS dispositivos 
(
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    status BOOLEAN NOT NULL DEFAULT TRUE
);

CREATE TABLE IF NOT EXISTS perguntas 
(
    id SERIAL PRIMARY KEY,
    texto TEXT NOT NULL,
    ordem INTEGER NOT NULL DEFAULT 0,
    status BOOLEAN NOT NULL DEFAULT TRUE
);

CREATE TABLE IF NOT EXISTS avaliacoes 
(
    id SERIAL PRIMARY KEY,
    dispositivo_id INTEGER REFERENCES dispositivos(id) ON DELETE SET NULL,
    pergunta_id INTEGER REFERENCES perguntas(id) ON DELETE CASCADE,
    resposta INTEGER NOT NULL CHECK (resposta BETWEEN 0 AND 10),
    feedback TEXT,
    data_hora TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT now()
);

-- Tabela de administradores (parte 2)
CREATE TABLE IF NOT EXISTS admins (
    id SERIAL PRIMARY KEY,
    usuario VARCHAR(100) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL
);

-- Inserções de exemplo
INSERT INTO dispositivos (nome, status) VALUES ('Tablet Recepção', TRUE) ON CONFLICT DO NOTHING;
INSERT INTO perguntas (texto, ordem, status) VALUES
    ('Como você avalia o atendimento?', 1, TRUE),
    ('Como você avalia a limpeza do ambiente?', 2, TRUE),
    ('Como você avalia a rapidez do serviço?', 3, TRUE)
ON CONFLICT DO NOTHING;
