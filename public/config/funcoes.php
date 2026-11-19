<?php
function h($valor):string
    {
        return htmlspecialchars(
            (string)$valor,
            ENT_QUOTES,"UTF-8");
    }
?>