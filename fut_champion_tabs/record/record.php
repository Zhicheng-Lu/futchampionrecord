	<br><br><br><br><br>

	<style type="text/css">
        #game_modal {
        	z-index: 9999;
        }

        .submit_button {
			height: 40px;
			border-radius: 5px;
			font-size: 20px;
			background-color: white;
			width: 40%;
		}

		.dropdown {
			position: relative;
			width: 140px;
			height: 36px;
			display: inline-block;
			border: 1px solid #D9D9D9;
			cursor: pointer;
		}

		.dropdown-options {
			display: none;
			position: absolute;
			background-color: #F9F9F9;
			box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
			width: 100%;
			z-index: 1;
			margin-top: 2px;
			cursor: pointer;
		}

		.dropdown-option:hover {
			color: white;
			background-color: #18a3eb;
		}

		.dropdown:mouseleave .dropdown-options {
			display: none;
		}
	</style>

	<div class="section">
		<div class="container" id="container">
			<?php
			if (!isset($_GET["game_player_name"])) $game_player_criteria = '';
			elseif ($_GET["game_player_name"] == "") $game_player_criteria = '';
			else $game_player_criteria = ' AND game_player="'.$_GET["game_player_name"].'"';

			$sql = 'SELECT COUNT(*) AS win FROM results WHERE fut_champion_id='.$fut_champion_id.' AND (score1>score2 OR penalty1>penalty2)'.$game_player_criteria;
			$result = $conn->query($sql);
			while ($row = $result->fetch_assoc()) {
				$win = $row["win"];
			}
			$sql = 'SELECT COUNT(*) AS loss FROM results WHERE fut_champion_id='.$fut_champion_id.' AND (score1<score2 OR penalty1<penalty2)'.$game_player_criteria;
			$result = $conn->query($sql);
			while ($row = $result->fetch_assoc()) {
				$loss = $row["loss"];
			}

			// num_games in different situations
			if (!isset($_GET["game_player_name"])) {
				$sql = 'SELECT MAX(game) AS num_games FROM results WHERE fut_champion_id='.$fut_champion_id;
				$result = $conn->query($sql);
				while ($row = $result->fetch_assoc()) {
					$num_games = $row["num_games"];
				}
			}
			elseif ($_GET["game_player_name"] == "") {
				$sql = 'SELECT MAX(game) AS num_games FROM results WHERE fut_champion_id='.$fut_champion_id;
				$result = $conn->query($sql);
				while ($row = $result->fetch_assoc()) {
					$num_games = $row["num_games"];
				}
			}
			else {
				$num_games = $win + $loss;
			}
			

			echo '
			<center style="margin-bottom: 20px;">
				<h2 style="display: inline-block;">'.$win.' 胜 '.($num_games-$win).' 负'.(($win+$loss==$num_games)?'':' ('.($num_games-$win-$loss).')').'</h2>
				&nbsp;&nbsp;&nbsp;
				<div class="dropdown" style="text-align: left; display: inline-block;" onclick="show_options(this)" onmouseleave="hide_options(this)" ondragover="allowDrop(event)" ondrop="drop_player(this)">
					<div><img src="images/transparent.png" style="height: 25px; width" 25px;>'.(($game_player_criteria=='')? '--选择玩家--':$_GET["game_player_name"]).'</div>
					<div class="dropdown-options" onclick="event.stopPropagation();">
						<div class="dropdown-option" onclick="choose_game_player(\'\')">
							<img src="images/transparent.png" style="height: 25px; width" 25px;>
						</div>
						<div class="dropdown-option" onclick="choose_game_player(\'Andy\')">
							<img src="images/transparent.png" style="height: 25px; width" 25px;>Andy
						</div>
						<div class="dropdown-option" onclick="choose_game_player(\'Jack\')">
							<img src="images/transparent.png" style="height: 25px; width" 25px;>Jack
						</div>
					</div>
				</div>
			</center>';
			?>

			<div class="row">
				<?php
				$num_win = 0;
				$num_loss = 0;
				for ($game=1; $game < 31; $game++) {
					$score1 = "";
					$score2 = "";
					$penalty1 = "";
					$penalty2 = "";
					$game_player = "";
					$show = false;
					$color = "black";
					$sql = 'SELECT * FROM results WHERE fut_champion_id='.$fut_champion_id.' AND game='.$game;
					$result = $conn->query($sql);
					while ($row = $result->fetch_assoc()) {
						$game_player = $row["game_player"];
						$score1 = $row["score1"];
						$score2 = $row["score2"];
						$penalty1 = $row["penalty1"];
						$penalty2 = $row["penalty2"];
						$game_player = $row["game_player"];
						$show = true;
					}
					if (isset($_GET["game_player_name"])) {
						if ($_GET["game_player_name"] != "" && $_GET["game_player_name"] != $game_player) continue;
					}
					if (!$show) {
						$num_loss += 1;
						if ($game < $num_games) $show = true;
					}
					if ($score1>$score2 || ($score1==$score2 && $penalty1>$penalty2)) {
						$num_win += 1;
						$color = "red";
					}
					if ($score1<$score2 || ($score1==$score2 && $penalty1<$penalty2)) {
						$num_loss += 1;
						$color = "blue";
					}
					

					echo '
				<div id="game_'.$game.'" class="col-xxl-24 col-xl-30 col-lg-40 col-sm-60" style="border: 1px solid #888888; border-radius: 5px; min-height: 150px; cursor: pointer;" onclick="open_game_modal('.$game.')">
					<b style="font-size: 20px; color: '.$color.';">Game '.$game.(($show)?' ('.$num_win.'-'.$num_loss.')':'').'</b><br>
					<div class="row" style="font-size: 16px;">
						<div class="col-60">
							'.(($score1!="")? $score1.' - '.$score2:'');

						if ($penalty1 != "") {
							echo ' ('.$penalty1.' - '.$penalty2.')';
						}

						echo '
						</div>
						<div class="col-60">
							'.$game_player.'
						</div>
					</div>';

					$sql = 'SELECT PG.id AS scorer_id, PG.C_name AS scorer_C_name, PA.id AS assist_id, PA.C_name AS assist_C_name FROM goals AS G LEFT JOIN players AS PG ON G.scorer=PG.id LEFT JOIN players AS PA ON G.assist=PA.id WHERE G.fut_champion_id='.$fut_champion_id.' AND G.game='.$game;
					$result = $conn->query($sql);
					while ($row = $result->fetch_assoc()) {
						echo '
					<div>
						<img src="images/photos/'.$row["scorer_id"].'.png" style="width: 30px; height: 30px;">'.$row["scorer_C_name"];

						if ($row["assist_C_name"] != "") {
							echo '
						（<img src="images/photos/'.$row["assist_id"].'.png" style="width: 30px; height: 30px;">'.$row["assist_C_name"].'）';
						}

						echo '
					</div>';
					}

					echo '
				</div>';
				}
				?>
			</div>
		</div>
	</div>

	<?php include("fut_champion_tabs/record/game_modal.php"); ?>


	<script type="text/javascript">
		var fut_champion_id = <?php echo $fut_champion_id; ?>;
		function open_game_modal(game) {
			var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                	// Typical action to be performed when the document is ready:
                	document.getElementById("game_modal_body").innerHTML = xhttp.responseText;
					document.getElementById("game_modal").style.display = "block";
                }
            };
            xhttp.open("POST", "fut_champion_tabs/record/game_modal_body.php", true);
            xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhttp.send("fut_champion_id=" + fut_champion_id + "&game=" + game);
		}

		function close_game_modal() {
			document.getElementById("game_modal").style.display = "none";
		}

		// close modal when click outside of popup box
		window.onclick = function(event) {
			var modals = document.getElementsByClassName("modal");
			for (var i = modals.length - 1; i >= 0; i--) {
				var modal = modals[i];
				if (event.target == modal) {
					modal.style.display = "none";
				}
			}
		}

		// drop down list
		function show_options(dropdown) {
			options = dropdown.childNodes[3];
			if (options.style.display == "block") {
				options.style.display = "none";
			}
			else {
				options.style.display = "block";
			}
		}

		function hide_options(dropdown) {
			options = dropdown.childNodes[3];
			options.style.display = "none";
		}

		function choose_game_player(game_player_name) {
			location.href = 'fut_champion.php?fut_champion_id=<?php echo $fut_champion_id; ?>&tab=record&game_player_name=' + game_player_name;
		}
	</script>