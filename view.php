<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHPUnit Shop</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <style type="text/css">
    .container {
        width: 800px;
    }
    </style>
</head>
<body>
<div class="container">
    <h1>PHPUnit Shop</h1>
    <hr>
    <form action="index.php" method="post">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>商品</th>
                    <th>數量</th>
                    <th class="text-right">單價</th>
                    <th class="text-right">小計</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($cart->getProducts() as $key => $product):
                ?>
                <tr>
                    <td class="col-sm-8 col-md-6">
                    <div class="media">
                        <div class="media-body">
                            <h4 class="media-heading"><a href="#"><?= $product['name'] ?></a></h4>
                        </div>
                    </div></td>
                    <td class="col-sm-1 col-md-1">
                    <?php if ($key !== Cart::FREIGHT_KEY): ?>
                    <input type="text" name="quantity[<?= $key ?>]" class="form-control" value="<?= $product['quantity'] ?>">
                    <?php else: ?>
                    <input type="hidden" name="quantity[<?= $key ?>]" value="0">
                    <?php endif; ?>
                    <!-- <input type="text" name="quantity[<?= $key ?>]" class="form-control" value="<?= $product['quantity'] ?>"> -->
                    </td>
                    <td class="col-sm-1 col-md-1 text-right"><strong>$<?= number_format($product['price']) ?></strong></td>
                    <td class="col-sm-1 col-md-1 text-right"><strong>$<?= number_format($product['subtotal']) ?></strong></td>
                </tr>
                <?php
                endforeach;
                ?>
                <tr>
                    <td>   </td>
                    <td>   </td>
                    <td class="text-right"><h3>總計</h3></td>
                    <td class="text-right"><h3><strong>$<?= number_format($cart->getTotal()) ?></strong></h3></td>
                </tr>
                <tr>
                    <td>   </td>
                    <td>   </td>
                    <td>   </td>
                    <td class="text-right">
                    <button type="submit" class="btn btn-primary">
                        <span class="glyphicon glyphicon-shopping-cart"></span> 重新計算
                    </button></td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
</body>
</html>
