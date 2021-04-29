# PA-Theme-Sedes
Desenvolvido em Wordpress

## Instalando dependências globais
Siga as intruções antes começar a desenvolver no tema:

- Instalar [Ruby](https://www.ruby-lang.org/pt/documentation/installation) seguindo as instruções em https://www.ruby-lang.org/pt/documentation/installation
- Instalar [Compass](http://compass-style.org/install/) em sua maquina local

        gem install compass

- Instalar [Yarn](https://classic.yarnpkg.com/en/docs/install) em sua maquina local

        npm install -g yarn

- Instalar [Grunt](https://gruntjs.com/using-the-cli) em sua maquina local

        npm install -g grunt-cli

## Configurando o tema
Após ter instalado todas as dependências globais em sua máquina, já podemos inicializar o tema utilizando os seguintes comandos

1. Execute o comando a seguir para baixar as dependências:
        
        composer install

2. Acesse `/assets` e execute os comandos:

        yarn install
        grunt
