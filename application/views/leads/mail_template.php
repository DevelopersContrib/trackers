<table width="600" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td>
				<table width="100%" class="content" align="l" cellpadding="0" cellspacing="0" border="0">
					<tr bgcolor="#222">
						<td style="padding:20px;color:#ffffff;">
							<h2 style="padding:0;margin:0;">
								<img src="https://d2qcctj8epnr7y.cloudfront.net/images/2013/logo-trackers1.png" alt="trackers.com"  width="130" height="40">
							</h2>
						</td>
					</tr>
					<tr bgcolor="#fafafa">
						<td style="padding:35px;color:#222222;">
							<img src="https://image.flaticon.com/icons/png/128/184/184657.png" style="margin: 0 auto;display: table;">
							<h2>Hi <?php echo $to_name?>,</h2>
							<p><?php echo stripcslashes($message)?></p>
							<br><br><br>
							<p>
								Thanks,
							</p>
							<p>
								<?php echo $from_name?><br>
								Trackers Account
							</p>
							<p>
								<a href="">
									<?php echo $from_email?>
								</a>
							</p>
						</td>
					</tr>
					<tr bgcolor="#172734">
						<td style="padding:15px;color:#ffffff;">
							<p><small><a href="" style="color:#999999"><?php echo $from_email?></a></small></p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>