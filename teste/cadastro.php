<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Aluno</title>
</head>
<body>
    <h2>Cadastro de Aluno</h2>
    <form method="POST" action="processo_cadastro.php">
        <label for="username">Nome de Usuário:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="phone">Telefone:</label>
        <input type="tel" id="phone" name="phone" required><br><br>
        
        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <label for="turmas">Turmas:</label><br>
        <input type="checkbox" id="logos" name="turmas[]" value="1">
        <label for="logos">Logos</label><br>
        
        <input type="checkbox" id="cronos" name="turmas[]" value="2">
        <label for="cronos">Cronos</label><br>
        
        <input type="checkbox" id="suntzu" name="turmas[]" value="3">
        <label for="suntzu">Sun Tzu</label><br><br>
        
        <input type="submit" value="Cadastrar">
    </form>
</body>
</html>
