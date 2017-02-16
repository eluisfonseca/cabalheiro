<?PhP
    get_header();
    echo '<link href="' . SITE_ROOT . '/es-temas/' . config(1) . '/css/page.css" rel="stylesheet">';
    echo '<link href="' . SITE_ROOT . '/es-temas/' . config(1) . '/css/archive.css" rel="stylesheet">';
?>
</head>

<body id="page-top">

    <?PhP
get_menu();
?>

    <!-- Header -->
    <section class="header recent">
        <div class="container recent-container">
            <div class="recent-body">
                    <div class="col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2" id="page-container">
                        <div id="arc-content-container" class="clear-padding col-xs-12 col-sm-8">
                            <div class="col-xs-12 clear-padding clear-b" id="arc-header">
                                <div class="clear-b arc-header-container">
                                    <h2>Related Articles</h2>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-8 clear-margin clear-padding" id="arc-search-container">
                                <div id="arc-search-form-container">
                                    <form class="form-horizontal" id="arc-search-form" role="form" name="search">
                                        <input id="arc-search-box" name="search-token" placeholder="Search" type="text">
                                        <button type="button" class="btn btn-default btn-xs" id="arc-search-button"><i class="fa fa-chevron-right"></i></button>
                                    </form>
                                </div>
                            </div>
                            <div id="arc-list-container" class="col-xs-12">
                                <?php printSearch() ?>
                            </div>
                        </div>
                        <div id="right-side-container" class="col-xs-12">
                        <?php printAdd(5); ?>
                            <div id="right-side-newsletter-container" class="col-xs-12 clear-padding clear-margin">
                                <div class="footer-col col-xs-12 clear-margin clear-padding">
                                    <div class="clear-b newsletter-header-container">
                                        <h3 >Newsletter</h3>
                                    </div>
                                    <div class="col-xs-12 clear-margin clear-padding">
                                        <p id="side-newsletter-text">
                                            // RIGHT TO YOUR DOORSTEP<br>
                                            Be up to date with the latest news and reviews. You can save a ton of time by making things easy.
                                        </p>
                                    </div>
                                    <!-- Begin MailChimp Signup Form -->

                                    <div id="mc_embed_signup">
                                        <form action="//cabalheiro.us12.list-manage.com/subscribe/post?u=34aea4ce0f2d49448eba195ff&amp;id=1fba739a54" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                                            <div id="mc_embed_signup_scroll">
                                                <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Enter your email" required>
                                                <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                                                <div id="req-mailc" aria-hidden="true"><input type="text" name="b_34aea4ce0f2d49448eba195ff_1fba739a54" tabindex="-1" value=""></div>
                                                <div class="clear"><input type="submit" value="YES!" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div id="right-side-follow-container" class="col-xs-12 clear-padding clear-margin">
                                <div class="footer-col col-xs-12 clear-margin clear-padding">
                                    <div class="clear-b follow-header-container">
                                        <h3 >Follow Me</h3>
                                    </div>
                                    <p>Know more. See more. Explore.</p>
                                    <!--End mc_embed_signup-->
                                    <div id="follow-social-container">
                                        <ul class="list-inline">
                                            <li>
                                                <a href="https://www.facebook.com/originalcabalheiro/"><i class="fa fa-facebook-square fa-2x"></i></i></a>
                                            </li>
                                            <li>
                                                <a href="https://www.instagram.com/originalcabalheiro/"><i class="fa fa-instagram fa-2x"></i></a>
                                            </li>
                                            <li>
                                                <a href="https://www.youtube.com/channel/UCF3YAR5S-dO4O0s8hlTgh_Q"><i class="fa fa-youtube-square fa-2x"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div id="top-five-container" class="col-xs-12">
                                <div class="clear-b top-five-header-container">
                                    <h3>Most Viewed</h3>
                                </div>
                                <?php noticiasMaisVistasMain() ?>
                            </div>
                            <?php printAdd(8);?>
                        </div>
                    </div>
                    <div style="clear: both;"></div>
            </div>
        </div>
    </section>


<?PhP
get_footer();
?>