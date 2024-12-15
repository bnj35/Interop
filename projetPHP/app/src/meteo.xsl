<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html" indent="yes"/>
    <xsl:template match="/">

               
                <xsl:apply-templates select="previsions/echeance[position() &lt;= 7]"/>


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
