CROSSFIT SERVER
===================

## Como rodar no localhost?

1. Caso não tenha, baixe o composer, para o controle de dependencias do sistema [Composer](http://getcomposer.org/download/).

2. Com o arquivo composer.phar colocado no diretorio raiz do projeto, onde se encontra o arquivo composer.json, execute
na linha de comando.

<pre>
  php composer.phar install
</pre>

3. Apos o composer instalar todas as dependencias, basta na pasta raiz do projeto, onde se encontra o arquivo index.php
executar o seguinte comando

<pre>
  php -S localhost:8181
</pre>

Feito isso o servidor ja vai estar rodando na url localhost:8181
