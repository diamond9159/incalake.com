<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cupon_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    
    public function __destruct(){
        $this->db->close();
    }

    public function get_cupon($codigo,$lang = "EN"){
        $cupon = $this->db->query("SELECT * FROM cupon WHERE codigo_cupon = '".mb_strtoupper($codigo)."';")->row_array();
        $data = [];
        if ( !empty($cupon) ) {
            $data = array( 
                'response'  => "success",
                'codigo'    => $cupon['codigo_cupon'],
                'valor'     => (Float)number_format($cupon['descuento_cupon'],"2",".",""),
                'tipo'      => (Integer)$cupon['tipo_descuento_cupon'],
                'simbolo'   => ($cupon['tipo_descuento_cupon']==0?'%':'USD'),
                'ip'        => '',
            );
        }else{
            $data['response'] = "error";
        }
        return $data;
    } 

}
