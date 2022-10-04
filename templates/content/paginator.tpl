{*pagination total=$total page=$page count=10 url='/blog/archiv' linkparam='?stran­ka=%d' firstText='První' lastText='Poslední' lowOmmitOffset='2' middleOmmitOffset='20' highOmmitOffset='50'*}
{pagination total=dbContentCategory::getCount() page=dbContentCategory::getPage() count=dbContentCategory::getPerPage() url=Registry::getUrl() linkparam='&p=%d' firstText='' lastText='' separator=''}
{*{pagination total=$count page=dbContentCategory::getPage() count=dbContentCategory::getPerPage() url=Registry::getUrl() linkparam='&p=%d' firstText='' lastText='' separator=''}*}
