	<br><br><br><br><br>

	<div class="section">
		<div class="container" id="container">
			<?php
			$sql = 'SELECT COUNT(*) AS win FROM results WHERE fut_champion_id='.$fut_champion_id.' AND (score1>score2 OR penalty1>penalty2)';
			$result = $conn->query($sql);
			while ($row = $result->fetch_assoc()) {
				$win = $row["win"];
			}
			$sql = 'SELECT COUNT(*) AS loss FROM results WHERE fut_champion_id='.$fut_champion_id.' AND (score1<score2 OR penalty1<penalty2)';
			$result = $conn->query($sql);
			while ($row = $result->fetch_assoc()) {
				$loss = $row["loss"];
			}

			echo '
			<center style="margin-bottom: 20px;">
				<h2>'.$win.' 胜 '.$loss.' 负</h2>
			</center>';
			?>

			<div class="row">
				<?php
				$num_win = 0;
				$num_loss = 0;
				for ($game=1; $game < 31; $game++) {
					$show = false;
					$sql = 'SELECT * FROM results WHERE fut_champion_id='.$fut_champion_id.' AND game='.$game;
					$result = $conn->query($sql);
					while ($row = $result->fetch_assoc()) {
						if ($row["score1"]>$row["score2"] || ($row["score1"]==$row["score2"] && $row["penalty1"]>$row["penalty2"])) $num_win += 1;
						else $num_loss += 1;
						$show = true;
					}

					echo '
				<div id="game_'.$game.'" class="col-xxl-24 col-xl-30 col-lg-40 col-sm-60" style="border: 1px solid #888888; border-radius: 5px; min-height: 150px; cursor: pointer;" onclick="open_game_modal('.$game.')">
					<b style="font-size: 20px;">Game '.$game.(($show)?' ('.$num_win.'-'.$num_loss.')':'').'</b><br>';

					$sql = 'SELECT * FROM results WHERE fut_champion_id='.$fut_champion_id.' AND game='.$game;
					$result = $conn->query($sql);
					while ($row = $result->fetch_assoc()) {
						echo '
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
					}

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
	</script>

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
	</style>