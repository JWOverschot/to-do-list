<h1>TO-DO Lists</h1>

<?php
$currentList = 0;
$tasksArray = [];
$title = '';
$listArray = [];

class ListList {
	function ListList($title, $tasks, $listId) {
		$this->title = $title;
		$this->tasks = $tasks;
		$this->listId = $listId;
	}
}

class Task {
	function Task($description, $taskId, $done) {
		$this->description = $description;
		$this->taskId = $taskId;
		$this->done = $done;
	}
}

foreach ($lists as $list):
	if ($currentList != $list['ListID']) {
		$currentList = $list['ListID'];

		foreach ($lists as $task) {
				//var_dump($task);
			if ($currentList == $task['ListID']) {
				array_push($tasksArray, new Task($task['TaskDescription'], $task['TaskID'], $task['TaskDone']));
			}
		}

		$title = $list['ListTitle'];

		array_push($listArray, new ListList($title, $tasksArray, $currentList));
		$tasksArray = [];
	}
endforeach;
?>
<div class="fixed-action-btn">
	<a href="#add-list" class="btn-floating btn-large waves-effect red btn modal-trigger">
		<i class="large material-icons">add</i>
	</a>
</div>
<div class="row">
	<?php foreach ($listArray as $list): ?>
		<div class="col s12 m6 xl4">
			<div class="card yellow darken-1">
				<div class="card-content black-text" id="list_<?= $list->listId ?>">
					<div class="row">
						<span id="title-list_<?= $list->listId ?>" class="card-title col s10" contenteditable="true"><?= $list->title;?></span>
						<a class="black-text col s2 dropdown-button" href='#' data-activates='dropdown_<?= $list->listId ?>'><i class="material-icons waves-effect round">more_vert</i></a>
						<ul id='dropdown_<?= $list->listId ?>' class='dropdown-content'>
							<li><a href="<?= base_url()?>delete/<?= $list->listId ?>">Delete</a></li>
						</ul>
					</div>
					<ul class="task-list" id="task-list-id_<?= $list->listId ?>">
						<?php if ($list->tasks[0]->taskId != null ) { ?>
						<?php foreach ($list->tasks as $task): ?>
							<li id="task_<?= $task->taskId ?>">
								<input type="checkbox" class="filled-in" id="task-checkbox_<?= $task->taskId ?>" <?php if ($task->done) { echo 'checked="true"'; } else { echo ''; } ?> />
								<label for="task-checkbox_<?= $task->taskId ?>"></label>
								<p class="black-text label" id="task-checkbox_<?= $task->taskId ?>" contenteditable="true"><?= $task->description ?></p>
								<i class="material-icons right list-id_<?= $list->listId ?>">menu</i>
							</li>
						<?php endforeach; ?>
						<?php } ?>
						<li>
							<a href="#" class="black-text add-new-task">+ Task</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>

<!-- Modal Structure -->
<div id="add-list" class="modal">
	<div class="modal-content">
		<?php $this->load->view('pages/create.php'); ?>
	</div>
</div>

<!-- Edit forms -->
<?= form_open('pages/edit', array('id' => 'title-form', 'style' => 'display:none;')); ?>
	<input type="text" id="edit-list-title" name="ListTitle" />
	<input type="number" id="edit-list-id" name="ListID" />
  	<input type="submit" name="submit" id="submit-list-form" />
<?= form_close(); ?>

<?= form_open('pages/editTask', array('id' => 'task-form', 'style' => 'display:none;')); ?>
	<input type="text" id="edit-task-description" name="TaskDescription" />
	<input type="number" id="edit-task-done" name="TaskDone" />
	<input type="number" id="edit-task-id" name="TaskID" />
	<input type="number" id="edit-task-list-id" name="ListID" />
  	<input type="submit" name="submit" id="submit-task-form" />
<?= form_close(); ?>