<?php

namespace App\Services;

use App\Proxy;
use App\SpysOneFilterSet;
use Facebook\WebDriver\Exception\TimeOutException;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Laravel\Dusk\Browser;
use Laravel\Dusk\Chrome\SupportsChrome;
use Laravel\Dusk\Concerns\ProvidesBrowser;

class SpysOneParser
{

    use SupportsChrome, ProvidesBrowser;

    /** @var string */
    private $link = 'http://spys.one/free-proxy-list/ALL/';

    /** @var SpysOneFilterSet|null */
    private $filter_set = null;

    /** @var array  */
    private $parsed_array = [];

    /**
     * @return int
     */
    public function getParsedRecordsNum()
    {
        return count($this->parsed_array);
    }

    /**
     * @param string $link
     * @return $this
     */
    public function setLink(string $link): self
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @return $this
     */
    public function autoSetupFilterSet(): self
    {
        $this->filter_set = SpysOneFilterSet::getOldestUpdated();
        //$this->filter_set = SpysOneFilterSet::find(1);
        return $this;
    }

    /**
     * @return $this
     * @throws TimeOutException
     */
    public function ParseData()
    {
        $browser = new Browser($this->driver());

        $browser->visit($this->link);
        $browser->waitFor('font.spy2', 2);

        $filter_array = $this->filter_set->toFilterArray();

        foreach ($filter_array as $key => $value) {
            $browser->select($key, $value)
                ->pause(1000)
                ->waitFor('font.spy2', 2);
        }

        $counter = 0;
        do {
            $filters_not_done = false;
            foreach ($filter_array as $key => $value) {
                $browser_value = $browser
                    ->element("select[name='{$key}']>option[selected]")
                    ->getAttribute('value');
                if ($value != $browser_value) {
                    $browser->select($key, $value)
                        ->pause(1000)
                        ->waitFor('font.spy2', 2);
                    $filters_not_done = true;
                }
            }
            $counter++;
        } while ($counter < 5 && $filters_not_done);


        $table_array = [];
        foreach ($browser->elements('tr.spy1x, tr.spy1xx') as $row) {
            $row_array = [];
            $add = false;
            foreach ($row->findElements(WebDriverBy::cssSelector('td')) as $num => $col) {
                $col_text = $col->getText();
                switch ($num) {
                    case 0:
                        if (preg_match(
                            '/^([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})\:([0-9]+)$/m',
                            $col_text,
                            $ip_port
                        )) {
                            $add = true;
                            $row_array['address'] = $ip_port[1];
                            $row_array['port'] = $ip_port[2];
                        }
                        break;
                    case 1:
                        if($add) {
                            $row_array['type'] = $col_text;
                        }
                        break;
                    case 2:
                        if($add) {
                            $row_array['anonymity'] = $col_text;
                        }
                        break;
                    case 3:
                        if($add) {
                            $col_array = explode(' ', $col_text);
                            $row_array['country'] = $col_array[0];
                        }
                        break;
                    default:
                        break;
                }
            }
            if ($add) {
                $table_array[] = $row_array;
            }
        }

        $browser->quit();

        $this->parsed_array = $table_array;

        return $this;
    }

    /**
     * @return $this
     */
    public function insertData() :self
    {
        Proxy::insert($this->parsed_array);
        return $this;
    }

    /**
     * @return $this
     */
    public function finalUpdateFilterSet() :self
    {
        $this->filter_set->updated_at = now();
        $this->filter_set->status = 'Updated';
        $this->filter_set->save();

        return $this;
    }

    /**
     * @inheritDoc
     */
    protected function driver()
    {
        return RemoteWebDriver::create(
            'http://selenium-hub:4444/wd/hub',
            DesiredCapabilities::firefox()
                ->setCapability('acceptInsecureCerts', true)
                ->setCapability('enablePassThrough', false)
                ->setCapability('javascriptEnabled', true)
        );
    }
}
