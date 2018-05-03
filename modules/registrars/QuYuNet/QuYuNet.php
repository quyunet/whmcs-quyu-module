<?php
/*
User Documents: http://www.quyu.net/info/userdocs
OTE Platform: http://ote.quyu.net
Official Website: http://www.quyu.net
API Documents: http://www.quyu.net/knowledgebase.php?action=displaycat&catid=8
*/
/* ***********************************************************************
 * Customization Development Services by QuYu.Net                        *
 * Copyright (c) ShenZhen QuYu Tech CO.,LTD, All Rights Reserved         *
 * (2013-09-23, 12:16:25)                                                *
 *                                                                       *
 *                                                                       *
 *  CREATED BY QUYU,INC.           ->       http://www.quyu.net          *
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

if (!defined('DS'))
	define('DS', DIRECTORY_SEPARATOR);

include_once dirname(__FILE__) . DS . 'class.api.php';

/**
* FUNCTION QuYuNet_getConfigArray()
* @param array $params
* @return array $return
*/
function QuYuNet_getConfigArray() {
	$configarray = array(
		"FriendlyName" => array(
			"Type"          => "System",
			"Value"         => "QuYu.NET"
		),
		"Description" => array(
			"Type"          => "System",
			"Value"         => "Don't have an QuYu Account yet? Get one here: <a href=\"http://www.quyu.net\">www.quyu.net</a>"
		),
		"api_email" => array(
			"FriendlyName"  => "User Email",
			"Type"          => "text",
			"Size"          => "40",
			"Description"   => "Enter your email used in the main WHMCS"
		),
		"api_key" => array(
			"FriendlyName"  => "API Key",
			"Type"          => "password",
			"Size"          => "40",
			"Description"   => "Enter your API key recived from provider"
		),
	);
	return $configarray;
}

/**
* FUNCTION QuYuNet_RegisterDomain()
* Register Domain
* @param array $params
* @return array $return
*/
function QuYuNet_RegisterDomain($params) {
	$API = new QuYuNet_API($params['api_email'], $params['api_key']);
        $requeststring = array(
		'action'		=> 'RegisterDomain',
		'sld'			=> $params["sld"],
		'tld'			=> $params["tld"],
		'regperiod'		=> $params["regperiod"],
		'nameserver1'           => $params["ns1"],
		'nameserver2'           => $params["ns2"],
		'nameserver3'           => $params["ns3"],
		'nameserver4'           => $params["ns4"],
		'nameserver5'           => $params["ns5"],
		'dnsmanagement'		=> $params['dnsmanagement']	? 1 : 0,
		'emailforwarding'	=> $params['emailforwarding']	? 1 : 0,
		'idprotection'		=> $params['idprotection']	? 1 : 0,
                'firstname'             => $params["firstname"],
		'lastname'		=> $params["lastname"],
		'companyname'           => $params["companyname"],
		'address1'		=> $params["address1"],
		'address2'		=> $params["address2"],
		'city'                  => $params["city"],
		'state'                 => $params["state"],
		'country'		=> $params["country"],
		'postcode'		=> $params["postcode"],
		'phonenumber'           => $params["phonenumber"],
                'fullphonenumber'       => $params["fullphonenumber"],
		'email'                 => $params["adminemail"],
		'adminfirstname'	=> $params["adminfirstname"],
		'adminlastname'		=> $params["adminlastname"],
		'admincompanyname'	=> $params["admincompanyname"],
		'adminaddress1'		=> $params["adminaddress1"],
		'adminaddress2'		=> $params["adminaddress2"],
		'admincity'		=> $params["admincity"],
		'adminstate'		=> $params["adminstate"],
		'admincountry'		=> $params["admincountry"],
		'adminpostcode'		=> $params["adminpostcode"],
		'adminphonenumber'	=> $params["adminphonenumber"],
                'adminfullphonenumber'  => $params["adminfullphonenumber"],
		'adminemail'		=> $params["adminemail"],
                'domainfields'          => base64_encode(serialize(array_values($params["additionalfields"])))
	);
	$result = $API->simpleCall('POST', $requeststring);
        if($API->getError() == '----536b775905076----')
        {
            $result = $API->simpleCall('POST', $requeststring);
        }

	return $API->getError() ? array( 'error' => $API->getError() ) : 'success';
}

