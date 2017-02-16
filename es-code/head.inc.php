<?PhP
function head(){
	global $bd;
	global $esJSInit;
	global $esJSResize;


	echo '<meta charset="utf-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';

    if(reqvlr('ID') && (reqvlr('p') && trim(reqvlr('p'))=='post') ) {
        printSocialHeader();
    }
    else {
        echo '<meta itemprop="name" content="The Original Cabalheiro">'
            .'<meta itemprop="description" content="The Original CABALHEIRO - Traditional Barber & Men\'s Grooming Aide. Specialized in classic haircuts, from the 1920\'s to the 50\'s, and hot towel straight razor shaves.">'

            .'<meta itemprop="image" content="' . SITE_ROOT . '/es-temas/' . config(1) . '/img/site_thumbnail.jpg">';
        //<!-- Twitter Card data -->
        echo '<meta name="twitter:card" content="summary_large_image">'
            .'<meta name="twitter:title" content="The Original Cabalheiro">'
            .'<meta name="twitter:description" content="The Original CABALHEIRO - Traditional Barber & Men\'s Grooming Aide. Specialized in classic haircuts, from the 1920\'s to the 50\'s, and hot towel straight razor shaves.">';
        //<!-- Twitter summary card with large image must be at least 280x150px -->
        echo '<meta name="twitter:image:src" content="' . SITE_ROOT . '/es-temas/' . config(1) . '/img/site_thumbnail.jpg">';
        //<!-- Open Graph data -->.'<meta property="og:url" content="http://www.cabalheiro.com/index.php?p=post&ID='.$id.'" />'
        echo '<meta property="og:title" content="The Original Cabalheiro" />'
            .'<meta property="og:image" content="' . SITE_ROOT . '/es-temas/' . config(1) . '/img/site_thumbnail.jpg" />'
            .'<meta property="og:description" content="The Original CABALHEIRO - Traditional Barber & Men\'s Grooming Aide. Specialized in classic haircuts, from the 1920\'s to the 50\'s, and hot towel straight razor shaves." />'
            .'<meta property="og:site_name" content="The Original Cabalheiro" />';
        echo '<title>The Original Cabalheiro</title>';
        echo '<meta name="description" content="The Original CABALHEIRO - Traditional Barber & Men\'s Grooming Aide. Specialized in classic haircuts, from the 1920\'s to the 50\'s, and hot towel straight razor shaves.">';
    }

    echo '<meta name="keywords" content="Men\'s Grooming, Traditional Barbering, Barber, Reviews, Tutorials, Old School, Classic, beard, hair, body, original, cabalheiro">
    <meta name="author" content="Content by: André Macedo.  Developed by: Eduardo Fonseca and João Martins.">';
    echo '<link rel="icon" href="' . SITE_ROOT .'/es-temas/' . config(1) . '/img/icon.jpg" type="image/png">';

    /*<!-- Bootstrap core CSS -->*/
    echo '<link href="' . SITE_ROOT . '/es-temas/' . config(1) . '/css/bootstrap.css" rel="stylesheet">';

    /*<!-- Add custom CSS here -->*/
    echo '<link href="' . SITE_ROOT . '/es-temas/' . config(1) . '/css/style.css" rel="stylesheet">';

    echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">';
    echo '<link href="//cdn-images.mailchimp.com/embedcode/slim-081711.css" rel="stylesheet" type="text/css">';
    echo '<link href="' . SITE_ROOT . '/es-temas/' . config(1) . '/css/newsletter.css" rel="stylesheet">';
    /* JavaScript --> */
    echo '<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>';
    echo '<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>';

    if(reqvlr('p') && trim(reqvlr('p'))=='post') {
        echo '';
    }
}
?>
