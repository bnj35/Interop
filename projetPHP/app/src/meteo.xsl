<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html" indent="yes"/>
    <xsl:template match="/">
        <html>
            <head>
                <title>Prévisions Météo</title>
            </head>
            <body>
                <h1>Prévisions Météo :</h1>
                <section id="meteo_section">
                <xsl:apply-templates select="previsions/echeance[position() &lt;= 7]"/>
                </section>
            </body>
            <style>
            *{
                padding: 0;
                margin: 0;
                font-family: Arial, sans-serif;
            }

            body{
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                align-items: center;
                flex-direction: column;
            }

            #meteo_section{
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                align-items: center;
                flex-direction: row;
            }
            
            .meteo {
                border-radius: 10px;
                background-color: #fcfcfc;
                border: 1px inset lightgrey;
                margin: 2Vw;
                padding: 2Vw 1vw;
            }

            .meteo p{
                margin: 1Vw;
            }

            </style>
        </html>
    </xsl:template>

    <xsl:template match="echeance">
        <div class="meteo">
            <h2>Meteo du 
                <xsl:value-of select="concat(substring(@timestamp, 9, 2), '/', substring(@timestamp, 6, 2), '/', substring(@timestamp, 1, 4), ' ', substring(@timestamp, 12, 5))"/>
            </h2>
            <xsl:apply-templates select="temperature/level[@val='2m']"/>
            <p>Humidité: <xsl:value-of select="humidite/level[@val='2m']"/> %</p>
            <xsl:apply-templates select="vent_moyen/level[@val='10m']"/>
            <p>Risque de neige: <xsl:value-of select="risque_neige"/></p>
        </div>
    </xsl:template>

    <xsl:template match="temperature/level[@val='2m']">
        <xsl:variable name="tempK" select="."/>
        <xsl:variable name="tempC" select="format-number($tempK - 273.15, '#0.00')"/>
        <p>
            <xsl:choose>
                <xsl:when test="$tempC &lt; 0">Il fait froid</xsl:when>
                <xsl:otherwise>Température: <xsl:value-of select="$tempC"/> °C</xsl:otherwise>
            </xsl:choose>
        </p>
    </xsl:template>

    <xsl:template match="vent_moyen/level[@val='10m']">
        <xsl:variable name="vent" select="."/>
        <p>
            <xsl:choose>
                <xsl:when test="$vent &gt; 20">Vent fort</xsl:when>
                <xsl:otherwise>Vent faible</xsl:otherwise>
            </xsl:choose>
        </p>
    </xsl:template>
</xsl:stylesheet>
