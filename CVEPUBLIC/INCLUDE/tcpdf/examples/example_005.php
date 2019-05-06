<?php
//============================================================+
// File name   : example_005.php
// Begin       : 2008-03-04
// Last Update : 2009-04-16
// 
// Description : Example 005 for TCPDF class
//               Multicell
// 
// Author: Nicola Asuni
// 
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com s.r.l.
//               Via Della Pace, 11
//               09044 Quartucciu (CA)
//               ITALY
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Multicell
 * @author Nicola Asuni
 * @copyright 2004-2009 Nicola Asuni - Tecnick.com S.r.l (www.tecnick.com) Via Della Pace, 11 - 09044 - Quartucciu (CA) - ITALY - www.tecnick.com - info@tecnick.com
 * @link http://tcpdf.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
 * @since 2008-03-04
 */

require_once('../config/lang/eng.php');
require_once('../tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 005');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 

//set some language-dependent strings
$pdf->setLanguageArray($l); 

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 10);

// add a page
$pdf->AddPage();

// set color for filler
$pdf->SetFillColor(255, 255, 0);

// Multicell test
$pdf->MultiCell(40, 5, 'A test multicell line 1 test multicell line 2 test multicell line 3', 1, 'L', 1, 0, '', '', true);
$pdf->MultiCell(40, 5, 'B test multicell line 1 test multicell line 2 test multicell line 3', 1, 'R', 0, 1, '', '', true);
$pdf->MultiCell(40, 5, 'C test multicell line 1 test multicell line 2 test multicell line 3', 1, 'C', 0, 0, '', '', true);
$pdf->MultiCell(40, 5, '<p style="text-align: center;"><strong><span style="color: #000000;">CONDICIONES COMERCIALES</span></strong></p><p style="text-align: justify;"><span style="color: #000000;">Si solicita a EASY COLOMBIA S.A. alg&uacute;n tipo de asesor&iacute;a respecto de los productos objeto de la presente cotizaci&oacute;n, y dicha asesor&iacute;a le es atendida por parte de EASY COLOMBIA S.A. por &eacute;ste o por cualquier otro medio, le informamos que: 1) Nuestros asesores est&aacute;n capacitados &uacute;nicamente para resolver inquietudes respecto de los productos comercializados por EASY COLOMBIA S.A., por lo que cualquier otro concepto emitido por los mismos se debe tomar como una recomendaci&oacute;n, que puede ser aceptada o rechazada por usted, seg&uacute;n sus necesidades t&eacute;cnicas; 2) en todos los casos las recomendaciones emitidas por EASY COLOMBIA S.A. deben ser avaladas y autorizadas por la persona calificada y competente designada por usted; 3) EASY COLOMBIA S.A. &uacute;nicamente responder&aacute; por los productos comercializados por &eacute;sta, en los t&eacute;rminos y condiciones en que sea otorgada la garant&iacute;a de los mismos, por lo cual en ning&uacute;n caso, EASY COLOMBIA S.A. o sus empleados ser&aacute;n responsables por fallas o da&ntilde;os que se causen por inexactitudes o errores en el dise&ntilde;o, c&aacute;lculo o instalaci&oacute;n de los productos, por cuanto EASY COLOMBIA S.A. &uacute;nicamente est&aacute; obligado a suministrar el material solicitado por cliente, sin conocer ni participar en su destinaci&oacute;n o uso final. Las anteriores condiciones se entender&aacute;n aceptadas por usted con la compra de los productos.</span></p>', 1, 'J', 1, 2, '' ,'', true);
$pdf->MultiCell(40, 5, 'E test multicell line 1 test multicell line 2 test multicell line 3', 1, 'L', 0, 1, '', '', true);

$pdf->SetFillColor(255, 200, 200);

$contenidoemaild='F <p style="text-align: center;"><strong><span style="color: #000000;">CONDICIONES COMERCIALES</span></strong></p><p style="text-align: justify;"><span style="color: #000000;">Si solicita a EASY COLOMBIA S.A. alg&uacute;n tipo de asesor&iacute;a respecto de los productos objeto de la presente cotizaci&oacute;n, y dicha asesor&iacute;a le es atendida por parte de EASY COLOMBIA S.A. por &eacute;ste o por cualquier otro medio, le informamos que: 1) Nuestros asesores est&aacute;n capacitados &uacute;nicamente para resolver inquietudes respecto de los productos comercializados por EASY COLOMBIA S.A., por lo que cualquier otro concepto emitido por los mismos se debe tomar como una recomendaci&oacute;n, que puede ser aceptada o rechazada por usted, seg&uacute;n sus necesidades t&eacute;cnicas; 2) en todos los casos las recomendaciones emitidas por EASY COLOMBIA S.A. deben ser avaladas y autorizadas por la persona calificada y competente designada por usted; 3) EASY COLOMBIA S.A. &uacute;nicamente responder&aacute; por los productos comercializados por &eacute;sta, en los t&eacute;rminos y condiciones en que sea otorgada la garant&iacute;a de los mismos, por lo cual en ning&uacute;n caso, EASY COLOMBIA S.A. o sus empleados ser&aacute;n responsables por fallas o da&ntilde;os que se causen por inexactitudes o errores en el dise&ntilde;o, c&aacute;lculo o instalaci&oacute;n de los productos, por cuanto EASY COLOMBIA S.A. &uacute;nicamente est&aacute; obligado a suministrar el material solicitado por cliente, sin conocer ni participar en su destinaci&oacute;n o uso final. Las anteriores condiciones se entender&aacute;n aceptadas por usted con la compra de los productos.</span></p>';
$pdf->writeHTML($contenidoemaild, true, false, false, false, '');
// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_005.pdf', 'I');

//============================================================+
// END OF FILE                                                 
//============================================================+
?>
