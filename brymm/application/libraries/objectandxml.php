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
class ObjectAndXML {

    private static $xml;
    private $contador = 0;
    private $etiqueta;
    private $mensaje = '';

    // Constructor
    public function __construct($params) {
        if (array_key_exists('mensaje',$params)) {
            $this->mensaje = $params['mensaje'];
        }
        $this->etiqueta = $params['etiqueta'];
        $this->xml = new XmlWriter();
        $this->xml->openMemory();
        //$this->xml->startDocument('1.0');
        $this->xml->setIndent(true);
    }

    // Method to convert Object into XML string
    public function objToXML($obj) {
        $this->getObject2XML($this->xml, $obj);
        
        $this->xml->endElement();

        return $this->xml->outputMemory(true);
    }

    // Method to convert XML string into Object
    public function xmlToObj($xmlString) {
        return simplexml_load_string($xmlString);
    }

    private function getObject2XML(XMLWriter $xml, $data) {
        $this->contador = $this->contador + 1;
        if ($this->contador == 1) {
            $xml->startElement('xml');
            if ($this->mensaje != '') {
                $xml->writeElement('mensaje', $this->mensaje);
            }
        }
        foreach ($data as $key => $value) {
            if (is_object($value)) {
                //$xml->startElement($key);
                $xml->startElement($this->etiqueta);
                $this->getObject2XML($xml, $value);
                $xml->endElement();
                continue;
            } else if (is_array($value)) {
                $this->getArray2XML($xml, $key, $value);
            }

            if (is_string($value)) {
                $xml->writeElement($key, $value);
            }
        }
        if ($this->contador == 1) {
            $xml->endElement();
        }
    }

    private function getArray2XML(XMLWriter $xml, $keyParent, $data) {
        foreach ($data as $key => $value) {
            if (is_string($value)) {
                $xml->writeElement($keyParent, $value);
                continue;
            }

            if (is_numeric($key)) {
                $xml->startElement($keyParent);
            }

            if (is_object($value)) {
                $this->getObject2XML($xml, $value);
            } else if (is_array($value)) {
                $this->getArray2XML($xml, $key, $value);
                continue;
            }

            if (is_numeric($key)) {
                $xml->endElement();
            }
        }
    }

}

?>
