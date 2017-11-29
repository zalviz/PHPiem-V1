<?php use Dompdf\Dompdf;

if (!defined('BASEPATH')) exit('No direct script access allowed');

function pdf_create($html, $filename='', $stream=false)
{
    require APPPATH . 'vendor/autoload.php';

    $dompdf = new dompdf();
    $dompdf->setPaper('A5', 'landscape');
    $dompdf->set_option('isHtml5ParserEnabled', true);
    $dompdf->load_html($html);
    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename);
    } else {
        return $dompdf->output();
    }
}