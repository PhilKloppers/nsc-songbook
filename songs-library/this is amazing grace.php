<?php
	$filename = basename(__FILE__, '.php');
	$identifier = str_replace(array( '\'', '"', ',' , ';', '<', '>', ' '), '_', $filename);
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
Who breaks the power of sin and darkness<br/>
Whose love is mighty and so much stronger<br/>
The King of Glory,  the King above all kings<br/>
Who shakes the whole earth with holy thunder<br/>
Who leaves us breathless in awe and wonder<br/>
The King of Glory,  the King above all kings</p>
<h5>Chorus</h5>
<p>
This is amazing grace, this is unfailing love<br/>
That You would take my place, that You would bear my cross<br/>
You would lay down Your life, that I would be set free<br/>
Oh, Jesus, I sing for all that You've done for me</p>
<h5>Verse 2</h5>
<p>
Who brings our chaos back into order<br/>
Who makes the orphan a son and daughter<br/>
The King of Glory,  the King above all kings<br/>
Who rules the nations with truth and justice<br/>
Shines like the sun in all of its brilliance<br/>
The King of Glory,  the King above all kings</p>
<h5>Bridge</h5>
<p>
Worthy is the Lamb who was slain<br/>
Worthy is the King who conquered the grave<br/>
Worthy is the Lamb who was slain<br/>
Worthy is the King who conquered the grave</p>
						<!-------------------------->
						<!-------------------------->
						<!-------------------------->
						</div>
					</div>
				</div>