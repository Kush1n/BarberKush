# BarberKush

BarberKush – Sistema de Gestão para Barbearias

Descrição do Sistema

O BarberKush é um sistema web desenvolvido para gerenciar o funcionamento de uma barbearia, oferecendo controle completo de clientes, serviços, barbeiros, agendamentos e pagamentos.
O objetivo do sistema é facilitar o atendimento, evitar conflitos de horários, melhorar a organização e garantir mais eficiência no gerenciamento diário da barbearia.
O sistema permite:
Cadastrar e gerenciar clientes, barbeiros e serviços.
Realizar agendamentos com verificação de conflitos.
Controlar status do agendamento (agendado, concluído, cancelado).
Calcular valores automaticamente com base nos serviços escolhidos.
Evitar registros duplicados.
Criar um histórico completo dos atendimentos.

Entidades e Atributos
   
1. Cliente
id_cliente (PK)
nome
telefone
email
data_cadastro

2. Barbeiro
id_barbeiro (PK)
nome
telefone
especialidade
status (ativo/inativo)

3. Serviço
id_servico (PK)
nome
descricao
valor
duracao (em minutos)

4. Agendamento
id_agendamento (PK)
id_cliente (FK)
id_barbeiro (FK)
id_servico (FK)
data
hora
status (agendado, concluído, cancelado)
valor_total

5. Pagamento (opcional, mas deixa mais completo)
id_pagamento (PK)
id_agendamento (FK)
valor
forma_pagamento (dinheiro, cartão, pix)
data_pagamento

Regras de Negócio (mínimo 5 — aqui tem 8 para ficar completo)
   
1. Não permitir agendamento em horários ocupados
Antes de criar um agendamento, o sistema deve verificar se o barbeiro já possui outro atendimento naquele horário.

2. Impedir cadastro duplicado de clientes
Não deve ser permitido cadastrar dois clientes com o mesmo telefone ou e-mail.

3. Calcular valor automático do agendamento
O valor_total deve ser preenchido automaticamente com base no valor do serviço escolhido.

4. Barbeiros inativos não podem receber novos agendamentos
Se o barbeiro estiver com status = "inativo", o sistema deve bloquear agendamentos com ele.

5. Cancelamento somente antes do horário marcado
O sistema deve impedir cancelar agendamentos que já estão concluídos ou que o horário já passou.

6. Impedir exclusão de clientes com agendamentos vinculados
Só poderá excluir um cliente se ele não tiver agendamentos ativos ou concluídos.

7. Impedir exclusão de serviços vinculados
Um serviço só poderá ser excluído se não existir nenhum agendamento utilizando aquele serviço.

8. Validar formatos de dados
Telefone deve seguir formato válido (ex.: (31) 99999-9999)
E-mail deve ter formato padrão
Data não pode ser retroativa
