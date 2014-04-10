<?php
if (!ACCESS_CHECK) { die('ACCESS ERROR');}
class Router {
	public static function routerStart($URL) {
		if (!empty($URL[1])) {
			$controllerFile = ROOT . 'app/controllers/' . $URL[1] . '.controller.php';
			$controllerName = $URL[1] . 'Controller';
			$modelFile = ROOT . 'app/models/' . $URL[1] . '.model.php';
			$modelName = $URL[1] . 'Model';
			$viewFile = ROOT . 'app/views/' . $URL[1] . '.template.html';
		} else {
			$controllerFile = ROOT . 'app/controllers/' . 'index.controller.php';
			$controllerName = 'indexController';
			$modelFile = ROOT . 'app/models/' . 'index.model.php';
			$modelName = 'indexModel';
		}

		if (!empty($URL[2])) {
			$actionName = $URL[2] . 'Action';
		} else {
			$actionName = 'indexAction';
		}

		if (!empty($URL[3])) {
			$param = $URL[3];
		}
		try {
			if (file_exists($controllerFile)) {
				require_once $controllerFile;
				require_once $modelFile;
				$currentController = new $controllerName();
				if (!empty($param)) {
					$currentController->paramValue = $param;
				}
				if (method_exists($currentController, $actionName)) {
					$currentController->$actionName();
				} else {
					throw new Exception("NOT FOUND");
				}
			} else {
				throw new Exception("NOT FOUND");
			}
		} catch(Exception $e) {
			echo $e->getMessage();
		}
	}
}
?>