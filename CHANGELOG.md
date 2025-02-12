# Change Log

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [1.9.5] - 2025-02-12

### Fix

- Ajuste de responsividade do nome do campo no footer

## [1.9.4] - 2024-12-17

### Fix

- Inclui logo do campo ASC, ACRS

## [1.9.3] - 2024-12-09

### Fix

- Validação JS slide-downloads

## [1.9.2] - 2024-11-27

### Fix

- Inclui logo do campo MLA


## [1.9.1] - 2024-11-19

### Added

- Corrige erro nos blocos

## [1.9.0] - 2024-11-06

### Added

- Adiciona novas features ao bloco 7class


## [1.8.0] - 2024-10-07

### Added

- Corrige o CSS do bloco "Find a Church"
- Adiciona novas features ao bloco Carousel Kits
- Adiciona nova feature de autoplay ao bloco "Carousel Ministry
- Adiciona novas features ao bloco Felix7Play


## [1.7.2] - 2024-10-03

### Added

- Corrige a versão do Font Awesome p/ a 6.


## [1.7.1] - 2023-11-22

### Added

- Corrige a proporção da imagem da logo customizada no header.


## [1.7.0] - 2023-11-22

### Added

- Inclui a opção de customizar a logo via painel do wordpress.


## [1.6.5] - 2023-11-22

### Fix

- Inclui logo do campo MRP


## [1.6.4] - 2023-11-22

### Fix

