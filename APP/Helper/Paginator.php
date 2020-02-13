<?php
class Paginator {

	public function go($page = false, $totalPages = false, $link = false, $perpage = 10) {
		$totalPages = ceil($totalPages / $perpage);

		$return = false;
		if ($page && $totalPages && $link) {
			$return .= '<div class="btn-group">';
			if ($page > 1) {
				if ($page > 2) {
					$return .= '<a class="btn btn-warning" href="'.$link.(1).'">Primeira</a>';
					$return .= '<a class="btn btn-default" href="'.$link.($page - 1).'">Anterior</a>';
				} else {
					$return .= '<a class="btn btn-default" href="'.$link.($page - 1).'">Anterior</a>';
				}
			}
				
				//$return .= '<span class="stepper-next" onclick="goUrl('.($page - 1).',\''.$link.'\')"  >Anterior</span>';
			
			for ($i=$page - 2; $i <= $page + 2 ; $i++)
				if (($i >= 1) && ($i <= $totalPages))
					$return .= '<a class="btn btn-'.(($page == $i) ? 'info' : 'default').' btn'. $i. '" href="'.$link.($i).'">'.$i.'</a>';
			
			if ($page < $totalPages) {
				if (($page + 1) == $totalPages) {
					$return .= '<a class="btn btn-warning" href="'.$link.($totalPages).'">Última</a>';	
				} else {
					$return .= '<a class="btn btn-default" href="'.$link.($page + 1).'">Próxima</a>';
					$return .= '<a class="btn btn-warning" href="'.$link.($totalPages).'">Última</a>';	
				}
			}

			$return .= '</div>';
		}	
		return $return;
	}

}