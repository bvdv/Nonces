<?php
declare(strict_types=1);

namespace Bvdv\Nonces;

/**
 * Abstract Nonce class.
 */
abstract class NonceAbstract implements NonceInterface
{
    /**
     * Action string.
     *
     * @var string $action The nonce action value.
     */
    private $action;

    /**
     * Name of the nonce.
     *
     * @var string $name The nonce request name.
     */
    private $name;

    /**
     * Nonce value.
     *
     * @var string $nonce The nonce value.
     */
    protected $nonce;

    /**
     * NonceAbstract constructor.
     *
     * @param string $paramAction The parameter action.
     * @param string $paramName   The parameter name.
     */
    public function __construct(string $paramAction, string $paramName)
    {
        is_string($paramAction) ? $this->changeAction($paramAction) : $this->changeAction('');
        is_string($paramName) ? $this->changeName($paramName) : $this->changeName('_wpnonce');
    }

    /**
     * Get action property.
     *
     * @return string Action value.
     */
    public function action(): string
    {
        return $this->action;
    }

    /**
     * Change or set action property.
     *
     * @param  string $paramAction The nonce action value.
     * @return string $action      Changed action value.
     */
    public function changeAction(string $paramAction): string
    {
        $this->action = $paramAction;

        return $this->action();
    }

    /**
     * Get request name property.
     *
     * @return string $name The nonce name value.
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Change or set request name property.
     *
     * @param  string $paramName The nonce name value.
     * @return string $name      Changed name value.
     */
    public function changeName(string $paramName): string
    {
        $this->name = $paramName;

        return $this->name();
    }

    /**
     * Get nonce property.
     *
     * @return string $nonce Nonce value.
     */
    public function nonce(): string
    {
        return $this->nonce;
    }

    /**
     * Change or set nonce property.
     *
     * @param  string $paramNonce The nonce value to change or set.
     * @return string $nonce      Changed nonce value.
     */
    public function changeNonce(string $paramNonce): string
    {
        $this->nonce = $paramNonce;

        return $this->nonce();
    }
}
