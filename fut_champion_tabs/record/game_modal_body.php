				<?php
				include("../../includes/connection.php");
				$fut_champion_id = $_POST["fut_champion_id"];
				$game = $_POST["game"];
				?>

				<div class="row">
					<?php
					$counter = 0;
					$sql = 'SELECT * FROM appearances AS A LEFT JOIN players AS P ON A.player_id=P.id WHERE A.fut_champion_id='.$fut_champion_id.' AND A.game='.$game;
					$result = $conn->query($sql);
					while ($row = $result->fetch_assoc()) {
						echo '
					<div class="col-xxl-24 col-xl-30 col-lg-40 col-sm-60" id="player_'.$counter.'" style="height: 150px; border-bottom: 1px solid #888888; cursor: pointer;" onclick="choose_player('.$row["id"].')">
						<div class="row" style="height: 100%;">
							<div style="height: 100%;" class="col-50">
								<img src="images/cards/'.$row["id"].'.png" style="height: 100%;">
							</div>
							<div style="height: 100%;" class="col-70">
								<b style="font-size: 16px;">'.$row["C_name"].'</b>
								<br>
								'.$row["E_name"].'
							</div>
						</div>
					</div>';
						$counter += 1;
					}
					?>
				</div>