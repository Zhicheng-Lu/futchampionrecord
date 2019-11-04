	<?php
	include("../../includes/connection.php");
	$position = $_POST["position"];
	$player_id = $_POST["player_id"];

	if ($player_id == "") {
		$sql = 'DELETE FROM squad WHERE position='.$position;
		$conn->query($sql);
	}
	else {
		$sql = 'INSERT INTO squad(position, player_id) VALUES('.$position.', '.$player_id.') ON DUPLICATE KEY UPDATE player_id='.$player_id;
		$result = $conn->query($sql);

		$sql = 'SELECT * FROM players WHERE id='.$player_id;
		$result = $conn->query($sql);
		while ($row = $result->fetch_assoc()) {
			echo '
		<div class="row" style="height: 100%;" draggable="true" ondragstart="drag('.$position.', '.$player_id.')" ondragover="allowDrop(event)" ondrop="swap(event, '.$position.', '.$player_id.')">
			<div style="height: 100%;" class="col-50">
				<img src="images/cards/'.$row["id"].'.png" style="height: 100%;" draggable="false">
			</div>
			<div style="height: 100%;" class="col-70">
				<span onclick="clear_player('.$position.')" style="float: right; font-size: 16px;"><b>&times;</b></span>
				<b style="font-size: 16px;">'.$row["C_name"].'</b>
				<br>
				'.$row["E_name"].'
			</div>
		</div>';
		}
	}
	?>