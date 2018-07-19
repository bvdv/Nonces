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
        $this->setAction($paramAction);
        $this->setName($paramName);
        //$this->setNonce(null);
    }

    /**
     * Get action property.
     *
     * @return string|null
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set action property.
     *
     * @param string $paramAction
     * @return string|null $action
     */
    public function setAction(string $paramAction)
    {
        $this->action = $paramAction;
        return $this->getAction();
    }

    /**
     * Get request name property.
     *
     * @return string|null $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set request name property.
     *
     * @param string $paramName
     * @return string|null $name
     */
    public function setName(string $paramName)
    {
        $this->name = $paramName;
        return $this->getName();
    }

    /**
     * Get nonce property.
     *
     * @return string|null $nonce.
     */
    public function getNonce()
    {
        return $this->nonce;
    }

    /**
     * Set nonce property.
     *
     * @param string $paramNonce
     * @return string|null $nonce
     */
    public function setNonce(string $paramNonce)
    {
        $this->nonce = $paramNonce;
        return $this->getNonce();
    }
}
