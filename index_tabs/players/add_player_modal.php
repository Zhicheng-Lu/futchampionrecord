	<form action="index.php" method="post" enctype="multipart/form-data">
	    <div id="add_player_modal" class="modal" style="top: 10%;">
			<div class="modal-content col-xxl-40 offset-xxl-40 col-xl-60 offset-xl-30 col-lg-80 offset-lg-20 col-md-100 offset-md-10">
				<div class="modal-header">
					<span class="close" onclick="close_add_player_modal()">&times;</span>
				</div>
				<div class="modal-body" id="modal_body">
					<div>
						<div style="width: 70px; display: inline-block;">英文名：</div>
						<input type="text" name="E_name" style="display: inline-block;" required>
					</div>
					<div style="margin-top: 15px;">
						<div style="width: 70px; display: inline-block;">卡种：</div>
						<select name="version" style="display: inline-block;" required>
							<option value=""></option>
							<option value="Gold Common">Gold Common</option>
							<option value="Gold Rare">Gold Rare</option>
							<option value="Ones to Watch">Ones to Watch</option>
							<option value="Team of the Week">Team of the Week</option>
							<option value="FUT Champion">FUT Champion</option>
						</select>
					</div>
					<div style="margin-top: 15px;">
						<div style="width: 70px; display: inline-block;">中文名：</div>
						<input type="text" name="C_name" style="display: inline-block;" required>
					</div>
					<div style="margin-top: 15px;">
						<div style="width: 70px; display: inline-block;">总评：</div>
						<input type="number" name="rating" style="display: inline-block;" required>
					</div>
					<div style="margin-top: 15px;">
						<div style="width: 70px; display: inline-block;">卡面：</div>
						<input type="file" name="card" required>
					</div>
					<div style="margin-top: 15px;">
						<div style="width: 70px; display: inline-block;">头像：</div>
						<input type="file" name="photo" required>
					</div>
				</div>
				<div class="modal-footer justify-content-center">
					<button name="create_player" class="submit_button">确认</button>
					<button type="button" class="submit_button" onclick="close_add_player_modal()">取消</button>
				</div>

			</div><!-- /.modal-content -->
		</div><!-- /.modal -->
	</form>

	<script type="text/javascript">
		// document.getElementById('date').valueAsDate = new Date();

		function open_add_player_modal() {
			document.getElementById("add_player_modal").style.display = "block";
		}

		function close_add_player_modal() {
			document.getElementById("add_player_modal").style.display = "none";
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
		#add_player_modal {
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