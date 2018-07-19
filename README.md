# Nonces

OOP package for WordPress nonces.


Code Style according to https://github.com/inpsyde/php-coding-standards

was checked with parameters: phpcs.bat --standard="Inpsyde" ..\bvdv\nonces\src


### Usage

Create WpNonce class object:

```$wpNonceObj = new WpNonce( 'actionName', 'nonceParameterName' );```

To generate the nonce use createNonce() method:

$nonce = $wpNonceObj->createNonce();

Create url with nonce parameter:

$url = $wpNonceObj->createNonceUrl( 'www.github.com' );

Create nonce field form:

$fieldForm = $wpNonceObj->createNonceField();

Nonce validation:

$isValid = $wpNonceObj->validateNonce($nonce);

