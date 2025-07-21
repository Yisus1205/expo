<?php
include 'db.php';

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    die("ID inválido.");
}

$stmt = $conn->prepare("DELETE FROM clientes WHERE id_cliente = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: index.php");
exit;
?>
