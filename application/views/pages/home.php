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
					<span class="card-title" contenteditable="true"><?= $list->title;?></span>
					<?php if ($list->tasks[0]->taskId != null ) { ?>
					<ul>
						<?php foreach ($list->tasks as $task): ?>
							<li id="task_<?= $task->taskId ?>">
								<input type="checkbox" class="filled-in" id="task-checkbox_<?= $task->taskId ?>" <?php if ($task->done) { echo 'checked="true"'; } else { echo ''; } ?> />
								<label class="black-text" for="task-checkbox_<?= $task->taskId ?>" contenteditable="true"><?= $task->description ?></label>
							</li>
						<?php endforeach; ?>
					</ul>
					<?php } ?>
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