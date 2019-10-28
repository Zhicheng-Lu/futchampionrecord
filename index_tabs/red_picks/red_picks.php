	<br><br><br><br><br>
	<div class="section">
        <div class="container">
			<h2>Andy</h2>
			<div class="row">
				<?php
				$sql = 'SELECT P.id AS player_id, P.C_name, P.E_name, P.price, F.id AS fut_champion_id, F.date FROM red_picks AS R LEFT JOIN players AS P ON R.player_id=P.id LEFT JOIN fut_champions AS F ON R.fut_champion_id=F.id WHERE R.game_player="Andy" ORDER BY P.id DESC';
				$result = $conn->query($sql);
				while ($row = $result->fetch_assoc()) {
					$fut_champion_id = $row["fut_champion_id"];
					$sql1 = 'SELECT COUNT(*) AS win FROM results WHERE fut_champion_id='.$fut_champion_id.' AND (score1>score2 OR penalty1>penalty2)';
					$result1 = $conn->query($sql1);
					while ($row1 = $result1->fetch_assoc()) {
						$win = $row1["win"];
					}

					echo '
				<div class="col-xxl-24 col-xl-30 col-lg-40 col-sm-60" style="border: 1px solid #888888; border-radius: 5px; height: 150px;">
					<div class="row" style="height: 100%;">
						<div style="height: 100%;" class="col-50">
							<img src="images/cards/'.$row["player_id"].'.png" style="height: 100%;">
						</div>
						<div style="height: 100%;" class="col-70">
							<b style="font-size: 16px;">'.$row["C_name"].'</b>
							<br>
							'.$row["E_name"].'
							<br>
							身价：'.number_format($row["price"], 0, ".", ",").'
							<br><br>
							<a href="fut_champion.php?fut_champion_id='.$fut_champion_id.'&tab=red_picks" target="_blank" style="text-decoration: underline; color: black;">'.$row["date"].':</a>
							&nbsp;
							'.$win.' 胜
						</div>
					</div>
				</div>';
				}
				?>
			</div>

			<h2 style="margin-top: 50px;">Jack</h2>
			<div class="row">
				<?php
				$sql = 'SELECT P.id AS player_id, P.C_name, P.E_name, P.price, F.id AS fut_champion_id, F.date FROM red_picks AS R LEFT JOIN players AS P ON R.player_id=P.id LEFT JOIN fut_champions AS F ON R.fut_champion_id=F.id WHERE R.game_player="Jack" ORDER BY P.id DESC';
				$result = $conn->query($sql);
				while ($row = $result->fetch_assoc()) {
					$fut_champion_id = $row["fut_champion_id"];
					$sql1 = 'SELECT COUNT(*) AS win FROM results WHERE fut_champion_id='.$fut_champion_id.' AND (score1>score2 OR penalty1>penalty2)';
					$result1 = $conn->query($sql1);
					while ($row1 = $result1->fetch_assoc()) {
						$win = $row1["win"];
					}

					echo '
				<div class="col-xxl-24 col-xl-30 col-lg-40 col-sm-60" style="border: 1px solid #888888; border-radius: 5px; height: 150px;">
					<div class="row" style="height: 100%;">
						<div style="height: 100%;" class="col-50">
							<img src="images/cards/'.$row["player_id"].'.png" style="height: 100%;">
						</div>
						<div style="height: 100%;" class="col-70">
							<b style="font-size: 16px;">'.$row["C_name"].'</b>
							<br>
							'.$row["E_name"].'
							<br>
							身价：'.number_format($row["price"], 0, ".", ",").'
							<br><br>
							<a href="fut_champion.php?fut_champion_id='.$fut_champion_id.'&tab=red_picks" target="_blank" style="text-decoration: underline; color: black;">'.$row["date"].':</a>
							&nbsp;
							'.$win.' 胜
						</div>
					</div>
				</div>';
				}
				?>
			</div>
		</div>
	</div>