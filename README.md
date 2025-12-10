BarberKush - Sistema de Gerenciamento de Barbearia
1. Nome do Sistema

BarberKush

2. Descrição

BarberKush é um sistema web para gerenciamento completo de uma barbearia, permitindo controle de clientes, barbeiros, serviços e agendamentos. O sistema facilita:

Agendamento de horários evitando conflitos de agenda.

Controle de clientes e barbeiros ativos.

Registro de histórico de atendimentos.

Aplicação de regras de negócio para horários, cancelamentos e validações de dados.

3. Entidades e Atributos

clientes

id_cliente (INT, PK, AI)

nome (VARCHAR)

cpf (VARCHAR(14), UNIQUE)

telefone (VARCHAR)

email (VARCHAR)

data_nascimento (DATE)

endereco (VARCHAR)

criado_em (DATETIME)

barbeiros

id_barbeiro (INT, PK, AI)

nome (VARCHAR)

apelido (VARCHAR)

telefone (VARCHAR)

ativo (TINYINT)

criado_em (DATETIME)

servicos

id_servico (INT, PK, AI)

nome (VARCHAR)

duracao_min (INT) — duração em minutos

preco (DECIMAL(10,2))

ativo (TINYINT)

criado_em (DATETIME)

agendamentos

id_agendamento (INT, PK, AI)

id_cliente (INT, FK -> clientes.id_cliente)

id_barbeiro (INT, FK -> barbeiros.id_barbeiro)

id_servico (INT, FK -> servicos.id_servico)

data_inicio (DATETIME)

data_fim (DATETIME)

status (ENUM: pendente, confirmado, cancelado, concluido)

observacoes (TEXT)

criado_em (DATETIME)

4. Regras de Negócio

Clientes únicos

Não permitir cadastro de cliente com CPF ou e-mail duplicado.

Agendamento sem conflito

Um barbeiro não pode ter dois agendamentos no mesmo horário.

Um cliente não pode ter dois agendamentos sobrepostos.

Horário de funcionamento

Agendamentos permitidos somente entre 09:00 e 19:00.

Agendamentos apenas em dias úteis.

Agendamento de dias futuros

Não é permitido criar agendamento para o dia atual ou datas passadas.

Agendamentos devem ser feitos para o dia seguinte ou dias posteriores.

Edição e cancelamento com antecedência mínima

Cancelamento de agendamento permitido somente com antecedência de 24 horas.

Edição de agendamento permitida apenas se a alteração for realizada com antecedência mínima de 24 horas antes do horário agendado.

Alterações não podem ser feitas para horários do dia atual ou passados.

Não permitir exclusão direta de entidades com vínculos

Serviços e barbeiros não podem ser excluídos se possuírem agendamentos futuros.

Pode-se apenas marcar como ativo = 0 para desativação.

Validação de dados

CPF, e-mail, telefone e datas devem ser validados antes do cadastro.

Botões de edição e cancelamento dinâmicos

Na listagem de agendamentos, editar e cancelar só ficam habilitados se houver antecedência mínima de 24h.

Fora desse período, os botões aparecem desabilitados.
