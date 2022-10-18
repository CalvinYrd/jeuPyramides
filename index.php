<?php

error_reporting(E_ALL);

class Html {
	static function debug($data, $entities = false) {
		if ($entities) $data = htmlentities($data);
		echo "<pre>";
		var_dump($data);
		echo "</pre>";
	}
	static function array_find_index($sth, $arr) {
		$result = false;
		$index = array_search($sth, $arr);
		if (is_int($index)) $result = $index;
		return $result;
	}
	static function html_element($tag, $params = null, $content = null) {
		if (preg_match("/doctype/", strtolower($tag))) {
			if (!is_string($params)) $params = "html";
			$valueToReturn = "<!DOCTYPE $params>";
		}
		else {
			$unclosingTags = array("area", "base", "br", "col", "embed", "hr", "img", "input", "link", "meta", "param", "source", "track", "wbr");
			$endOfTag = "";
			$finalParams = "";
			if (!is_array($params)) $params = null;

			if (!in_array($tag, $unclosingTags)) {
				$endOfTag = "</$tag>";
			}
			else {
				$content = "";
			}
			foreach ($params as $key => $value) {
				if (!$value) $value = null;
				$finalParams .= "$key='$value' ";
			}
			$valueToReturn = "<$tag $finalParams>$content$endOfTag";
		}
		return $valueToReturn;
	}
	static function img($params = null, $content = null) {
		return Html::html_element("img", $params, $content);
	}
	static function a($params = null, $content = null) {
		return Html::html_element("a", $params, $content);
	}
	static function doctype($params = null, $content = null) {
		return Html::html_element("doctype", $params, $content);
	}
	static function head($params = null, $content = null) {
		return Html::html_element("head", $params, $content);
	}
	static function html($params = null, $content = null) {
		return Html::html_element("html", $params, $content);
	}
	static function body($params = null, $content = null) {
		return Html::html_element("body", $params, $content);
	}
	static function div($params = null, $content = null) {
		return Html::html_element("div", $params, $content);
	}
	static function span($params = null, $content = null) {
		return Html::html_element("span", $params, $content);
	}
	static function p($params = null, $content = null) {
		return Html::html_element("p", $params, $content);
	}
	static function meta($params = null, $content = null) {
		return Html::html_element("meta", $params, $content);
	}
	static function title($params = null, $content = null) {
		return Html::html_element("title", $params, $content);
	}
	static function h1($params = null, $content = null) {
		return Html::html_element("h1", $params, $content);
	}
	static function h2($params = null, $content = null) {
		return Html::html_element("h2", $params, $content);
	}
	static function h3($params = null, $content = null) {
		return Html::html_element("h3", $params, $content);
	}
	static function h4($params = null, $content = null) {
		return Html::html_element("h4", $params, $content);
	}
	static function h5($params = null, $content = null) {
		return Html::html_element("h5", $params, $content);
	}
	static function h6($params = null, $content = null) {
		return Html::html_element("h6", $params, $content);
	}
	static function input($params = null, $content = null) {
		return Html::html_element("input", $params, $content);
	}
	static function select($params = null, $content = null) {
		return Html::html_element("select", $params, $content);
	}
	static function textArea($params = null, $content = null) {
		return Html::html_element("textArea", $params, $content);
	}
	static function button($params = null, $content = null) {
		return Html::html_element("button", $params, $content);
	}
	static function canvas($params = null, $content = null) {
		return Html::html_element("canvas", $params, $content);
	}
	static function video($params = null, $content = null) {
		return Html::html_element("video", $params, $content);
	}
	static function article($params = null, $content = null) {
		return Html::html_element("article", $params, $content);
	}	
}