/**
* FUNCTION QuYuNet_TransferDomain()
* Transfer Domain
* @param array $params
* @return array $return
*/
function QuYuNet_TransferDomain($params) {
	$API = new QuYuNet_API($params['api_email'], $params['api_key']);
	$API->simpleCall('POST', array(
                'action'		=> 'TransferDomain',
		'transfersecret'        => $params['transfersecret'],
		'sld'			=> $params["sld"],
		'tld'			=> $params["tld"],
		'regperiod'		=> $params["regperiod"],
		'nameserver1'           => $params["ns1"],
		'nameserver2'           => $params["ns2"],
		'nameserver3'           => $params["ns3"],
		'nameserver4'           => $params["ns4"],
		'nameserver5'           => $params["ns5"],
		'dnsmanagement'		=> $params['dnsmanagement']	? 1 : 0,
		'emailforwarding'	=> $params['emailforwarding']	? 1 : 0,
		'idprotection'		=> $params['idprotection']	? 1 : 0,
                'firstname'             => $params["firstname"],
		'lastname'		=> $params["lastname"],
		'companyname'           => $params["companyname"],
		'address1'		=> $params["address1"],
		'address2'		=> $params["address2"],
		'city'                  => $params["city"],
		'state'                 => $params["state"],
		'country'		=> $params["country"],
		'postcode'		=> $params["postcode"],
		'phonenumber'           => $params["phonenumber"],
                'fullphonenumber'       => $params["fullphonenumber"],
		'email'                 => $params["email"],
		'adminfirstname'	=> $params["adminfirstname"],
		'adminlastname'		=> $params["adminlastname"],
		'admincompanyname'	=> $params["admincompanyname"],
		'adminaddress1'		=> $params["adminaddress1"],
		'adminaddress2'		=> $params["adminaddress2"],
		'admincity'		=> $params["admincity"],
		'adminstate'		=> $params["adminstate"],
		'admincountry'		=> $params["admincountry"],
		'adminpostcode'		=> $params["adminpostcode"],
		'adminphonenumber'	=> $params["adminphonenumber"],
                'adminfullphonenumber'  => $params["adminfullphonenumber"],
		'adminemail'		=> $params["adminemail"],
                'domainfields'          => base64_encode(serialize(array_values($params["additionalfields"])))
	));

	return $API->getError() ? array( 'error' => $API->getError() ) : 'success';
}

/**
* FUNCTION QuYuNet_RenewDomain
* Renew Domain
* @param array $params
* @return array $return
*/
function QuYuNet_RenewDomain($params) {
	$API = new QuYuNet_API($params['api_email'], $params['api_key']);
	$API->simpleCall('POST', array(
		'action'		=> 'RenewDomain',
		'sld'			=> $params["sld"],
		'tld'			=> $params["tld"],
		'regperiod'		=> $params["regperiod"],
	));

	return $API->getError() ? array( 'error' => $API->getError() ) : 'success';
}

/**
* FUNCTION QuYuNet_getNameserver
* Get name servers
* @param array $params
* @return array $return
*/
function QuYuNet_GetNameservers($params){
        $API  = new QuYuNet_API($params['api_email'], $params['api_key']);
	$data = $API->simpleCall('POST', array(
		'action'		=> 'GetNameservers',
                'sld'			=> $params["sld"],
		'tld'			=> $params["tld"],
	));

        if($data['result']=='success'){
            for($i=1;$i<=5;$i++)
            {
                $return['ns'.$i] = $data['ns'.$i];
            }
        } else return array('error'=>$API->getError());
        return $return;
}

