<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once 'vendor/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;


class PdfController extends CI_Controller {

    public function __construct() {
           parent::__construct();
           $this->load->model("cuota_model");
        }

    public function checkoutPayment()
    {
        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isRemoteEnabled', TRUE);

        $html = $this->load->view('cart/vaucher', '', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);

        $dompdf->render();
        $dompdf->stream('Vasdasdasdasd',[ 'Attachment' => 0 ]);
    }

    public function vaucherPayment()
    {       
        $data['language'] = $this->uri->segment(1);
        $data['codr'] = $this->input->get('codr');

        //Recuperando coutas de pago del cliente
        $data['cuotas'] = $this->cuota_model->get_cuotaIdReserva(@$data['codr']);

        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isRemoteEnabled', TRUE);
        $data['codr'] = $this->input->get('codr');
        $html = $this->load->view('cart/pdf_vaucher-payment', $data, true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $red = $dompdf->render();
        $dompdf->stream('Comprobante de pago');
    }
}