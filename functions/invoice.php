<?php

require 'TCPDF/tcpdf.php';

function createPDF(){

// PDF-Instanz erstellen
$pdf = new TCPDF('P', 'mm', 'A4');
$pdf->SetMargins(10, 10, 10);

// PDF-Header setzen
$pdf->setPrintHeader(false);

// PDF-Footer setzen
$pdf->setPrintFooter(false);

// Neue Seite hinzufügen
$pdf->AddPage();

// Inhalt der Rechnung
$rechnung = '<h1>Rechnung</h1>';
$rechnung .= '<p>Rechnungsnummer: 12345</p>';
$rechnung .= '<p>Rechnungsdatum: ' . date('d.m.Y') . '</p>';
$rechnung .= '<p>Rechnungsbetrag: $100.00</p>';

// PDF-Inhalt hinzufügen
$pdf->writeHTML($rechnung, true, false, true, false, '');

// PDF-Datei ausgeben
$pdf->Output(DATA_DIR.'/invoice/rechnung.pdf', 'F'); // 'D' steht für Download, du kannst stattdessen 'I' für Anzeigen verwenden


}
