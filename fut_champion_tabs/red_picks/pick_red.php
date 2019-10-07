	<?php
	include("../../includes/connection.php");
	$fut_champion_id = $_POST["fut_champion_id"];
	$game_player = $_POST["game_player"];
	$position = $_POST["position"];
	$player_id = $_POST["player_id"];

	if ($player_id == "") {
		$sql = 'DELETE FROM red_picks WHERE fut_champion_id='.$fut_champion_id.' AND game_player="'.$game_player.'" AND position='.$position;
		$conn->query($sql);
	}
	else {
		$sql = 'INSERT INTO red_picks VALUES('.$fut_champion_id.', "'.$game_player.'", '.$position.', '.$player_id.') ON DUPLICATE KEY UPDATE player_id='.$player_id;
		$result = $conn->query($sql);

		$sql = 'SELECT * FROM players WHERE id='.$player_id;
		$result = $conn->query($sql);
		while ($row = $result->fetch_assoc()) {
			echo '
		<div class="row" style="height: 100%;">
			<div style="height: 100%;" class="col-50">
				<img src="images/cards/'.$row["id"].'.png" style="height: 100%;">
			</div>
			<div style="height: 100%;" class="col-70">
				<span onclick="clear_player(\''.$game_player.'\', '.$position.')" style="float: right; font-size: 16px;"><b>&times;</b></span>
				<b style="font-size: 16px;">'.$row["C_name"].'</b>
				<br>
				'.$row["E_name"].'
			</div>
		</div>';
		}
	}
	?>