/**
* FUNCTION QuYuNet_SaveNameservers
* Save nameservers
* @param array $params
* @return array $return
*/
function QuYuNet_SaveNameservers($params){
    $API  = new QuYuNet_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'                => 'SaveNameservers',
            'sld'                   => $params["sld"],
            'tld'                   => $params["tld"],
            'nameserver1'           => $params["ns1"],
            'nameserver2'           => $params["ns2"],
            'nameserver3'           => $params["ns3"],
            'nameserver4'           => $params["ns4"],
            'nameserver5'           => $params["ns5"],
    ));

    if($data['result']=='success')
        return true;
    else
        return array('error'=>$API->getError());

}

/**
* FUNCTION QuYuNet_ReleaseDomain
* Release Domain
* @param array $params
* @return array $return
*/
function QuYuNet_ReleaseDomain($params){
    $API  = new QuYuNet_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'		=> 'ReleaseDomain',
            'sld'		=> $params["sld"],
            'tld'		=> $params["tld"],
            'newtag'            => $params['transfertag']
    ));

    if($data['result']=='success')
        return true;
    else
        return array('error'=>$API->getError());
}


/**
* FUNCTION QuYuNet_getEPPCode
* Get EPP Code
* @param array $params
* @return array $return
*/
function QuYuNet_GetEPPCode($params){
    $API  = new QuYuNet_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'		=> 'GetEPPCode',
            'sld'		=> $params["sld"],
            'tld'		=> $params["tld"],
    ));


    if($data['result']=='success'){
        return array('eppcode'=>$data['eppcode']);
    }
    else
        return array('error'=>$API->getError());
}

/**
* FUNCTION QuYuNet_getContactDetails
* Get Contact Details
* @param array $params
* @return array $return
*/
function QuYuNet_GetContactDetails($params){
    $API  = new QuYuNet_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'		=> 'GetContactDetails',
            'sld'		=> $params["sld"],
            'tld'		=> $params["tld"],
    ));

    if($data['result']=='success'){
        unset($data['result']);
        $new = array();
        foreach($data as $key=>$val){
            foreach($val as $k => $v){
                $new[$key][str_replace('_', ' ',$k)] = $v;
            }
        }

        return $new;
    } else
        return array('error'=>$API->getError());

}

/**
* FUNCTION QuYuNet_SaveContactDetails
* Save Contact Details
* @param array $params
* @return array $return
*/
function QuYuNet_SaveContactDetails($params){
    $new = array();
        foreach($params['contactdetails'] as $key=>$val){
            foreach($val as $k => $v){
                $new[$key][str_replace(' ', '_',$k)] = $v;
            }
    }

    $API  = new QuYuNet_API($params['api_email'], $params['api_key']);
    $te = array(
            'action'		=> 'SaveContactDetails',
            'sld'		=> $params["sld"],
            'tld'		=> $params["tld"],
            'contactdetails'    => $new,
    );

    $data = $API->simpleCall('POST', $te);

    if($data['result']=='success'){
        unset($data['result']);
        return $data;
    } else
        return array('error'=>$API->getError());

}


/**
* FUNCTION QuYuNet_GetDomainFields
* Get Additional Domain Fields
* @param array $params
* @return array $return
*/
function QuYuNet_GetDomainFields(){
    global $additionaldomainfields;
    $query = mysql_query("SELECT `setting`,`value` FROM `tblregistrars` WHERE `registrar`='QuYuNet'");
    $params = array();

    while($r = mysql_fetch_assoc($query)){
        $params[$r['setting']] = decrypt($r['value']);
    }

    if(empty($params))
        return false;

    $API  = new QuYuNet_API($params['api_email'], $params['api_key']);
    $vars =  array(
        'action' => 'GetDomainFields'
    );
    $data = $API->simpleCall('POST', $vars);
    if(is_array($data)){
       $merge = array_merge($additionaldomainfields,$data);
           return $merge;
    }

}


