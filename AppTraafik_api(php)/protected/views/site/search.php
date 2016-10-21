<form class="navbar-search pull-left" method = "get" action='.Yii::app()->createUrl("api/site/search").' >
				<input type="text" class="search-query span3" placeholder="Search for jobs, trainings, etc ..." name = "q" value='. Yii::app()->request->getQuery('q') .'>
				</form>