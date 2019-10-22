	<br><br><br><br><br>
	<div class="section">
		<div class="container">
			<div class="row">
				<button class="col-sm-30 offset-sm-45 col-40 offset-40" style="height: 50px; background-color: white; color: black; border-radius: 5px; font-size: 16px; cursor: pointer;" onclick="open_add_player_modal(0)">添加球员</button>
			</div>
			<br>
			<div style="width: 100%; text-align: center;">
				<div style="display: inline-block;">
					<i class="fa fa-search"></i>
				</div>
				<div style="display: inline-block;">
					<input id="player_name_input" type="search" style="width: 100%; margin-bottom: 30px; border: 1px solid #AAAAAA;" oninput="player_name_oninput()" value="">
				</div>
			</div>
			<div class="row">
				<?php
				$counter = 0;
				$sql = 'SELECT P.id, P.E_name, P.C_name, P.price, IFNULL(apps,0) AS apps FROM players AS P LEFT JOIN (SELECT player_id, COUNT(*) AS apps FROM appearances GROUP BY player_id) AS APP ON P.id=APP.player_id ORDER BY P.id DESC';
				$result = $conn->query($sql);
				while ($row = $result->fetch_assoc()) { 
					echo '
				<div class="col-xxl-24 col-xl-30 col-lg-40 col-sm-60" id="player_'.$counter.'" style="border: 1px solid #888888; border-radius: 5px; height: 150px; cursor: pointer;" onclick="open_add_player_modal('.$row["id"].')">
					<div class="row" style="height: 100%;">
						<div style="height: 100%;" class="col-50">
							<img src="images/cards/'.$row["id"].'.png" style="height: 100%;">
						</div>
						<div style="height: 100%;" class="col-70">'.
							(($row["apps"]==0)?'<span onclick="open_delete_player_modal('.$row["id"].')" style="float: right; font-size: 16px;"><b>&times;</b></span>':'').'
							<b style="font-size: 16px;">'.$row["C_name"].'</b>
							<br>
							'.$row["E_name"].'
							<br><br>
							身价：'.number_format($row["price"], 0, ".", ",").'
						</div>
					</div>
				</div>';
					$counter += 1;
				}
				?>
			</div>
		</div>
	</div>

	<form action="index.php" method="post">
		<input type="hidden" name="player_id" id="delete_player_id">
		<div id="delete_player_modal" class="modal" style="top: 20%;">
			<div class="modal-content col-xxl-24 offset-xxl-48 col-xl-30 offset-xl-45 col-lg-40 offset-lg-40 col-sm-60 offset-sm-30">
				<div class="modal-header">
					<span class="close" onclick="close_delete_player_modal()">&times;</span>
				</div>
				<div class="modal-body" id="modal_body">
					<p>确认彻底删除此球员么？</p>
				</div>
				<div class="modal-footer justify-content-center">
					<button name="delete_player" class="submit_button">确认</button>
					<button type="button" class="submit_button" onclick="close_delete_player_modal()">取消</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal -->
	</form>

	<script type="text/javascript">
		var counter = <?php echo $counter; ?>;
		var players = [];
    	<?php
    	$sql = 'SELECT * FROM players ORDER BY id DESC';
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

	    function open_delete_player_modal(player_id) {
	    	event.stopPropagation();
	    	document.getElementById("delete_player_modal").style.display = "block";
	    	document.getElementById("delete_player_id").value = player_id;
	    }

	    function close_delete_player_modal(player_id) {
	    	document.getElementById("delete_player_modal").style.display = "none";
	    }
	</script>

    <?php include("index_tabs/players/add_player_modal.php") ?>