[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=igrejaadventista_PA-Theme-Sedes&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=igrejaadventista_PA-Theme-Sedes)

# Parent Theme - Portal Aventista
Esse tema foi desenvolvido para ser a base dos outros temas do portal adventista.

### Instalando dependências globais
Siga as intruções antes começar a desenvolver no tema:

- Instalar [Yarn](https://classic.yarnpkg.com/en/docs/install)
- Instalar [composer](https://getcomposer.org/download/)

### Configurando o tema
Após ter instalado todas as dependências globais em seu ambiente, podemos inicializar o tema utilizando os seguintes comandos:

1. Execute o comando a seguir para baixar as dependências:
        
        composer install

2. Execute os comandos:

        yarn install
        yarn build

### Testando o build localmente

Para validar o build antes de enviar para o GitHub, rode o mesmo `Dockerfile` utilizado pelo CI:

```bash
docker build -t pa-theme-sedes:test .
```

Para acompanhar cada etapa com mais detalhes:

```bash
docker build --progress=plain -t pa-theme-sedes:test .
```

Se o build finalizar sem erros, o processo está equivalente ao que será executado no GitHub Actions.
