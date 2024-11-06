<?php
include 'config.php';
require_once('tcpdf/tcpdf.php');

$cliente_id = $_GET['cliente_id'];
$producto = urldecode($_GET['producto']);
$cantidad = $_GET['cantidad'];
$total = $_GET['total'];

// Crear PDF
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('Helvetica', '', 12);

// Título
$pdf->Cell(0, 10, 'Calzados B & C', 0, 1, 'C');
$pdf->SetFont('Helvetica', 'I', 10);
$pdf->Cell(0, 10, 'Dirección: Calle Ejemplo 123, Ciudad, País', 0, 1, 'C');
$pdf->Cell(0, 10, 'Teléfono: (123) 456-7890', 0, 1, 'C');
$pdf->Cell(0, 10, 'Email: contacto@calzadosbc.com', 0, 1, 'C');
$pdf->Ln(5);
$pdf->SetFont('Helvetica', '', 12);
$pdf->Cell(0, 10, 'Factura', 0, 1, 'C');
$pdf->Ln(10);

// Información de la factura
$pdf->Cell(0, 10, 'Cliente ID: ' . $cliente_id, 0, 1);
$pdf->Cell(0, 10, 'Producto: ' . $producto, 0, 1);
$pdf->Cell(0, 10, 'Cantidad: ' . $cantidad, 0, 1);
$pdf->Cell(0, 10, 'Total: $' . number_format($total, 2), 0, 1);
$pdf->Cell(0, 10, 'Fecha: ' . date('d-m-Y'), 0, 1);
$pdf->Ln(10);

// Pie de página
$pdf->Cell(0, 10, 'Gracias por su compra!', 0, 1, 'C');

// Salida del PDF
$pdf->Output('factura_' . $cliente_id . '.pdf', 'D'); // 'D' para descargar
?>
