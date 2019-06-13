<?php

class Cart
{
    private $products = [
        [
            'name'     => 'iPhone 6 (16G)',
            'quantity' => 0,
            'price'    => 199,
            'subtotal' => 0,
        ],
        [
            'name'     => 'iPhone 6 (64G)',
            'quantity' => 0,
            'price'    => 299,
            'subtotal' => 0,
        ],
        [
            'name'     => 'iPhone 6 (128G)',
            'quantity' => 0,
            'price'    => 399,
            'subtotal' => 0,
        ],
        [
            'name'     => 'iPhone 6 Plus (16G)',
            'quantity' => 0,
            'price'    => 299,
            'subtotal' => 0,
        ],
        [
            'name'     => 'iPhone 6 Plus (64G)',
            'quantity' => 0,
            'price'    => 399,
            'subtotal' => 0,
        ],
        [
            'name'     => 'iPhone 6 Plus (128G)',
            'quantity' => 0,
            'price'    => 499,
            'subtotal' => 0,
        ],
        // ... 加入運費商品
        [
            'name'     => '運費',
            'quantity' => 0,
            'price'    => 20,
            'subtotal' => 0,
        ],
    ];

    CONST FREIGHT_KEY = 6;
    private $total = 0;

    public function getProducts()
    {
        return $this->products;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function updateQuantities($quantities)
    {
        // 更新商品數量並算出小計
        foreach ($quantities as $key => $qty) {
            $this->setQuantity($key, $qty);
            if (!is_numeric($qty) || $qty < 0) {
                throw new CartException("數量不正確, 請輸入0 或 0以上的整數", 1);
            }            
        }

        // 計算總金額
        $this->total = 0;
        foreach ($this->products as $key => $product) {
            $this->total += $product['subtotal'];
        }

        // 運費
        if ($this->total > 0 && $this->total < 500) {
            $this->setQuantity(self::FREIGHT_KEY, 1);

            // 加上運費
            $this->total += $this->products[self::FREIGHT_KEY]['subtotal'];
        } else {
            $this->setQuantity(self::FREIGHT_KEY, 0);
        }        
    }

    public function setQuantity($key, $qty)
    {
        $this->products[$key]['quantity'] = $qty;
        $this->products[$key]['subtotal'] = $this->products[$key]['quantity'] * $this->products[$key]['price'];
    }

    public function __sleep()
    {
        return ['products', 'total'];
    }

}

class CartException extends Exception
{
}