<?php

  $page_content = $ARTICLE->get_article_detail(1);

  $SMARTY->assign("page_content", $page_content);
  $page_right = "homepage.tpl";

  include(PROJECT_DIR."res/display.php");

?>
