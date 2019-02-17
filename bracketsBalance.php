<?php

	if(in_array('-h', $argv) || in_array('--help', $argv) || !isset($argv[1])) {
		die ("Usage: php ".basename(__FILE__)." -i=\"<input string>\"\n");
	}

	$pairs = [
		'{' => '}',
		'(' => ')',
		'[' => ']'
	];
	$result = true;

	foreach ($argv as $key => $value) {
		if ($key == 0) continue;
		$params = explode('=', $value);
		if ($params[0] == '-i') {
			$input = (string)$params[1];
			$reg = preg_replace('/[^(){}\[\]]/s', '', $input);
			if ($reg == '') die("No brackets found!\n");
			$strlen = strlen($reg);
			$symbolsArr = [];

			for($i = 0; $i < $strlen; $i++) {
				switch ($reg[$i]) {
					case (in_array($reg[$i], array_flip($pairs))):
						$symbolsArr[] = $reg[$i];
						break;
					case (in_array($reg[$i], $pairs)):
						$key = end(array_keys($symbolsArr));
						$pair = $pairs[$symbolsArr[$key]];
						if ($pair == $reg[$i]) {
							unset($symbolsArr[$key]);
							break;
						} else {
							$result = false;
							break(2);
						}
					
					default:
						echo "wrong input\n";
						break;
				}
			}
			echo (count($symbolsArr) > 0 || !$result) ? "Wrong!\n" : "Correct!\n";
		} else {
			echo "unknown parameter " . $params[0] . "\n";
		}
	}

?>
