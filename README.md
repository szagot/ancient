# Projeto CRUD para personagens do passado

Controle os personagens e as perguntas do jogo "Out of the Loop" (Fora da Rodada).

## Sobre o Jogo "Fora da Rodada"

Joguinho para se divertir com a galera!

Crie uma sala, ou entre em uma já criada utilizando o código passado.

Deve haver pelo menos 3 jogadores. Porém, quanto mais jogarem, mais difícil e divertido fica!

**Como Jogar?**

O jogo irá reservar um personagem secreto.

Cada um vai poder ver qual é esse personagem. Olhe o seu e passe para o próximo.

Um dos jogadores não receberá esse personagem, pois estará marcado como "Fora da Rodada".

Todos terão oportunidade de fazer 2 perguntas para outros jogadores (se houverem apenas 3 jogadores, então serão 3
perguntas cada).

Depois das perguntas, todos terão de votar em quem acha que está fora da rodada, e o que está fora deve tentar adivinhar
qual é o personagem secreto.

**Pontuação:**

* 25 pontos para cada jogador que acertar quem está fora da rodada.
* 100 pontos para todos os jogadores (exceto o que está fora) caso a maioria acerte quem está fora da rodada.
* 50 pontos para o jogador que está fora da rodada se a maioria não acertar que é ele.
* 125 pontos para quem está fora da rodada se ele acertar o personagem secreto.

**Quem Ganha?**

Quem tiver mais pontos! (ah vá!)

Joguem várias rodadas. Quando não quiserem mais jogar com o time atual, basta ver a pontuação final!

---

## Endpoints básicos

Os endpoints disponíveis são:

* `/characters`: Controle os personagens do jogo
* `/questions`: Controle as perguntas do jogo

Para todos eles é possível usar os métodos:

* **GET**: Pegue 1 ou mais registros. Para pegar um específico, adicione o ID na borda
* **POST**: Adicione 1 registro.
* **DELETE**: Delete o registro com o ID indicado na borda
* **PUT**: Atualiza o registro. No caso de `questions`, aqui você informa a lista de IDs de personagens para os quais
  aquela pergunta é verdadeira.

## Endpoints para o Game

* `/room`: Controle da sala e dos jogadores nela.
* `/game`: Controle do jogo.

Para detalhes das requisições, na pasta `/http/` do projeto tem um exemplo de cada requisição para cada endpoint.

