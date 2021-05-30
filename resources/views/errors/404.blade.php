
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Smartpharmacy - 404</title>
	<link rel="stylesheet" href="{{ asset('bootstrap-4.3.1-dist/css/bootstrap.min.css') }}">  
	<link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body id="body" class="bg-sea">
	<div class="preloader">
		<div id="des" class="d-flex justify-content-center mx-auto">
			<div class="spinner-grow text-primary" role="status">
				<span class="sr-only">Loading...</span>
			</div>
			<div class="spinner-grow text-secondary" role="status">
				<span class="sr-only">Loading...</span>
			</div>
			<div class="spinner-grow text-success" role="status">
				<span class="sr-only">Loading...</span>
			</div>
			<div class="spinner-grow text-danger" role="status">
				<span class="sr-only">Loading...</span>
			</div>
			<div class="spinner-grow text-warning" role="status">
				<span class="sr-only">Loading...</span>
			</div>  
		</div>
	</div>		

	<div id="ups">
		UPS, PAGE NOT <a class="text-white" href="/dashboard"><u>FOUND</u></a> PLEASE CLICK THE WHITE TEXT ABOVE!
	</div>

	<script src="{{ asset('js/jquery.min.js') }}"></script>
	<script src="{{ asset('js/popper.min.js') }}"></script>
	<script src="{{ asset('bootstrap-4.3.1-dist/js/bootstrap.min.js') }}"></script>
	<script>
			$(document).ready(function(){
					$('.preloader').fadeOut(2500);
			});		

	</script>
</body>
</html>
