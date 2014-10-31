<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?=APPTITLE; ?></title>
    <link rel="shortcut icon" href="/images/icons/favicon.png" />
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/css/normalize.css" />
    <link rel="stylesheet" href="/css/foundation.css" />
    <link rel="stylesheet" href="/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/css/animate.min.css" />
    <link rel="stylesheet" href="/css/slicknav.css">
    <link rel="stylesheet" href="/style.css" />
    <script src="/js/vendor/modernizr.js"></script>
  </head>
  <body>

    <?#--  HEADER --?>
    <?php Load('Header'); ?>
    <?#--  END OF HEADER --?>

    <?#-- CONTENT --?>
    <?php Load($content); ?>
    <?#-- END OF CONTENT --?>

    <?#--  FOOTER  --?>
    <?php Load('Footer'); ?>
    <?#--  END OF FOOTER  --?>

    <a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

    <?#--  SCRIPTS  --?>
    <script src="js/vendor/jquery.js"></script>
    <script src="js/foundation.min.js"></script>
    <script src="js/vendor/hoverIntent.js"></script>
    <script src="js/vendor/superfish.min.js"></script>
    <script src="js/vendor/morphext.min.js"></script>
    <script src="js/vendor/wow.min.js"></script>
    <script src="js/vendor/jquery.slicknav.min.js"></script>
    <script src="js/vendor/waypoints.min.js"></script>
    <script src="js/vendor/jquery.animateNumber.min.js"></script>
    <script src="js/vendor/owl.carousel.min.js"></script>
    <script src="js/vendor/jquery.slicknav.min.js"></script>
    <script src="js/custom.js"></script>
    <?#--  END OF SCRIPTS  --?>

  </body>
</html>