	<br><br><br><br><br>

	<div class="section">
		<div class="col-lg-108 offset-lg-6 col-120">	
			<div class="row">
				<button id="button_" class="col-sm-30 offset-sm-15 col-40" style="height: 50px; background-color: white; color: black; border-radius: 5px; font-size: 16px; cursor: pointer;" onclick="change_game_player('')">总和</button>
				<button id="button_Andy" class="col-sm-30 col-40" style="height: 50px; background-color: white; color: black; border-radius: 5px; font-size: 16px; cursor: pointer;" onclick="change_game_player('Andy')">Andy</button>
				<button id="button_Jack" class="col-sm-30 col-40" style="height: 50px; background-color: white; color: black; border-radius: 5px; font-size: 16px; cursor: pointer;" onclick="change_game_player('Jack')">Jack</button>
			</div>
			<br><br>

			<div class="row justify-content-center">
				<div id="stats_display" class="col-xxl-100"></div>
			</div>
		</div>
	</div>

	<div id="player_game_history_modal" class="modal">
		<div class="modal-content container" style="min-height: 100%;">
			<div class="modal-header">
				<span class="close" onclick="close_player_game_history_modal()">&times;</span>
			</div>
			<div class="modal-body" id="player_game_history_modal_body">
					
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->

	<style type="text/css">
		#player_game_history_modal {
			z-index: 9999;
		}
	</style>

	<script type="text/javascript">
		var game_player_name = "";
		var column = "appearance";
		var order = "DESC";
		get_stats();

		function change_game_player(game_player) {
			game_player_name = game_player;
			get_stats();
		}

		function change_order_by(new_column) {
			if (new_column == column) {
				if (order == "DESC") order = "ASC";
				else order = "DESC";
			}
			else {
				order = "DESC";
			}

			column = new_column;
			get_stats();
		}

		function get_stats() {
	    	var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   // Typical action to be performed when the document is ready:
                   document.getElementById("stats_display").innerHTML = xhttp.responseText;
                   document.getElementById("button_").style.backgroundColor = "white";
                   document.getElementById("button_").style.color = "black";
                   document.getElementById("button_Andy").style.backgroundColor = "white";
                   document.getElementById("button_Andy").style.color = "black";
                   document.getElementById("button_Jack").style.backgroundColor = "white";
                   document.getElementById("button_Jack").style.color = "black";

                   document.getElementById("button_" + game_player_name).style.backgroundColor = "#2E78EF";
                   document.getElementById("button_" + game_player_name).style.color = "white";
                }
            };
            xhttp.open("POST", "index_tabs/red_picks_stats/red_picks_get_stats.php", true);
            xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhttp.send("game_player_name=" + game_player_name + "&column=" + column + "&order=" + order);
	    }

	    function get_player_game_history(player_id) {
	    	var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   // Typical action to be performed when the document is ready:
                   document.getElementById("player_game_history_modal").style.display = "block";
                   document.getElementById("player_game_history_modal_body").innerHTML = xhttp.responseText;
                }
            };
            xhttp.open("POST", "includes/get_player_game_history.php", true);
            xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhttp.send("game_player_name=" + game_player_name + "&player_id=" + player_id);
	    }

	    function close_player_game_history_modal() {
	    	document.getElementById("player_game_history_modal").style.display = "none";
	    }

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