<nav id="top-menu" class="navbar navbar-default navbar-fixed-top">
    <div class="col-xs-12">
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#cabalheiro-navbar-collapse-top">
                <span class="sr-only">Toggle navigation</span>
                <i class="fa fa-chevron-down fa-lg"></i>
            </button>
            <a class="navbar-brand" href="index.php">
                <img class="img-responsive" <?Php echo 'src="' . SITE_ROOT . '/es-temas/' . config(1) . '/img/cab_weblogo_128.jpg"'; ?>>
            </a>
        </div>
        <div class="collapse navbar-collapse" id="cabalheiro-navbar-collapse-top">
            <ul class="nav navbar-nav navbar-right" id="navbar-ul">
                <li class="hidden">
                    <a href="#page-top"></a>
                </li>
                <?PhP
                menu();
                while(item()):
                    if (theisParent()==0) {
                        get_template('menu');
                    }
                    else {
                        get_template('submenu');
                    }
                endwhile;
                ?>

                <li class="page-scroll" id="search-menu-li" ><a href="#" id="search-menu-btn"><i class="fa fa-search"></i></a></li>
            </ul>
            <div id="search-form-container">
                <form class="form-horizontal" id="search-form" role="form" name="search">
                    <input id="search-box" name="search-token" placeholder="Search" type="text">
                    <button type="button" class="btn btn-default btn-xs" id="search-button"><i class="fa fa-chevron-right"></i></button>
                </form>
            </div>
        </div>
    </div>
</nav>