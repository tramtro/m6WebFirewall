<?php
namespace nguyenanhung\Component\Firewall\Tests\Units\Lists;

require_once __DIR__ . '/../../bootstrap.php';

use nguyenanhung\Component\Firewall\Entry\EntryInterface;

/**
 * Class EntryList
 *
 * @package nguyenanhung\Component\Firewall\Tests\Units
 * @author  Adrien Samson <asamson.externe@m6.fr>
 */
class EntryList extends \mageekguy\atoum\test
{
    public function test()
    {
        $list = array(
            new EntryMock(42),
            new EntryMock(666),
        );
        $entryList = new \nguyenanhung\Component\Firewall\Lists\EntryList($list, true);

        $this
            ->boolean($entryList->isAllowed('42'))
                ->isEqualTo(true)
            ->boolean($entryList->isAllowed('666'))
            ->isEqualTo(true)
            ->variable($entryList->isAllowed('123'))
                ->isNull()
            ->array($entryList->getMatchingEntries())
                ->hasSize(2)
                ->containsValues(array('42', '666'))
        ;
    }
}

class EntryMock implements EntryInterface
{
    protected $e;

    public function __construct($e)
    {
        $this->e = $e;
    }

    public static function match($entry) {}

    public function check($entry)
    {
        return $entry == $this->e;
    }

    public function getMatchingEntries()
    {
        return array($this->e);
    }
}
