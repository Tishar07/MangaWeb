<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/UserAccount">
        <div class="account-container">
            <h2>My Account</h2>
            <form class="account-card" id="accountForm" action="php/update_user.php" method="POST" onsubmit="return encodeItems()">
                <label for="fname">First Name</label>
                <input type="text" id="fname" name="FirstName" required="required">
                    <xsl:attribute name="value">
                        <xsl:value-of select="FirstName"/>
                    </xsl:attribute>
                </input>
                <label for="lname">Last Name</label>
                <input type="text" id="lname" name="LastName" required="required">
                    <xsl:attribute name="value">
                        <xsl:value-of select="LastName"/>
                    </xsl:attribute>
                </input>
                <label for="email">Email</label>
                <input type="email" id="email" name="Email" required ="required">
                    <xsl:attribute name="value">
                        <xsl:value-of select="Email"/>
                    </xsl:attribute>                    
                </input>
                <label for="ContactNumber">Contact Number</label>
                <input type="text" id="ContactNumber" name="ContactNumber">
                    <xsl:attribute name="value">
                        <xsl:value-of select="ContactNumber"/>
                    </xsl:attribute>    
                </input>
                <label for="street">Street</label>
                <input type="text" id="street" name="Street" >
                    <xsl:attribute name="value">
                        <xsl:value-of select="Street"/>
                    </xsl:attribute>                        
                </input>
                <label for="city">City</label>
                <input type="text" id="city" name="City" >
                    <xsl:attribute name="value">
                        <xsl:value-of select="City"/>
                    </xsl:attribute>    
                </input>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter new password"/>
                <button type="submit" class="save-btn">Save Changes</button>
                <input type="hidden" name="txt_xml_Account" id="txt_xml_Account"/>
            </form>
            <a href="logout.php" class="logout-link">Logout</a>
        </div>
    </xsl:template>
</xsl:stylesheet>