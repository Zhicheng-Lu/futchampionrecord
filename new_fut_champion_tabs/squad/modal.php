	<div id="modify_squad_modal" class="modal">
		<div class="modal-content container" style="height: 100%;">
			<div class="modal-header">
				<span class="close" onclick="close_modal()">&times;</span>
			</div>
			<div class="modal-body" id="modal_body">
				<input id="player_name_input" type="search" style="width: 100%; margin-bottom: 30px; border: 1px solid #AAAAAA;" oninput="player_name_oninput()" value="">
				<div class="row">
					<?php
					$counter = 0;
					$sql = 'SELECT * FROM players';
					$result = $conn->query($sql);
					while ($row = $result->fetch_assoc()) {
						echo '
					<div class="col-xxl-24 col-xl-30 col-lg-40 col-sm-60" id="player_'.$counter.'" style="height: 150px; border-bottom: 1px solid #888888; cursor: pointer;" onclick="choose_player('.$row["id"].')">
						<div class="row" style="height: 100%;">
							<div style="height: 100%;" class="col-50">
								<img src="images/cards/'.$row["id"].'.png" style="height: 100%;">
							</div>
							<div style="height: 100%;" class="col-70">
								<b style="font-size: 16px;">'.$row["C_name"].'</b>
								<br>
								'.$row["E_name"].'
							</div>
						</div>
					</div>';
						$counter += 1;
					}
					?>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->

	<style type="text/css">
		#modify_squad_modal {
        	z-index: 9999;
        }

        .submit_button {
			height: 40px;
			border-radius: 5px;
			font-size: 20px;
			background-color: white;
			margin-top: 40px;
		}
	</style>

	<script type="text/javascript">
		var position;

		function open_modal(p) {
			position = p;
			document.getElementById("modify_squad_modal").style.display = "block";
		}

		function close_modal() {
			document.getElementById("modify_squad_modal").style.display = "none";
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

		var counter = <?php echo $counter; ?>;
		var players = [];
    	<?php
    	$sql = "SELECT * FROM players";
        $result = $conn->query($sql);
    	while ($row = $result->fetch_assoc()) {
    		echo '
    	players.push({E_name: "'.$row["E_name"].'", C_name: "'.$row["C_name"].'"});';
    	}
    	?>

        // filter while input
	    function player_name_oninput() {
	    	var input = document.getElementById("player_name_input").value;
	    	for (i = 0; i < counter;  i++) {
	    		if (players[i]["E_name"].toLowerCase().includes(input.toLowerCase()) || players[i]["C_name"].toLowerCase().includes(input.toLowerCase())) {
	    			document.getElementById("player_" + i).style.display = "block";
	    		}
	    		else {
	    			document.getElementById("player_" + i).style.display = "none";
	    		}
	    	}
	    }

	    function choose_player(player_id) {
	    	var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   // Typical action to be performed when the document is ready:
                   document.getElementById("position_" + position).innerHTML = xhttp.responseText;
                   close_modal();
                }
            };
            xhttp.open("POST", "new_fut_champion_tabs/squad/modify_player.php", true);
            xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhttp.send("position=" + position + "&player_id=" + player_id);
	    }

	    function clear_player(p) {
			event.stopPropagation();
			var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   // Typical action to be performed when the document is ready:
                   document.getElementById("position_" + position).innerHTML = xhttp.responseText;
                }
            };
            xhttp.open("POST", "new_fut_champion_tabs/squad/modify_player.php", true);
            xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhttp.send("position=" + position + "&player_id=");
	    }
	</script>