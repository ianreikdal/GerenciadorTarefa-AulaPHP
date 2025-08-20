<?php

require_once 'conn.php';

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = isset($_POST['title']) ? $_POST['title'] : null;
        $description = isset($_POST['description']) ? $_POST['description'] : null;


        if ($title) {
            $sql = "INSERT INTO crud_php (title, description) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("ss", $title, $description);

                if ($stmt->execute()) {
                    header("Location: index.php");
                    exit();
                } else {
                    throw new Exception("Error executing statement: " . $stmt->error);
                }
            } else {
                throw new Exception("Erro ao preparar consulta: " . $conn->error);
            }
        } else {
            throw new Exception("Título é obrigatório.");
        }
    } else {
        throw new Exception("Método de requisição inválido!");
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    $conn->close();
}
