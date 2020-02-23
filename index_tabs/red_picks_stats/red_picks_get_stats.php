				<?php
				include("../../includes/connection.php");
				$game_player_name = $_POST["game_player_name"];
				$column = $_POST["column"];
				$order = $_POST["order"];
				$order_by = $column." ".$order;
				if ($order == "ASC") $order_by = $order_by.', appearance ASC, avg_sum ASC, num_score ASC, num_assist ASC, win_rate ASC, rating ASC';
				else $order_by = $order_by.', appearance DESC, avg_sum DESC, num_score DESC, num_assist DESC, win_rate DESC, rating DESC';

				if ($order == "ASC") $icon = '<i class="fa fa-chevron-up"></i>';
				else $icon = '<i class="fa fa-chevron-down"></i>';
					
				echo '
				<table style="width: 100%;">
					<tr>
						<th style="width: 20%;">姓名</th>
						<th style="width: 7%; cursor: pointer; display: none" class="d-md-table-cell" onclick="change_order_by(\'rating\')">总评'.(($column=="rating")?$icon:"").'</th>
						<th style="width: 7%; cursor: pointer; display: none;" class="d-xl-table-cell" onclick="change_order_by(\'price\')">身价'.(($column=="price")?$icon:"").'</th>
						<th style="width: 7%; cursor: pointer;" onclick="change_order_by(\'appearance\')">出场'.(($column=="appearance")?$icon:"").'</th>
						<th style="width: 7%; cursor: pointer;" onclick="change_order_by(\'num_score\')">进球'.(($column=="num_score")?$icon:"").'</th>
						<th style="width: 7%; cursor: pointer;" onclick="change_order_by(\'num_assist\')">助攻'.(($column=="num_assist")?$icon:"").'</th>
						<th style="width: 7%; cursor: pointer; display: none" class="d-lg-table-cell" onclick="change_order_by(\'avg_score\')">场均进球'.(($column=="avg_score")?$icon:"").'</th>
						<th style="width: 7%; cursor: pointer; display: none" class="d-lg-table-cell" onclick="change_order_by(\'avg_assist\')">场均助攻'.(($column=="avg_assist")?$icon:"").'</th>
						<th style="width: 7%; cursor: pointer; display: none" class="d-sm-table-cell" onclick="change_order_by(\'avg_sum\')">场均制造'.(($column=="avg_sum")?$icon:"").'</th>
						<th style="width: 7%; cursor: pointer; display: none" class="d-xl-table-cell" onclick="change_order_by(\'win\')">胜'.(($column=="win")?$icon:"").'</th>
						<th style="width: 7%; cursor: pointer; display: none" class="d-xl-table-cell" onclick="change_order_by(\'loss\')">负'.(($column=="loss")?$icon:"").'</th>
						<th style="width: 7%; cursor: pointer;" onclick="change_order_by(\'win_rate\')">胜率'.(($column=="win_rate")?$icon:"").'</th>
					</tr>';

				if ($game_player_name == "") $game_player_citeria = "";
				else $game_player_citeria = ' AND R.game_player="'.$game_player_name.'"';		
				$sql = 'SELECT RED.player_id, RED.game_player, E_name, C_name, rating, price, IFNULL(appearance,0) AS appearance, 
						IFNULL(num_score,0) AS num_score, (IFNULL(num_score,0)/IFNULL(appearance,0)) AS avg_score, 
						IFNULL(num_assist,0) AS num_assist, (IFNULL(num_assist,0)/IFNULL(appearance,0)) AS avg_assist, 
						((IFNULL(num_score,0)+IFNULL(num_assist,0))/IFNULL(appearance,0)) AS avg_sum, 
						IFNULL(win,0) AS win, IFNULL(loss,0) AS loss, (IFNULL(win,0)/IFNULL(appearance,0)) AS win_rate
						FROM (SELECT player_id, game_player FROM red_picks'.(($game_player_name=="")?"":' WHERE game_player="'.$game_player_name.'"').') AS RED 
						LEFT JOIN players AS PLA on RED.player_id=PLA.id 
						LEFT JOIN (SELECT player_id, COUNT(*) AS appearance FROM appearances GROUP BY player_id) AS APP ON RED.player_id=APP.player_id
						LEFT JOIN (SELECT scorer, COUNT(*) AS num_score FROM goals GROUP BY scorer) AS SCO ON APP.player_id=SCO.scorer 
						LEFT JOIN (SELECT assist, COUNT(*) AS num_assist FROM goals GROUP BY assist) AS ASS ON RED.player_id=ASS.assist 
						LEFT JOIN (SELECT APP.player_id, COUNT(*) AS win FROM appearances AS APP LEFT JOIN results AS R ON APP.fut_champion_id=R.fut_champion_id AND APP.game=R.game WHERE (R.score1>R.score2 OR R.penalty1>R.penalty2) GROUP BY APP.player_id) AS WIN ON RED.player_id=WIN.player_id
						LEFT JOIN (SELECT APP.player_id, COUNT(*) AS loss FROM appearances AS APP LEFT JOIN results AS R ON APP.fut_champion_id=R.fut_champion_id AND APP.game=R.game WHERE (R.score1<R.score2 OR R.penalty1<R.penalty2) GROUP BY APP.player_id) AS LOSS ON RED.player_id=LOSS.player_id
						ORDER BY '.$order_by;

				$result = $conn->query($sql);
				while ($row = $result->fetch_assoc()) {
					$appearance = $row["appearance"];
					$num_score = $row["num_score"];
					$num_assist = $row["num_assist"];
					$avg_score = (($appearance==0)? '':bcdiv($num_score, $appearance, 2));
					$avg_assist = (($appearance==0)? '':bcdiv($num_assist, $appearance, 2));
					$avg_sum = (($appearance==0)? '':bcdiv(($num_score+$num_assist), $appearance, 2));
					$win_rate = (($appearance==0)? '':round(100*$row["win"]/$appearance).'%');
					echo '
					<tr style="cursor: pointer;" onclick="get_player_game_history('.$row["player_id"].')">
						<td>
							<div class="row" style="width: 100%;">
								<div style="height: 100%; display: none;" class="col-50 d-sm-block">
									<img src="images/photos/'.$row["player_id"].'.png" style="height: 70px;;">
								</div>
								<div style="height: 100%;" class="col-sm-70">
									<b style="font-size: 12px;">'.$row["C_name"].'</b>
									<br>
									<a style="font-size: 10px;">'.$row["E_name"].'</a>';

					if ($game_player_name == "") {
						echo '
									<br>
									<a style="font-size: 10px;">Packed By: <b>'.$row["game_player"].'</b></a>';
					}

					echo '
								</div>
							</div>
						</td>
						<td style="text-align: center; display: none;" class="d-md-table-cell">'.$row["rating"].'</td>
						<td style="text-align: center; display: none;" class="d-xl-table-cell">'.number_format($row["price"], 0, ".", ",").'</td>
						<td style="text-align: center;">'.$appearance.'</td>
						<td style="text-align: center;">'.$num_score.'</td>
						<td style="text-align: center;">'.$num_assist.'</td>
						<td style="text-align: center; display: none;" class="d-lg-table-cell">'.$avg_score.'</td>
						<td style="text-align: center; display: none;" class="d-lg-table-cell">'.$avg_assist.'</td>
						<td style="text-align: center; display: none;" class="d-sm-table-cell">'.$avg_sum.'</td>
						<td style="text-align: center; display: none;" class="d-xl-table-cell">'.$row["win"].'</td>
						<td style="text-align: center; display: none;" class="d-xl-table-cell">'.$row["loss"].'</td>
						<td style="text-align: center;">'.$win_rate.'</td>
					</tr>';
				}



				// overall row
				$sql = 'SELECT AVG(rating) AS avg_rating, AVG(price) AS avg_price, IFNULL(SUM(appearance),0) AS appearance,
						IFNULL(SUM(num_score),0) AS num_score, (IFNULL(SUM(num_score),0)/IFNULL(SUM(appearance),0)) AS avg_score, 
						IFNULL(SUM(num_assist),0) AS num_assist, (IFNULL(SUM(num_assist),0)/IFNULL(SUM(appearance),0)) AS avg_assist, 
						((IFNULL(SUM(num_score),0)+IFNULL(SUM(num_assist),0))/IFNULL(SUM(appearance),0)) AS avg_sum, 
						IFNULL(SUM(win),0) AS win, IFNULL(SUM(loss),0) AS loss, (IFNULL(SUM(win),0)/IFNULL(SUM(appearance),0)) AS win_rate
						FROM (SELECT player_id, game_player FROM red_picks'.(($game_player_name=="")?"":' WHERE game_player="'.$game_player_name.'"').') AS RED 
						LEFT JOIN players AS PLA on RED.player_id=PLA.id 
						LEFT JOIN (SELECT player_id, COUNT(*) AS appearance FROM appearances GROUP BY player_id) AS APP ON RED.player_id=APP.player_id
						LEFT JOIN (SELECT scorer, COUNT(*) AS num_score FROM goals GROUP BY scorer) AS SCO ON APP.player_id=SCO.scorer 
						LEFT JOIN (SELECT assist, COUNT(*) AS num_assist FROM goals GROUP BY assist) AS ASS ON RED.player_id=ASS.assist 
						LEFT JOIN (SELECT APP.player_id, COUNT(*) AS win FROM appearances AS APP LEFT JOIN results AS R ON APP.fut_champion_id=R.fut_champion_id AND APP.game=R.game WHERE (R.score1>R.score2 OR R.penalty1>R.penalty2) GROUP BY APP.player_id) AS WIN ON RED.player_id=WIN.player_id
						LEFT JOIN (SELECT APP.player_id, COUNT(*) AS loss FROM appearances AS APP LEFT JOIN results AS R ON APP.fut_champion_id=R.fut_champion_id AND APP.game=R.game WHERE (R.score1<R.score2 OR R.penalty1<R.penalty2) GROUP BY APP.player_id) AS LOSS ON RED.player_id=LOSS.player_id';

				$result = $conn->query($sql);
				while ($row = $result->fetch_assoc()) {
					$appearance = $row["appearance"];
					$num_score = $row["num_score"];
					$num_assist = $row["num_assist"];
					$avg_score = (($appearance==0)? '':bcdiv($num_score, $appearance, 2));
					$avg_assist = (($appearance==0)? '':bcdiv($num_assist, $appearance, 2));
					$avg_sum = (($appearance==0)? '':bcdiv(($num_score+$num_assist), $appearance, 2));
					$win_rate = (($appearance==0)? '':round(100*$row["win"]/$appearance).'%');
					echo '
					<tr>
						<td style="text-align: center; height: 70px;"><b>综合</b></td>
						<td style="text-align: center; display: none;" class="d-xl-table-cell">'.bcdiv($row["avg_rating"],1,2).'</td>
						<td style="text-align: center; display: none;" class="d-xl-table-cell">'.number_format($row["avg_price"], 0, ".", ",").'</td>
						<td style="text-align: center;">'.$appearance.'</td>
						<td style="text-align: center;">'.$num_score.'</td>
						<td style="text-align: center;">'.$num_assist.'</td>
						<td style="text-align: center; display: none;" class="d-lg-table-cell">'.$avg_score.'</td>
						<td style="text-align: center; display: none;" class="d-lg-table-cell">'.$avg_assist.'</td>
						<td style="text-align: center; display: none;" class="d-sm-table-cell">'.$avg_sum.'</td>
						<td style="text-align: center; display: none;" class="d-xl-table-cell">'.$row["win"].'</td>
						<td style="text-align: center; display: none;" class="d-xl-table-cell">'.$row["loss"].'</td>
						<td style="text-align: center;">'.$win_rate.'</td>
					</tr>';
				}
				?>
				</table>