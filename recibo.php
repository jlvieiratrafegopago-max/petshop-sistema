<?php
include 'db.php';

if (!isset($_GET['id'])) {
    die("ID do atendimento não fornecido.");
}

$id = $_GET['id'];
$res = $conn->query("SELECT * FROM atendimentos WHERE id = $id");
$dados = $res->fetch_assoc();

if (!$dados) {
    die("Atendimento não encontrado.");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Recibo - <?php echo $dados['pet_nome']; ?></title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; padding: 20px; color: #000; }
        .recibo-box { width: 400px; border: 1px solid #000; padding: 15px; margin: auto; }
        .header { text-align: center; border-bottom: 1px dashed #000; margin-bottom: 10px; padding-bottom: 10px; }
        .linha { display: flex; justify-content: space-between; margin: 5px 0; }
        .footer { text-align: center; margin-top: 20px; border-top: 1px dashed #000; padding-top: 10px; font-size: 0.8em; }
        @media print { .btn-print { display: none; } }
    </style>
</head>
<body>

    <div class="recibo-box">
        <div class="header">
            <strong>PAW MAGIC - PET SHOP</strong><br>
            Comprovante de Serviço
        </div>

        <div class="linha"><span>Data:</span> <span><?php echo date('d/m/Y', strtotime($dados['data_registro'])); ?></span></div>
        <div class="linha"><span>Tutor:</span> <span><?php echo $dados['tutor_nome']; ?></span></div>
        <div class="linha"><span>Telefone:</span> <span><?php echo $dados['telefone']; ?></span></div>
        <hr>
        <div class="linha"><span>Pet:</span> <span><?php echo $dados['pet_nome']; ?> (<?php echo $dados['pet_raca']; ?>)</span></div>
        <div class="linha"><span>Serviço:</span> <span><?php echo $dados['servico']; ?></span></div>
        
        <?php if(!empty($dados['observacoes'])): ?>
            <div style="margin-top:10px;">
                <small><strong>Obs:</strong> <?php echo $dados['observacoes']; ?></small>
            </div>
        <?php endif; ?>

        <div class="footer">
            Obrigado pela preferência!<br>
            Assinatura: ___________________________
        </div>
    </div>

    <div style="text-align: center; margin-top: 20px;">
        <button class="btn-print" onclick="window.print()">Imprimir Recibo</button>
    </div>

</body>
</html>
