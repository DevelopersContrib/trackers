<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<div class="container">
				<a class="navbar-brand" href="/">
					<img style="margin-top: -15px;" src="https://d2qcctj8epnr7y.cloudfront.net/images/2013/logo-trackers1.png" height="30" alt="">
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto">
						<li class="nav-item">
							<a class="nav-link" href="/dashboard">Dashboard</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/leads">My Leads</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/campaigns">Campaigns</a>
						</li>
					</ul>
					<ul class="navbar-nav ">
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<?php echo $this->session->userdata('name')?>
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="/account">Account Settings</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="/account/changepassword">Change Password</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="/account/apisettings">API Settings</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="/logout">Logout</a>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</nav>