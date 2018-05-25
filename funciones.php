<?php
    function get_result($consulta_productos) {
        $items = [];
        
        while ($item = mysqli_fetch_assoc($consulta_productos)) {
            $items[] = (object) $item;
        }
        
        return $items;
    }
?>