<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="2.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9"
                xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

    <xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>

    <xsl:template match="/">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <title>XML Sitemap</title>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                <style type="text/css">
                    body {
                        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
                        font-size: 14px;
                        color: #444;
                        margin: 0;
                        padding: 20px;
                    }

                    #sitemap {
                        max-width: 980px;
                        margin: 0 auto;
                    }

                    h1 {
                        font-size: 24px;
                        margin: 0 0 5px;
                        font-weight: normal;
                    }

                    p {
                        color: #999;
                        margin: 5px 0 20px;
                        font-size: 13px;
                    }

                    table {
                        border-collapse: collapse;
                        border: 1px solid #ddd;
                        width: 100%;
                        margin-top: 20px;
                    }

                    th {
                        background: #f8f8f8;
                        text-align: left;
                        padding: 10px;
                        font-size: 13px;
                        border-bottom: 1px solid #ddd;
                        font-weight: 600;
                    }

                    td {
                        padding: 10px;
                        border-bottom: 1px solid #eee;
                        font-size: 13px;
                    }

                    tr:hover {
                        background: #fafafa;
                    }

                    a {
                        color: #0073aa;
                        text-decoration: none;
                    }

                    a:hover {
                        text-decoration: underline;
                    }

                    .images {
                        font-size: 11px;
                        color: #999;
                        margin-top: 5px;
                    }
                </style>
            </head>
            <body>
                <div id="sitemap">
                    <h1>XML Sitemap</h1>
                    <p>This is an XML Sitemap to help search engines better index this website.</p>
                    <p>Powered by <a href="https://webmarka.com/tr">Webmarka</a>.</p>
                    <xsl:apply-templates/>
                </div>
            </body>
        </html>
    </xsl:template>

    <!-- Sitemap Index Template -->
    <xsl:template match="sitemap:sitemapindex">
        <p>Number of sitemaps in this index: <strong><xsl:value-of select="count(sitemap:sitemap)"/></strong></p>
        <table>
            <thead>
                <tr>
                    <th width="75%">Sitemap</th>
                    <th width="25%">Last Modified</th>
                </tr>
            </thead>
            <tbody>
                <xsl:for-each select="sitemap:sitemap">
                    <tr>
                        <td>
                            <a href="{sitemap:loc}">
                                <xsl:value-of select="sitemap:loc"/>
                            </a>
                        </td>
                        <td>
                            <xsl:value-of select="concat(substring(sitemap:lastmod, 0, 11), ' ', substring(sitemap:lastmod, 12, 8))"/>
                        </td>
                    </tr>
                </xsl:for-each>
            </tbody>
        </table>
    </xsl:template>

    <!-- URL Set Template -->
    <xsl:template match="sitemap:urlset">
        <p>Number of URLs in this sitemap: <strong><xsl:value-of select="count(sitemap:url)"/></strong><xsl:if test="sitemap:url/image:image">, Images: <strong><xsl:value-of select="count(sitemap:url/image:image)"/></strong></xsl:if></p>
        <table>
            <thead>
                <tr>
                    <th width="60%">URL</th>
                    <th width="15%">Priority</th>
                    <th width="25%">Last Modified</th>
                </tr>
            </thead>
            <tbody>
                <xsl:for-each select="sitemap:url">
                    <tr>
                        <td>
                            <a href="{sitemap:loc}">
                                <xsl:value-of select="sitemap:loc"/>
                            </a>
                            <xsl:if test="image:image">
                                <div class="images">
                                    <xsl:value-of select="count(image:image)"/> image(s)
                                </div>
                            </xsl:if>
                        </td>
                        <td>
                            <xsl:value-of select="sitemap:priority"/>
                        </td>
                        <td>
                            <xsl:value-of select="concat(substring(sitemap:lastmod, 0, 11), ' ', substring(sitemap:lastmod, 12, 8))"/>
                        </td>
                    </tr>
                </xsl:for-each>
            </tbody>
        </table>
    </xsl:template>

</xsl:stylesheet>

