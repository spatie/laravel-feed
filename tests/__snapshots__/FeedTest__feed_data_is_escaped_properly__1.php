<?php return '<?xml version="1.0" encoding="UTF-8"?>
<feed xmlns="http://www.w3.org/2005/Atom">
                        <id>http://localhost/feedBaseUrl/feed-with-special-chars</id>
                                <link href="http://localhost/feedBaseUrl/feed-with-special-chars"></link>
                                <title><![CDATA[Feed with special characters]]></title>
                                <updated>2016-01-01T00:00:00+01:00</updated>
                        <entry>
            <title><![CDATA[This is &, ∑´†®¥¨˙©ƒ∂˙∆∂ß∑ƒ©˙ú]]></title>
            <link rel="alternate" href="https://localhost/news/testItem1" />
            <id>http://localhost/1</id>
            <author>
                <name><![CDATA[feedItemAuthor]]></name>
            </author>
            <summary type="html">
                <![CDATA[The summary contains a CEnd tag, ]]]]><![CDATA[>, but it is escaped properly]]>
            </summary>
            <updated>2016-01-01T00:00:00+01:00</updated>
        </entry>
    </feed>
';
