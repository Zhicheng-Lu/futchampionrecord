	<br><br><br><br><br>
	<div class="section">
        <div class="container">
			<h2>首发</h2>
			<div class="row">
				<?php
				for ($i=1; $i < 12; $i++) { 
					echo '
				<div id="position_'.$i.'" class="col-xxl-24 col-xl-30 col-lg-40 col-sm-60" style="border: 1px solid #888888; border-radius: 5px; height: 150px; cursor: pointer;" onclick="open_modal('.$i.')" ondragover="allowDrop(event)" ondrop="move(event, '.$i.')">';

					$sql = 'SELECT * FROM squad AS S LEFT JOIN players AS P ON S.player_id=P.id WHERE S.position='.$i;
					$result = $conn->query($sql);
					while ($row = $result->fetch_assoc()) {
						echo '
					<div class="row" style="height: 100%;" draggable="true" ondragstart="drag('.$i.', '.$row["player_id"].')" ondragover="allowDrop(event)" ondrop="swap(event, '.$i.', '.$row["player_id"].')">
						<div style="height: 100%;" class="col-50">
							<img src="images/cards/'.$row["id"].'.png" style="height: 100%;" draggable="false">
						</div>
						<div style="height: 100%;" class="col-70">
							<span onclick="clear_player('.$i.')" style="float: right; font-size: 16px;"><b>&times;</b></span>
							<b style="font-size: 16px;">'.$row["C_name"].'</b>
							<br>
							'.$row["E_name"].'
						</div>
					</div>';
					}

					echo '
				</div>';
				}
				?>
			</div>

			<h2 style="margin-top: 20px;">替补</h2>
			<div class="row">
				<?php
				for ($i=12; $i < 19; $i++) { 
					echo '
				<div id="position_'.$i.'" class="col-xxl-24 col-xl-30 col-lg-40 col-sm-60" style="border: 1px solid #888888; border-radius: 5px; height: 150px; cursor: pointer;" onclick="open_modal('.$i.')" ondragover="allowDrop(event)" ondrop="move(event, '.$i.')">';

					$sql = 'SELECT * FROM squad AS S LEFT JOIN players AS P ON S.player_id=P.id WHERE S.position='.$i;
					$result = $conn->query($sql);
					while ($row = $result->fetch_assoc()) {
						echo '
					<div class="row" style="height: 100%;" draggable="true" ondragstart="drag('.$i.', '.$row["player_id"].')" ondragover="allowDrop(event)" ondrop="swap(event, '.$i.', '.$row["player_id"].')">
						<div style="height: 100%;" class="col-50">
							<img src="images/cards/'.$row["id"].'.png" style="height: 100%;" draggable="false">
						</div>
						<div style="height: 100%;" class="col-70">
							<span onclick="clear_player('.$i.')" style="float: right; font-size: 16px;"><b>&times;</b></span>
							<b style="font-size: 16px;">'.$row["C_name"].'</b>
							<br>
							'.$row["E_name"].'
						</div>

					</div>';
					}

					echo '
				</div>';
				}
				?>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		var from_position;
		var from_id;
		var to_position;
		var to_id;

		function drag(p, id) {
			from_position = p;
			from_id = id;
		}

		function allowDrop(ev) {
			ev.preventDefault();
		}

		function swap(ev, p, id) {
			ev.preventDefault();
			ev.stopPropagation();
			to_position = p;
			to_id = id;

			var xhttp1 = new XMLHttpRequest();
            xhttp1.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   // Typical action to be performed when the document is ready:
                   document.getElementById("position_" + to_position).innerHTML = xhttp1.responseText;
                }
            };
            xhttp1.open("POST", "new_fut_champion_tabs/squad/modify_player.php", true);
            xhttp1.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhttp1.send("position=" + to_position + "&player_id=" + from_id);

            var xhttp2 = new XMLHttpRequest();
            xhttp2.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   // Typical action to be performed when the document is ready:
                   document.getElementById("position_" + from_position).innerHTML = xhttp2.responseText;
                }
            };
            xhttp2.open("POST", "new_fut_champion_tabs/squad/modify_player.php", true);
            xhttp2.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhttp2.send("position=" + from_position + "&player_id=" + to_id);
		}

		function move(ev, p) {
			ev.preventDefault();
			to_position = p;

			var xhttp1 = new XMLHttpRequest();
            xhttp1.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   // Typical action to be performed when the document is ready:
                   document.getElementById("position_" + to_position).innerHTML = xhttp1.responseText;
                }
            };
            xhttp1.open("POST", "new_fut_champion_tabs/squad/modify_player.php", true);
            xhttp1.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhttp1.send("position=" + to_position + "&player_id=" + from_id);

            var xhttp2 = new XMLHttpRequest();
            xhttp2.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   // Typical action to be performed when the document is ready:
                   document.getElementById("position_" + from_position).innerHTML = xhttp2.responseText;
                }
            };
            xhttp2.open("POST", "new_fut_champion_tabs/squad/modify_player.php", true);
            xhttp2.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhttp2.send("position=" + from_position + "&player_id=");
		}
	</script>

	<?php include("new_fut_champion_tabs/squad/modal.php"); ?>