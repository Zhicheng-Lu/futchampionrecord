<?php
include("includes/connection.php");
if (isset($_POST["end_fut_champion"])) {
    $fut_champion_id = $_POST["fut_champion_id"];
    $sql = 'INSERT INTO finished_fut_champions VALUES('.$fut_champion_id.')';
    $conn->query($sql);
    header('Location: fut_champion.php?fut_champion_id='.$fut_champion_id.'&tab=record');
}
$fut_champion_id = $_GET["fut_champion_id"];
if ($_GET["tab"] == "record") $title = "比赛记录";
if ($_GET["tab"] == "stats") $title = "数据统计";
if ($_GET["tab"] == "red_picks") $title = "红卡";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>FIFA20周赛 - <?php echo $fut_champion_id; ?> - <?php echo $title; ?></title>
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
                                <li class="<?php if ($_GET["tab"]=="record") echo "current-menu-item";?>"><a href="fut_champion.php?fut_champion_id=<?php echo $fut_champion_id;?>&tab=record">比赛记录</a></li>
                                <li class="<?php if ($_GET["tab"]=="stats") echo "current-menu-item";?>"><a href="fut_champion.php?fut_champion_id=<?php echo $fut_champion_id;?>&tab=stats">数据统计</a></li>
                                <li class="<?php if ($_GET["tab"]=="red_picks") echo "current-menu-item";?>"><a href="fut_champion.php?fut_champion_id=<?php echo $fut_champion_id;?>&tab=red_picks">红卡</a></li>
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
    include('fut_champion_tabs/'.$_GET["tab"].'/'.$_GET["tab"].'.php');
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