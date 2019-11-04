					<?php
					include("../../includes/connection.php");
					$fut_champion_id = $_POST["fut_champion_id"];
					$game = $_POST["game"];

					$score1 = "";
					$score2 = "";
					$penalty1 = "";
					$penalty2 = "";
					$sql = 'SELECT * FROM results WHERE fut_champion_id='.$fut_champion_id.' AND game='.$game;
					$result = $conn->query($sql);
					while ($row = $result->fetch_assoc()) {
						$score1 = $row["score1"];
						$score2 = $row["score2"];
						$penalty1 = $row["penalty1"];
						$penalty2 = $row["penalty2"];
					}

					if ($score1 == $score2 && $score1 != "") $penalty_display = "inline";
					else $penalty_display = "none";

					echo '

					<div class="row">
						<div class="col-sm-40" style="text-align: center;">
							<input type="number" id="score1" name="score1" min="0" max="15" style="width: 40px;" oninput="score1_oninput()" value="'.$score1.'"> - <input type="number" id="score2" name="score2" min="0" max="15" style="width: 40px;" oninput="score2_oninput()" value="'.$score2.'">
							<b style="margin-left: 30px; display: '.$penalty_display.';" id="penalty">(<input type="number" id="penalty1" name="penalty1" min="0" max="15" style="width: 40px;" value="'.$penalty1.'"> - <input type="number" id="penalty2" name="penalty2" min="0" max="15" style="width: 40px;" value="'.$penalty2.'">)</b>';

					// get all the players in the current squad
					$squad_players = array();
					$sql = 'SELECT * FROM squad AS S LEFT JOIN players AS P ON S.player_id=P.id ORDER BY S.position ASC';
					$result = $conn->query($sql);
					while ($row = $result->fetch_assoc()) {
						array_push($squad_players, array("id"=>$row["id"], "C_name"=>$row["C_name"]));
					}


					$sql = 'SELECT * FROM goals WHERE fut_champion_id='.$fut_champion_id.' AND game='.$game;
					$result = $conn->query($sql);
					$counter = 1;
					while ($row = $result->fetch_assoc()) {
						echo '
							<div style="margin-top: 15px;" id="goal_'.$counter.'">
								<select name="scorer_'.$counter.'">
									<option value=""></option>';

						foreach ($squad_players as $squad_player) {
							$selected = ($squad_player["id"]==$row["scorer"])? " selected":"";
							echo '
									<option value="'.$squad_player["id"].'"'.$selected.'>'.$squad_player["C_name"].'</option>';
						}

						echo '
								</select>
								（
								<select name="assist_'.$counter.'">
									<option value="null"></option>';

						foreach ($squad_players as $squad_player) {
							$selected = ($squad_player["id"]==$row["assist"])? " selected":"";
							echo '
									<option value="'.$squad_player["id"].'"'.$selected.'>'.$squad_player["C_name"].'</option>';
						}

						echo '
								</select>
								）
							</div>';

						$counter += 1;
					}


					// all goals & assists
					for ($i=$counter; $i < 16; $i++) {
						echo '
							<div style="margin-top: 15px; display: none;" id="goal_'.$i.'">
								<select name="scorer_'.$i.'" id="scorer_'.$i.'" ondragover="allowDrop(event)" ondrop="choose_scorer(event, '.$i.')" style="height: 25px;">
									<option value=""></option>';

						$sql = 'SELECT * FROM squad AS S LEFT JOIN players AS P ON S.player_id=P.id ORDER BY S.position ASC';
						$result = $conn->query($sql);
						while ($row = $result->fetch_assoc()) {
							echo '
									<option value="'.$row["id"].'">'.$row["C_name"].'</option>';
						}

						echo '
								</select>
								（
								<select name="assist_'.$i.'" id="assist_'.$i.'" ondragover="allowDrop(event)" ondrop="choose_assist(event, '.$i.')" style="height: 25px;">
									<option value="null"></option>';

						$sql = 'SELECT * FROM squad AS S LEFT JOIN players AS P ON S.player_id=P.id ORDER BY S.position ASC';
						$result = $conn->query($sql);
						while ($row = $result->fetch_assoc()) {
							echo '
									<option value="'.$row["id"].'">'.$row["C_name"].'</option>';
						}

						echo '
								</select>
								）
							</div>';
					}

					echo '
						</div>
						<div class="col-sm-80">
							<div class="row">';

					$sql = 'SELECT * FROM squad AS S LEFT JOIN players AS P ON S.player_id=P.id ORDER BY S.position ASC';
					$result = $conn->query($sql);
					while ($row = $result->fetch_assoc()) {
						if ($row["position"] <= 11) $checked = " checked";
						else {
							$sql1 = 'SELECT * FROM appearances WHERE fut_champion_id='.$fut_champion_id.' AND game='.$game.' AND player_id='.$row["player_id"];
							$result1 = $conn->query($sql1);
							if ($result1->num_rows == 1) $checked = " checked";
							else $checked = "";
						}
						// $checked = ($row["position"]<=11)? " checked":"";
						echo '
								<div class="col-xl-40 col-md-60" style="margin-bottom: 10px;" draggable="true" ondragstart="drag('.$row["player_id"].')">
									<div class="row" style="height: 120px;">
										<div style="height: 100%;" class="col-50">
											<img src="images/cards/'.$row["id"].'.png" style="height: 100%;" draggable="false">
										</div>
										<div style="height: 100%;" class="col-70">
											<input name="appearances[]" value="'.$row["player_id"].'" type="checkbox"'.$checked.'>
											&nbsp;
											<b style="font-size: 12px;">'.$row["C_name"].'</b>
											<br>
											<a style="font-size: 10px;">'.$row["E_name"].'</a>
										</div>
									</div>
								</div>';
					}
					?>
							</div>
						</div>
					</div>