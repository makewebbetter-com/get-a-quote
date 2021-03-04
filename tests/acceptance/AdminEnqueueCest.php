<?php 

class AdminEnqueueCest
{
    public function _before(AcceptanceTester $I)
    {
        // will be executed at the begining of each test.
        $I->loginAsAdmin();
        $I->am('administrator');
    }

    public function enqueue_script_test(AcceptanceTester $I)
    {
        $I->wantTo('Check admin script on the plugins page');
        $I->amOnAdminPage('admin.php?page=get_a_quote_menu');
        $I->seeInSource('get-a-quote-admin.js');
        $I->seeInSource('get-a-quote-select2.js');
    }

    public function enqueue_style_test(AcceptanceTester $I)
    {
        $I->wantTo('Check admin styles on the plugins page');
        $I->amOnAdminPage('admin.php?page=get_a_quote_menu');
        $I->seeInSource('get-a-quote-admin.scss');
        $I->seeInSource('get-a-quote-select2.css');
    }
}
