<?php
declare(strict_types=1);

namespace Bvdv\Nonces;

/**
 * Class for Wp Nonce.
 */
class WpNonce extends NonceAbstract
{

    /**
     * NonceGenerator constructor.
     *
     * @param $paramAction
     * @param string|null $paramName
     */
    public function __construct($paramAction, $paramName = '_wpnonce')
    {
        parent::__construct($paramAction, $paramName);
    }

    /**
     * Generate nonce string
     *
     * @return string|null
     */
    public function createWpNonce()
    {
        $this->setNonce(wp_create_nonce($this->getAction()));
        return $this->getNonce();
    }

    /**
     * Generate url with nonce value parameter
     *
     * @param $paramActionUrl
     * @return mixed|null
     */
    public function createWpNonceUrl($paramActionUrl)
    {
        $this->createWpNonce();

        $name = $this->getName();
        $action = $this->getAction();
        $actionUrl = str_replace('&amp;', '&', $paramActionUrl);

        return wp_nonce_url($actionUrl, $action, $name);
    }

    /**
     * Validate the nonce.
     *
     * @return    boolean|null $isValid False if the nonce is invalid. Otherwise, returns true.
     */
    private function validate()
    {
        $isValid = wp_verify_nonce($this->getNonce(), $this->getAction());
        if (false === $isValid) {
            return $isValid;
        }
            return true;
    }

    /**
     * Validate the nonce from the request.
     *
     * @return bool|null
     */
    public function validateRequest()
    {
        $isValid = false;
        if (isset($_REQUEST[ $this->getName() ])) {
            $nonceReceived = sanitize_text_field(wp_unslash($_REQUEST[ $this->getName() ]));
            $this->setNonce($nonceReceived);
            $isValid = $this->validate();
        }
        return $isValid;
    }

    /**
     * Validate nonce
     *
     * @param $paramNonce
     * @return bool|null
     */
    public function validateNonce(string $paramNonce)
    {
        $isValid = false;

        $this->setNonce($paramNonce);
        $isValid = $this->validate();
        return $isValid;
    }

    /**
     * Generate the nonce field html tags
     *
     * @param bool $paramReferer
     * @param bool $paramEcho
     * @return string|null
     */
    public function createNonceField(bool $paramReferer = true, bool $paramEcho = true)
    {
        $this->createWpNonce();
        $name = $this->getName();
        $action = $this->getAction();
        $nonce = $this->getNonce();
        $name = esc_attr($name);

        return wp_nonce_field($action, $name, $paramReferer, $paramEcho);
    }
}
