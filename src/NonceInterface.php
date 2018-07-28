<?php
declare(strict_types=1);

namespace Bvdv\Nonces;

/**
 * Nonce interface.
 */
interface NonceInterface
{

    /**
     * Get the Wp action
     *
     * @return string $action value.
     */
    public function action();

    /**
     * Set the Wp action.
     *
     * @param string $paramAction The parameter action.
     */
    public function changeAction(string $paramAction);

    /**
     * Get signature for name property.
     *
     * @return string $name The nonce name value.
     */
    public function name();

    /**
     * Set signature for name property.
     *
     * @param  string $paramName Name for the nonce value to set.
     * @return string $name The nonce name value set.
     */
    public function changeName(string $paramName);

    /**
     * Get signature for nonce property.
     *
     * @return string $nonce Nonce value.
     */
    public function nonce();

    /**
     * Set signature for nonce property.
     *
     * @param  string $paramNonce Nonce value to set.
     * @return string $nonce      Nonce value set.
     */
    public function changeNonce(string $paramNonce);
}
