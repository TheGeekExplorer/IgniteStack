<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Error <?php echo $c; ?></title>

    <link href='https://fonts.googleapis.com/css?family=Indie+Flower' rel='stylesheet' type='text/css'>

    <style type="text/css">
        body,div,h1,h2,p,span { font-family: 'Indie Flower', cursive; }
        div { width:300px; position:absolute; top:25%; left:50%; margin-top:-50px; margin-left:-150px; text-align:center; }
        h1,h2 { font-weight:bold; margin:0; padding:0; }
        h1 { color:#ff9900; font-size:3rem; }
        h2 { color:#333; font-size:1.5rem; }
        h5 { color:#aaa; font-size:0.8rem; }
    </style>
</head>
<body>

    <div>
        <h1>
            Error <?php echo $c; ?>
        </h1>
        <h2>
            <?php
                if (isset($_ERRORS[$t])) {
                    echo $_ERRORS[$t];
                } else {
                    echo $t;
                }
            ?>
        </h2>

    </div>

</body>
</html>
