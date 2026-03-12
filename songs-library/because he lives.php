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
God sent His son, they called Him, Jesus;<br/>
He came to love, heal and forgive;<br/>
He lived and died to buy my pardon,<br/>
An empty grave is there to prove my Savior lives!</p>
<h5>Chorus</h5>
<p>
Because He lives, I can face tomorrow,<br/>
Because He lives, all fear is gone;<br/>
Because I know He holds the future,<br/>
And life is worth the living,<br/>
Just because He lives!</p>
<h5>Verse 2</h5>
<p>
And then one day, I'll cross the river,<br/>
I'll fight life's final war with pain;<br/>
And then, as death gives way to victory,<br/>
I'll see the lights of glory and I'll know He lives!</p>
<h5>End</h5>
<p>
And life is worth the living,<br/>
Just because He lives!</p>
						<!-------------------------->
						<!-------------------------->
						<!-------------------------->
						</div>
					</div>
				</div>
