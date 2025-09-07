# 🔐 Configuração OAuth - Google e GitHub

Este guia te ajudará a configurar o login social com Google e GitHub no Dev Project Manager.

## 📋 Pré-requisitos

- Conta Google (para Google OAuth)
- Conta GitHub (para GitHub OAuth)
- Acesso ao console de desenvolvedor de cada plataforma

---

## 🔵 Google OAuth Setup

### 1. Acessar Google Cloud Console
1. Vá para [Google Cloud Console](https://console.cloud.google.com/)
2. Faça login com sua conta Google
3. Crie um novo projeto ou selecione um existente

### 2. Configurar OAuth Consent Screen
1. No menu lateral, vá em **APIs & Services** > **OAuth consent screen**
2. Escolha **External** (para usuários externos)
3. Preencha os campos obrigatórios:
   - **App name**: `Dev Project Manager`
   - **User support email**: Seu email
   - **Developer contact information**: Seu email
4. Clique em **Save and Continue**
5. Na tela **Scopes**, clique em **Save and Continue**
6. Na tela **Test users**, adicione emails de teste (opcional)
7. Clique em **Save and Continue**

### 3. Criar Credenciais OAuth
1. Vá em **APIs & Services** > **Credentials**
2. Clique em **+ CREATE CREDENTIALS** > **OAuth client ID**
3. Selecione **Web application**
4. Configure:
   - **Name**: `Dev Project Manager Web Client`
   - **Authorized JavaScript origins**: 
     - `http://localhost:8000` (desenvolvimento)
     - `https://seudominio.com` (produção)
   - **Authorized redirect URIs**:
     - `http://localhost:8000/auth/google/callback` (desenvolvimento)
     - `https://seudominio.com/auth/google/callback` (produção)
5. Clique em **Create**
6. **Copie o Client ID e Client Secret**

### 4. Adicionar ao arquivo .env
```env
GOOGLE_CLIENT_ID=seu_google_client_id_aqui
GOOGLE_CLIENT_SECRET=seu_google_client_secret_aqui
```

---

## 🐙 GitHub OAuth Setup

### 1. Acessar GitHub Developer Settings
1. Vá para [GitHub Settings](https://github.com/settings/developers)
2. Faça login com sua conta GitHub
3. Clique em **OAuth Apps** no menu lateral

### 2. Criar Nova OAuth App
1. Clique em **New OAuth App**
2. Preencha os campos:
   - **Application name**: `Dev Project Manager`
   - **Homepage URL**: 
     - `http://localhost:8000` (desenvolvimento)
     - `https://seudominio.com` (produção)
   - **Application description**: `Sistema de gerenciamento de projetos para desenvolvedores`
   - **Authorization callback URL**:
     - `http://localhost:8000/auth/github/callback` (desenvolvimento)
     - `https://seudominio.com/auth/github/callback` (produção)
3. Clique em **Register application**

### 3. Obter Credenciais
1. Na página da aplicação criada, você verá:
   - **Client ID** (público)
   - **Client Secret** (clique em "Generate a new client secret")

### 4. Adicionar ao arquivo .env
```env
GITHUB_CLIENT_ID=seu_github_client_id_aqui
GITHUB_CLIENT_SECRET=seu_github_client_secret_aqui
```

---

## ⚙️ Configuração do Laravel

### 1. Verificar config/services.php
O arquivo já está configurado com:
```php
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT_URI', env('APP_URL') . '/auth/google/callback'),
],

'github' => [
    'client_id' => env('GITHUB_CLIENT_ID'),
    'client_secret' => env('GITHUB_CLIENT_SECRET'),
    'redirect' => env('GITHUB_REDIRECT_URI', env('APP_URL') . '/auth/github/callback'),
],
```

### 2. Limpar Cache
```bash
php artisan config:clear
php artisan cache:clear
```

---

## 🧪 Testando a Configuração

### 1. Verificar Rotas
```bash
php artisan route:list | grep auth
```

### 2. Testar Login Social
1. Acesse `http://localhost:8000/login`
2. Clique em "Entrar com Google" ou "Entrar com GitHub"
3. Deve redirecionar para a página de autorização
4. Após autorizar, deve retornar e fazer login automaticamente

---

## 🚨 Troubleshooting

### Erro: "Invalid redirect URI"
- Verifique se as URLs de callback estão corretas no console do Google/GitHub
- Certifique-se de que não há espaços extras nas URLs

### Erro: "Client ID not found"
- Verifique se as variáveis estão no arquivo .env
- Execute `php artisan config:clear`

### Erro: "Access denied"
- Verifique se o OAuth consent screen está configurado
- Para Google: adicione emails de teste se necessário

### Erro: "State parameter mismatch"
- Limpe o cache do navegador
- Verifique se as sessões estão funcionando

---

## 🔒 Segurança

### Produção
- Use HTTPS em produção
- Configure domínios corretos nas credenciais
- Mantenha as credenciais seguras
- Use variáveis de ambiente

### Desenvolvimento
- Use localhost para desenvolvimento
- Mantenha credenciais separadas para dev/prod
- Não commite o arquivo .env

---

## 📝 Exemplo de .env Completo

```env
APP_NAME="Dev Project Manager"
APP_ENV=local
APP_KEY=base64:sua_app_key_aqui
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dev_project_manager
DB_USERNAME=root
DB_PASSWORD=

# OAuth - Google
GOOGLE_CLIENT_ID=seu_google_client_id_aqui
GOOGLE_CLIENT_SECRET=seu_google_client_secret_aqui

# OAuth - GitHub
GITHUB_CLIENT_ID=seu_github_client_id_aqui
GITHUB_CLIENT_SECRET=seu_github_client_secret_aqui
```

---

## 🎯 Próximos Passos

Após configurar o OAuth:
1. ✅ Teste o login com Google
2. ✅ Teste o login com GitHub
3. ✅ Verifique se o usuário é criado automaticamente
4. ✅ Teste o logout
5. ✅ Verifique se as sessões funcionam corretamente

---

**🎉 Parabéns! Seu sistema de login social está configurado!**
