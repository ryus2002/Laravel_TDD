<?php
/* tests/CartTest.php */

require __DIR__ . '/../Cart.php';

class CartTest extends PHPUnit_Framework_TestCase
{
    private $cart = null;


    /**
    每個測試方法執行之前，都會先執行 setUp 方法；而結束之後，則會執行 tearDown 方法。以此例來說，順序如下：
    setUp
    testUpdateQuantitiesAndGetTotal
    tearDown
    setUp
    testUpdateQuantitiesAndGetTotal
    tearDown
    **/
    public function setUp()
    {
        $this->cart = new Cart();
    }

    public function tearDown()
    {
        $this->cart = null;
    }

    /**
     * @dataProvider provider
     * @group update
     */
    public function testUpdateQuantitiesAndGetTotal($quantities, $expected)
    {
        $this->cart->updateQuantities($quantities);
        $this->assertEquals($expected, $this->cart->getTotal());
    }

    public function provider()
    {
        return [
            [ [ 1, 0, 0, 0, 0, 0 ], 199 + 20 ],
            [ [ 1, 0, 0, 2, 0, 0 ], 797 ],
            [ [ 0, 0, 0, 0, 0, 0 ], 0 ],
        ];
    }

    /**
     * @depends testUpdateQuantitiesAndGetTotal
       //相依測試 depends 讓 testGetProducts 方法可以接收 testUpdateQuantitiesAndGetTotal
     * @group get
     */
    public function testGetProducts()
    {
        $products = $this->cart->getProducts();
        $this->assertEquals(7, count($products));
        $this->assertEquals(0, $products[3]['quantity']);
    }

    /**
     * @expectedException CartException
     * @group update
     * @group exception
     */
    public function testUpdateQuantitiesWithException()
    {
        $this->setExpectedException('CartException');
        $quantities = [ -1, 0, 0, 0, 0, 0 ];
        $this->cart->updateQuantities($quantities); // 預期會產生一個 Exception
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     * @group exception
     */
    public function testFileWriting()
    {
        $this->assertFalse(file_put_contents('/is-not-writeable/file', 'stuff'));
    }

    /**
    測試__sleep()函數
    **/
    public function testSerialize()
    {
        $serial = serialize($this->cart);
        $cart = unserialize($serial);
        $this->assertEquals($cart, $this->cart);
    }

    
}