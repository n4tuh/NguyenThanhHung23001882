<?php

$productPrices = [150000, 320000, 45000, 890000, 210000];

function calculateTotal($prices) {
    $total = 0;
  
    foreach ($prices as $price) {
        $total += $price;
    }
    return $total; 

}

function findMaxPrice($prices) {
   
    $max = $prices[0]; 
    

    foreach ($prices as $price) {
        if ($price > $max) {
            $max = $price;
        }
    }
    return $max;
    

}

$totalPrice = calculateTotal($productPrices);
$highestPrice = findMaxPrice($productPrices);
echo "Danh sách giá sản phẩm: " . implode(" VNĐ, ", $productPrices) . " VNĐ<br>";
echo "Tổng giá trị của tất cả sản phẩm: " . number_format($totalPrice) . " VNĐ<br>";
echo "Giá sản phẩm cao nhất: " . number_format($highestPrice) . " VNĐ<br>";
?>