Class Hoop {
	protected $width;
	protected $color;
	protected $pyramid;

	public function __construct($_width, $_color, $_pyramid) {
		$this->width = $_width;
		$this->color = $_color;
		$this->pyramid = $_pyramid;
	}

	public function has_successors() {
		$result = false;

		foreach ($this->pyramid->get_hoops() as $hoop) {
			if ($hoop->get_width() < $this->get_width()) {
				$result = true;
				break;
			}
		}
		return $result;
	}
	public function get_color() {
		return $this->color;
	}
	public function get_width() {
		return $this->width;
	}
	public function get_pyramid() {
		return $this->pyramid;
	}
	public function can_ride($hoop) {
		return $this->get_width() < $hoop->get_width();
	}
	public function change_pyramid($new_pyramid) {
		$this->pyramid = $new_pyramid;
	}
}
Class Pyramid {
	protected $height;
	protected $hoops;

	public function __construct($_height, $_hoops = array()) {
		$this->height = $_height;
		$this->hoops = $_hoops;
	}

	private function has_hoop($_hoop) {
		return in_array($_hoop, $this->hoops);
	}
	private function is_same_pyramid($__hoop__) {
		return $this == $__hoop__->get_pyramid();
	}
	private function move_hoop_to($hoop, $_new_pyramid) {
		if (!$this->is_same_pyramid($hoop)) {
			$hoop->get_pyramid()->remove_last_hoop();
		}
		$hoop->change_pyramid($_new_pyramid);
		$_new_pyramid->hoops[] = $hoop;
	}
	public function get_hoops() {
		return $this->hoops;
	}
	public function get_hoop_by_width($w) {
		foreach ($this->hoops as $hoop) {
			if ($hoop->get_width() == $w) {
				return $hoop;
			}
		}
	}
	public function get_last_hoop() {
		return end($this->hoops);
	}
	private function has_hoops() {
		return boolval($this->hoops);
	}
	private function new_hoop_is_valid($new_hoop) {
		if ($this->has_hoops()) {
			$last_hoop = $this->get_last_hoop();
			$result = $new_hoop->can_ride($last_hoop);
		}
		else {
			$result = true;
		}
		if (!$result) echo Html::html_element("script", null, "alert('les cerceaux se chevauchent mal')");
		return $result;
	}
	public function is_empty() {
		return boolval(!$this->hoops);
	}
	public function is_full() {
		$amount = count($this->hoops);
		return $amount >= $this->height;
	}
	public function remove_last_hoop() {
		array_pop($this->hoops);
	}
	public function add_hoop($hoop) {
		if ((!$this->is_full()) and $this->new_hoop_is_valid($hoop)) {
			$this->move_hoop_to($hoop, $this);
		}
	}
	public function draw($libelle = "") {
		$_hoops = array_reverse($this->hoops);
		$pyramidHeight = $basePyramidHeight = $this->height;

		$pyramidWidth = 20; // 20
		$pyramidHeight *= 20; // 20
		$pyramidHeight += 10;
		$hoopsWidth = 20; // 20
		$hoopsFontSize = 15; // 15

		$sizeDemultiplier = $basePyramidHeight / 20;
		if ($sizeDemultiplier > 1) {
			foreach (array("pyramidHeight", "hoopsWidth", "hoopsFontSize", "pyramidWidth") as $varName) {
				${$varName} /= $sizeDemultiplier;
			}
		}
		$htmlHoops = "";
		$hoopsDelays = array();

		foreach ($_hoops as $curHoop) {
			$curDelay = $curHoop->get_width();
			$curDelay /= 16; // 16
			if ($sizeDemultiplier > 1) $curDelay /= $sizeDemultiplier;
			$hoopsDelays[] = $curDelay;
		}
		$hoopsDelays = array_reverse($hoopsDelays);
		foreach ($_hoops as $key => $curHoop) {
			$curColor = $curHoop->get_color();
			$curBaseWidth = $curHoop->get_width();

			$curWidth = $curBaseWidth;
			$curWidth *= 30; // 30
			$curDelay = $hoopsDelays[$key];
			if ($sizeDemultiplier > 1) $curWidth /= $sizeDemultiplier;

			$htmlHoops .= Html::div(array("class"=>"hoop d-flex justify-content-center", "style"=>"animation-delay: {$curDelay}s; width: {$curWidth}px; background: $curColor; height: {$hoopsWidth}px"),
				Html::p(array("class"=>"color-white", "style"=>"font-size: {$hoopsFontSize}px;"), $curBaseWidth)
			);
		}
		return Html::div(array("class"=>"pyramid d-flex flex-direction-column align-items-center justify-content-end", "style"=>"height: {$pyramidHeight}px; width: {$pyramidWidth}px;"),
			$htmlHoops.
			Html::p(array("class"=>"libelle color-white"), $libelle)
		);
	}
}
$stepsCount = 0;

