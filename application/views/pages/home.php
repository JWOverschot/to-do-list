<h1>TO-DO Lists</h1>

<?php
	$currentList = 0;
	$tasksArray = [];
	$title = '';
	$listArray = [];

	class ListList {
	    function ListList($title, $descriptions) {
	        $this->title = $title;
	        $this->descriptions = $descriptions;
	    }
	}

	foreach ($lists as $list):
		if ($currentList != $list['ListID']) {
			// set the previus list in an array
			if ($currentList != 0) {
				array_push($listArray, new ListList($title, $tasksArray));
				$tasksArray = [];
			}

			$title = $list['ListTitle'];

			$currentList = $list['ListID'];
		}
		array_push($tasksArray, $list['TaskDescription']);
	endforeach;

foreach ($listArray as $list): ?>
	<div class="row">
		<div class="col s12 m6">
			<div class="card blue-grey darken-1">
				<div class="card-content white-text">
					<span class="card-title"><?= $list->title;?></span>
					<ul>
						<?php foreach ($list->descriptions as $task): ?>
						<li><?= $task ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
<?php endforeach; ?>