<?php
namespace Bvdv\Nonces\test;

use Bvdv\Nonces\WpNonces;
use PHPUnit\Framework\TestCase;

class WpNonceTest extends TestCase
{
    /**
     * Test action.
     *
     * @var string $testAction The default test action value.
     */
    private $testAction;
    
    /**
     * Test nonce.
     *
     * @var string The default test nonce value.
     */
    private $testNonce;

    /**
     * Test validator.
     *
     * @var object $testWpNonceObj The default test created object.
     */
    private $testWpNonceObj;

    /**
     * Setting up the test environment.
     */
    protected function setUp()
    {
        $this->testAction = 'action';
        $this->testName = 'name';

        $this->testWpNonceObj1 = new WpNonce($this->testAction);
        $this->testWpNonceObj2 = new WpNonce($this->testAction, $this->testName);
        
        // Building nonce value.
        $this->testNonce = wp_create_nonce($this->testAction);
    }

    /**
     * Test the object instance.
     */
    public function testInstance()
    {
        $this->assertInstanceOf(WpNonce::class, $this->testWpNonceObj2);
        $this->assertInstanceOf(Wpnonce::class, $this->testWpNonceObj1);
    }

    /**
     * Test the getter and setter for the action property.
     */
    public function testGetSetAction()
    {
        $testObj = $this->testWpNonceObj2;

        // Check the getter.
        $this->assertSame($this->testAction, $testObj->action());

        // Check the setter.
        $action = $testObj->changeAction('newAction');
        $this->assertSame($testObj->action(), $action);
    }

    /**
     * Test the getter and setter for the name property.
     */
    public function testGetSetName()
    {
        $testObj = $this->testWpNonceObj2;

        // Check the getter.
        $this->assertSame($this->testName, $testObj->name());

        // Check the setter.
        $name = $testObj->changeName('newName');
        $this->assertSame($testObj->name(), $name);
    }

    /**
     * Test the getter and setter for the name property when default value in the constructor is used.
     */
    public function testDefaultName()
    {
        $testObj = new WpNonce('anotherAction');
        
        // Check the action property getter.
        $this->assertSame('anotherAction', $testObj->action());
        
        // Check the name property getter: the name value now is the default one.
        $this->assertSame('_wpnonce', $testObj->name());
    }

    /**
     * Test the createWpNonce method used for the straight create of the nonce.
     */
    public function testCreateNonce()
    {
        $this->assertSame($this->testWpNonceObj1->nonce(), $this->testNonce);
    }

    /**
     * Test the getter and setter for the nonce property.
     */
    public function testGetSetNonce()
    {
        // Generating the nonce.
        $nonceCreated = $this->testWpNonceObj1->nonce();
        
        // Setting new value for the nonce.
        $this->testWpNonceObj1->changeNonce('newNonce');

        // Getting and cheking the nonce value.
        $this->assertNotEquals($nonceCreated, $this->testWpNonceObj1->nonce());
        $this->assertSame('newNonce', $this->testWpNonceObj1->nonce());
    }

    /**
     * Test the validateNonce method used for the straight validation of the nonce.
     */
    public function testValidateNonce()
    {
        // Check validating method.
        $isValid = $this->testWpNonceObj1->validateNonce($this->testNonce);
        $this->assertTrue($isValid);

        // Injecting wrong value in the nonce.
        $isValid = $this->testWpNonceObj1->validateNonce($this->testNonce . 'failure');
        
        // Check failure on validating.
        $this->assertFalse($isValid);
    }

    /**
     * Test the validateRequest method used for the validation of the nonce through the $_REQUEST.
     */
    public function testValidateRequest()
    {
        $testName = '_wpnonce';

        // Build the $_REQUEST
        $_REQUEST[ $testName ] = $this->testNonce;

        // Checking validation method.
        $isValid = $this->testWpNonceObj1->validateRequest();
        $this->assertTrue($isValid);

        // Injecting wrong value in the nonce.
        $_REQUEST[ $testName ] = $this->testNonce . 'failure';

        // Check failure on validating.
        $isValid = $this->testWpNonceObj1->validateRequest();
        $this->assertFalse($isValid);
    }

    /**
     * Test the createWpNonceUrl method to build an url with a nonce.
     */
    public function testCreateNonceUrl()
    {
        // Create the nonce and build the url.
        $urlCreated = $this->testWpNonceObj1->createWpNonceUrl('http://www.github.com');

        // Building the expected url.
        $urlExpected = 'http://www.github.com?active='. $this->testNonce;

        // Checking result.
        $this->assertSame($urlCreated, $urlExpected);
    }

    /**
     * Test the createNonceField method to build form field with a nonce parameter.
     *
     * referer: false ---> hidden field with refer url value is not added.
     * echo: false ------> the field is not printed.
     */
    public function testCreateNonceField()
    {
        // Create the form field.
        $fieldCreated = $this->testWpNonceObj1->createNonceField(false, false);

        // Building the expected form field.
        $fieldExpected = '<input type="hidden" id="_wpnonce" 
        name="_wpnonce" value="' . $this->testNonce . '" />';

        // Checking result.
        $this->assertSame($fieldCreated, $fieldExpected);
    }

    /**
     * Test the createNonceField method to build form field with a nonce parameter.
     *
     * referer: true ---> hidden field with refer url value is added.
     * echo: false ------> the fields are not printed.
     */
    public function testCreateNonceFieldRef()
    {
        // Create the form field.
        $fieldCreated = $this->testWpNonceObj1->createNonceField(true, false);

        // Building the expected form field.
        $fieldExpected = '<input type="hidden" id="_wpnonce" name="_wpnonce" value="' . $this->testNonce . '" />
        <input type="hidden" name="_wp_http_referer" value="" />';

        // Checking result.
        $this->assertSame($fieldCreated, $fieldExpected);
    }

    /**
     * Test the createNonceField method to build form field with a nonce parameter.
     *
     * referer: false ---> hidden field with refer url value is not added.
     * echo: true ------> the field is printed.
     */
    public function testCreatedNonceFieldEcho()
    {
        // Building the expected form field.
        $fieldExpected = '<input type="hidden" id="_wpnonce" name="_wpnonce" value="' . $this->testNonce . '" />';

        // Check that the result is printed.
        $this->expectOutputString($fieldExpected);

        // Create the form fields. The second parameter defaults to true.
        $fieldCreated = $this->testWpNonceObj1->createNonceField(false);
        ;

        // Checking result.
        $this->assertSame($fieldCreated, $fieldExpected);
    }
}
