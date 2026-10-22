<?php

$name = "Nguyễn Văn A";
$score = 7.5; 


$xep_loai = "";

if ($score >= 8) {
    $xep_loai = "Giỏi";
} elseif ($score >= 6.5) {
    $xep_loai = "Khá";
} elseif ($score >= 5) {
    $xep_loai = "Trung bình";
} else {
    $xep_loai = "Yếu";
}
echo "Tên học sinh: " . $name . "<br>";
echo "Điểm số: " . $score . "<br>";
echo "Xếp loại: " . $xep_loai . "<br>";
?>
