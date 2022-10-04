<?php
class Log_Decorator_Html implements Log_Decorator_Interface
{
    public function decorate($hash, $userId, $date, $title, $message, $type, $file, $line) {

        if($message instanceof Exception){
            $exception = $message;
            $message = $exception->getMessage();
        }elseif(is_object($message)){
            $message = (array)$message;
        }

        $text = "<table>";
        $text .= '<tr><td>Čas</td><td><strong>' . date('d/m/Y H:i', $date) . "</strong></td></tr>";
        $text .= '<tr><td>Hash</td><td><strong>' . $hash . "</strong></td></tr>";
        $text .= "<tr><td>Titulek</td><td><strong>" . $title . "</strong></td></tr>";
        $text .= "<tr><td>Zpráva</td><td><strong>" . $message . "</strong></td></tr>";
        $text .= '<tr><td>Id Uživatele</td><td><strong>' . $userId . "</strong></td></tr>";
        $text .= "<tr><td>Url</td><td><strong>" . Helper_Url::getCurrentURL() . "</strong></td></tr>";
        $text .= "</table>";

        $text .= "<br />";
        $text .= "<table>";
        $text .= "<caption>Konfigurace</caption>";
		foreach(Registry::getConfig()->getSelected() as $index => $value){
		     $text .= "<tr><td>$index</td><td>$value</td></tr>";
		}
		$text .= "</table>";

        if(isset($exception)){

            $text .= "<br />";
            $text .= "<table>";
            $text .= "<caption>Cesta</caption>";
            $text .= "  <tr>
                            <th>Soubor</th>
                            <th>Řádek</th>
                            <th>Volaná třída</th>
                            <th>Volaná funkce</th>
                            <th>Pořadí</th>
                        </tr>";

            $text .= "<tr>
                        <td>" . $exception->getFile() . "</td>
                        <td>" . $exception->getLine() . "</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>-</td>
                      </tr>";

            if(count($exception->getTrace())){
                foreach ($exception->getTrace() as $index => $trace){
                    $text .= "<tr>
                               <td>" . (isset($trace['file']) ? $trace['file'] : '') . "</td>
                               <td>" . (isset($trace['line']) ? $trace['line'] : '') . "</td>
                               <td>" . (isset($trace['class']) ? $trace['class'] : '') . "</td>
                               <td>" . (isset($trace['function']) ? $trace['function'] : '') . "</td>
                               <td>" . $index . "</td>
                             </tr>";

                }
            }
            $text .= "</table>";
			$text .= "<br/>SESSION TO FIND: ". implode(",", array_keys((array)$_SESSION["to_find"]));
			$text .= "<br/>SESSION TO FIND: ". implode(",", (array)$_SESSION["to_find"]);
			$text .= "<br/><br/>POST: ". implode(",", array_keys($_POST));
			$text .= "<br/><br/>POST: ". implode(",", $_POST);
            return $text;
        }

        if(!is_string($message)){
            $message = print_r($message, 1);
        }

		return $text;
    }
}
