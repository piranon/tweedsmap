<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Tweets Map</title>
    <link href="<?php echo $cssUrl; ?>bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $cssUrl; ?>loading.min.css" rel="stylesheet">
    <link href="<?php echo $cssUrl; ?>tweetsmap.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?php echo $diUrl; ?>favicon.png" />
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="<?php echo $jsUrl; ?>jquery.min.js"></script>
<!--     <script src="<?php echo $jsUrl; ?>tweetsmap.js"></script> -->
  </head>
  <body>
    <div class="list-group">
        <?php if (empty($histories[0])) { ?>
            <?php $backUrl = $baseUrl; ?>
        <?php } else { ?>
            <?php $backUrl = $baseUrl . 'q=' . $histories[0]; ?>
        <?php } ?>
        <a href="<?php echo $backUrl; ?>" class="list-group-item history-list"><< BACK TO THE TWEETS</a>
        <?php foreach ($histories as $history) { ?>
            <a href="<?php echo $baseUrl; ?>?q=<?php echo $history; ?>" class="list-group-item history-list"><?php echo $history; ?></a>
        <?php } ?>
    </div>
    <script src="<?php echo $jsUrl; ?>bootstrap.min.js"></script>
    <script src="<?php echo $jsUrl; ?>loading.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo $jsUrl; ?>ie10-viewport-bug-workaround.js"></script>
  </body>
</html>