	<form action="new_fut_champion.php" method="post">
		<input type="hidden" name="fut_champion_id" value="<?php echo $fut_champion_id; ?>">
		<input type="hidden" name="game" id="game">
		<div id="game_modal" class="modal">
			<div class="modal-content container">
				<div class="modal-header">
					<span class="close" onclick="close_game_modal()">&times;</span>
				</div>
				<div class="modal-body" id="game_modal_body">
					
				</div>
				<div class="modal-footer justify-content-center">
					<button class="submit_button" name="add_game">确认</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal -->
	</form>

	<script type="text/javascript">
		function score1_oninput() {
			var score1 = document.getElementById("score1").value;
			var score2 = document.getElementById("score2").value;
			if (score1 != "" && score2 != "" && score1 == score2) {
				document.getElementById("penalty").style.display = "inline";
			}
			else {
				document.getElementById("penalty").style.display = "none";
				document.getElementById("penalty1").value = "";
				document.getElementById("penalty2").value = "";
			}

			for (i = 1; i <= 15; i++) {
				document.getElementById("goal_" + i).style.display = "none";
			}
			for (i = 1; i <= score1; i++) {
				document.getElementById("goal_" + i).style.display = "block";
			}

			current_score = score1;
		}

		function score2_oninput() {
			var score1 = document.getElementById("score1").value;
			var score2 = document.getElementById("score2").value;
			if (score1 != "" && score2 != "" && score1 == score2) {
				document.getElementById("penalty").style.display = "inline";
			}
			else {
				document.getElementById("penalty").style.display = "none";
				document.getElementById("penalty1").value = "";
				document.getElementById("penalty2").value = "";
			}
		}


		// drag and drop
		var player_id;
		function drag(id) {
			player_id = id;
		}

		function allowDrop(ev) {
			ev.preventDefault();
		}

		function choose_scorer(ev, scorer) {
			ev.preventDefault();
			document.getElementById("scorer_" + scorer).value = player_id;
		}

		function choose_assist(ev, scorer) {
			ev.preventDefault();
			document.getElementById("assist_" + scorer).value = player_id;
		}
	</script>