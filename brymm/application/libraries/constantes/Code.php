<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2006 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * Shopping Cart Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Shopping Cart
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/cart.html
 */
class Code {

    const CODE_OK = 200;
    const CODE_KO = 404;
    const CODE_NO_DATA = 400;
    //Campos enviados con JSON
    const JSON_OPERACION_OK = "operacionOK";
    const JSON_MENSAJE = "mensaje";
    
    const RES_OPERACION_OK = 1;
    const RES_OPERACION_KO = 0;
    const RES_OPERACION_NO_ALERTAS = 2;
    
    const NO_DATA = "no_data";
    
    const FIELD_ID_LOCAL = "idLocal";
    const FIELD_NOMBRE_LOCAL = "nombreLocal";
    const FIELD_ID_USUARIO = "idUsuario";

}
