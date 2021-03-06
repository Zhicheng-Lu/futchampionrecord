<?php
include("includes/connection.php");
if (isset($_POST["create_fut_champion"])) {
    $sql = 'INSERT INTO fut_champions(date) VALUES ("'.$_POST["date"].'")';
    $conn->query($sql);
    header('Location: index.php');
}
if (isset($_POST["delete_player"])) {
    $player_id = $_POST["player_id"];
    $sql = 'DELETE FROM players WHERE id='.$player_id;
    echo $sql;
    $conn->query($sql);
    unlink('images/photos/'.$player_id.'.png');
    unlink('images/cards/'.$player_id.'.png');
    header('Location: index.php?tab=players');
}
if (isset($_POST["create_player"])) {
    $id = $_POST["player_id"];
    $E_name = $_POST["E_name"];
    $version = $_POST["version"];
    $C_name = $_POST["C_name"];
    $rating = $_POST["rating"];
    $price = $_POST["price"];

    // modify database
    if ($id == 0) {
        $sql = 'INSERT INTO players(E_name, version, C_name, rating, price) VALUES("'.$E_name.'", "'.$version.'", "'.$C_name.'", '.$rating.', '.$price.')';
        $conn->query($sql);
        $id = $conn->insert_id;
    }
    else {
        $sql = 'UPDATE players SET E_name="'.$E_name.'", C_name="'.$C_name.'", version="'.$version.'", rating='.$rating.', price='.$price.' WHERE id='.$id;
        $conn->query($sql);
    }

    // upload photo
    $uploaded_photo = $_FILES["photo"]["tmp_name"];
    if (!empty($uploaded_photo)) {
        $src = imagecreatefrompng($uploaded_photo);
        list($width,$height)=getimagesize($uploaded_photo);

        $new_height = 90;
        $new_width = ($width/$height)*$new_height;
        $tmp = imagecreatetruecolor($new_width, $new_height);

        imagealphablending($tmp, false);
        imagesavealpha($tmp, true);
        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

        $target_dir = "images/photos/";
        $target_file = $target_dir.$id.'.'.pathinfo($_FILES["photo"]["name"],PATHINFO_EXTENSION);
        imagepng($tmp, $target_file, 9);
        imagedestroy($src);
        imagedestroy($tmp);
    }


    // upload card
    $uploaded_card = $_FILES["card"]["tmp_name"];
    if (!empty($uploaded_card)) {
        $src = imagecreatefrompng($uploaded_card);
        list($width,$height)=getimagesize($uploaded_card);

        $new_height = 200;
        $new_width = ($width/$height)*$new_height;
        $tmp = imagecreatetruecolor($new_width, $new_height);

        imagealphablending($tmp, false);
        imagesavealpha($tmp, true);
        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

        $target_dir = "images/cards/";
        $target_file = $target_dir.$id.'.'.pathinfo($_FILES["card"]["name"],PATHINFO_EXTENSION);
        imagepng($tmp, $target_file, 9);
        imagedestroy($src);
        imagedestroy($tmp);
    }

    header('Location: index.php?tab=players');
}
if (!isset($_GET["tab"])) $title = "首页";
else {
    if ($_GET["tab"] == "players") $title = "编辑球员";
    if ($_GET["tab"] == "stats") $title = "数据统计";
    if ($_GET["tab"] == "red_picks") $title = "红卡";
    if ($_GET["tab"] == "red_picks_stats") $title = "红卡统计";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>FIFA20周赛 - <?php echo $title; ?></title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="images/fut_champion_logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/swiper.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="js/custom.js"></script>
    <link rel="stylesheet" href="css/mycss.css">
    <link rel="stylesheet" href="css/grid.css">
</head>

<body>
    <!-- header -->
    <header class="site-header">
        <div class="nav-bar">
            <div class="container">
                <div class="row">
                    <div class="col-120 d-flex flex-wrap justify-content-between align-items-center">
                        <div class="site-branding d-flex align-items-center">
                           <a class="d-block" href="index.php" rel="home"><img class="d-block" src="images/fut_champion_logo.png" alt="logo" style="height: 80px;"></a>
                        </div><!-- .site-branding -->

                        <!-- navigation bar -->
                        <nav class="site-navigation d-flex justify-content-end align-items-center">
                            <ul class="d-flex flex-column flex-lg-row justify-content-lg-end align-items-center">
                                <li class="<?php if (!isset($_GET["tab"])) echo "current-menu-item";?>"><a href="index.php">首页</a></li>
                                <li class="<?php if ($_GET["tab"]=="players") echo "current-menu-item";?>"><a href="index.php?tab=players">编辑球员</a></li>
                                <li class="<?php if ($_GET["tab"]=="stats") echo "current-menu-item";?>"><a href="index.php?tab=stats">数据统计</a></li>
                                <li class="<?php if ($_GET["tab"]=="red_picks") echo "current-menu-item";?>"><a href="index.php?tab=red_picks">红卡</a></li>
                                <li class="<?php if ($_GET["tab"]=="red_picks_stats") echo "current-menu-item";?>"><a href="index.php?tab=red_picks_stats">红卡统计</a></li>
                            </ul>
                        </nav><!-- .site-navigation -->

                        <div class="hamburger-menu d-lg-none">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div><!-- .hamburger-menu -->
                    </div><!-- .col -->
                </div><!-- .row -->
            </div><!-- .container -->
        </div><!-- .nav-bar -->
    </header>

    <?php
    if (!isset($_GET["tab"])) include("index_tabs/home/home.php");
    else include('index_tabs/'.$_GET["tab"].'/'.$_GET["tab"].'.php');
    ?>

    <script type='text/javascript' src='js/jquery.js'></script>
    <script type='text/javascript' src='js/jquery.collapsible.min.js'></script>
    <script type='text/javascript' src='js/swiper.min.js'></script>
    <script type='text/javascript' src='js/jquery.countdown.min.js'></script>
    <script type='text/javascript' src='js/circle-progress.min.js'></script>
    <script type='text/javascript' src='js/jquery.countTo.min.js'></script>
    <script type='text/javascript' src='js/jquery.barfiller.js'></script>
    <script type='text/javascript' src='js/custom.js'></script>
</body>
</html>