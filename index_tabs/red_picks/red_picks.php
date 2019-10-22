	<br><br><br><br><br>
	<div class="section">
        <div class="container">
			<h2>Andy</h2>
			<div class="row">
				<?php
				$sql = 'SELECT * FROM red_picks AS R LEFT JOIN players AS P ON R.player_id=P.id WHERE game_player="Andy" ORDER BY P.id DESC';
				$result = $conn->query($sql);
				while ($row = $result->fetch_assoc()) { 
					echo '
				<div id="position_Andy_'.$i.'" class="col-xxl-24 col-xl-30 col-lg-40 col-sm-60" style="border: 1px solid #888888; border-radius: 5px; height: 150px; cursor: pointer;">
					<div class="row" style="height: 100%;">
						<div style="height: 100%;" class="col-50">
							<img src="images/cards/'.$row["id"].'.png" style="height: 100%;">
						</div>
						<div style="height: 100%;" class="col-70">
							<b style="font-size: 16px;">'.$row["C_name"].'</b>
							<br>
							'.$row["E_name"].'
							<br><br>
							身价：'.number_format($row["price"], 0, ".", ",").'
						</div>
					</div>
				</div>';
				}
				?>
			</div>

			<h2 style="margin-top: 50px;">Jack</h2>
			<div class="row">
				<?php
				$sql = 'SELECT * FROM red_picks AS R LEFT JOIN players AS P ON R.player_id=P.id WHERE game_player="Jack" ORDER BY P.id DESC';
				$result = $conn->query($sql);
				while ($row = $result->fetch_assoc()) { 
					echo '
				<div id="position_Andy_'.$i.'" class="col-xxl-24 col-xl-30 col-lg-40 col-sm-60" style="border: 1px solid #888888; border-radius: 5px; height: 150px; cursor: pointer;">
					<div class="row" style="height: 100%;">
						<div style="height: 100%;" class="col-50">
							<img src="images/cards/'.$row["id"].'.png" style="height: 100%;">
						</div>
						<div style="height: 100%;" class="col-70">
							<b style="font-size: 16px;">'.$row["C_name"].'</b>
							<br>
							'.$row["E_name"].'
							<br><br>
							身价：'.number_format($row["price"], 0, ".", ",").'
						</div>
					</div>
				</div>';
				}
				?>
			</div>
		</div>
	</div>