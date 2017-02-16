<?PhP
get_header();
?>
<div id="header">
<h1><?PhP echo config(3); ?> </h1>
<h2><?PhP echo I_ADMIN_PANEL; ?></h2>
</div>
<div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form action="index.php" method="post" enctype="multipart/form-data" name="Login" target="_self" role="form">
                            <fieldset>
                                <div class="form-group">
                                	<input name="h" type="hidden" value="login">
                                	<input class="form-control" placeholder="<?PhP echo I_USER; ?>" name="Utilizador" type="text" size="25" maxlength="50" autofocus/>
                                </div>
                                <div class="form-group">
                                	<input class="form-control" placeholder="Password" name="Palavra" type="password" size="25" maxlength="50" />
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input name="Entrar" type="submit" value="<?PhP echo I_LOGIN; ?>" class="btn btn-lg btn-success btn-block">
                                
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?PhP
get_footer();
?>
