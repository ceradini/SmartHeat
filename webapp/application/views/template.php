<!DOCTYPE html>
<html lang="it">
	<head>
		<?php 
			setlocale(LC_ALL, 'it_IT.utf8');
			setlocale(LC_TIME, 'it_IT.utf8');
		?>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<title>Home APP</title>
		<meta name="description" content="Home application controller" />
		<meta name="author" content="Matteo Ceradini" />
		<link rel="shortcut icon" type="image/png" href="<?php echo site_url('assets/images/favicon.ico'); ?>" />
		<link href="<?php echo site_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
		<link href="<?php echo site_url('assets/css/sidebar.css'); ?>" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo site_url('assets/css/custom.css'); ?>?v=<?php echo $this->config->item('site_version'); ?>" />
	</head>

	<body class="body">
		<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
			<symbol id="home" viewBox="0 0 16 16">
				<path fill-rule="evenodd" d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
				<path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z" />
			</symbol>
			<symbol id="weather" viewBox="0 0 16 16">
				<path d="M7 8a3.5 3.5 0 0 1 3.5 3.555.5.5 0 0 0 .624.492A1.503 1.503 0 0 1 13 13.5a1.5 1.5 0 0 1-1.5 1.5H3a2 2 0 1 1 .1-3.998.5.5 0 0 0 .51-.375A3.502 3.502 0 0 1 7 8zm4.473 3a4.5 4.5 0 0 0-8.72-.99A3 3 0 0 0 3 16h8.5a2.5 2.5 0 0 0 0-5h-.027z" />
				<path d="M10.5 1.5a.5.5 0 0 0-1 0v1a.5.5 0 0 0 1 0v-1zm3.743 1.964a.5.5 0 1 0-.707-.707l-.708.707a.5.5 0 0 0 .708.708l.707-.708zm-7.779-.707a.5.5 0 0 0-.707.707l.707.708a.5.5 0 1 0 .708-.708l-.708-.707zm1.734 3.374a2 2 0 1 1 3.296 2.198c.199.281.372.582.516.898a3 3 0 1 0-4.84-3.225c.352.011.696.055 1.028.129zm4.484 4.074c.6.215 1.125.59 1.522 1.072a.5.5 0 0 0 .039-.742l-.707-.707a.5.5 0 0 0-.854.377zM14.5 6.5a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z" />
			</symbol>
			<symbol id="graph" viewBox="0 0 16 16">
				<path d="M8 2a.5.5 0 0 1 .5.5V4a.5.5 0 0 1-1 0V2.5A.5.5 0 0 1 8 2zM3.732 3.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 8a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 8zm9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5zm.754-4.246a.389.389 0 0 0-.527-.02L7.547 7.31A.91.91 0 1 0 8.85 8.569l3.434-4.297a.389.389 0 0 0-.029-.518z" />
				<path fill-rule="evenodd" d="M6.664 15.889A8 8 0 1 1 9.336.11a8 8 0 0 1-2.672 15.78zm-4.665-4.283A11.945 11.945 0 0 1 8 10c2.186 0 4.236.585 6.001 1.606a7 7 0 1 0-12.002 0z" />
			</symbol>
			<symbol id="settings" viewBox="0 0 16 16">
				<path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z" />
				<path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z" />
			</symbol>
		</svg>
		<div>
			<ul class="cbp-vimenu">
				<li class="nav-item">
					<a href="<?php echo site_url('/index.php'); ?>" class="nav-link <?php echo $page == 'home' ? 'cbp-vicurrent' : ''; ?> py-3 border-bottom" title="Home" data-bs-toggle="tooltip" data-bs-placement="right">
						<svg class="bi" width="45" height="45">
							<use xlink:href="#home" />
						</svg>
					</a>
				</li>
				<li>
					<a href="<?php echo site_url('/index.php/weather'); ?>" class="nav-link <?php echo $page == 'weather' ? 'cbp-vicurrent' : ''; ?> py-3 border-bottom" title="Dashboard" data-bs-toggle="tooltip" data-bs-placement="right">
						<svg class="bi" width="45" height="45">
							<use xlink:href="#weather" />
						</svg>
					</a>
				</li>
				<?php /*
					<li>
						<a href="<?php echo site_url('/index.php/graphs'); ?>" class="nav-link <?php echo $page == 'graphs' ? 'active' : ''; ?> py-3 border-bottom" title="Dashboard" data-bs-toggle="tooltip" data-bs-placement="right">
							<svg class="bi" width="32" height="32">
								<use xlink:href="#graph" />
							</svg>
						</a>
					</li>
					*/ ?>
				<li>
					<a href="<?php echo site_url('/index.php/settings'); ?>" class="nav-link <?php echo $page == 'settings' ? 'cbp-vicurrent' : ''; ?> py-3 border-bottom" title="Dashboard" data-bs-toggle="tooltip" data-bs-placement="right">
						<svg class="bi" width="45" height="45">
							<use xlink:href="#settings" />
						</svg>
					</a>
				</li>
			</ul>
			<div class="main-container">
				<?php echo $content; ?>
			</div>
		</div>

		<script src="<?php echo site_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
		<script src="<?php echo site_url('assets/js/jquery.min.js'); ?>"></script>
		<script src="<?php echo site_url('assets/js/components.js'); ?>?v=<?php echo $this->config->item('site_version'); ?>"></script>
		<script src="<?php echo site_url('assets/js/template.js'); ?>?v=<?php echo $this->config->item('site_version'); ?>"></script>
		<?php
			if (isset($gui_files)) :
				foreach ($gui_files as $file_name) : ?>
					<script src="<?php echo site_url('assets/js/gui/' . $file_name); ?>?v=<?php echo $this->config->item('site_version'); ?>"></script>
			<?php
				endforeach;
			endif;
			
			if (isset($js_files)) :
				foreach ($js_files as $file_name) : ?>
					<script src="<?php echo site_url('assets/js/pages/' . $file_name); ?>?v=<?php echo $this->config->item('site_version'); ?>"></script>
				<?php
				endforeach;
			endif;
		?>
	</body>

</html>