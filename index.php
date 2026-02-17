<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetShop - Início</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="logo"><h2>🐾 PetMagic</h2></div>
        <nav>
            <a href="index.php">Início</a>
            <a href="gerenciamento.php">Gerenciar Atendimentos</a>
        </nav>
    </header>

    <div class="container">
        <h3>Cadastrar Novo Atendimento</h3>
        <form action="index.php" method="POST">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                <input type="text" name="tutor" placeholder="Nome do Tutor" required>
                <input type="text" name="telefone" placeholder="Telefone" required>
            </div>
            <input type="text" name="endereco" placeholder="Endereço Completo">
            
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px;">
                <input type="text" name="pet" placeholder="Nome do Pet" required>
                <input type="text" name="tipo" placeholder="Tipo (Cão/Gato)">
                <input type="text" name="raca" placeholder="Raça">
            </div>
            <input type="text" name="servico" placeholder="Serviço a ser executado">
            <textarea name="observacoes" placeholder="Observações (Alergias, comportamento, etc.)" style="width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 4px; font-family: Arial;"></textarea>
            
            <button type="submit" name="cadastrar">Registrar Atendimento</button>
        </form>

        <?php
        if(isset($_POST['cadastrar'])){
            $tutor = $_POST['tutor'];
            $end = $_POST['endereco'];
            $tel = $_POST['telefone'];
            $pet = $_POST['pet'];
            $tipo = $_POST['tipo'];
            $raca = $_POST['raca'];
            $serv = $_POST['servico'];
            $obs = $_POST['observacoes'];

            $sql = "INSERT INTO atendimentos (tutor_nome, endereco, telefone, pet_nome, pet_tipo, pet_raca, servico, observacoes) 
                    VALUES ('$tutor', '$end', '$tel', '$pet', '$tipo', '$raca', '$serv', '$obs')";
            
            if($conn->query($sql)){
                echo "<p style='color:green; font-weight:bold; text-align:center;'>✅ Registro concluído!</p>";
            }
        }
        ?>

        <hr style="margin: 40px 0;">
        
        <h3>Consultar Status</h3>
        <form method="GET" action="index.php" style="display: flex; gap: 10px;">
            <input type="text" name="busca" placeholder="Pesquisar por Pet ou Tutor..." required>
            <button type="submit" style="width: auto; background: #34495e;">Buscar</button>
        </form>

        <?php
        if(isset($_GET['busca']) && !empty($_GET['busca'])){
            $filtro = $_GET['busca'];
            $res = $conn->query("SELECT * FROM atendimentos WHERE pet_nome LIKE '%$filtro%' OR tutor_nome LIKE '%$filtro%'");
            
            if($res->num_rows > 0){
                echo "<table>
                        <tr>
                            <th>Pet</th>
                            <th>Tutor</th>
                            <th>Serviço</th>
                            <th>Status Atual</th>
                        </tr>";
                while($row = $res->fetch_assoc()){
                    echo "<tr>
                            <td>{$row['pet_nome']}</td>
                            <td>{$row['tutor_nome']}</td>
                            <td>{$row['servico']}</td>
                            <td style='color: #2980b9; font-weight:bold;'>{$row['status']}</td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "<p style='color:red; margin-top:20px;'>Nenhum registro encontrado para: <strong>$filtro</strong></p>";
            }
        }
        ?>
    </div>
</body>
</html>
