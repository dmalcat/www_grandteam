<?php

use Tracy\Debugger;

//	include_once(PROJECT_DIR . "res/classes/InfoBox.php");
$infoBoxPanel = new InfoBoxPanel("UsedPHP");
Debugger::getBar()->addPanel($infoBoxPanel);
//Debugger::getBlueScreen()->addPanel($infoBoxPanel1);
//Debugger::addPanel($infoBoxPanel);

$infoBoxPanel2 = new InfoBoxPanel("UsedTemplates");
Debugger::getBar()->addPanel($infoBoxPanel2);


//$infoBoxPanel4 = new \Dibi\Bridges\Tracy\Panel();
//Debugger::getBar()->addPanel($infoBoxPanel4);


if ($config->debug->profiler->enabled) {
    if (extension_loaded('xhprof')) {
        $profiler_namespace = 'myapp';  // namespace for your application
        $xhprof_data = xhprof_disable();
        $xhprof_runs = new XHProfRuns_Default();
        $run_id = $xhprof_runs->save_run($xhprof_data, $profiler_namespace);

        // url to the XHProf UI libraries (change the host name and path)
        $profiler_url = sprintf('http://localhost/xhprof_html/index.php?run=%s&source=%s', $run_id, $profiler_namespace);
        $infoBoxPanel3 = new InfoBoxPanel("XHPROF");
        Debugger::getBar()->addPanel($infoBoxPanel3);
        $infoBoxPanel3->addMessage('PROFILLER', '<a href="' . $profiler_url . '" target="_blank">Profiler output</a>');
//		echo '<a href="' . $profiler_url . '" target="_blank">Profiler output</a>';
    }
}

Debugger::barDump($_POST, "POST");
Debugger::barDump($_GET, "GET");

foreach (get_included_files() as $file) {
    if (strpos($file, '3n/www/')) {
        $infoBoxPanel->addMessage('UsedPHP', '<a href="editor://open/?file=' . $file . '&line=1">' . basename($file) . '</a>');
    }
}

foreach ($usedTemplates as $usedTemplate) {
    if (!strpos($usedTemplate, "val:")) {
        $infoBoxPanel2->addMessage('UsedTemplates', '<a href="editor://open/?file=' . $SMARTY->template_dir . '/' . $usedTemplate . '&line=1">' . $usedTemplate . '</a>');
    }
}
//Debugger::getBar()->addPanel(new JanDrabek\Tracy\GitVersionPanel());
?>
