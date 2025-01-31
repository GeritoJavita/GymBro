<?php
include('database.php');
require('../fpdf186/fpdf.php');
function generarCodigoBarras() {
    $codigo = '';
    for ($i = 0; $i < 12; $i++) {
        $codigo .= rand(0, 9);
    }
    return $codigo;
}
if (isset($_GET['id'])) {
    $pedido_id = $_GET['id'];

    // Consultar los detalles del pedido
    $query = "SELECT p.id AS pedido_id, dp.cantidad, dp.precio, py.metodo_pago, u.username, u.id AS usuario_id
              FROM pedidos p
              JOIN detalle_pedido dp ON p.id = dp.pedido_id
              JOIN usuarios u ON p.usuario_id = u.id
              LEFT JOIN pagos py ON p.id = py.pedido_id
              WHERE p.id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $pedido_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $pedido = $result->fetch_assoc();

    // Crear una subclase de FPDF
    class PDF extends FPDF {
        // Cabecera de página
        function Header() {
            $this->Image('logo.png', 40, 6, 30);
            // Título
            
            $this->SetFont('Arial', 'B', 15);
            $this->Cell(0, 10, 'Detalle del Pedido', 0, 1, 'C');
            // Salto de línea
            $this->Ln(10);
        }

        // Pie de página
        function Footer() {
            // Posición a 1,5 cm del final
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial', 'I', 8);
            // Número de página
            $this->Cell(0, 10, 'Página ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        }
    }

    // Crear instancia de PDF
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 12);

    $codigoBarras = generarCodigoBarras();
    // Agregar información del pedido
    $pdf->Cell(0, 10, 'Pedido ID: ' . $pedido['pedido_id'], 0, 1);
    $pdf->Cell(0, 10, 'Usuario: ' . $pedido['username'], 0, 1);
    $pdf->Cell(0, 10, 'Usuario ID: ' . $pedido['usuario_id'], 0, 1);
    $pdf->Cell(0, 10, 'Cantidad: ' . $pedido['cantidad'], 0, 1);
    $pdf->Cell(0, 10, 'Costo: $' . number_format($pedido['precio'], 2), 0, 1);
    $pdf->Cell(0, 10, 'Metodo de Pago: ' . $pedido['metodo_pago'], 0, 1);
    $pdf->Cell(0, 10, 'Codigo de Barras: ' . $codigoBarras, 0, 1);
    // Salida del PDF
    $pdf->Output();
} else {
    echo "ID de pedido no especificado.";
}
