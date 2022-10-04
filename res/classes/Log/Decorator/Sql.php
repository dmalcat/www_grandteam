<?php

	class Log_Decorator_Sql implements Log_Decorator_Interface {
		
		public function decorate($hash, $userId, $date, $title, $message, $type, $file, $line) {
			
			$message = self::formatSQL(self::linearize_message($message));
			
			$type = str_pad($type . ';', 10, ' ');
			$date = str_pad(date('Y-m-d H:i:s', $date). ';', 15, ' ');
			
			$message = "$hash;\t$userId;\t$date\t$type\t$title;\t$message\n";
			
			return $message;
		}
		
		private static function formatSQL($sql) {
			$words1 = 'DELETE|FROM|GROUP BY|HAVING|INNER JOIN|INSERT|LEFT JOIN|LIMIT|ORDER BY|OUTER JOIN|REPLACE|RIGHT JOIN|SELECT|SET|TRUNCATE|UNION|UPDATE|VALUES|WHERE|JOIN';
			$words2 = 'AND|ON';
			$sql = preg_replace("/[\s]+/", ' ', $sql);
			$sql = preg_replace("/(\s|\()($words1|$words2)\s/", "$1\n\t$2 ", $sql);
			$sql = preg_replace("/(\s)($words2)\s/", "$1\t$2 ", $sql);
			$sql = preg_replace("/\)\s+AND COALESCE\(/", ") AND COALESCE(", $sql);
			return "\t" . ltrim($sql) . "\n";
		}
		
		private function linearize_message($message) {
			
			if ($message instanceof Exception) {
				$message = $message->getMessage();
			} elseif (is_object($message)) {
				$message = (array)$message;
			}
			
			if (is_array($message)) {
				$temp = array();
				foreach ($message as $index => $value) {
					$temp[] = $index . '=>' . $value;
				}
				$message = '(' . implode(',', $temp) . ')';
			}
			
			return $message;
		}
	}