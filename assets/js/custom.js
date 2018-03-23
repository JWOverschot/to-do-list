$(document).ready( () => {
	// init all modals
	if ($('.modal').length > 0) {
		$('.modal').modal();
	}
	// make text line-through when checkbox is checked
	if ($('input[type="checkbox"]:checked')) {
		$('input[type="checkbox"]:checked').nextAll($("p.label")).css('text-decoration', 'line-through');
	}
	$('input[type="checkbox"]').on('click', (event) => {
		if ($(event.target).is(':checked')) {
			$('input[type="checkbox"]:checked').nextAll($("p.label")).css('text-decoration', 'line-through');
		}
		else {
			$('input[type="checkbox"]:not(:checked)').nextAll($("p.label")).css('text-decoration', '');
		}
	});
	// aligenment for more buttons to the right
	if ($('.dropdown-button').length > 0) {
		$('.dropdown-button').dropdown({
			alignment: 'right'
		});
	}
	// add task move icons to list
	// $('.card .card-content').on('mouseenter', (event) => {
	// 	$('li i.list-id_' + event.toElement.id.split('_')[1]).addClass('hover');
	// });
	// // remove task move icons to list
	// $('.card .card-content').on('mouseout', (event) => {
	// 	$('li i.list-id_' + event.toElement.id.split('_')[1]).removeClass('hover');
	// });
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
		var currentListID = event.target.parentElement.parentElement.id.split('_')[1];
		var nextTaskID;
		$.get("pages/getTaskIncrementID", (data, status) => {
			if (status == 'success') {
				nextTaskID = data;

				$(event.currentTarget.parentElement).before(`<li id="task_${nextTaskID}">
					<input type="checkbox" class="filled-in" id="task-checkbox_${nextTaskID}">
					<label for="task-checkbox_${nextTaskID}"></label>
					<p class="black-text label" id="task-label_${nextTaskID}" contenteditable="true"></p>
					<a class="red-text" href="deleteTask/${nextTaskID}"><i class="material-icons right task-id_${nextTaskID}">remove_circle_outline</i></a>
					</li>`
					);
				$('#task-label_' + nextTaskID).get(0).focus()
				$.ajax({
					type: 'POST',
					url: 'pages/createTask',
					data: {
						'ListID_FK': currentListID,
						'TaskSortIndex': $('ul#task-list-id_' + currentListID + ' li').length -1
					}
				}).done(function(response) {
					//console.info('You done did');
				}).fail(function(data) {
					console.error('You did done failed');
				});
			}
			else {
				return;
			}
		});
	});
	// extract values from json
	function extractResponseData(response){
		response = JSON.parse(response);
		var responseArray = [];
		// specific for ListID response
		for (var i = 0; $('.card').parent().length > i; i++) {
					$('.card').parent()[i].style.display = 'block';
				}
		if (response[0]) {
			if (response[0].ListID) {
				response.forEach((ele) => {responseArray.push(ele.ListID)});
				responseArray.forEach((ele) => {
					$('#list_' + ele).parent().parent().css('display', 'none');
				});
			}
		}
	}
	// forms
	function sendForm(form) {
		$(form).one('submit', function(event) {
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
				if (response) {
					extractResponseData(response);
				}
			}).fail(function(data) {
				console.error('You did done failed');
			});
		});
		$(form).trigger("submit");
	}
	// submit changed title to db with ajax
	$(".card-title").on('click blur focus', (event) => {
		if ($("#edit-list-title").val() != $(event.currentTarget).html()) {

			$("#edit-list-title").val($(event.currentTarget).html());
			$("#edit-list-id").val(event.currentTarget.id.split('_')[1]);
			// Get the form.
			sendForm($('#title-form'));
		}
	});

	// submit changed task description to db with ajax
	$('ul.task-list').on('click blur focus keypress', 'li', (event) => {
		if (event.type === 'keypress') {
			if (event.keyCode === 13) {
				event.preventDefault();
				$(event.target).blur();
			}
			else {
				return;
			}	
		}
		var taskListID = event.currentTarget.parentElement.id;
		var taskID = event.currentTarget.id;
		var taskSortIndex = 0;

		if (taskID !== '') {
			var taskLabel = $('#' + taskID + ' p.label');

			event.currentTarget.classList.forEach((e) => {
				if(e.split('_')[0] == 'sort-index') {
					taskSortIndex = e.split('_')[1];
				}
			});

			$("#edit-task-description").val(taskLabel.html());
			$("#edit-task-list-id").val(taskListID.split('_')[1]);
			$("#edit-task-id").val(taskID.split('_')[1]);
			$("#edit-task-sort-index").val(taskSortIndex);

			if ($('#' + taskID + ' input[type="checkbox"]').is(':checked')) {
				$("#edit-task-done").val(1);
			}
			else {
				$("#edit-task-done").val(0);
			}

			// Get the form.
			sendForm($('#task-form'));
		}
	});

	// submit search form
	$("#search").on('keyup', (event) => {
		sendForm($('#search-form'));
	});
});