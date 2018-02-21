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
	// add task move icons to list
	$('.card .card-content').on('mouseenter', (event) => {
		$('li i.list-id_' + event.toElement.id.split('_')[1]).addClass('hover');
	});
	// remove task move icons to list
	$('.card .card-content').on('mouseout', (event) => {
		$('li i.list-id_' + event.toElement.id.split('_')[1]).removeClass('hover');
	});
	// add more input fields on creating tasks
	$('#add-task-input').on('click', (event) => {
		var nextID = parseInt($('.create-list-task').sort().reverse()[0].id.split('_')[1]) + 1;
		$(event.currentTarget.parentElement).before(`<div class="input-field col s11 push-s1">
			<input class="create-list-task" id="task_${nextID}" type="text" name="task_${nextID}" autocomplete="off" spellcheck="true">
			<label for="title">Task</label>
			</div>`);
	});
	// add a new task html element
	$('.add-new-task').on('click', (event) => {
		$(event.currentTarget.parentElement).before(`<li>
			<input type="checkbox" class="filled-in" />
			<label class="black-text" contenteditable="true"></label>
			<i class="material-icons right list-id_<?= $list->listId ?>">menu</i>
			</li>`);
	});

	$(".card-title").on('click blur focus', (event) => {
		if ($("#edit-list-title").val() != $(event.currentTarget).html()) {
			//debugger;
			$("#edit-list-title").val($(event.currentTarget).html());
			$("#edit-list-id").val(event.currentTarget.id.split('_')[1]);
			
			// Get the form.
			var form = $('#ajax-contact');

			// Get the messages div.
			var formMessages = $('#form-messages');
			$(form).trigger("submit");
			$(form).submit(function(event) {
				// Stop the browser from submitting the form.
				event.preventDefault();

				// Serialize the form data.
				var formData = $(form).serialize();

				// Submit the form using AJAX.
				$.ajax({
					type: 'POST',
					url: $(form).attr('action'),
					data: formData
				}).done(function(response) {
				  	console.info('You done did');
				}).fail(function(data) {
				    console.error('You did done failed');
				});
			});
		}
	});
});