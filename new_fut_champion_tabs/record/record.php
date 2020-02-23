	<br><br><br><br><br>

	<style type="text/css">
		#login_modal {
        	z-index: 9999;
        }

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
			$sql = 'SELECT MAX(game) AS num_games FROM results WHERE fut_champion_id='.$fut_champion_id;
			$result = $conn->query($sql);
			while ($row = $result->fetch_assoc()) {
				$num_games = $row["num_games"];
			}

			echo '
			<center style="margin-bottom: 20px;">
				<h2>'.$win.' 胜 '.$loss.' 负'.(($win+$loss==$num_games)?'':' ('.($num_games-$win-$loss).')').'&nbsp;&nbsp;&nbsp;<button class="submit_button" style="width: 150px;" onclick="open_end_modal()">结束周赛</button></h2>
			</center>';
			?>

			<div class="row">
				<?php
				for ($game=1; $game < 31; $game++) { 
					echo '
				<div id="game_'.$game.'" class="col-xxl-24 col-xl-30 col-lg-40 col-sm-60" style="border: 1px solid #888888; border-radius: 5px; min-height: 150px; cursor: pointer;" onclick="open_game_modal('.$game.')">
					<b style="font-size: 20px;">Game '.$game.'</b><br>';

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


	<div id="login_modal" class="modal" style="top: 20%;">
		<div class="modal-content col-xxl-24 offset-xxl-48 col-xl-30 offset-xl-45 col-lg-40 offset-lg-40 col-sm-60 offset-sm-30">
			<div class="modal-header">
			</div>
			<div class="modal-body" id="modal_body">
				<input type="radio" name="user_name" value="Andy"> Andy<br>
				<input type="radio" name="user_name" value="Jack"> Jack
			</div>
			<div class="modal-footer justify-content-center">
				<button class="submit_button" onclick="login()">登录</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->

	<form action="fut_champion.php" method="post">
		<input type="hidden" name="fut_champion_id" value="<?php echo $fut_champion_id; ?>">
		<div id="end_modal" class="modal" style="top: 20%;">
			<div class="modal-content col-xxl-24 offset-xxl-48 col-xl-30 offset-xl-45 col-lg-40 offset-lg-40 col-sm-60 offset-sm-30">
				<div class="modal-header">
					<span class="close" onclick="close_end_modal()">&times;</span>
				</div>
				<div class="modal-body" id="modal_body">
					<p>结束本次周赛以后，包括比分在内的数据均不可以更改。确认结束么？</p>
				</div>
				<div class="modal-footer justify-content-center">
					<button name="end_fut_champion" class="submit_button">确认</button>
					<button type="button" class="submit_button" onclick="close_end_modal()">取消</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal -->
	</form>


	<?php include("new_fut_champion_tabs/record/game_modal.php"); ?>


	<script type="text/javascript">
		<?php
		if (!isset($_SESSION["user_name"])) {
			echo '
		open_login_modal();';
		}
		?>
		function open_login_modal() {
			document.getElementById("login_modal").style.display = "block";
		}

		function close_login_modal() {
			document.getElementById("login_modal").style.display = "none";
		}

		function open_end_modal() {
			document.getElementById("end_modal").style.display = "block";
		}

		function close_end_modal() {
			document.getElementById("end_modal").style.display = "none";
		}

		var fut_champion_id = <?php echo $fut_champion_id; ?>;
		function open_game_modal(game) {
			var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                	// Typical action to be performed when the document is ready:
                	document.getElementById("game_modal_body").innerHTML = xhttp.responseText;
                	document.getElementById("game").value = game;
					document.getElementById("game_modal").style.display = "block";
                }
            };
            xhttp.open("POST", "new_fut_champion_tabs/record/game_modal_body.php", true);
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
				if (event.target == modal && modal.id != "login_modal") {
					modal.style.display = "none";
				}
			}
		}

		function login() {
			var user_names = document.getElementsByName('user_name');
			var user_name
			for(i = 0; i < user_names.length; i++){
			    if(user_names[i].checked){
			        user_name = user_names[i].value;
			    }
			}
			var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   // Typical action to be performed when the document is ready:
                   document.getElementById("login_modal").style.display = "none";
                }
            };
            xhttp.open("POST", "new_fut_champion_tabs/record/login.php", true);
            xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhttp.send("user_name=" + user_name);
		}
	</script>