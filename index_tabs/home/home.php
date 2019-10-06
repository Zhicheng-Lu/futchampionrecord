	<br><br><br><br><br>
	<div class="section">
        <div class="container">
            <div class="col-120">
                <div class="row">
                    <?php
                    // ended fut champion
                    $fut_champion_id = -1;
                    $sql = 'SELECT * FROM finished_fut_champions AS FI LEFT JOIN fut_champions AS FU ON FI.fut_champion_id=FU.id';
					$result = $conn->query($sql);
					while ($row = $result->fetch_assoc()) {
						$fut_champion_id = $row["id"];
						$date = $row["date"];
						$sql1 = 'SELECT COUNT(*) AS win FROM results WHERE fut_champion_id='.$fut_champion_id.' AND (score1>score2 OR penalty1>penalty2)';
						$result1 = $conn->query($sql1);
						while ($row1 = $result1->fetch_assoc()) {
							$win = $row1["win"];
						}
						$sql1 = 'SELECT COUNT(*) AS loss FROM results WHERE fut_champion_id='.$fut_champion_id.' AND (score1<score2 OR penalty1<penalty2)';
						$result1 = $conn->query($sql1);
						while ($row1 = $result1->fetch_assoc()) {
							$loss = $row1["loss"];
						}

                        echo '
                    <div class="col-xxl-30 col-xl-30 col-lg-40 col-md-60 col-120" style="margin-bottom: 20px;">
                        <div style="width: 90px; display: inline-block;">
                            <a href="fut_champion.php?fut_champion_id='.$fut_champion_id.'&tab=record" target="_blank" style="text-decoration: underline; color: blue;">'.$date.':</a>
                        </div>
                        <a href="javascript:void(0)" style="color: black;">'.$win.' 胜 '.$loss.' 负</a>
                    </div>';
                    }



                    // ongoing fut champion or new fut champion
                    $sql = 'SELECT * FROM fut_champions WHERE id>'.$fut_champion_id;
                    $result = $conn->query($sql);
                    if ($result->num_rows == 1) {
                    	// ongoing
                    	while ($row = $result->fetch_assoc()) {
                    		$fut_champion_id = $row["id"];
							$date = $row["date"];
							$sql1 = 'SELECT COUNT(*) AS win FROM results WHERE fut_champion_id='.$fut_champion_id.' AND (score1>score2 OR penalty1>penalty2)';
							$result1 = $conn->query($sql1);
							while ($row1 = $result1->fetch_assoc()) {
								$win = $row1["win"];
							}
							$sql1 = 'SELECT COUNT(*) AS loss FROM results WHERE fut_champion_id='.$fut_champion_id.' AND (score1<score2 OR penalty1<penalty2)';
							$result1 = $conn->query($sql1);
							while ($row1 = $result1->fetch_assoc()) {
								$loss = $row1["loss"];
							}

	                        echo '
	                    <div class="col-xxl-30 col-xl-30 col-lg-40 col-md-60 col-120" style="margin-bottom: 20px;">
	                        <div style="width: 90px; display: inline-block;">
	                            <a href="new_fut_champion.php?fut_champion_id='.$fut_champion_id.'&tab=record" target="_blank" style="text-decoration: underline; color: blue;">'.$date.':</a>
	                        </div>
	                        <a href="javascript:void(0)" style="color: black;">'.$win.' 胜 '.$loss.' 负</a>
	                    </div>';
                    	}
                    }
                    else {
                    	// new competition
	                    echo '
	                    <div class="col-xxl-30 col-xl-30 col-lg-40 col-md-60 col-120" style="margin-bottom: 20px;">
	                        <div style="width: 90px; display: inline-block;">
	                            <a style="text-decoration: underline; color: blue; cursor: pointer;" onclick="open_modal()">添加新的周赛</a>
	                        </div>
	                    </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <form action="index.php" method="post">
	    <div id="create_modal" class="modal" style="top: 20%;">
			<div class="modal-content col-xxl-40 offset-xxl-40 col-xl-60 offset-xl-30 col-lg-80 offset-lg-20 col-md-100 offset-md-10">
				<div class="modal-header">
					<span class="close" onclick="close_modal()">&times;</span>
				</div>
				<div class="modal-body" id="modal_body">
					<input type="date" id="date" name="date" value="<?php echo date("Y-m-d"); ?>">
				</div>
				<div class="modal-footer justify-content-center">
					<button name="create_fut_champion" class="submit_button">确认</button>
					<button type="button" class="submit_button" onclick="close_modal()">取消</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal -->
	</form>

	<script type="text/javascript">
		// document.getElementById('date').valueAsDate = new Date();

		function open_modal() {
			document.getElementById("create_modal").style.display = "block";
		}

		function close_modal() {
			document.getElementById("create_modal").style.display = "none";
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
        .submit_button {
			height: 40px;
			border-radius: 5px;
			font-size: 20px;
			background-color: white;
			width: 40%;
		}
	</style>