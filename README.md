
# ⚡ Teste Prático - :upd8

Bem-vindo ao repositório do teste prático desenvolvido para a :upd8! Este projeto visa demonstrar competências técnicas em desenvolvimento web, arquitetura de sistemas e boas práticas de código.

![screencapture-upd8](https://github.com/user-attachments/assets/0fc7cb83-9c0c-43b6-8610-0bfc116eb826)

---

# 🚀 Tecnologias Utilizadas

- **PHP 8.4**
- **Laravel 12**
- **Blade (Views)**
- **Bootstrap 5**
- **jQuery**
- **DataTables.js**
- **SweetAlert2.js**
- **MySQL 8**

---

# 🏭 Arquitetura do Projeto

O sistema segue o padrão de separação por camadas para garantir melhor organização, manutenção e escalabilidade.

### Camadas Implementadas

| Camada | Função |
|:---|:---|
| **Controller** | Recebe as requisições HTTP, orquestra o fluxo e chama os Services |
| **Service** | Contém a lógica de negócio e manipula os dados recebidos dos Repositories |
| **Repository** | Responsável pelo acesso direto aos Models e banco de dados |
| **Model** | Representa as entidades do banco |
| **Resource** | Formata as respostas JSON para a API |
| **Form Request** | Realiza as validações de dados de entrada |

---

# 📘 Estrutura de Pastas

```
app/
|-- Http/
|   |-- Controllers/
|   |-- Requests/
|   |-- Resources/
|
|-- Services/
|-- Repositories/
|-- Models/
|
routes/
|-- api.php
|-- web.php
```

---

# 🛢️ Diagrama do Banco de Dados
![database-diagram](https://github.com/user-attachments/assets/0813ac23-ee3b-4320-b9ba-e0a7757da35a)

---

# ⚙️ Como Rodar o Projeto

### 1. Clonar o repositório

```
git clone https://github.com/richard-tavares/upd8.git
cd upd8
```

### 2. Instalar as dependências

```
composer install
npm install && npm run build
```

### 3. Configurar o ambiente

Copie o arquivo `.env.example` para `.env`:

```
cp .env.example .env
```

Atualize as credenciais do banco de dados no `.env`.


### 4. Rodar as migrations e seeders

```
php artisan migrate --seed
```

### 5. Iniciar o servidor

```
php artisan serve
```

Acesse:

```
http://localhost:8000
```

---

# 📋 Observações Importantes

- O projeto utiliza **relacionamentos Eloquent** para gerenciar as relações de cidades e clientes.
- As respostas da API foram **simplificadas** para facilitar a integração com front-end sem necessidade de parser adicional.
- Foram seguidos padrões de código PSR-12 e arquitetura limpa para separação de responsabilidades.
- O sistema já está preparado para futura integração com ferramentas como Swagger para documentação da API.

---

# 📫 Contato

Desenvolvido com muito empenho para o teste prático da :upd8.

**Richard Tavares - Desenvolvedor Full Stack**  
[LinkedIn](https://www.linkedin.com/in/richard-tavares)  
[GitHub](https://github.com/richard-tavares)

---

# 🚀 Obrigado pela oportunidade! Let's code!