/**
* FUNCTION QuYuNet_getRegistrarLock
* Get Lock Status
* @param array $params
* @return array $return
*/
function QuYuNet_GetRegistrarLock($params){
    $API  = new QuYuNet_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'		=> 'domaingetlockingstatus',
            'sld'		=> $params["sld"],
            'tld'		=> $params["tld"],
    ));


    if($data['result']=='success'){
        if($data['lockstatus']=='Unknown')
            return "";
        return $data['lockstatus'];
    }
    else
        return array('error'=>$API->getError());
}


/**
* FUNCTION QuYuNet_SaveRegistrarLock
* Update Lock Status
* @param array $params
* @return array $return
*/
function QuYuNet_SaveRegistrarLock($params){
    $API  = new QuYuNet_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'		=> 'domainupdatelockingstatus',
            'sld'		=> $params["sld"],
            'tld'		=> $params["tld"],
            'lockenabled'       => $params['lockenabled']
    ));


    if($data['result']=='success'){
        return true;
    }else if($data['result']=='empty')
        return;
    else
        return array('error'=>$API->getError());
}

/**
* FUNCTION QuYuNet_GetDNS
* Get DNS Records
* @param array $params
* @return array $return
*/
function QuYuNet_GetDNS($params){
    $API  = new QuYuNet_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'		=> 'GetDNS',
            'sld'		=> $params["sld"],
            'tld'		=> $params["tld"],
            'regperiod'         => $params['regperiod'],
            'regtype'           => $params['regtype'],
    ));

    if($data['result']=='success'){
        unset($data['result']);
        return $data;
    } else
        return array(
           'error' => $API->getError()
       );
}

/**
* FUNCTION QuYuNet_SaveDNS
* Save DNS Records
* @param array $params
* @return array $return
*/
function QuYuNet_SaveDNS($params){
    $API  = new QuYuNet_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'		=> 'SaveDNS',
            'sld'		=> $params["sld"],
            'tld'		=> $params["tld"],
            'regperiod'         => $params['regperiod'],
            'regtype'           => $params['regtype'],
            'dnsrecords'        => base64_encode(serialize($params['dnsrecords']))
    ));

    if($data['result']=='success'){
        return 'success';
    } else {
       return array(
           'error' => $API->getError()
       );
    }
}

/**
* FUNCTION QuYuNet_RegisterNameserver
* Register Name Server
* @param array $params
* @return array $return
*/
function QuYuNet_RegisterNameserver($params){
    $API  = new QuYuNet_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'		=> 'RegisterNameserver',
            'sld'		=> $params["sld"],
            'tld'		=> $params["tld"],
            'regperiod'         => $params['regperiod'],
            'nameserver'        => $params['nameserver'],
            'ipaddress'         => $params['ipaddress'],
            'regtype'           => $params['regtype']
    ));

    if($data['result']=='success'){
        return 'success';
    } else {
       return array(
           'error' => $API->getError()
       );
    }
}

/**
* FUNCTION QuYuNet_ModifyNameserver
* Update Name Server
* @param array $params
* @return array $return
*/
function QuYuNet_ModifyNameserver($params){
    $API  = new QuYuNet_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'		=> 'ModifyNameserver',
            'sld'		=> $params["sld"],
            'tld'		=> $params["tld"],
            'regperiod'         => $params['regperiod'],
            'nameserver'        => $params['nameserver'],
            'currentipaddress'  => $params['currentipaddress'],
            'newipaddress'      => $params['newipaddress'],
            'regtype'           => $params['regtype']
    ));

    if($data['result']=='success'){
        return 'success';
    } else {
       return array(
           'error' => $API->getError()
       );
    }

}

