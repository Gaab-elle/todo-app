# 🚀 Deploy do NERDINO no Railway

## 📋 Pré-requisitos

1. **Conta no Railway**: [railway.app](https://railway.app)
2. **Repositório no GitHub**: Código commitado e pushado
3. **OAuth configurado**: Google e GitHub (opcional)

## 🔧 Passo a Passo

### 1. **Conectar ao Railway**
- Acesse [railway.app](https://railway.app)
- Faça login com GitHub
- Clique em "New Project"
- Selecione "Deploy from GitHub repo"
- Escolha o repositório do NERDINO

### 2. **Configurar Variáveis de Ambiente**
No Railway, vá em "Variables" e adicione:

```env
APP_NAME="NERDINO - Gerenciador de Projetos Dev"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.railway.app

# Database (Railway fornece automaticamente)
DB_CONNECTION=pgsql
DB_HOST=${{Postgres.PGHOST}}
DB_PORT=${{Postgres.PGPORT}}
DB_DATABASE=${{Postgres.PGDATABASE}}
DB_USERNAME=${{Postgres.PGUSER}}
DB_PASSWORD=${{Postgres.PGPASSWORD}}

# OAuth (opcional)
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_secret
GOOGLE_REDIRECT_URI=https://your-app.railway.app/auth/google/callback

GITHUB_CLIENT_ID=your_github_client_id
GITHUB_CLIENT_SECRET=your_github_secret
GITHUB_REDIRECT_URI=https://your-app.railway.app/auth/github/callback
```

### 3. **Adicionar Banco de Dados**
- No Railway, clique em "New"
- Selecione "Database" → "PostgreSQL"
- Railway criará automaticamente as variáveis de ambiente

### 4. **Deploy**
- Railway detectará automaticamente que é Laravel
- Executará as migrações automaticamente
- Aplicação ficará online em alguns minutos

## 🎯 URLs Importantes

- **Aplicação**: `https://your-app.railway.app`
- **Admin**: `https://your-app.railway.app/admin`
- **API**: `https://your-app.railway.app/api`

## 🔧 Comandos Úteis

```bash
# Ver logs
railway logs

# Conectar ao banco
railway connect postgres

# Executar comandos Laravel
railway run php artisan migrate
railway run php artisan tinker
```

## 🚨 Troubleshooting

### Problema: Erro 500
- Verifique as variáveis de ambiente
- Execute: `railway run php artisan config:clear`

### Problema: Banco não conecta
- Verifique se o PostgreSQL está rodando
- Confirme as variáveis de ambiente do banco

### Problema: Assets não carregam
- Execute: `railway run npm run build`
- Verifique se o Vite está configurado corretamente

## 📊 Monitoramento

- **Logs**: Disponível no dashboard do Railway
- **Métricas**: CPU, RAM, rede
- **Uptime**: Monitoramento automático

## 💰 Custos

- **Gratuito**: $5 de crédito/mês
- **Pro**: $20/mês (recomendado para produção)
- **Banco**: Incluído no plano

## 🎉 Próximos Passos

1. **Domínio customizado**: Configure no Railway
2. **SSL**: Automático com Railway
3. **Backup**: Configure backup automático do banco
4. **Monitoramento**: Configure alertas

---

**🎯 NERDINO estará online em minutos!**
