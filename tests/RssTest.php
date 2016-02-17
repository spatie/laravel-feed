<?php

namespace Spatie\Rss\Test;


use XMLReader;

class RssTest extends TestCase
{
    /**
     * @test
    */
    public function it_registers_route()
    {
        $this->assertEquals(200, $this->call('GET', '/en/myfeed')->getStatusCode());
        $this->assertEquals(200, $this->call('GET', '/nl/myfeed')->getStatusCode());

    }

    /**
     * @test
     */
    public function feed_has_valid_xml()
    {

        $reader = new XMLReader();



        $reader->XML($this->call('GET', '/en/myfeed')->getContent());

        $reader->setParserProperty(XMLReader::VALIDATE, true);
        $reader->read();
//        die($this->call('GET', '/en/myfeed')->getContent());
        $this->assertTrue($reader->isValid());

    }

    /**
     * @test
     */
    public function feed_has_all_models(){

    }

    /**
     * @test
     */
    public function feed_has_meta(){
        str_contains() '<link>...</link>'
    }

    /**
     * @test
     */
    public function feed_works_if_no_models(){

    }



}