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
				<div id="stats_display" class="col-sm-90"></div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		var fut_champion_id = <?php echo $fut_champion_id; ?>;
		var game_player_name = "";
		var column = "rating";
		var order = "DESC";
		var order_by = "PLA.rating DESC";
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

			if (new_column == "rating") order_by = "PLA.rating " + order;
			if (new_column == "appearance") order_by = "APP.appearance " + order;
			if (new_column == "num_score") order_by = "SCO.num_score " + order;
			if (new_column == "num_assist") order_by = "ASS.num_assist " + order;
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
            xhttp.open("POST", "fut_champion_tabs/stats/get_stats.php", true);
            xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhttp.send("fut_champion_id=" + fut_champion_id + "&game_player_name=" + game_player_name + "&order_by=" + order_by);
	    }
	</script>