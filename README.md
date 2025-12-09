# BarberKush
Sistema: BarberKush
Descrição do Sistema

O BarberKush será um sistema web para gerenciamento completo de uma barbearia.
Ele permitirá controlar clientes, serviços, barbearias, agendamentos, e profissionais.
O objetivo é organizar o fluxo da barbearia, evitando conflitos de horários e garantindo melhor atendimento.

Entidades e Atributos
1. Cliente
id_cliente
nome
telefone
email
data_cadastro

3. Profissional (Barbeiro)
id_profissional
nome
especialidade
telefone
status (ativo/inativo)

3. Serviço
id_servico
nome_servico
descricao
valor
tempo_estimado (minutos)

4. Agendamento
id_agendamento
id_cliente (FK)
id_profissional (FK)
id_servico (FK)
data
hora
status (pendente, concluído, cancelado)

5. Pagamento
id_pagamento
id_agendamento (FK)
valor
forma_pagamento (PIX, cartão, dinheiro)
data_pagamento

Regras de Negócio (mínimo 5)
1. Um agendamento não pode ser criado se o barbeiro já estiver ocupado no mesmo horário.
(Impede conflitos de horário.)
2. Não é possível marcar um agendamento para um cliente sem preencher nome e telefone.
(Dados obrigatórios.)
3. O pagamento só pode ser registrado após o serviço ser concluído.
4. Serviços devem ter preço maior que zero e tempo estimado informado.
5. Um profissional só pode receber agendamentos se estiver com status “ativo”.
