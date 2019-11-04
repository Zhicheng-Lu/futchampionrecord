	<br><br><br><br><br>
	<div class="section">
        <div class="container">
			<h2>首发</h2>
			<div class="row">
				<?php
				for ($i=1; $i < 12; $i++) { 
					echo '
				<div id="position_'.$i.'" class="col-xxl-24 col-xl-30 col-lg-40 col-sm-60" style="border: 1px solid #888888; border-radius: 5px; height: 150px; cursor: pointer;" onclick="open_modal('.$i.')" draggable="true">';

					$sql = 'SELECT * FROM squad AS S LEFT JOIN players AS P ON S.player_id=P.id WHERE S.position='.$i;
					$result = $conn->query($sql);
					while ($row = $result->fetch_assoc()) {
						echo '
					<div class="row" style="height: 100%;">
						<div style="height: 100%;" class="col-50">
							<img src="images/cards/'.$row["id"].'.png" style="height: 100%;" draggable="false">
						</div>
						<div style="height: 100%;" class="col-70">
							<span onclick="clear_player('.$i.')" style="float: right; font-size: 16px;"><b>&times;</b></span>
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

			<h2 style="margin-top: 20px;">替补</h2>
			<div class="row">
				<?php
				for ($i=12; $i < 19; $i++) { 
					echo '
				<div id="position_'.$i.'" class="col-xxl-24 col-xl-30 col-lg-40 col-sm-60" style="border: 1px solid #888888; border-radius: 5px; height: 150px; cursor: pointer;" onclick="open_modal('.$i.')" draggable="true">';

					$sql = 'SELECT * FROM squad AS S LEFT JOIN players AS P ON S.player_id=P.id WHERE S.position='.$i;
					$result = $conn->query($sql);
					while ($row = $result->fetch_assoc()) {
						echo '
					<div class="row" style="height: 100%;">
						<div style="height: 100%;" class="col-50">
							<img src="images/cards/'.$row["id"].'.png" style="height: 100%;" draggable="false">
						</div>
						<div style="height: 100%;" class="col-70">
							<span onclick="clear_player('.$i.')" style="float: right; font-size: 16px;"><b>&times;</b></span>
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

	<?php include("new_fut_champion_tabs/squad/modal.php"); ?>