- Ajustando termos de tradução. O arquivo .PO foi aberto sem as devidas configurações de extrator para os templates blade. 
- Utilizando o gia presente na [página](https://github.com/roots/sage/issues/1875) o problema foi resolvido.

## [1.6.3] - 2023-08-30

### Fix

- Ajustando ordem da chamada do array que faz o registro das taxonomías.
- Corrigindo bug de tradução.
## [1.6.2] - 2023-08-17

### Fix

- Ajustando condicional na chamada para construir a linha especial da taxonomia (owner) no list post.

## [1.6.1] - 2023-07-19

### Fix

- Restringindo versão minima do php 8.0

## [1.6.0] - 2023-07-19

### Added

- Adicionando seletor de módulos
- Compatível e Limitado a PHP 8.0 ou superior

## [1.5.32] - 2023-05-24

### Fix

- Ajustando a frequência de acionamento do cron: blocos (30 minutos), menus banner global e taxonomias (Uma vez por dia);
## [1.5.31] - 2023-05-18

### Fix

- Removendo trecho de códio desconhecido no arquivo RemoteData.php que estava causando erro nas chamadas que alimenta os blocos quando o WP_DEBUG está ativo. 

## [1.5.30] - 2023-05-17

### Fix

- Corrigindo mensagens de warning 

## [1.5.29] - 2023-04-25

### Fix

- Expecificando caminho dos arquivos de cache do blaid (/uploads/.bladecache)
- Acertando alguns pontos que estavam gerando PHP warning

## [1.5.28] - 2023-04-03

### Fix

- Ajustando script que sincroniza as taxonomias, adicionando logo do campo mibes


## [1.5.27] - 2023-01-12

### Fix

- Removendo parâmetro de 'event': 'Pageview', no datalayer.
- Adicionando logo do campo MBON.
- Adicionando logo do campo MBOS.


## [1.5.26] - 2023-01-10

### Fix

- Mudando chamada da camada de dataLayar para o header.

## [1.5.25] - 2022-12-07

### Fix

- Ajustando chamada da função que seta a datalayer.

## [1.5.24] - 2022-12-07

### Fix

- Ajustando chamada com prefixo do datalayer.


## [1.5.23] - 2022-12-07

### Fix

- Adicionando data layer GA4

## [1.5.22] - 2022-11-21

### Fix

- Adicionando class que formata o h2 na página de archive

## [1.5.21] - 2022-10-21

### Fix

- Ajustando espaçamento entre o top da row e os blocos de encontre uma igreja e f7

## [1.5.20] - 2022-10-07

### Fix

- Ajustando tamanho do texto H2.

## [1.5.19] - 2022-09-16

### Fix

- Adicionando condição na função que manipula a $wp_query.

## [1.5.18] - 2022-07-27

### Fix

- Novos blocos QVS e Downloads de Kits

## [1.5.17] - 2022-07-21

### Fix

- Ajustando Changelog por conta do pull request

## [1.5.16] - 2022-07-16

### Fix

- Ajustando Changelog

## [1.5.15] - 2022-06-30

### Fix

- Recebendo pull request
- Comentando função que oculta campo que permite criar senha fraca (Esta dando erro em alguns ambientes).

## [1.5.14] - 2022-06-28

### Fix

- Colocando condição que desabilita script cado a teg não seja encontrada.

## [1.5.13] - 2022-04-28

### Fix

- Removendo responsabilidade do tema da pai, unregister da taxonomia category e teg

## [1.5.12] - 2022-04-04

### Fix

- Ajustando comportamento do menu mobile.

## [1.5.11] - 2022-03-24

### Fix

- Alterando a função que checa a propriedade de um objeto, de property_exists para isser, a fim de remover os warnings do console

## [1.5.10] - 2022-03-23

### Fix

- Reformando regras que oculta elementos/menu de usuarios que não são administradores

## [1.5.9] - 2022-03-18

### Fix

- Adicionando regras que oculta elementos/menu de usuarios que não são administradores

## [1.5.8] - 2022-03-03

### Fix

- Acidiona o tmanho da thumbnail dos blocos. De 'medium' para 'large'

## [1.5.7] - 2022-03-03

### Fix

- Acidiona o post-type projects no page template page-elementor.

## [1.5.6] - 2022-02-28

### Fix

- Ajustando nome do post type que são chamados nos blocos.
- Ajustando titulo da página quando aberto um projeto

## [1.5.5] - 2022-02-28

### Fix

- Removendo margem bottom negativa do bloco encontre uma igreja
- Condicionando a apresentação do leitor de tela poly no arquivo page.php

## [1.5.4] - 2022-02-28

### Fix

- Add new post type (Page - Elementor)

## [1.5.3] - 2022-02-25

### Fix

- Ajustando largura do bloco de vídeso
- Ajustando margem-top dos blocos.
- Almentando o z-index do menu mobile.
- Ajustando altura do titulo do bloco facebook

## [1.5.2] - 2022-02-24

### Fix

- Ajustando largura dos blocos

## [1.5.1] - 2022-02-18

### Fix

- Atribuindo cor ao header menu, afim de ajustar incompatibilidade com o elementor

## [1.5.0] - 2022-02-18

### Added

- Adicionando novo template de página para dar suporte ao Elementor.
- Para tal foi criado os seguintes arquivos:
  -- Template page -> ./page-elementor.php
  -- Template footer -> ./footer-elementor.php e ./components/menu/footer-elementor.php

## [1.4.2] - 2022-01-18

### Fix

- Adicionando logo do campo ANRA.

## [1.4.1] - 2022-01-18

### Fix

- Ajustando mecanismo que lida com a senha forte.

## [1.4.0] - 2022-01-18

### Added

- Adicionando função que oculta e impedir que o campo "Confirmar o uso de uma senha fraca" seja ativado levando assim o usuário a criar uma senha forte.

## [1.3.12] - 2022-01-18

### Fix

- Adicionando logo do campo ALM.

## [1.3.11] - 2022-01-18

### Fix

- Ajustando espaçamnto do bloco Feliz7Play.

## [1.3.10] - 2022-01-17

### Fix

- Colocando o arquivo da logo do campo asuma no diretório correto.

## [1.3.9] - 2022-01-13

### Fix

- Ajusta a versão do tema.
- Adicionando logo do campo asuma - Associação Sul Maranhense.

## [1.3.8] - 2022-01-04

### Fix

- Corrige a cor do texto do bloco "Encontre uma igreja"
- Corrige o hover dos links dos blocos.
- Ajusta o nome de algumas classes p/ evitar conflito com o código legado do PA-Plugin-Utilities.

## [1.3.7] - 2021-12-29

### Fix

- Corrige o comportamento da página de busca.

## [1.3.6] - 2021-12-29

### Fix

- Corrige o espaçamento, tamanho da fonte e cor, dos textos no single.
- Corrige as opções de compartilhamento do single.

## [1.3.5] - 2021-12-22

### Fix

- Corrige o espaçamento dos textos na lista de posts.
- Corrige o espaçamento das linhas dos títulos dos blocos.

## [1.3.4] - 2021-12-22

### Fix

- Corrige o tamanho do texto no header dos conteúdos.

## [1.3.3] - 2021-12-21

### Fix

- Corrige os textos das legendas das imagens da galeria.

## [1.3.2] - 2021-12-15

### Fix

- Corrige as margens do bloco de notícias.
- Corrige traduções dos blocos.

## [1.3.1] - 2021-12-15

### Fix

- Ajustando arquivo css para não importa @charset.

## [1.3.0] - 2021-12-15

### Changed

- Altera a rota da API dos conteúdos de api.adventistas.org p/ api.adventistas.dev

## [1.2.2] - 2021-12-13

### Fix

- Corrige a tradução do bloco Find Church.

## [1.2.1] - 2021-12-13

### Added

- Adiciona a logo do campo Associação Leste Matogrossense.

## [1.2.0] - 2021-12-09

### Added

- Adiciona o favicon.

### Fix

- Ajusta as margens dos blocos.

## [1.1.1] - 2021-12-09

### Fix

- Ajuste na logo da USeB.
- Ajuste na colunagem dos blocos Downloads e 7Cast.

## [1.1.0] - 2021-12-09

### Added

- Adicionado uma action que seta o header X-Frame-Option.
