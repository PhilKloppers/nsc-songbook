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
Let us come together,<br/>
Let us join as one<br/>
Let us turn our faces<br/>
To the risen Son<br/>
Let us go up to Zion,<br/>
To God’s holy hill<br/>
A mighty army that will worship Him</p>
							<h5>Chorus</h5>
							<p>
We will worship Him,<br/>
We will worship Him<br/>
Jesus, He’s our King,<br/>
We will worship Him<br/>
Let the oceans roar,<br/>
Let the heavens ring<br/>
To the glory of our God<br/>
As we worship Him</p>
							<h5>Verse 2</h5>
							<p>
It is time for battle,<br/>
It is time for war<br/>
As we sing Hosanna,<br/>
As we praise the Lord<br/>
He will still the accuser,<br/>
Crush the enemy<br/>
As we celebrate God’s victory.
							</p>
						<!-------------------------->
						<!-------------------------->
						<!-------------------------->
						</div>
					</div>
				</div>