function random_choice($arr) {
	$arr_size = count($arr);
	$random_index = random_int(1, $arr_size);
	$random_index -= 1;

	return $arr[$random_index];
}
function get_random_color() {
	$colors = array("red", "green", "blue", "orangered", "orange", "magenta", "pink");
	return random_choice($colors);
}
function genereate_hoops($count, $pyramid) {
	$result = array();

	for ($i = $count; $i; $i--) {
		$new_hoop = new Hoop($i, get_random_color(), $pyramid);
		$result[] = $new_hoop;
	}
	return $result;
}
function generate_pyramids($height) {
	$base_pyramid = new Pyramid($height);
	$hoops = genereate_hoops($height, $base_pyramid);

	foreach ($hoops as $hoop) {
		$base_pyramid->add_hoop($hoop);
	}
	$pyramids = array(
		"base" => $base_pyramid,
		"mid" => new Pyramid($height),
		"end" => new Pyramid($height)
	);
	return $pyramids;
}
function addStep($pyramids, $from = null, $to = null) {
	global $stepsCount;
	$stepsCount++;

	if ($from and $to) $pyramids[$to]->add_hoop($pyramids[$from]->get_last_hoop());
	$_pyramids = "";

	foreach ($pyramids as $key => $pyramid) {
		$_pyramids .= $pyramid->draw($key);
	}
	echo Html::html_element("script", array("type"=>"text/javascript"), 'steps.push("'.$_pyramids.'")');
}
function resolve($pyramids, $source = "base", $destination = "end", $element) {
	$hoop = $pyramids[$source]->get_hoop_by_width($element);
	$hoopHasSuccessors = $hoop->has_successors();

	if ($hoopHasSuccessors) {
		if ($pyramids["base"]->is_empty() or $source == "end" or ($source == "mid" and $destination == "end")) $switchingPyramid = "base";
		else $switchingPyramid = "mid";
		$next = ($destination == $switchingPyramid ? "end" : $switchingPyramid);
		if ($source == $next) $next = ($source == "end" ? "mid" : "end");

		resolve($pyramids, $source, $next, $element - 1);
		resolve($pyramids, $source, $destination, $element);
		resolve($pyramids, $next, $destination, $element - 1);
	}
	else {
		addStep($pyramids, $source, $destination);
	}
}
function getDOM() {
	return Html::doctype().
	Html::html(array("lang"=>"fr"),
		Html::head(null,
			Html::meta(array("charset"=>"UTF-8")).
			Html::meta(array("name"=>"viewport", "content"=>"width=device-width, initial-scale=1.0")).
			Html::title(null, "Jeu des pyramides").
			Html::html_element("link", array("rel"=>"stylesheet", "href"=>"style.css")).
			Html::html_element("script", array("type"=>"text/javascript", "src"=>"https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"))
		).
		Html::body(array("class"=>"d-flex flex-direction-column align-items-center justify-content-space-evenly height100"),
			Html::div(array("class"=>"pyramidsContainer d-flex align-items-center justify-content-space-around")).
			Html::div(array("class"=>"actionsButtons"),
				Html::input(array("type"=>"button", "class"=>"start", "value"=>"Début")).
				Html::input(array("type"=>"button", "class"=>"previous", "value"=>"Précédent")).
				Html::input(array("type"=>"button", "class"=>"next", "value"=>"Suivant")).
				Html::input(array("type"=>"button", "class"=>"end", "value"=>"Fin"))
			).
			Html::div(array("class"=>"chargement d-flex justify-content-center align-items-center"),
				Html::p(null, "Chargement en cours")
			).
			Html::html_element("script", array("type"=>"text/javascript"),
				"
				steps = Array()
				pyramids = $('.pyramidsContainer')
				pyramidIndex = 0

				$('.actionsButtons .start').on('click', function() {
					pyramidIndex = 0
					pyramids.html(steps[pyramidIndex])
				})
				$('.actionsButtons .previous').on('click', function() {
					if (pyramidIndex > 0) {
						pyramidIndex -= 1
						pyramids.html(steps[pyramidIndex])
					}
				})
				$('.actionsButtons .next').on('click', function() {
					if (pyramidIndex < steps.length - 1) {
						pyramidIndex += 1
						pyramids.html(steps[pyramidIndex])
					}
				})
				$('.actionsButtons .end').on('click', function() {
					pyramidIndex = steps.length - 1
					pyramids.html(steps[pyramidIndex])
				})
				"
			)
		)
	);
}
function printGame($height, $dest = "end") {
	echo getDOM();

	$pyramids = generate_pyramids($height);
	addStep($pyramids);

	echo Html::html_element("script", array("type"=>"text/javascript"), 'pyramids.html(steps[0])');
	resolve($pyramids, "base", $dest, $height);

	global $stepsCount;
	echo Html::html_element("script", array("type"=>"text/javascript"), '$(".chargement").html("'.$stepsCount.' coup(s) pour résoudre le/les cerceau(x).")');
}

printGame(7, "end");

?>
