<?php
srand((double)microtime()*1000000 );
$td = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CFB,'');
$IV = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
$ks = mcrypt_enc_get_key_size($td);