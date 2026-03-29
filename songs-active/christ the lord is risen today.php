<?php
	$filename = basename(__FILE__, '.php');
	$identifier = str_replace(' ', '_', $filename);
?>
				<div class="accordion-item">
					<h2 class="accordion-header" id="heading-<?php echo $identifier; ?>">
						<button
							class="accordion-button collapsed"
							type="button"
							data-mdb-toggle="collapse"
							data-mdb-target="#collapse-<?php echo $identifier; ?>"
							aria-expanded="false"
							aria-controls="collapse-<?php echo $identifier; ?>"
						>
							<strong><?php echo strtoupper($filename); ?></strong>
						</button>
					</h2>
					<div id="collapse-<?php echo $identifier; ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?php echo $identifier; ?>" data-mdb-parent="#accordionExample">
						<div class="accordion-body">
						<!-------------------------->
						<!--Edit this section only-->
						<!-------------------------->
							<h5>Verse 1</h5>
							<p>
Christ the Lord is risen today, Hallelujah<br/>
Earth and heaven in chorus say, Hallelujah<br/>
Raise your joys and triumphs high, Hallelujah<br/>
Sing, ye heavens and earth reply, Hallelujah
							</p>
							<h5>Verse 2</h5>
							<p>
Love’s redeeming work is done, Hallelujah<br/>
Fought the fight, the battle won, Hallelujah<br/>
Death in vain forbids Him rise, Hallelujah<br/>
Christ has opened paradise, Hallelujah
							</p>
							<h5>Verse 3</h5>
							<p>
Lives again our glorious king, Hallelujah<br/>
Where O death is now thy sting?  Hallelujah<br/>
Once He died our souls to save. Hallelujah<br/>
Where’s thy victory, boasting grave, Hallelujah!
							</p>
						<!-------------------------->
						<!-------------------------->
						<!-------------------------->
						</div>
					</div>
				</div>
