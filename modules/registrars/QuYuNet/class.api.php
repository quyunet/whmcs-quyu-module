<?php

/* ***********************************************************************
 * Customization Development Services by QuYu.Net                        *
 * Copyright (c) ShenZhen QuYu Tech CO.,LTD, All Rights Reserved         *
 * (2013-09-23, 12:16:25)                                                *
 *                                                                       *
 *                                                                       *
 *  CREATED BY QUYU                ->       http://www.quyu.net          *
 *  CONTACT                        ->       support@quyu.net             *
 *                                                                       *
 *                                                                       *
 *                                                                       *
 *                                                                       *
 * This software is furnished under a license and may be used and copied *
 * only  in  accordance  with  the  terms  of such  license and with the *
 * inclusion of the above copyright notice.  This software  or any other *
 * copies thereof may not be provided or otherwise made available to any *
 * other person.  No title to and  ownership of the  software is  hereby *
 * transferred.                                                          *
 *                                                                       *
 *                                                                       *
 * ******************************************************************** */

if (!class_exists('QuYuNet_API')) {

    class QuYuNet_API {

        protected $_ch        = null;
        protected $_timeout   = 40;
        protected $_response  = null;
        protected $_url       = null;
        protected $_email     = null;
        protected $_key       = null;
        protected $_debug     = true;

        public function __construct( $email, $key) {
            $this->_url     = "http://api.quyu.net/api.php";
            $this->_email   = $email;
            $this->_key     = $key;
        }

        protected function getSecretApiVars(){
            return array('key','transfersecret');
        }

        public function setDebugMode($mode = true) {
            $this->_debug = $mode;
        }

        public function getError() {
            return $this->_error;
        }

        public function getResponse() {
            return $this->_response;
        }

        public function setTimeout($timeout) {
            $this->_timeout = $timeout;
        }

        /**
         *
         * @param string $method POST|GET|PUT|DELETE
         * @param array $postdata
         * @return array|bool json_decode
         */
        public function simpleCall($method, array $postdata = array()) {

            $this->_error   = null;
            $alowed_methods = array('GET', 'POST', 'PUT', 'DELETE');
            if (!in_array($method, $alowed_methods)) {
                $this->_error = 'Wrong request method.';
                return false;
            }
            if (!$this->_email || !$this->_key || !$this->_url) {
                $this->_error = 'Wrong reseller API configuration';
                return false;
            }

            $postdata['token']      = $this->_key;
            $postdata['authemail']  = $this->_email;
            $data                   = $postdata;

            $this->_ch          = curl_init();
            curl_setopt($this->_ch, CURLOPT_URL, $this->_url);
            curl_setopt($this->_ch, CURLOPT_TIMEOUT, $this->_timeout);
            curl_setopt($this->_ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($this->_ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($this->_ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($this->_ch, CURLOPT_HEADER, true);
            curl_setopt($this->_ch, CURLINFO_HEADER_OUT, 1);

            $result = array();
            $result['response_body'] = curl_exec($this->_ch);
            $result['info']          = curl_getinfo($this->_ch);
            $curlHeaderSize          = $result['info']['header_size'];
            $result['headers']       = substr($result['response_body'], 0, $curlHeaderSize);
            $result['response_body'] = substr($result['response_body'], $curlHeaderSize);
            $this->_response = $result;
            //echo $this->_response['response_body'];die();
            $res = json_decode($this->_response['response_body'], true);
            if(is_string($this->_response['response_body']) && empty($res)){
                $this->_error = $this->_response['response_body'];
                return;
            }
            // adds log
            if ($this->_debug && !empty($res)){
                $this->logModuleCall($postdata['action'], $postdata, print_r($res, true));
            }
            if (empty($res)){
                $curlErr = curl_error($this->_ch);
                $this->_error = $curlErr ? $curlErr : 'Response body is empty for method: ' . $method;
                return false;
            } else {
                if (!empty($res['errors'])){
                    $this->_error = implode(' ', $res['errors']);
                    return false;
                }

                if(!empty($res['result']) && $res['result']=='error'){
                    $this->_error = $res['msg'];
                    return false;
                }


                return $res;
            }
        }

        /**
         * WHMCS Module Log call
         * @param string $method
         * @param string $resource
         * @param array $params
         * @param string $response
         * @return type
         */
        private function logModuleCall($action, array $params, $response) {
            if (function_exists('logModuleCall')) {
                // hide some values
                foreach ($this->getSecretApiVars() as $key){
                    if (isset($params[$key]))
                        $params[$key] = substr($params[$key], 0, 3) . '...';
                }
                return logModuleCall(
                    'QuYuNet',
                    $action,
                    print_r($params, true),
                    '',
                    $response
                );
            }
        }

    }

}