# Script para instalar PHP, Composer e Node.js sem privilégios administrativos
Write-Host "Instalando ferramentas necessárias para o projeto Laravel..." -ForegroundColor Green

# Criar diretório para ferramentas
$toolsDir = "$env:USERPROFILE\dev-tools"
if (!(Test-Path $toolsDir)) {
    New-Item -ItemType Directory -Path $toolsDir -Force
}

# Função para baixar arquivo
function Download-File {
    param($url, $output)
    Write-Host "Baixando $output..." -ForegroundColor Yellow
    try {
        Invoke-WebRequest -Uri $url -OutFile $output -UseBasicParsing
        Write-Host "✓ Download concluído: $output" -ForegroundColor Green
        return $true
    } catch {
        Write-Host "✗ Erro no download: $_" -ForegroundColor Red
        return $false
    }
}

# 1. Instalar PHP
Write-Host "`n=== Instalando PHP ===" -ForegroundColor Cyan
$phpDir = "$toolsDir\php"
$phpZip = "$toolsDir\php.zip"
$phpUrl = "https://windows.php.net/downloads/releases/php-8.3.14-Win32-vs16-x64.zip"

if (!(Test-Path $phpDir)) {
    if (Download-File $phpUrl $phpZip) {
        Write-Host "Extraindo PHP..." -ForegroundColor Yellow
        Expand-Archive -Path $phpZip -DestinationPath $phpDir -Force
        Remove-Item $phpZip
        
        # Copiar php.ini
        $phpIniDev = "$phpDir\php.ini-development"
        $phpIni = "$phpDir\php.ini"
        if (Test-Path $phpIniDev) {
            Copy-Item $phpIniDev $phpIni
            Write-Host "✓ PHP configurado" -ForegroundColor Green
        }
    }
}

# 2. Instalar Composer
Write-Host "`n=== Instalando Composer ===" -ForegroundColor Cyan
$composerDir = "$toolsDir\composer"
$composerPhar = "$composerDir\composer.phar"
$composerBat = "$composerDir\composer.bat"
$composerUrl = "https://getcomposer.org/download/latest-stable/composer.phar"

if (!(Test-Path $composerDir)) {
    New-Item -ItemType Directory -Path $composerDir -Force
}

if (!(Test-Path $composerPhar)) {
    if (Download-File $composerUrl $composerPhar) {
        # Criar bat file para o composer
        $batContent = "@echo off`n$phpDir\php.exe `"$composerPhar`" %*"
        Set-Content -Path $composerBat -Value $batContent
        Write-Host "✓ Composer instalado" -ForegroundColor Green
    }
}

# 3. Instalar Node.js
Write-Host "`n=== Instalando Node.js ===" -ForegroundColor Cyan
$nodeDir = "$toolsDir\node"
$nodeZip = "$toolsDir\node.zip"
$nodeUrl = "https://nodejs.org/dist/v20.11.0/node-v20.11.0-win-x64.zip"

if (!(Test-Path $nodeDir)) {
    if (Download-File $nodeUrl $nodeZip) {
        Write-Host "Extraindo Node.js..." -ForegroundColor Yellow
        Expand-Archive -Path $nodeZip -DestinationPath $toolsDir -Force
        # Renomear pasta extraída
        $extractedDir = "$toolsDir\node-v20.11.0-win-x64"
        if (Test-Path $extractedDir) {
            Rename-Item $extractedDir $nodeDir
        }
        Remove-Item $nodeZip
        Write-Host "✓ Node.js instalado" -ForegroundColor Green
    }
}

# 4. Configurar PATH para a sessão atual
Write-Host "`n=== Configurando PATH ===" -ForegroundColor Cyan
$currentPath = $env:PATH
$newPaths = @(
    $phpDir,
    $composerDir,
    $nodeDir
)

foreach ($path in $newPaths) {
    if ($currentPath -notlike "*$path*") {
        $env:PATH = "$path;$env:PATH"
        Write-Host "✓ Adicionado ao PATH: $path" -ForegroundColor Green
    }
}

# 5. Verificar instalações
Write-Host "`n=== Verificando instalações ===" -ForegroundColor Cyan

# Testar PHP
try {
    $phpVersion = & "$phpDir\php.exe" --version 2>&1
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✓ PHP: $($phpVersion.Split("`n")[0])" -ForegroundColor Green
    }
} catch {
    Write-Host "✗ PHP não funcionou" -ForegroundColor Red
}

# Testar Composer
try {
    $composerVersion = & "$composerBat" --version 2>&1
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✓ Composer: $($composerVersion.Split("`n")[0])" -ForegroundColor Green
    }
} catch {
    Write-Host "✗ Composer não funcionou" -ForegroundColor Red
}

# Testar Node.js
try {
    $nodeVersion = & "$nodeDir\node.exe" --version 2>&1
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✓ Node.js: $nodeVersion" -ForegroundColor Green
    }
} catch {
    Write-Host "✗ Node.js não funcionou" -ForegroundColor Red
}

# Testar npm
try {
    $npmVersion = & "$nodeDir\npm.cmd" --version 2>&1
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✓ npm: $npmVersion" -ForegroundColor Green
    }
} catch {
    Write-Host "✗ npm não funcionou" -ForegroundColor Red
}

Write-Host "`n=== Instalação concluída! ===" -ForegroundColor Green
Write-Host "As ferramentas foram instaladas em: $toolsDir" -ForegroundColor Yellow
Write-Host "Para usar em novas sessões, adicione esses caminhos ao PATH do sistema:" -ForegroundColor Yellow
foreach ($path in $newPaths) {
    Write-Host "  $path" -ForegroundColor White
}
