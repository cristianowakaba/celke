# celkeadm
curso adminstrativo celke
Iniciar novo packet com GIT na máquina 
### git init

Definir as configurações do usuário
### git config --local user.name Cesar
### git config --local user.email cesar@celke.com.br

Baixar os arquivos do Git
### git clone --branch <branch_name> <repository_url>
### git clone --branch 1.0 https://github.com/celkecursos/celke_como_usar_github.git

Verificar a branch
### git branch 

Baixar as atualizações
### git pull

Adicionar o arquivo criado, adicionar arquivo ao índice de preparação (staging area). 
O índice de preparação é uma área intermediária entre o diretório de trabalho (working directory) e o repositório Git
### git add <file>
### git add README.md

Adicionar todos os arquivos modificados
### git add .

Verificar o status do arquivo no repositório
### git status

Representa um conjunto de alterações em um ponto específico da história do seu projeto, registra apenas as alterações adicionadas ao índice de preparação.
O comando -m permite que insira a mensagem de commit diretamente na linha de comando
### git commit -m "Criar o arquivo readme"

Enviar os commits locais, para um repositório remoto.
### git push <remote> <branch>
### git push origin 1.0

Criar nova branch no PC
### git checkout -b <branch>
### git checkout -b desenvolvimento

Adicionar todos os arquivos modificados no staging area - área de preparação
### git add .

Verificar em qual branch está
### git branch

Enviar os commits locais, para um repositório remoto.
### git push <remote> <branch>
### git push origin desenvolvimento

Mudar de branch
### git switch <branch>
### git switch 1.0

Mesclar o histórico de commits de um branch em outra branch
### git merge <branch_name>
### git merge desenvolvimento

Fazer o push dessas alterações
### git push origin <branch_name>
### git push origin 1.0

Retirar o arquivo do staging area
### git restore --staged <file_path>
### git restore --staged index.html
# Define a branch upstream para a branch local 'aula'
git branch --set-upstream-to=origin/aula aula

# Busca as alterações mais recentes do repositório remoto
git fetch

# Mescla as alterações mais recentes na branch local 'aula'
git pull