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
O Lord my God,  when I in awesome wonder<br/>
Consider all the works Thy hands have made<br/>
I see the stars, I hear the rolling thunder<br/>
Thy pow'r throughout the universe displayed</p>
<h5>Chorus 1</h5>
<p>
Then sings my soul, my Saviour God to Thee<br/>
How great Thou art,  how great Thou art<br/>
Then sings my soul, my Saviour God to Thee<br/>
How great Thou art,  how great Thou art</p>
<h5>Verse 2</h5>
<p>
And when I think  that God His Son not sparing<br/>
Sent Him to die, I scarce can take it in<br/>
That on the Cross, my burden gladly bearing<br/>
He bled and died to take away my sin</p>
<h5>Verse 3</h5>
<p>
When Christ shall come  with shout of acclamation<br/>
And take me home, what joy shall fill my heart<br/>
Then shall I bow  in humble adoration<br/>
And there proclaim my God how great Thou art</p>
						<!-------------------------->
						<!-------------------------->
						<!-------------------------->
						</div>
					</div>
				</div>
