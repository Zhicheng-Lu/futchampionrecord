	<?php
	$fut_champion_id = $_POST["fut_champion_id"];
	$game = $_POST["game"];
	$score1 = $_POST["score1"];
	$score2 = $_POST["score2"];
	$penalty1 = $_POST["penalty1"];
	$penalty2 = $_POST["penalty2"];
	$appearances = $_POST["appearances"];

	// update game result
	if ($penalty1 == "") $penalty1 = "null";
	if ($penalty2 == "") $penalty2 = "null";
	$sql = 'INSERT INTO results VALUES('.$fut_champion_id.', '.$game.', "'.$_SESSION["user_name"].'", '.$score1.', '.$score2.', '.$penalty1.', '.$penalty2.') ON DUPLICATE KEY UPDATE game_player="'.$_SESSION["user_name"].'", score1='.$score1.', score2='.$score2.', penalty1='.$penalty1.', penalty2='.$penalty2;
	$conn->query($sql);

	// update player appearance
	$sql = 'DELETE FROM appearances WHERE fut_champion_id='.$fut_champion_id.' AND game='.$game;
	$conn->query($sql);
	foreach ($appearances as $appearance) {
		$sql = 'INSERT INTO appearances(fut_champion_id, game, player_id) VALUES('.$fut_champion_id.', '.$game.', '.$appearance.')';
		$conn->query($sql);
	}

	// update player score and assist
	$sql = 'DELETE FROM goals WHERE fut_champion_id='.$fut_champion_id.' AND game='.$game;
	$conn->query($sql);
	for ($i=1; $i <= $score1; $i++) { 
		$scorer = $_POST['scorer_'.$i];
		if ($scorer=="") $scorer = "NULL";
		$assist = $_POST['assist_'.$i];
		if ($assist=="") $assist = "NULL";
		$sql = 'INSERT INTO goals(fut_champion_id, game, scorer, assist) VALUES('.$fut_champion_id.', '.$game.', '.$scorer.', '.$assist.')';

		$conn->query($sql);
	}

	echo '
	<script>
		location.href="new_fut_champion.php?fut_champion_id='.$fut_champion_id.'&tab=record"
	</script>';
	?>