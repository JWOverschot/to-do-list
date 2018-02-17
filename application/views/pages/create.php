<?= validation_errors(); ?>

<?= form_open('pages/create', array('class' => 'col s12')); ?>

<div class="row">
	<div class="input-field col s12">
		<input id="title" type="text" name="title" autocomplete="off" spellcheck="true" required>
		<label for="title">Title</label>
	</div>
</div>
<button class="waves-effect waves-light btn" type="submit" name="submit" value="Create list" >Create</button>

<?= form_close(); ?>