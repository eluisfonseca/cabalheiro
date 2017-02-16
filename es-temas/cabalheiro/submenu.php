<li class="dropdown">
    <a href="<?PhP echo theLink(); ?>" class="dropdown-toggle js-activated" data-toggle="dropdown" data-hover="dropdown" aria-haspopup="true"><?PhP echo theTitle(); ?></a>
    <?Php
        global $bd;
        if(theID()==3){
            echo '<ul class="dropdown-menu top-dropdown-menu style-dropdown">';
        }
        else {
            echo '<ul class="dropdown-menu top-dropdown-menu">';
        }
        echo '<i class="hidden-xs fa fa-chevron-down fa-xs"></i>';
        $subMenu	= $bd->query("SELECT ID, Descricao, Link, Target FROM " . BD_PREFIXO . "Menu WHERE Activo = '1' AND Parent='".theID()."' ORDER BY ID ASC");
        while($row=$bd->dados($subMenu)) {
            echo '<li><a href="'.$row[2].'">'.$row[1].'</a></li>';
        }
        ?>
    </ul>
</li>