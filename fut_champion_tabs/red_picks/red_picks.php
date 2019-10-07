	<br><br><br><br><br>
	<div class="section">
        <div class="container">
			<h2>Andy</h2>
			<div class="row">
				<?php
				for ($i=1; $i <= 5; $i++) { 
					echo '
				<div id="position_Andy_'.$i.'" class="col-xxl-24 col-xl-30 col-lg-40 col-sm-60" style="border: 1px solid #888888; border-radius: 5px; height: 150px; cursor: pointer;" onclick="open_modal(\'Andy\', '.$i.')">';

					$sql = 'SELECT * FROM red_picks AS R LEFT JOIN players AS P ON R.player_id=P.id WHERE fut_champion_id='.$fut_champion_id.' AND game_player="Andy" AND R.position='.$i;
					$result = $conn->query($sql);
					while ($row = $result->fetch_assoc()) {
						echo '
					<div class="row" style="height: 100%;">
						<div style="height: 100%;" class="col-50">
							<img src="images/cards/'.$row["id"].'.png" style="height: 100%;">
						</div>
						<div style="height: 100%;" class="col-70">
							<span onclick="clear_player(\'Andy\', '.$i.')" style="float: right; font-size: 16px;"><b>&times;</b></span>
							<b style="font-size: 16px;">'.$row["C_name"].'</b>
							<br>
							'.$row["E_name"].'
						</div>
					</div>';
					}

					echo '
				</div>';
				}
				?>
			</div>

			<h2 style="margin-top: 50px;">Jack</h2>
			<div class="row">
				<?php
				for ($i=1; $i <= 5; $i++) { 
					echo '
				<div id="position_Jack_'.$i.'" class="col-xxl-24 col-xl-30 col-lg-40 col-sm-60" style="border: 1px solid #888888; border-radius: 5px; height: 150px; cursor: pointer;" onclick="open_modal(\'Jack\', '.$i.')">';

					$sql = 'SELECT * FROM red_picks AS R LEFT JOIN players AS P ON R.player_id=P.id WHERE fut_champion_id='.$fut_champion_id.' AND game_player="Jack" AND R.position='.$i;
					$result = $conn->query($sql);
					while ($row = $result->fetch_assoc()) {
						echo '
					<div class="row" style="height: 100%;">
						<div style="height: 100%;" class="col-50">
							<img src="images/cards/'.$row["id"].'.png" style="height: 100%;">
						</div>
						<div style="height: 100%;" class="col-70">
							<span onclick="clear_player(\'Jack\', '.$i.')" style="float: right; font-size: 16px;"><b>&times;</b></span>
							<b style="font-size: 16px;">'.$row["C_name"].'</b>
							<br>
							'.$row["E_name"].'
						</div>

					</div>';
					}

					echo '
				</div>';
				}
				?>
			</div>
		</div>
	</div>

	<?php include("fut_champion_tabs/red_picks/modal.php"); ?>