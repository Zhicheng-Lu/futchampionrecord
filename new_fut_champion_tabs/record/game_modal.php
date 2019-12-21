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

	<style type="text/css">
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
			/*margin-top: 40px;*/
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

	<script type="text/javascript">
		function score1_oninput() {
			var score1 = document.getElementById("score1").value;
			var score2 = document.getElementById("score2").value;
			if (score1 != "" && score2 != "" && score1 == score2) {
				document.getElementById("penalty").style.visibility = "visible";
			}
			else {
				document.getElementById("penalty").style.visibility = "hidden";
				document.getElementById("penalty1").value = "";
				document.getElementById("penalty2").value = "";
			}

			for (i = 1; i <= 10; i++) {
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
				document.getElementById("penalty").style.visibility = "visible";
			}
			else {
				document.getElementById("penalty").style.visibility = "hidden";
				document.getElementById("penalty1").value = "";
				document.getElementById("penalty2").value = "";
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

		function choose_player(option, player_id, player_C_name) {
			event.stopPropagation();
			options = option.parentNode;
			options.style.display = "none";
			dropdown = options.parentNode;
			// show selected option
			if (player_id == 0) {
				dropdown.childNodes[1].innerHTML = '<img src="images/transparent.png" style="height: 30px; width: 30px;">&nbsp';
			}
			else {
				dropdown.childNodes[1].innerHTML = '<img src="images/photos/' + player_id + '.png" style="height: 30px; width: 30px;">' + player_C_name;
			}
			// modify hidden input
			input = dropdown.childNodes[5];
			if (player_id == 0) input.value = "";
			else input.value = player_id;
		}


		// click checkbox for appearance
		function sub_on(checkbox, player_id) {
			if (checkbox.checked == true) {
				checkbox.parentNode.parentNode.parentNode.setAttribute("draggable", "true");
				options = document.getElementsByClassName("player_" + player_id);
				for (var i = options.length - 1; i >= 0; i--) {
					console.log(options[i]);
					options[i].style.display = "block";
				}
			}
			else {
				checkbox.parentNode.parentNode.parentNode.setAttribute("draggable", "false");
				options = document.getElementsByClassName("player_" + player_id);
				for (var i = options.length - 1; i >= 0; i--) {
					options[i].style.display = "none";
				}
			}
		}


		// drag and drop
		var player_id;
		var player_name;
		function drag(id, player_C_name) {
			player_id = id;
			player_name = player_C_name;
		}

		function allowDrop(ev) {
			ev.preventDefault();
		}

		function drop_player(dropdown) {
			event.stopPropagation();
			// show selected option
			if (player_id == 0) {
				dropdown.childNodes[1].innerHTML = '<img src="images/transparent.png" style="height: 30px; width: 30px;">&nbsp';
			}
			else {
				dropdown.childNodes[1].innerHTML = '<img src="images/photos/' + player_id + '.png" style="height: 30px; width: 30px;">' + player_name;
			}
			// modify hidden input
			input = dropdown.childNodes[5];
			if (player_id == 0) input.value = "";
			else input.value = player_id;
		}
	</script>