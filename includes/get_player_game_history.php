				<div class="row">
					<?php
					include("connection.php");
					$game_player_name = $_POST["game_player_name"];
					$player_id = $_POST["player_id"];

					$sql = 'SELECT * FROM players WHERE id='.$player_id;
					$result = $conn->query($sql);
					while ($row = $result->fetch_assoc()) {
						echo '
					<div class="col-md-60">
						<div class="row">
							<div class="col-70" style="text-align: right;">
								<img src="images/cards/'.$player_id.'.png">
							</div>
							<div class="col-50" style="text-align: left;">
								<br>
								<b style="font-size: 16px;">'.$row["C_name"].'</b>
								<br>
								'.$row["E_name"].'
								<br><br>
								身价：'.number_format($row["price"], 0, ".", ",").'
							</div>
						</div>
					</div>';


						if (isset($_POST["fut_champion_id"])) {
							$fut_champion_id = $_POST["fut_champion_id"];
							$game_player_citeria = ($game_player_name=="")?"":' AND R.game_player="'.$game_player_name.'"';
							$sql = 'SELECT PLA.id, appearance, IFNULL(num_score,0) AS num_score, IFNULL(num_assist,0) AS num_assist,
									IFNULL(win,0) AS win, IFNULL(loss,0) AS loss, APP.team_score, APP.team_conceed FROM 
									(SELECT id FROM players WHERE id='.$player_id.') AS PLA
									LEFT JOIN (SELECT APP.player_id, COUNT(*) AS appearance, SUM(score1) AS team_score, SUM(score2) AS team_conceed FROM appearances AS APP LEFT JOIN results AS R ON APP.fut_champion_id=R.fut_champion_id AND APP.game=R.game WHERE APP.fut_champion_id='.$fut_champion_id.$game_player_citeria.' GROUP BY APP.player_id) AS APP ON PLA.id=APP.player_id 
									LEFT JOIN (SELECT SCO.scorer, COUNT(*) AS num_score FROM goals AS SCO LEFT JOIN results AS R ON SCO.fut_champion_id=R.fut_champion_id AND SCO.game=R.game WHERE SCO.fut_champion_id='.$fut_champion_id.$game_player_citeria.' GROUP BY SCO.scorer) AS SCO ON APP.player_id=SCO.scorer 
									LEFT JOIN (SELECT ASS.assist, COUNT(*) AS num_assist FROM goals AS ASS LEFT JOIN results AS R ON ASS.fut_champion_id=R.fut_champion_id AND ASS.game=R.game WHERE ASS.fut_champion_id='.$fut_champion_id.$game_player_citeria.' GROUP BY assist) AS ASS ON APP.player_id=ASS.assist 
									LEFT JOIN (SELECT APP.player_id, COUNT(*) AS win FROM appearances AS APP LEFT JOIN results AS R ON APP.fut_champion_id=R.fut_champion_id AND APP.game=R.game WHERE APP.fut_champion_id='.$fut_champion_id.$game_player_citeria.' AND (R.score1>R.score2 OR R.penalty1>R.penalty2) GROUP BY APP.player_id) AS WIN ON APP.player_id=WIN.player_id
									LEFT JOIN (SELECT APP.player_id, COUNT(*) AS loss FROM appearances AS APP LEFT JOIN results AS R ON APP.fut_champion_id=R.fut_champion_id AND APP.game=R.game WHERE APP.fut_champion_id='.$fut_champion_id.$game_player_citeria.' AND (R.score1<R.score2 OR R.penalty1<R.penalty2) GROUP BY APP.player_id) AS LOSS ON APP.player_id=LOSS.player_id';
						}
						else {
							$sql = 'SELECT PLA.id, IFNULL(appearance,0) AS appearance, IFNULL(num_score,0) AS num_score, IFNULL(num_assist,0) AS num_assist,
									IFNULL(win,0) AS win, IFNULL(loss,0) AS loss, APP.team_score, APP.team_conceed FROM 
									(SELECT id FROM players WHERE id='.$player_id.') AS PLA
									LEFT JOIN (SELECT APP.player_id, COUNT(*) AS appearance, SUM(score1) AS team_score, SUM(score2) AS team_conceed FROM appearances AS APP LEFT JOIN results AS R ON APP.fut_champion_id=R.fut_champion_id AND APP.game=R.game'.(($game_player_name=="")?"":' WHERE R.game_player="'.$game_player_name.'"').' GROUP BY APP.player_id) AS APP ON PLA.id=APP.player_id 
									LEFT JOIN (SELECT SCO.scorer, COUNT(*) AS num_score FROM goals AS SCO LEFT JOIN results AS R ON SCO.fut_champion_id=R.fut_champion_id AND SCO.game=R.game'.(($game_player_name=="")?"":' WHERE R.game_player="'.$game_player_name.'"').' GROUP BY SCO.scorer) AS SCO ON APP.player_id=SCO.scorer 
									LEFT JOIN (SELECT ASS.assist, COUNT(*) AS num_assist FROM goals AS ASS LEFT JOIN results AS R ON ASS.fut_champion_id=R.fut_champion_id AND ASS.game=R.game'.(($game_player_name=="")?"":' WHERE R.game_player="'.$game_player_name.'"').' GROUP BY assist) AS ASS ON APP.player_id=ASS.assist 
									LEFT JOIN (SELECT APP.player_id, COUNT(*) AS win FROM appearances AS APP LEFT JOIN results AS R ON APP.fut_champion_id=R.fut_champion_id AND APP.game=R.game WHERE'.(($game_player_name=="")?"":' R.game_player="'.$game_player_name.'" AND').' (R.score1>R.score2 OR R.penalty1>R.penalty2) GROUP BY APP.player_id) AS WIN ON APP.player_id=WIN.player_id
									LEFT JOIN (SELECT APP.player_id, COUNT(*) AS loss FROM appearances AS APP LEFT JOIN results AS R ON APP.fut_champion_id=R.fut_champion_id AND APP.game=R.game WHERE'.(($game_player_name=="")?"":' R.game_player="'.$game_player_name.'" AND').' (R.score1<R.score2 OR R.penalty1<R.penalty2) GROUP BY APP.player_id) AS LOSS ON APP.player_id=LOSS.player_id';
						}

						$result = $conn->query($sql);
						while ($row = $result->fetch_assoc()) {
							$appearance = $row["appearance"];
							echo '
						<div class="col-md-60" style="font-size: 16px;">
							<br>
							出场：'.$appearance.'
							<br>
							进球：'.$row["num_score"].' (场均 '.(($appearance==0)?'-':bcdiv($row["num_score"], $appearance, 2)).')
							&nbsp;&nbsp;
							助攻：'.$row["num_assist"].' (场均 '.(($appearance==0)?'-':bcdiv($row["num_assist"], $appearance, 2)).')
							<br>
							场均制造：'.(($appearance==0)?'-':bcdiv($row["num_score"]+$row["num_assist"], $appearance, 2)).'
							<br>
							'.$row["win"].' 胜 ('.(($appearance==0)?'-':round(100*$row["win"]/$appearance)).'%)&nbsp;&nbsp;'.$row["loss"].' 负 ('.(($appearance==0)?'-':round(100*$row["loss"]/$appearance)).'%)
							<br>
							球队进球：'.$row["team_score"].' (场均 '.(($appearance==0)?'-':bcdiv($row["team_score"], $appearance, 2)).')
							&nbsp;&nbsp;
							球队失球：'.$row["team_conceed"].' (场均 '.(($appearance==0)?'-':bcdiv($row["team_conceed"], $appearance, 2)).')
						</div>';
						}
					}
					?>
				</div>

				<div class="row">
					<?php
					$sql = 'SELECT R.score1, R.score2, R.penalty1, R.penalty2, R.game_player, R.fut_champion_id, R.game, F.date FROM appearances AS A LEFT JOIN results AS R ON A.fut_champion_id=R.fut_champion_id AND A.game=R.game LEFT JOIN fut_champions AS F ON A.fut_champion_id=F.id WHERE A.player_id='.$player_id.((isset($_POST["fut_champion_id"]))?' AND A.fut_champion_id='.$fut_champion_id:'').(($game_player_name=="")?'':' AND R.game_player="'.$game_player_name.'"').' ORDER BY R.fut_champion_id ASC, R.game ASC';
					$result = $conn->query($sql);
					while ($row = $result->fetch_assoc()) {
						echo '
					<div class="col-xxl-24 col-xl-30 col-lg-40 col-sm-60" style="border: 1px solid #888888; border-radius: 5px; min-height: 150px;">
						'.((isset($_POST["fut_champion_id"]))? '':'<b style="font-size: 20px;">'.$row["date"].'</b><br>').'
						<b style="font-size: 18px;">Game '.$row["game"].'</b><br>
						<div class="row" style="font-size: 16px;">
							<div class="col-60">
								'.$row["score1"].' - '.$row["score2"];

							if ($row["penalty1"] != "") {
								echo ' ('.$row["penalty1"].' - '.$row["penalty2"].')';
							}

							echo '
							</div>
							<div class="col-60">
								'.$row["game_player"].'
							</div>
						</div>';

						$sql1 = 'SELECT PG.id AS scorer_id, PG.C_name AS scorer_C_name, PA.id AS assist_id, PA.C_name AS assist_C_name FROM goals AS G LEFT JOIN players AS PG ON G.scorer=PG.id LEFT JOIN players AS PA ON G.assist=PA.id WHERE G.fut_champion_id='.$row["fut_champion_id"].' AND G.game='.$row["game"];
						$result1 = $conn->query($sql1);
						while ($row1 = $result1->fetch_assoc()) {
							echo '
						<div>
							<img src="images/photos/'.$row1["scorer_id"].'.png" style="width: 30px; height: 30px;">'.
							(($row1["scorer_id"]==$player_id)? '<b style="color: red;">'.$row1["scorer_C_name"].'</b>':$row1["scorer_C_name"]);

							if ($row1["assist_C_name"] != "") {
								echo '
							（<img src="images/photos/'.$row1["assist_id"].'.png" style="width: 30px; height: 30px;">'.
							(($row1["assist_id"]==$player_id)? '<b style="color: blue;">'.$row1["assist_C_name"].'</b>':$row1["assist_C_name"]).'）';
							}

							echo '
						</div>';
						}

						echo '
					</div>';
					}
					?>
				</div>