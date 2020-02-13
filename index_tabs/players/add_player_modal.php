	<form action="index.php" method="post" enctype="multipart/form-data">
		<input type="hidden" name="player_id" id="add_player_id">
	    <div id="add_player_modal" class="modal" style="top: 5%;">
			<div class="modal-content col-xxl-40 offset-xxl-40 col-xl-60 offset-xl-30 col-lg-80 offset-lg-20 col-md-100 offset-md-10">
				<div class="modal-header">
					<span class="close" onclick="close_add_player_modal()">&times;</span>
				</div>
				<div class="modal-body" id="add_player_modal_body">
					
				</div>
				<div class="modal-footer justify-content-center">
					<button name="create_player" class="submit_button">确认</button>
					<button type="button" class="submit_button" onclick="close_add_player_modal()">取消</button>
				</div>

			</div><!-- /.modal-content -->
		</div><!-- /.modal -->
	</form>

	<style type="text/css">
		.dropdown {
			position: relative;
			width: 200px;
			height: 50px;
			display: inline-block;
			border: 1px solid #AAAAAA;
			cursor: pointer;
		}

		.dropdown-options {
			display: none;
			position: absolute;
			background-color: #F9F9F9;
			box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
			width: 100%;
			z-index: 1;
			margin-top: 11px;
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
		// document.getElementById('date').valueAsDate = new Date();

		function open_add_player_modal(player_id) {
			var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                	// Typical action to be performed when the document is ready:
                	document.getElementById("add_player_modal_body").innerHTML = xhttp.responseText;
                	document.getElementById("add_player_id").value = player_id;
					document.getElementById("add_player_modal").style.display = "block";
                }
            };
            xhttp.open("POST", "index_tabs/players/add_player_modal_body.php", true);
            xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhttp.send("player_id=" + player_id);
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

		function preview_card(input) {
			document.getElementById("card_preview").src = URL.createObjectURL(input.files[0]);
		}

		function preview_photo(input) {
			document.getElementById("photo_preview").src = URL.createObjectURL(input.files[0]);
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

		function choose_version(option, version) {
			event.stopPropagation();
			options = option.parentNode;
			options.style.display = "none";
			dropdown = options.parentNode;
			// show selected option
			dropdown.childNodes[1].innerHTML = '<img src="images/card_types/' + version + '.png" style="height: 30px;">' + version;
			
			// modify hidden input
			input = dropdown.childNodes[5];
			input.value = version;
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