<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once './src/assets/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

class Mypdf
{
    protected $ci;

    public function __construct()
    {
        $this->ci = &get_instance();
    }

    public function generate(
        $view,
        $data = [],
        $filename = 'Laporan',
        $paper = 'A4',
        $orientation = 'portrait'
    ) {
        // Buat objek Dompdf
        $dompdf = new Dompdf();

        // Load HTML dari view
        $html = $this->ci->load->view($view, $data, true);

        // Set HTML ke Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper($paper, $orientation);

        // Render the HTML as PDF
        $dompdf->render();

        // Output ke browser
        ob_clean();
        $dompdf->stream($filename . '.pdf', ['Attachment' => false]);
    }
}
