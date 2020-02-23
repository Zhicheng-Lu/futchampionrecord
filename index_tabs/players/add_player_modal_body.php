					<?php
					include("../../includes/connection.php");
					$id = $_POST["player_id"];
					$E_name = "";
					$C_name = "";
					$player_version = "";
					$rating = "";
					$price = "";

					$sql = 'SELECT * FROM players WHERE id='.$id;
					$result = $conn->query($sql);
					while ($row = $result->fetch_assoc()) {
						$E_name = $row["E_name"];
						$C_name = $row["C_name"];
						$player_version = $row["version"];
						$rating = $row["rating"];
						$price = $row["price"];
					}

					$versions = array("Gold Rare", "Team of the Week", "Ones to Watch", "FUT Champion", "Icon", "Ultimate Scream", "Storyline", "Premium League POTM", "UCL Road to the Final", "Flashback", "Premium SBC", "League Objective Player", "League SBC", "FUTMAS", "Team of the Year", "Future Stars", "Player Moments");

					echo '
					<div>
						<div style="width: 70px; display: inline-block;">英文名：</div>
						<input type="text" name="E_name" style="display: inline-block; width: 200px;" value="'.$E_name.'" required>
					</div>
					<div style="margin-top: 15px;">
						<div style="width: 70px; display: inline-block;">卡种：</div>
						<div class="dropdown" onclick="show_options(this)" onmouseleave="hide_options(this)">
							<div><img src="images/'.(($player_version=="")?'transparent':'card_types/'.$player_version).'.png" style="height: 30px;">'.(($player_version=="")?'':$player_version).'</div>
							<div class="dropdown-options" onclick="event.stopPropagation();">';
					foreach ($versions as $version) {
						echo '
								<div class="dropdown-option" onclick="choose_version(this, \''.$version.'\')">
									<img src="images/card_types/'.$version.'.png" style="height: 30px;">'.$version.'
								</div>';
					}
					echo '
							</div>
							<input type="hidden" name="version" value="'.$player_version.'">
						</div>
					</div>
					<div style="margin-top: 15px;">
						<div style="width: 70px; display: inline-block;">中文名：</div>
						<input type="text" name="C_name" style="display: inline-block; width: 200px;" value="'.$C_name.'" required>
					</div>
					<div style="margin-top: 15px;">
						<div style="width: 70px; display: inline-block;">总评：</div>
						<input type="number" name="rating" style="display: inline-block; width: 200px;" value="'.$rating.'" required>
					</div>
					<div style="margin-top: 15px;">
						<div style="width: 70px; display: inline-block;">身价：</div>
						<input type="number" name="price" style="display: inline-block; width: 200px;" value="'.$price.'" required>
					</div>
					<div style="margin-top: 15px;">
						<div style="width: 70px; display: inline-block;">卡面：</div>
						<input type="file" name="card"'.(($id==0)? " required":"").' onchange="preview_card(this)"><br>
						<img src="images/cards/'.$id.'.png" style="height: 200px;" id="card_preview">
					</div>
					<div style="margin-top: 15px;">
						<div style="width: 70px; display: inline-block;">头像：</div>
						<input type="file" name="photo"'.(($id==0)? " required":"").' onchange="preview_photo(this)"><br>
						<img src="images/photos/'.$id.'.png" style="height: 90px;" id="photo_preview">
					</div>';
					?>