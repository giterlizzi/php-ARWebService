<?php

namespace giterlizzi\ARWebService;

/**
 * ARWebService: SOAP Client
 *
 * @author     Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 * @copyright  (C) 2013-2022, Giuseppe Di Terlizzi
 */
class Client
{

    public $username;
    private $password;

    public $armidtier;
    public $arserver;
    public $contextRoot = 'arsys';
    public $permission  = 'public';
    public $service;

    public $trace = false;

    /**
     * ARWebService SOAP Client
     *
     * @param  string  $armidtier  URL (http|https)://hostname[:port]
     * @param  string  $arserver   instance
     * @param  string  $username   (optional)
     * @param  string  $password   (optional)
     */
    public function __construct($armidtier, $arserver, $username = null, $password = null)
    {

        $this->armidtier = rtrim($armidtier, '/');
        $this->arserver  = $arserver;

        $this->login($username, $password);

    }

    /**
     * Set WSDL permission
     *
     * @param  string  $permission
     */
    public function setPermission($permission)
    {
        $this->permission = $permission;
    }

    /**
     * Set Context-Root
     *
     * @param  string  $context_root
     */
    public function setContextRoot($context_root)
    {
        $this->contextRoot = ltrim($context_root, '/');
    }

    /**
     * Set WebService name
     *
     * @param   string  $webservice
     * @return  ARWebService
     */
    public function setService($webservice)
    {
        $this->webservice = $webservice;
        return $this;
    }

    /**
     * Get WSDL url
     *
     * @return string
     */
    public function getWsdlUrl()
    {

        if (!isset($this->armidtier, $this->contextRoot, $this->permission, $this->arserver, $this->webservice)) {
            throw new ClientException('Malformed WSDL url. Check the parameters (armidtier, arserver, permission and service).');
        }

        return sprintf("%s/%s/WSDL/%s/%s/%s",
            $this->armidtier, $this->contextRoot, $this->permission, $this->arserver, $this->webservice);
    }

    /**
     * Return the WSDL
     *
     * @return string
     */
    public function getWSDL()
    {
        return file_get_contents($this->getWsdlUrl());
    }

    /**
     * Set credetial
     *
     * @param  string  $username
     * @param  string  $password
     */
    public function login($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Call Service Method
     *
     * @return SoapClient
     */
    public function call($method, $params = array())
    {

        $auth = (object) array(
            'userName' => $this->username,
            'password' => $this->password,
        );

        $wsdl = $this->getWsdlUrl();

        try {

            $client = new \SoapClient($wsdl, array('trace' => $this->trace));
            $header = new \SoapHeader($wsdl, 'AuthenticationInfo', new \SoapVar($auth, SOAP_ENC_OBJECT), false);

            $client->__setSoapHeaders(array($header));

            $result = $client->__soapCall($method, array($params));

            return $result;

        } catch (\SoapFault $e) {

            if (preg_match('/ARERR \[([0-9]*)\] (.*)/', $e->faultstring, $matches)) {
                throw new ARException($matches[2], $matches[1]);
            }
            if (preg_match('/ERROR \(([0-9]*)\): (.*)/', $e->faultstring, $matches)) {
                throw new ARException(rtrim($matches[2], ' ;'), $matches[1]);
            }

            throw $e;

        }

    }

}

class ClientException extends \Exception
{}
class ARException extends \Exception
{}
