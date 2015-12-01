<?php
/**
 * SAML 2.0 remote SP metadata for simpleSAMLphp.
 *
 * See: https://simplesamlphp.org/docs/stable/simplesamlphp-reference-sp-remote
 */

/*
 * Example simpleSAMLphp SAML 2.0 SP
 */
//$metadata['https://saml2sp.example.org'] = array(
//	'AssertionConsumerService' => 'https://saml2sp.example.org/simplesaml/module.php/saml/sp/saml2-acs.php/default-sp',
//	'SingleLogoutService' => 'https://saml2sp.example.org/simplesaml/module.php/saml/sp/saml2-logout.php/default-sp',
//);
$metadata['google.com'] = array(
    'AssertionConsumerService' => 'https://www.google.com/a/g.feide.no/acs',
    'NameIDFormat' => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
    'simplesaml.nameidattribute' => 'uid',
    'simplesaml.attributes' => FALSE,
);

$metadata['https://gw-dev.stepup.coin.surf.net/app_dev.php/authentication/metadata'] = array(
    'entityid'                 => 'https://gw-dev.stepup.coin.surf.net/app_dev.php/authentication/metadata',
    'contacts'                 => array(),
    'metadata-set'             => 'saml20-sp-remote',
    'AssertionConsumerService' => array(
        0 => array(
            'Binding'  => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
            'Location' => 'https://gw-dev.stepup.coin.surf.net/app_dev.php/authentication/consume-assertion',
            'index'    => 0,
        ),
    ),
    'SingleLogoutService'      => array(),
    'saml20.sign.response' => false,
    'saml20.sign.assertion' => true,
);

$metadata['https://gw-dev.stepup.coin.surf.net/app_dev.php/gssp/tiqr/metadata'] = array(
    'entityid'                 => 'https://gw-dev.stepup.coin.surf.net/app_dev.php/gssp/tiqr/metadata',
    'contacts'                 => array(),
    'metadata-set'             => 'saml20-sp-remote',
    'AssertionConsumerService' => array(
        0 => array(
            'Binding'  => 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST',
            'Location' => 'https://gw-dev.stepup.coin.surf.net/app_dev.php/gssp/tiqr/consume-assertion',
            'index'    => 0,
        ),
    ),
    'SingleLogoutService'      => array(),
    'saml20.sign.response' => false,
    'saml20.sign.assertion' => true,
);

/*
 * This example shows an example config that works with Google Apps for education.
 * What is important is that you have an attribute in your IdP that maps to the local part of the email address
 * at Google Apps. In example, if your google account is foo.com, and you have a user that has an email john@foo.com, then you
 * must set the simplesaml.nameidattribute to be the name of an attribute that for this user has the value of 'john'.
 */
//$metadata['google.com'] = array(
//	'AssertionConsumerService' => 'https://www.google.com/a/g.feide.no/acs',
//	'NameIDFormat' => 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress',
//	'simplesaml.nameidattribute' => 'uid',
//	'simplesaml.attributes' => FALSE,
//);
