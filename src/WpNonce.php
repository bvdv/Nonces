<?php
declare(strict_types=1);

namespace Bvdv\Nonces;

/**
 * Class for Wp Nonce.
 */
class WpNonce extends NonceAbstract
{

    /**
     * Wp Nonce constructor.
     *
     * @param $paramAction
     * @param string $paramName
     */
    public function __construct($paramAction, $paramName = '_wpnonce')
    {
        parent::__construct($paramAction, $paramName);
    }

    /**
     * Create nonce string
     *
     * @return string
     */
    public function createWpNonce(): string
    {
        $this->changeNonce(wp_create_nonce($this->action()));
        return $this->nonce();
    }

    /**
     * Create url with nonce value parameter
     *
     * @param $paramActionUrl
     * @return mixed|null
     */
    public function createWpNonceUrl($paramActionUrl)
    {
        $actionUrl = str_replace('&amp;', '&', $paramActionUrl);

        return esc_url_raw(add_query_arg($this->action(), $this->nonce(), $actionUrl));
    }

    /**
     * Validate the nonce.
     *
     * @return bool False if the nonce is invalid. Otherwise, returns true.
     */
    private function validate(): bool
    {
        return (bool) wp_verify_nonce($this->nonce(), $this->action());
    }

    /**
     * Validate the nonce from the request.
     *
     * @return bool
     */
    public function validateRequest(): bool
    {
        $isValid = false;
        if (isset($_REQUEST[ $this->name() ])) {
            $nonceReceived = sanitize_text_field(wp_unslash($_REQUEST[ $this->name() ]));
            $this->changeNonce($nonceReceived);
            $isValid = $this->validate();
        }
        return $isValid;
    }

    /**
     * Validate nonce
     *
     * @param $paramNonce
     * @return bool
     */
    public function validateNonce(string $paramNonce): bool
    {
        $isValid = false;

        $this->changeNonce($paramNonce);
        $isValid = $this->validate();
        return $isValid;
    }

    /**
     * Create the nonce field html tags form
     *
     * @param bool $paramReferer
     * @param bool $paramEcho
     * @return string
     */
    public function createNonceField(bool $paramReferer = true, bool $paramEcho = true): string
    {
        $this->createWpNonce();
        $name = $this->name();
        $action = $this->action();
        $nonce = $this->nonce();
        $name = esc_attr($name);

        return wp_nonce_field($action, $name, $paramReferer, $paramEcho);
    }
}
