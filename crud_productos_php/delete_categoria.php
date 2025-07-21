<?php
include 'db.php';

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    die("ID inválido.");
}

$stmt = $conn->prepare("DELETE FROM categorias WHERE id_categoria = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: index.php");
exit;
?>