/**
* FUNCTION QuYuNet_DeleteNameserver
* Delete Name Server
* @param array $params
* @return array $return
*/
function QuYuNet_DeleteNameserver($params){
    $API  = new QuYuNet_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'		=> 'DeleteNameserver',
            'sld'		=> $params["sld"],
            'tld'		=> $params["tld"],
            'regperiod'         => $params['regperiod'],
            'nameserver'        => $params['nameserver'],
            'regtype'           => $params['regtype']
    ));

    if($data['result']=='success'){
        return 'success';
    } else {
       return array(
           'error' => $API->getError()
       );
    }

}

/**
* FUNCTION QuYuNet_RequestDelete
* Delete Domain
* @param array $params
* @return array $return
*/
function QuYuNet_RequestDelete($params){
    $API  = new QuYuNet_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'		=> 'RequestDelete',
            'sld'		=> $params["sld"],
            'tld'		=> $params["tld"],
            'regperiod'         => $params['regperiod'],
            'regtype'           => $params['regtype']
    ));
    $values = array();
    if($data['result']=='success'){
        return 'success';
    } else {
        $values['error'] = $API->getError();
    }

    return $values;
}


/**
* FUNCTION QuYuNet_TransferSync
* Synchronize transfer domain
* @param array $params
* @return array $return
*/
function QuYuNet_TransferSync($params) {
    $API  = new QuYuNet_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'		=> 'TransferSync',
            'sld'		=> $params["sld"],
            'tld'		=> $params["tld"],
            'regperiod'         => $params['regperiod'],
            'domain'            => $params['sld'].'.'.$params['tld']
    ));
    $values = array();
    if($data['result']=='success'){
        unset($data['result']);
        return $data;
    } else {
        $values['error'] = $API->getError();
    }

    return $values;
}


/**
* FUNCTION QuYuNet_Sync
* Synchronize Registered Domains
* @param array $params
* @return array $return
*/
function QuYuNet_Sync($params) {
    $API  = new QuYuNet_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'		=> 'Sync',
            'sld'		=> $params["sld"],
            'tld'		=> $params["tld"],
            'domain'            => $params['sld'].'.'.$params['tld']
    ));
    $values = array();
    if($data['result']=='success'){
          unset($data['result']);
          if($data['status']=='Active')
          {
              $values['active']       = true;
          } else {

              if (strtotime(date( "Ymd" )) <= strtotime( $data['expirydate'] )) {
                   $values['expirydate'] = $data['expirydate'];
                   $values["active"]  = true;
              }
              else {
                   $values['expirydate'] = $data['expirydate'];
                   $values["expired"] = true;
              }
          }
          return $values;
    } else {
        $values['error'] = $API->getError();
    }

    return $values;
}


/**
* FUNCTION QuYuNet_GetEmailForwarding
* Get list of emails aliases
* @param array $params
* @return array $return
*/
function QuYuNet_GetEmailForwarding($params)
  {
    $API  = new QuYuNet_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'		=> 'GetEmailForwarding',
            'sld'		=> $params["sld"],
            'tld'		=> $params["tld"],
            'regperiod'         => $params['regperiod'],
            'regtype'           => $params['regtype']
    ));
    if($data['result']=='success'){
        unset($data['result']);
        return $data;
    }
}


/**
* FUNCTION QuYuNet_SaveEmailForwarding
* Save list of emails aliases
* @param array $params
* @return array $return
*/
function QuYuNet_SaveEmailForwarding($params)
{
    $API  = new QuYuNet_API($params['api_email'], $params['api_key']);
    $data = $API->simpleCall('POST', array(
            'action'		=> 'SaveEmailForwarding',
            'sld'		=> $params["sld"],
            'tld'		=> $params["tld"],
            'regperiod'         => $params['regperiod'],
            'regtype'           => $params['regtype'],
            'prefix'            => base64_encode(serialize($params['prefix'])),
            'forwardto'         => base64_encode(serialize($params['forwardto']))
    ));
    if($data['result']=='success'){
        return $data;
    } else
        return array(
           'error' => $API->getError()
       );
}
