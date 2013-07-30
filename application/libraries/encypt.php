<?php
class MY_Encrypt extends CI_Encrypt
{
    
    function encode($str="")
    {
        return strtr(
                base64_encode($str),
                array(
                    '+' => '.',
                    '=' => '-',
                    '/' => '~'
                )
            );
    }
    function decode($str="")
    {
        return base64_decode(strtr(
                $str, 
                array(
                    '.' => '+',
                    '-' => '=',
                    '~' => '/'
                )
            ));
    }
}
?>