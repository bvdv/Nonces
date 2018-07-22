<?php
namespace Bvdv\Nonces\test;

use Bvdv\Nonces\WpNonces;
use PHPUnit\Framework\TestCase;

class WpNonceTest extends TestCase
{
    /**
    * Test action.
    *
    * @var    string $testAction The default test action value.
    */
    private $testAction;
    
    /**
    * Test nonce.
    *
    * @var    string The default test nonce value.
    */
    private $testNonce;

    /**
    * Test validator.
    *
    * @var    object $testWpNonceObj The default test created object.
    */
    private $testWpNonceObj;

    /**
    * Setting up the test environment.
    */
    protected function setUp() {

        $this->testAction = 'action';
        $this->testName = 'name';

        $this->testWpNonceObj1 = new WpNonce( $this->testAction );
        $this->testWpNonceObj2 = new WpNonce( $this->testAction, $this->testName );
        
        // Building nonce value.
        $this->testNonce = wp_create_nonce( $this->testAction );
    }

    /**
    * Test the object instance.
    */
    public function testInstance() {

        $this->assertInstanceOf( WpNonce::class, $this->testWpNonceObj2 );
        $this->assertInstanceOf( Wpnonce::class, $this->testWpNonceObj1 );
    }

    /**
    * Test the getter and setter for the action property.
    */
    public function testGetSetAction() {

        $testObj = $this->testWpNonceObj2;

        // Check the getter.
        $this->assertSame( $this->testAction, $testObj->action() );

        // Check the setter.
        $action = $testObj->changeAction( 'newAction' );
        $this->assertSame( $testObj->action(), $action );
    }

    /**
    * Test the getter and setter for the name property.
    */
    public function testGetSetName() {

        $testObj = $this->testWpNonceObj2;

        // Check the getter.
        $this->assertSame( $this->testName, $testObj->name() );

        // Check the setter.
        $name = $testObj->changeName( 'newName' );
        $this->assertSame( $testObj->name(), $name );
    }

    /**
    * Test the getter and setter for the name property when default value in the constructor is used.
    */
    public function testDefaultName() {

        $testObj = new WpNonce( 'anotherAction' );
        
        // Check the action property getter.
        $this->assertSame( 'anotherAction', $testObj->action() );
        
        // Check the name property getter: the name value now is the default one.
        $this->assertSame( '_wpnonce', $testObj->name() );
    }


    /**
    * Test the createWpNonce method used for the straight create of the nonce.
    */
    public function testCreateNonce() {

        $testObj = $this->testWpNonceObj1;

        // The constructor sets nonce property to null. Checking null value.
        $this->assertNull( $testObj->nonce() );

        // Generating the nonce.
        $nonceCreated = $testObj->createWpNonce();

        // Check the nonce.
        $this->assertSame( $nonceCreated, $this->testNonce );
    }

    /**
    * Test the getter and setter for the nonce property.
    */
    public function testGetSetNonce() {
        
        // Generating the nonce.
        $nonceCreated = $this->testWpNonceObj1->createWpNonce();
        
        // Setting new value for the nonce.
        $this->testWpNonceObj1->changeNonce( 'newNonce' );

        // Getting and cheking the nonce value.
        $this->assertNotEquals( $nonceCreated, $this->testWpNonceObj1->nonce() );
        $this->assertSame( 'newNonce', $this->testWpNonceObj1->nonce() );
    }

        public function testValidateNonce() {

        // Check validating method.
        $isValid = $this->testWpNonceObj1->validateNonce( $this->testNonce );
        $this->assertTrue( $isValid );

        // Injecting wrong value in the nonce.
        $isValid = $this->testWpNonceObj1->validateNonce( $this->testNonce . 'failure' );
        
        // Check failure on validating.
        $this->assertFalse( $isValid );
    }

    /**
    * Test the validateNonce method used for the validation of the nonce through the $_REQUEST.
    */
    public function testValidateRequest() {

        $testName = '_wpnonce';

        // Build the $_REQUEST
        $_REQUEST[ $testName ] = $this->testNonce;

        // Checking validation method.
        $isValid = $this->testWpNonceObj1->validateRequest();
        $this->assertTrue( $isValid );

        // Injecting wrong value in the nonce.
        $_REQUEST[ $testName ] = $this->testNonce . 'failure';

        // Check failure on validating.
        $isValid = $this->testWpNonceObj1->validateRequest();
        $this->assertFalse( $isValid );
    }	
}