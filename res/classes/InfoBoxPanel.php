<?php

class InfoBoxPanel implements \Tracy\IBarPanel {

    protected $_messages = array();

    /**
     * Renders HTML code for custom tab
     * IDebugPanel
     * @return void
     */
    public function getTab() {
        if (count($this->_messages)) {
            $img = '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsRAAALEQF/ZF+RAAAAB3RJTUUH0woJFhclOeocGQAAAB10RVh0Q29tbWVudABDcmVhdGVkIHdpdGggVGhlIEdJTVDvZCVuAAADDElEQVR42mWTTWhcZRiFn+/vzp07M8mkScykRo1NjKRaU6vWVlAnSguVulDThS6kRYRuAkXrwpWrbBQJCCKIXRQRS7RS1GA2xWC1uCitRYUUWkOmTTohfzNNJpm5c+/3uUgTWj2rl8Ph8HI4R/AffDEyfuTsxdn+3JbkQC2MkgBKKxbL1a+e3bHlzNE39n17p15sHDduzueOffTj14/1duUH9vVh4/Au42okOPXTZSanCl+eHj785gavAG4UF1oHPxwbOzKQ3/vczg7iOCJhNFtbU1gHYT1GK3iytx3lZ/tMbvfAxO9nPts0KNhHR1964am9TSnN0nKd0kpIzwNZsukEKd9w6coctyoxpeWQ5oxHjdQ9XTuez186991J/fGJsVf/nBGPC+e4PrcKgENw+eoiex5p5e9/FijMVVBKg3MAdObSXJzI5L8ZPd8uXn731Cc93d2D6YRcT0QIYutwgFESay1SSgCiKKa4sMZEocTSSkhQu35cp1P+YHm1zlLFIoTEAXt6W9m/K0fga7QUvPP5BYpLdaaKy9SjGOkcCMmDPV1v68L8Kpn6GlasfyClZOS3GWIERw9soxrGXLhWInIKtEZLibMO5xyhkA/rEMF0uQ5SIKQEIUAIrtzcyAOcUkjhgbU4a8FZsA7hKWSuLXO1bjSxVMRSYZUGrUGpzaIYT6M9gzAGYTRSa1zCkFZxQTbL6HurBFIbPGNI+x6Nvkc6oTerlvU1jYFHOjB4Ce+2EdybcKPy8Is9H3Q1RGQCj2zK0BQYsoFH6raBFJANDE2pdb7B16SShu0trnLs9aeHZP6Z7StPtPBeW8bRmPRoDDz6Oht4bXcLc+U1yishx195iCZfkE16NCdqbAuWEYW/Dubamqc3tzB04peRayvJQw2ZRmxskS5CivXuxNYRIzAJn8X5IpXScv/poQPjd40JYPjkzweny/KH9q33oYyHVgpwRJGlHtWYn50hvFXsH37/0Pj/1riBycnJ7nN/zL41NVvdn0kHuwCqtdqvHa3mbH5n7tOO+zvn7tT/CxVVH2++pqsXAAAAAElFTkSuQmCC" />';
            if (count($this->_getWarningsCount()) && false) {
                return $img . '<span class="nette-warning">Smarty templates (' . $this->_getWarningsCount() . ')</span>';
            } else {
                return $img . '<span class="nette">INCLUDE</span>';
            }
        } else {
            return '';
        }
    }

    public function getId() {
        return 7;
    }

    /**
     * Renders HTML code for custom panel
     * IDebugPanel
     * @return void
     */
    public function getPanel() {
        $text = '<h1>INCLUDE</h1>';
        $text .= '<div class="nette-inner">';
        $text .= '<table style="width: 100%">';
        $text .= '<tr><th>titulek</th><th>zprava</th></tr>';
        foreach ($this->_messages as $message) {
            $text .= "<tr style='" . ($message['type'] == 'warning' ? 'color: #D32B2B' : '' ) . "'>";
            if (is_array($message['message'])) {
                $text .= "<td>{$message['title']}</td>";
                $text .= "<td>" . print_r($message['message'], 1) . "</td>";
            } else {
                $text .= "<td>{$message['title']}</td>
            			 <td>{$message['message']}</td>";
            }
            $text .= "</tr>";
        }
        $text .= '</tr></table>';
        $text .= '</div>';
        return $text;
    }

    public function addMessage($title, $message, $type = 'notice') {
        $this->_messages[] = array(
            'title' => $title,
            'message' => $message,
            'type' => $type,
        );
    }

    protected function _getWarningsCount() {
        $count = 0;
        foreach ($this->_messages as $message) {
            if ($message['type'] == 'warning') {
                $count++;
            }
        }
        return $count;
    }

}
