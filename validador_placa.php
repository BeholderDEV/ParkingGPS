<?php

    function carReg($reg)
    {
        return (bool) preg_match('/^[A-Z]{3}[- ]?[0-9]{4}$/', addcslashes($reg, "\n"));
    }

?>