$(document).ready( () => {
	// init all modals
	if ($('.modal').length > 0) {
		$('.modal').modal();
	}
	// aligenment for more buttons to the right
	if ($('.dropdown-button').length > 0) {
		$('.dropdown-button').dropdown({
			alignment: 'right'
		});
	}

	$('.card .card-content').on('mouseenter', (event) => {
		$('li i.list-id_' + event.toElement.id.split('_')[1]).addClass('hover');
	});
	$('.card .card-content').on('mouseout', (event) => {
		$('li i.list-id_' + event.toElement.id.split('_')[1]).removeClass('hover');
	});

	$('#add-task-input').on('click', (event) => {
		var nextID = parseInt($('.create-list-task').sort().reverse()[0].id.split('_')[1]) + 1;
		$(event.currentTarget.parentElement).before(`<div class="input-field col s11 push-s1">
			<input class="create-list-task" id="task_${nextID}" type="text" name="task_${nextID}" autocomplete="off" spellcheck="true">
			<label for="title">Task</label>
			</div>`);
	});
});