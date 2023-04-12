 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/////////////////// procesar reservas //////////////////////

class Procesar_reservas extends CI_Controller {
    public function __construct() {
      parent::__construct();
     // $this->load->model('procesar_reservas');
     /* $this->load->model('admin/producto');
      $this->load->helper('url');*/
   }

	public function index(){
		//importando emailer donde se procesará el correo
		include 'assets/email/reservar.php';
	}
	
}