<?php

declare(strict_types=1);

namespace FreshBangApp\Presenters;

use Nette;


final class FinancePresenter extends BasePresenter
{
    public function actionSubpage() {
        $this->template->title = $this->getParameter('title');
    }
}
