<!doctype html>
<html>
<head>
<?PhP
echo charset();
echo title(TRUE, ' - ');
head();
?>
</head>

<body>
<div id="wrapper">
<?PhP
if(isset($_SESSION["S01"])){
	?>
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <p style="display:inline;" class="navbar-brand" href="index.html"><?PhP echo config(3)." - ".I_ADMIN_PANEL;?></p>
            </div>

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                    	<li>
                    		<a href="index.php" class="active" target="_self"><i class="fa fa-home fa-fw"></i> Inicio</a>
                    	</li>
                    	<?PhP 
							list_plugins();
						?>
						<li><a href="?out=1" target="_self"><i class="fa fa-power-off fa-fw"></i> <?PhP echo I_OUT; ?></a></li>
                    </ul>
                </div>
            </div>
        </nav>
	<?PhP
}
?>

