<?php
include "./phpqrcode.php";
// QRcode::png($text, $outfile = false, $level = QR_ECLEVEL_L, $size = 3, $margin = 4, $saveandprint=false, $back_color = 0xFFFFFF, $fore_color = 0x000000) 
QRcode::png('some othertext 1234', false, 'h', 5, 2, false, 0xFFFF00, 0xFF00FF);
