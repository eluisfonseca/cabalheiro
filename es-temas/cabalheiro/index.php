<?PhP
    get_header();
?>
</head>

<body id="page-top">

    <?PhP
get_menu();
?>

    <!-- Header -->
    <section class="header recent">
        <div class="container recent-container">
            <div class="recent-body col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
                    <div class="col-xs-12 col-sm-8" id="most-recent-post-container">
                        <div class="col-xs-12" id="most-recent-header-container-parent">
                            <div class="clear-b most-recent-header-container">
                                <h2 class="most-recent-header">Most Recent</h2>
                            </div>
                        </div>
                        <?PHP
                            printnoticiaRecente();
                        ?>
                    </div>
                    <div class="col-xs-12 col-sm-4" id="main-right-side-container">
                    <?php printAdd(2) ?>
                        <div class="clear-b top-five-header-container">
                            <h2 class="top-five-header">Previous Content</h2>
                        </div>
                        <?php noticiasMaisRecentesMain() ?>
                    </div>
                    <div style="clear: both;"></div>
            </div>
        </div>
    </section>


<?PhP
get_footer();
?>