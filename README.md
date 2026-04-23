## Adobe Commerce Bootcamp 2026 - Artefatos Backend
**Integração e Orquestração: Magento + AEM**

## Objetivo
Este repositório centraliza os artefatos de backend e as configurações de infraestrutura para o projeto de **Composable Commerce**. O foco aqui é a entrega de dados estruturados e conteúdo gerenciado para um storefront headless.

## Arquitetura de Integração
O projeto utiliza o Hydrogen como hub central, mas a inteligência do catálogo e do conteúdo reside nestes artefatos:

- **Adobe Commerce (Magento):** Provedor de dados transacionais e catálogo técnico.
- **AEM (Adobe Experience Manager):** CMS Headless para governança de banners e fragmentos de experiência.

---

## Artefatos Magento (Adobe Commerce)
Localizados na pasta `/magento-modules`, os módulos customizados resolvem desafios específicos de integração:

### 1. `Bootcamp_CatalogApi` (Protocolo REST)
* **Função:** Expõe atributos de produtos que nativamente não são processados para APIs externas.
* **Diferencial:** Tratamento do atributo `tech_stack`. A API foi customizada para retornar o *label* (ex: "React", "Node.js") em vez do ID interno, facilitando o consumo imediato pelo frontend.
* **Endpoint:** `/rest/V1/bootcamp/products`

### 2. `Bootcamp_AemContent` (Protocolo JSON Export)
* **Função:** Consome conteúdos dinâmicos vindos do AEM diretamente para o Magento.
* **Fluxo:** Utiliza o Sling Model Exporter do AEM para sincronizar banners e títulos na Home do Magento via requisições server-side.

---

## Artefatos AEM (Adobe Experience Manager)
Localizados na pasta `/aem-config`, os artefatos demonstram a flexibilidade do AEM como CMS Headless:

### 1. Content Fragment Models
* Modelagem de dados para a página **About** e **Banners**, permitindo que o marketing altere textos e imagens sem necessidade de deploy de código.

### 2. Persisted Queries (GraphQL)
* Consultas otimizadas para o Hydrogen.
* **Endpoint:** `/content/cq:graphql/(seu-projeto-personalizado)/endpoint.json`

---

## Mapeamento Técnico de Endpoints

| Serviço | Protocolo | Método | Finalidade |
| :--- | :--- | :--- | :--- |
| **Magento API** | REST | `GET` | Catálogo técnico e atributos de produtos. |
| **AEM GraphQL** | GraphQL | `POST` | Entrega de Content Fragments para o Frontend. |
| **AEM Export** | JSON | `GET` | Exportação de banners para o módulo Magento. |

---

## Estrutura do Repositório
* `/magento-modules`: Código fonte PHP dos módulos `CatalogApi` e `AemContent`.
* `/aem-config`: Definições de modelos e arquivos `.graphql` persistidos.
---

## Instalação dos módulos magento
* Mova a pasta bootcamp para app/code/ e execute os comandos no terminal:

-  Habilitar os módulos
bin/magento module:enable Bootcamp_CatalogApi Bootcamp_AemContent

-  Atualizar o esquema do banco de dados e registros
bin/magento setup:upgrade

-  Compilar as dependências (necessário em modo produção ou default)
bin/magento setup:di:compile

-  Limpar o cache
bin/magento cache:flush

## Configuração do Endpoint AEM (Módulo AemContent)
* Para que o Magento consiga consumir o banner AEM, configure o URL do Sling Model Exporter no painel administrativo:
-  Vá em: Stores > Configuration > Bootcamp > AEM Integration
-  Insira o endpoint. ex: http://localhost:4502/content/dam/bootcamp/banner-home.model.json

