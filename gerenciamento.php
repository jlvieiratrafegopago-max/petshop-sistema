<?php 
include 'db.php'; 

// --- Lógica para Atualizar Status ---
if(isset($_POST['atualizar'])){
    $id = $_POST['id'];
    $novo_status = $_POST['status'];
    $conn->query("UPDATE atendimentos SET status='$novo_status' WHERE id=$id");
}

// --- Lógica para Excluir Registro ---
if(isset($_POST['excluir'])){
    $id = $_POST['id'];
    $conn->query("DELETE FROM atendimentos WHERE id=$id");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Gerenciamento - PetShop</title>
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
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3>Painel de Controle de Atendimentos</h3>
            <button onclick="window.location.reload();" style="background: #7f8c8d; font-size: 12px;">Atualizar Lista</button>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Pet / Tutor</th>
                    <th>Serviço / Obs.</th>
                    <th>Status Atual</th>
                    <th>Ações Administrativas</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $res = $conn->query("SELECT * FROM atendimentos ORDER BY data_registro DESC");
                
                if($res->num_rows > 0){
                    while($row = $res->fetch_assoc()){
                        // Lógica para manter o status selecionado no HTML
                        $s1 = ($row['status'] == 'Em andamento') ? 'selected' : '';
                        $s2 = ($row['status'] == 'Ligar para cliente') ? 'selected' : '';
                        $s3 = ($row['status'] == 'Finalizado') ? 'selected' : '';

                        echo "<tr>
                            <td>
                                <strong style='color:#2c3e50; font-size: 1.1em;'>{$row['pet_nome']}</strong><br>
                                <span style='color:#7f8c8d; font-size: 0.9em;'>Tutor: {$row['tutor_nome']}</span><br>
                                <small style='color:#7f8c8d;'>Tel: {$row['telefone']}</small>
                            </td>

                            <td>
                                <strong>{$row['servico']}</strong><br>
                                <div style='background: #f9f9f9; padding: 5px; border-left: 3px solid #ddd; margin-top: 5px;'>
                                    <small><em>Obs: " . ($row['observacoes'] ? $row['observacoes'] : 'Sem observações.') . "</em></small>
                                </div>
                            </td>

                            <td style='text-align:center;'>
                                <span style='font-weight:bold; display:block; margin-bottom:5px;'>{$row['status']}</span>
                            </td>

                            <td>
                                <div style='display:flex; flex-wrap: wrap; gap: 8px; align-items: center;'>
                                    
                                    <form method='POST' style='display:flex; gap:3px;'>
                                        <input type='hidden' name='id' value='{$row['id']}'>
                                        <select name='status' style='padding: 5px; border-radius: 4px; border: 1px solid #ccc;'>
                                            <option value='Em andamento' $s1>Em andamento</option>
                                            <option value='Ligar para cliente' $s2>Ligar para cliente</option>
                                            <option value='Finalizado' $s3>Finalizado</option>
                                        </select>
                                        <button type='submit' name='atualizar' style='background:#2ecc71; padding: 6px 10px;' title='Salvar Status'>OK</button>
                                    </form>

                                    <a href='recibo.php?id={$row['id']}' target='_blank' 
                                       style='background: #f39c12; color: white; padding: 7px 12px; text-decoration: none; border-radius: 4px; font-size: 13px; font-weight: bold;'>
                                       Recibo
                                    </a>

                                    <form method='POST' onsubmit='return confirm(\"Deseja realmente excluir este registro?\");'>
                                        <input type='hidden' name='id' value='{$row['id']}'>
                                        <button type='submit' name='excluir' style='background:#e74c3c; padding: 7px 12px;'>Excluir</button>
                                    </form>

                                </div>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' style='text-align:center; padding: 40px; color: #95a5a6;'>Nenhum atendimento em aberto no momento.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
