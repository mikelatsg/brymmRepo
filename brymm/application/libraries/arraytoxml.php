<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of utilities
 *
 * @author mikelats
 */
class ArrayToXML {

    private $etiqueta;

    function __construct($etiqueta) {
        $this->etiqueta = $etiqueta;
    }

    function convertArrayToXml($array, $lastkey = 'root') {
        $buffer = "";

        if (is_numeric($lastkey)) {
            $buffer.="<" . $this->etiqueta['etiqueta'] . ">\n";
        } else {
            $buffer.="<" . $lastkey . ">\n";
        }
        if (!is_array($array)) {
            if (is_object($array)) {
                $array = (array) $array;
                foreach ($array as $key => $value) {
                    if (is_array($value)) {
                        if (is_numeric(key($value))) {
                            foreach ($value as $bkey => $bvalue) {
                                $buffer.=$this->convertArrayToXml($bvalue, $key);
                            }
                        } else {
                            $buffer.=$this->convertArrayToXml($value, $key);
                        }
                    } else {
                        $buffer.=$this->convertArrayToXml($value, $key);
                    }
                }
            } else {
                $buffer.=$array;
            }
        } else {
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    if (is_numeric(key($value))) {
                        foreach ($value as $bkey => $bvalue) {
                            $buffer.=$this->convertArrayToXml($bvalue, $key);
                        }
                    } else {
                        $buffer.=$this->convertArrayToXml($value, $key);
                    }
                } else {
                    $buffer.=$this->convertArrayToXml($value, $key);
                }
            }
        }
        //$buffer.="</" . $lastkey . ">\n";
        if (is_numeric($lastkey)) {
            $buffer.="</" . $this->etiqueta['etiqueta'] . ">\n";
        } else {
            $buffer.="</" . $lastkey . ">\n";
        }
        return $buffer;
    }

}

?>
