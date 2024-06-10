# Projeto CRUD para personagens do passado

Controle os personagens e as perguntas do jogo "Out of the Loop" (Fora da Rodada).

## Sobre o Jogo

Inicialmente o app escolhe um personagem, e cada jogador irá receber o personagem escolhido. Menos um. Esse jogador
receberá a mensagem: "Fora da Rodada".

O objetivo é descobrir quem está fora. Se a maioria não descobrir, o jogador fora da rodada ganha.
Se a maioria descobrir, ele perde e os demais ganham.

As perguntas são sempre do tipo "Sim ou Não", e o app irá escolher quem faz a pergunta pra quem.

O app também irá determinar a quantidade total de perguntas por rodada antes de pedir para que cada um vote em quem
ele acha que está fora.

Tudo isso é feito no `front` da aplicação. O `back` (esta API) serve apenas como banco de dados para os personages
e perguntas.

## Endpoints

Os endpoints disponíveis são:

* `/people`: Controle os personagens do jogo
* `/questions`: Controle as perguntas do jogo

Para todos eles é possível usar os métodos:

* **GET**: Pegue 1 ou mais registros. Para pegar um específico, adicione o ID na borda
* **POST**: Adicione 1 registro.
* **DELETE**: Delete o registro com o ID indicado na borda
* **PUT**: Atualiza o registro. No caso de `questions`, aqui você informa a lista de IDs de personagens para os quais
  aquela pergunta é verdadeira.

> **Obs**.: Na pasta `/http/` do projeto tem um exemplo de cada requisição para cada endpoint