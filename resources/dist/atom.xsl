<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="3.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:atom="http://www.w3.org/2005/Atom">
    <xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>
    <xsl:template match="/">
        <html xmlns="http://www.w3.org/1999/xhtml" lang="en">
            <head>
                <title>
                    RSS Feed | <xsl:value-of select="/atom:feed/atom:title"/>
                </title>
                <meta charset="utf-8"/>
                <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
                <meta name="viewport" content="width=device-width, initial-scale=1"/>
                <link rel="stylesheet" href="/vendor/feed/style.css"/>
            </head>
            <body>
                <main class="layout-content">
                    <h1 class="flex items-start">
                        <!-- https://commons.wikimedia.org/wiki/File:Feed-icon.svg -->
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                             class="mr-5"
                             style="flex-shrink: 0; width: 1em; height: 1em;"
                             viewBox="0 0 256 256">
                            <defs>
                                <linearGradient x1="0.085" y1="0.085" x2="0.915" y2="0.915"
                                                id="RSSg">
                                    <stop offset="0.0" stop-color="#E3702D"/>
                                    <stop offset="0.1071" stop-color="#EA7D31"/>
                                    <stop offset="0.3503" stop-color="#F69537"/>
                                    <stop offset="0.5" stop-color="#FB9E3A"/>
                                    <stop offset="0.7016" stop-color="#EA7C31"/>
                                    <stop offset="0.8866" stop-color="#DE642B"/>
                                    <stop offset="1.0" stop-color="#D95B29"/>
                                </linearGradient>
                            </defs>
                            <rect width="256" height="256" rx="55" ry="55" x="0" y="0"
                                  fill="#CC5D15"/>
                            <rect width="246" height="246" rx="50" ry="50" x="5" y="5"
                                  fill="#F49C52"/>
                            <rect width="236" height="236" rx="47" ry="47" x="10" y="10"
                                  fill="url(#RSSg)"/>
                            <circle cx="68" cy="189" r="24" fill="#FFF"/>
                            <path
                                d="M160 213h-34a82 82 0 0 0 -82 -82v-34a116 116 0 0 1 116 116z"
                                fill="#FFF"/>
                            <path
                                d="M184 213A140 140 0 0 0 44 73 V 38a175 175 0 0 1 175 175z"
                                fill="#FFF"/>
                        </svg>
                        RSS Feed
                    </h1>
                    <h2><xsl:value-of select="/atom:feed/atom:title"/></h2>
                    <p>
                        <xsl:value-of select="/atom:feed/atom:subtitle"/>
                    </p>
                    <hr/>
                    <xsl:for-each select="/atom:feed/atom:entry">
                        <div class="post">
                            <div class="title">
                                <a>
                                    <xsl:attribute name="href">
                                        <xsl:value-of select="atom:link/@href"/>
                                    </xsl:attribute>
                                    <xsl:value-of select="atom:title"/>
                                </a>
                            </div>

                            <div class="summary">
                                <xsl:value-of select="atom:summary" disable-output-escaping="yes"/>
                            </div>

                            <div class="published-info">
                                Published on
                                <xsl:value-of select="substring(atom:updated, 0, 11)" /> by <xsl:value-of select="atom:author/atom:name"/>
                            </div>
                        </div>
                    </xsl:for-each>
                </main>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
