<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html" indent="yes"/>
    <xsl:template match="/">
        <xsl:apply-templates select="previsions/echeance[(substring(@timestamp, 12, 2) = '07' or substring(@timestamp, 12, 2) = '13' or substring(@timestamp, 12, 2) = '22')][position() &lt;= 3]"/>
    </xsl:template>

    <xsl:template match="echeance">
        <xsl:variable name="hour" select="substring(@timestamp, 12, 2)"/>
        <xsl:choose>
            <xsl:when test="$hour = '07'">
                <div class="meteo matin">
                    <h2>Météo du matin 
                        <xsl:value-of select="concat(substring(@timestamp, 9, 2), '/', substring(@timestamp, 6, 2), '/', substring(@timestamp, 1, 4), ' ', substring(@timestamp, 12, 5))"/>
                    </h2>
                    <xsl:apply-templates select="temperature/level[@val='2m']"/>
                    <p>Humidité: <xsl:value-of select="humidite/level[@val='2m']"/> %</p>
                    <xsl:apply-templates select="vent_moyen/level[@val='10m']"/>
                    <p>Risque de neige: <xsl:value-of select="risque_neige"/></p>
                </div>
            </xsl:when>
            <xsl:when test="$hour = '13'">
                <div class="meteo midi">
                    <h2>Météo du midi 
                        <xsl:value-of select="concat(substring(@timestamp, 9, 2), '/', substring(@timestamp, 6, 2), '/', substring(@timestamp, 1, 4), ' ', substring(@timestamp, 12, 5))"/>
                    </h2>
                    <xsl:apply-templates select="temperature/level[@val='2m']"/>
                    <p>Humidité: <xsl:value-of select="humidite/level[@val='2m']"/> %</p>
                    <xsl:apply-templates select="vent_moyen/level[@val='10m']"/>
                    <p>Risque de neige: <xsl:value-of select="risque_neige"/></p>
                </div>
            </xsl:when>
            <xsl:when test="$hour = '22'">
                <div class="meteo soir">
                    <h2>Météo du soir 
                        <xsl:value-of select="concat(substring(@timestamp, 9, 2), '/', substring(@timestamp, 6, 2), '/', substring(@timestamp, 1, 4), ' ', substring(@timestamp, 12, 5))"/>
                    </h2>
                    <xsl:apply-templates select="temperature/level[@val='2m']"/>
                    <p>Humidité: <xsl:value-of select="humidite/level[@val='2m']"/> %</p>
                    <xsl:apply-templates select="vent_moyen/level[@val='10m']"/>
                    <p>Risque de neige: <xsl:value-of select="risque_neige"/></p>
                </div>
            </xsl:when>
        </xsl:choose>
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
