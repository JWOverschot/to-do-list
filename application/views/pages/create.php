<?= validation_errors(); ?>

<h3>Add list</h3>

<?= form_open('pages/create', array('class' => 'col s12')); ?>

<div class="row">
	<div class="input-field col s12">
		<input id="title" type="text" name="title" autocomplete="off" spellcheck="true" required>
		<label for="title">Title</label>
	</div>
	<div class="input-field col s11 push-s1">
		<input class="create-list-task" id="task_1" type="text" name="task_1" autocomplete="off" spellcheck="true">
		<label for="title">Task</label>
	</div>
	<div class="col s11 push-s1">
		<a href="#" id="add-task-input" class="black-taxt">+ Task</a>
	</div>
</div>
<button class="waves-effect waves-light btn" type="submit" name="submit" value="Create list" >Create</button>
<button type="button" class="modal-close waves-effect waves-light btn grey">Cancel</button>

<?= form_close(); ?>