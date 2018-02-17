$(document).ready(function () {
	if ($('.modal').length > 0) {
		$('.modal').modal();
	}
	if ($('.dropdown-button').length > 0) {
		$('.dropdown-button').dropdown({
			alignment: 'right'
		});
	}
});