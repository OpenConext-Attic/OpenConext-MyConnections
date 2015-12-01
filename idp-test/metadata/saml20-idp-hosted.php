<?php
/**
 * SAML 2.0 IdP configuration for simpleSAMLphp.
 *
 * See: https://simplesamlphp.org/docs/stable/simplesamlphp-reference-idp-hosted
 */

$metadata['__DYNAMIC:1__'] = array(
	/*
	 * The hostname of the server (VHOST) that will use this SAML entity.
	 *
	 * Can be '__DEFAULT__', to use this entry by default.
	 */
	'host' => '__DEFAULT__',

	/* X.509 key and certificate. Relative to the cert directory. */
	'privatekey' => 'server.pem',
	'certificate' => 'server.crt',

	/*
	 * Authentication source to use. Must be one that is configured in
	 * 'config/authsources.php'.
	 */
	'auth' => 'example-userpass',
    'userid.attribute' => 'urn:oid:1.2.840.113549.1.9.1',
    'authproc'           => array(
        40 => array(
            'class'     => 'saml:PersistentNameID',
            'attribute' => 'mail',
        ),
        60 => array(
            'class'     => 'saml:PersistentNameID2TargetedID',
            'attribute' => 'urn:oid:1.3.6.1.4.1.5923.1.1.1.10',
            'nameId'    => true,
        ),
        90 => array(
            'class' => 'core:AttributeMap',
            'name2oid',
        ),
    ),
    'attributes.NameFormat' => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
    'attributeencodings'    => array(
        'urn:oid:1.3.6.1.4.1.5923.1.1.1.10' => 'raw', /* eduPersonTargetedID with oid NameFormat is a raw XML value */
    ),

	/*
	 * WARNING: SHA-1 is disallowed starting January the 1st, 2014.
	 *
	 * Uncomment the following option to start using SHA-256 for your signatures.
	 * Currently, simpleSAMLphp defaults to SHA-1, which has been deprecated since
	 * 2011, and will be disallowed by NIST as of 2014. Please refer to the following
	 * document for more information:
	 *
	 * http://csrc.nist.gov/publications/nistpubs/800-131A/sp800-131A.pdf
	 *
	 * If you are uncertain about service providers supporting SHA-256 or other
	 * algorithms of the SHA-2 family, you can configure it individually in the
	 * SP-remote metadata set for those that support it. Once you are certain that
	 * all your configured SPs support SHA-2, you can safely remove the configuration
	 * options in the SP-remote metadata set and uncomment the following option.
	 *
	 * Please refer to the IdP hosted reference for more information.
	 */
	'signature.algorithm' => 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256',
    'saml20.sign.response' => true,
    'saml20.sign.assertion' => true,

	/* Uncomment the following to use the uri NameFormat on attributes. */
	/*
	'authproc' => array(
		// Convert LDAP names to oids.
		100 => array('class' => 'core:AttributeMap', 'name2oid'),
	),
	*/
    'NameIDFormat' => 'urn:oasis:names:tc:SAML:2.0:nameid-format:persistent'
	/*
	 * Uncomment the following to specify the registration information in the
	 * exported metadata. Refer to:
     * http://docs.oasis-open.org/security/saml/Post2.0/saml-metadata-rpi/v1.0/cs01/saml-metadata-rpi-v1.0-cs01.html
	 * for more information.
	 */
	/*
	'RegistrationInfo' => array(
		'authority' => 'urn:mace:example.org',
		'instant' => '2008-01-17T11:28:03Z',
		'policies' => array(
			'en' => 'http://example.org/policy',
			'es' => 'http://example.org/politica',
		),
	),
	*/
);
