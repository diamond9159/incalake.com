<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sliderindex_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    
    public function __destruct(){
        $this->db->close();
    }


    public function sliderindex($lang = 'ES'){
        $data=array();
        // switch (strtolower($lang)) {
        //     case 'es':
        //         $lang=1;
        //         break;
        //     case 'fr':
        //         $lang=3;
        //         break;
        //     case 'de':
        //         $lang=4;
        //         break;
        //     case 'br':
        //         $lang=5;
        //         break;
        //     case 'it':
        //         $lang=6;
        //         break;
        //     default:
        //         $lang=2;
        //         break;

        // }
        $response = $this->db->query("SELECT detalles,idioma FROM slider_principal WHERE idioma = (select i2.id_idioma from idioma as i2 where i2.codigo='".$lang."' limit 1);")->result_array();
if (empty($response)) {
            $response = $this->db->query("SELECT detalles,idioma FROM slider_principal WHERE idioma = (select i2.id_idioma from idioma as i2 where i2.codigo='en' limit 1);")->result_array();
        }
        $itemp_slider=array();
        // echo json_encode($response);
        if (!empty($response)) {
            // $response = $this->db->query("SELECT detalles,idioma FROM slider_principal WHERE idioma = (select i2.id_idioma from idioma as i2 where i2.codigo='en' limit 1);")->result_array();
            $temp = json_decode($response[0]['detalles'],true);
            foreach ($temp as $key => $value) {
               // echo $value['titulo'];
               $itemp_slider[]= array(
                'titulo' =>$value['titulo'],
                'imagen' =>$value['imagen'], 
                'descripcion'=>$value['subtitulo'],
                'url'=>$value['destino']
                );
            }
            
        }else{
            $itemp_slider[]= array(
                'titulo' =>'',
                'imagen' =>'',
                'descripcion'=>'',
                'url'=>''
                );
        }

        
        $data=$itemp_slider;

        
        return $data;
    }






}