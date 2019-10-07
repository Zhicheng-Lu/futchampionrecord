	<?php
	session_start();
	session_destroy();
	header('Location: ../new_fut_champion.php?fut_champion_id='.$_GET["fut_champion_id"].'&tab='.$_GET["tab"]);
	?>