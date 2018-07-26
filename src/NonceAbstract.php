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
     * @var    string $action The nonce action value.
     */
    private $action;

    /**
     * Name of the nonce.
     *
     * @var    string $name The nonce request name.
     */
    private $name;

    /**
     * Nonce value.
     *
     * @var    string $nonce The nonce value.
     */
    private $nonce;

    /**
     * NonceAbstract constructor.
     *
     * @param      string|int  $paramAction  The parameter action
     * @param      string|null  $paramName    The parameter name
     */
    public function __construct($paramAction, $paramName = '_wpnonce')
    {
        $this->changeAction($paramAction);
        $this->changeName($paramName);
    }

    /**
     * Get action property.
     *
     * @return string
     */
    public function action(): string
    {
        return $this->action;
    }

    /**
     * Set action property.
     *
     * @param string $paramAction
     * @return string $action
     */
    public function changeAction(string $paramAction): string
    {
        $this->action = $paramAction;
        return $this->action();
    }

    /**
     * Get request name property.
     *
     * @return string $name
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Set request name property.
     *
     * @param string $paramName
     * @return string $name
     */
    public function changeName(string $paramName): string
    {
        $this->name = $paramName;
        return $this->name();
    }

    /**
     * Get nonce property.
     *
     * @return string $nonce.
     */
    public function nonce(): string
    {
        return $this->nonce;
    }

    /**
     * Set nonce property.
     *
     * @param string $paramNonce
     * @return string $nonce
     */
    public function changeNonce(string $paramNonce): string
    {
        $this->nonce = $paramNonce;
        return $this->nonce();
    }
}
