				<?php
				include("../../includes/connection.php");
				$fut_champion_id = $_POST["fut_champion_id"];
				$game_player_name = $_POST["game_player_name"];
				if ($game_player_name == "") $search_citeria = "";
				else $search_citeria = ' AND R.game_player="'.$game_player_name.'"';
				$order_by = $_POST["order_by"];

				// win
				$sql = 'SELECT COUNT(*) AS win FROM results AS R WHERE fut_champion_id='.$fut_champion_id.' AND (score1>score2 OR penalty1>penalty2)'.$search_citeria;
				$result = $conn->query($sql);
				while ($row = $result->fetch_assoc()) {
					$win = $row["win"];
				}
				// loss
				$sql = 'SELECT COUNT(*) AS loss FROM results AS R WHERE fut_champion_id='.$fut_champion_id.' AND (score1<score2 OR penalty1<penalty2)'.$search_citeria;
				$result = $conn->query($sql);
				while ($row = $result->fetch_assoc()) {
					$loss = $row["loss"];
				}
				// goal & conceed
				$sql = 'SELECT SUM(score1) AS score, SUM(score2) AS conceed FROM results AS R WHERE fut_champion_id='.$fut_champion_id.$search_citeria;
				$result = $conn->query($sql);
				while ($row = $result->fetch_assoc()) {
					$score = $row["score"];
					$conceed = $row["conceed"];
				}

				if ($win+$loss == 0) {
					$win_rate = 0;
					$loss_rate = 0;
					$average_score = 0;
					$average_conceed = 0;
				}
				else {
					$win_rate = round(100 * $win / ($win+$loss));
					$loss_rate = round(100 * $loss / ($win+$loss));
					$average_score = bcdiv($score, $win+$loss, 2);
					$average_conceed = bcdiv($conceed, $win+$loss, 2);
				}

				$rating_icon = "";
				$appearance_icon = "";
				$score_icon = "";
				$assist_icon = "";
				if ($order_by == "PLA.rating ASC") $rating_icon = '<i class="fa fa-chevron-up"></i>';
				if ($order_by == "PLA.rating DESC") $rating_icon = '<i class="fa fa-chevron-down"></i>';
				if ($order_by == "APP.appearance ASC") $appearance_icon = '<i class="fa fa-chevron-up"></i>';
				if ($order_by == "APP.appearance DESC") $appearance_icon = '<i class="fa fa-chevron-down"></i>';
				if ($order_by == "SCO.num_score ASC") $score_icon = '<i class="fa fa-chevron-up"></i>';
				if ($order_by == "SCO.num_score DESC") $score_icon = '<i class="fa fa-chevron-down"></i>';
				if ($order_by == "ASS.num_assist ASC") $assist_icon = '<i class="fa fa-chevron-up"></i>';
				if ($order_by == "ASS.num_assist DESC") $assist_icon = '<i class="fa fa-chevron-down"></i>';

				echo '
				<center>
					<h3>'.$win.' 胜 ('.$win_rate.'%) '.$loss.' 负 ('.$loss_rate.'%)</h3>
					<h4>
						进 '.$score.' 球 (场均 '.$average_score.')
						<i class="d-md-inline" style="display: none">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i>
						<i class="d-md-none" style="display: inline"><br></i>
						失 '.$conceed.' 球 (场均 '.$average_conceed.')
					</h4>
				</center>

				<table style="width: 100%;">
					<tr>
						<th style="width: 40%;">姓名</th>
						<th style="width: 15%; cursor: pointer;" onclick="change_order_by(\'rating\')">总评'.$rating_icon.'</th>
						<th style="width: 15%; cursor: pointer;" onclick="change_order_by(\'appearance\')">出场'.$appearance_icon.'</th>
						<th style="width: 15%; cursor: pointer;" onclick="change_order_by(\'num_score\')">进球'.$score_icon.'</th>
						<th style="width: 15%; cursor: pointer;" onclick="change_order_by(\'num_assist\')">助攻'.$assist_icon.'</th>
					</tr>';

				if ($game_player_name == "") {
					$sql = 'SELECT APP.player_id, PLA.E_name, PLA.C_name, PLA.rating, APP.appearance, SCO.num_score, ASS.num_assist FROM (SELECT player_id, COUNT(*) AS appearance FROM appearances WHERE fut_champion_id='.$fut_champion_id.' GROUP BY player_id) AS APP LEFT JOIN (SELECT scorer, COUNT(*) AS num_score FROM goals WHERE fut_champion_id='.$fut_champion_id.' GROUP BY scorer) AS SCO ON APP.player_id=SCO.scorer LEFT JOIN (SELECT assist, COUNT(*) AS num_assist FROM goals WHERE fut_champion_id='.$fut_champion_id.' GROUP BY assist) AS ASS ON APP.player_id=ASS.assist LEFT JOIN players AS PLA on APP.player_id=PLA.id ORDER BY '.$order_by;
				}
				else {
					$sql = 'SELECT APP.player_id, PLA.E_name, PLA.C_name, PLA.rating, APP.appearance, SCO.num_score, ASS.num_assist FROM (SELECT APP.player_id, COUNT(*) AS appearance FROM appearances AS APP LEFT JOIN results AS R ON APP.fut_champion_id=R.fut_champion_id AND APP.game=R.game WHERE APP.fut_champion_id='.$fut_champion_id.' AND R.game_player="'.$game_player_name.'" GROUP BY APP.player_id) AS APP LEFT JOIN (SELECT SCO.scorer, COUNT(*) AS num_score FROM goals AS SCO LEFT JOIN results AS R ON SCO.fut_champion_id=R.fut_champion_id AND SCO.game=R.game WHERE SCO.fut_champion_id='.$fut_champion_id.' AND R.game_player="'.$game_player_name.'" GROUP BY SCO.scorer) AS SCO ON APP.player_id=SCO.scorer LEFT JOIN (SELECT ASS.assist, COUNT(*) AS num_assist FROM goals AS ASS LEFT JOIN results AS R ON ASS.fut_champion_id=R.fut_champion_id AND ASS.game=R.game WHERE ASS.fut_champion_id='.$fut_champion_id.' AND R.game_player="'.$game_player_name.'" GROUP BY assist) AS ASS ON APP.player_id=ASS.assist LEFT JOIN players AS PLA on APP.player_id=PLA.id ORDER BY '.$order_by;
				}
				
				$result = $conn->query($sql);
				while ($row = $result->fetch_assoc()) {
					$num_score = ($row["num_score"]=="")? 0:$row["num_score"];
					$num_assist = ($row["num_assist"]=="")? 0:$row["num_assist"];
					echo '
					<tr>
						<td>
							<div class="row" style="width: 100%;">
								<div style="height: 100%; display: none;" class="col-50 d-sm-block">
									<img src="images/photos/'.$row["player_id"].'.png" style="height: 70px;;">
								</div>
								<div style="height: 100%;" class="col-sm-70">
									&nbsp;
									<b style="font-size: 12px;">'.$row["C_name"].'</b>
									<br>
									<a style="font-size: 10px;">'.$row["E_name"].'</a>
								</div>
							</div>
						</td>
						<td style="text-align: center;">'.$row["rating"].'</td>
						<td style="text-align: center;">'.$row["appearance"].'</td>
						<td style="text-align: center;">'.$num_score.'</td>
						<td style="text-align: center;">'.$num_assist.'</td>
					</tr>';
				}
				?>
				</table>