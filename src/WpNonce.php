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
     * @param string $paramAction
     * @param string $paramName
     */
    public function __construct($paramAction, $paramName = '_wpnonce')
    {
        parent::__construct($paramAction, $paramName);

        $this->nonce = wp_create_nonce($this->action());
    }

    /**
     * Create url with nonce value parameter
     *
     * @param  string $paramActionUrl
     * @return string
     */
    public function createWpNonceUrl($paramActionUrl): string
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
        $isRequestValid = false;

        if (isset($_REQUEST[ $this->name() ])) {
            $nonceReceived = sanitize_text_field(wp_unslash($_REQUEST[ $this->name() ]));
            $this->changeNonce($nonceReceived);
            $isRequestValid = $this->validate();
        }

        return $isRequestValid;
    }

    /**
     * Validate nonce
     *
     * @param  string $paramNonce Nonce value.
     * @return bool
     */
    public function validateNonce(string $paramNonce): bool
    {
        $this->changeNonce($paramNonce);
        return $this->validate();
    }

    /**
     * Create the nonce field html tags form
     *
     * @param  bool $paramReferer Whether to set the referer field for validation.
     * @param  bool $paramEcho    Whether to display or return hidden form field.
     * @return string
     */
    public function createNonceField(bool $paramReferer = true, bool $paramEcho = true): string
    {
        return wp_nonce_field($this->action(), $this->name(), $paramReferer, $paramEcho);
    }
}
