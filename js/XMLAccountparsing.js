window.addEventListener("load", ajaxGetForm);
var xml_Account = "<UserAccount></UserAccount>";
var xmlDoc= loadXMLString(xml_Account);

function ajaxGetFormXML(){
    var http_request= new XMLHttpRequest();
    http_request.open("GET","php/account_xml.php",false);
    http_request.send();
    var xml = http_request.responseXML;
    return xml;
}

function ajaxGetFormXSLT(){
    var http_request= new XMLHttpRequest();
    http_request.open("GET","XSLT/UserAccount.xslt",false);
    http_request.send();
    var xslt = http_request.responseXML;
    return xslt;
}

function ajaxGetForm(){
    var xml = ajaxGetFormXML();
    var xslt = ajaxGetFormXSLT();
    var processor = new XSLTProcessor();
    processor.importStylesheet(xslt);
    const Form = document.getElementById("Form");
    Form.innerHTML ="";
    const xsltResult = processor.transformToFragment(xml, document);
    Form.appendChild(xsltResult);
}

function ajaxUpdateForm(xml){
    var xslt = ajaxGetFormXSLT();
    var processor = new XSLTProcessor();
    processor.importStylesheet(xslt);
    const Form = document.getElementById("Form");
    Form.innerHTML ="";
    const xsltResult = processor.transformToFragment(xml, document);
    Form.appendChild(xsltResult);
}

function loadXMLString(txt){
    try{
        parser =new DOMParser();
        xmlDoc = parser.parseFromString(txt, "application/xml");
        return xmlDoc;
    }catch(e){
        alert.message(e);
    }
}
function getBrowser(){
    var browser = navigator.userAgent;
    if (browser.toLowerCase().indexOf('msie')>-1){
        return "ie";
    }
     
    if (browser.toLowerCase().indexOf('firefox')>-1){
        return "ff";
    }
      
    if(browser.toLowerCase().indexOf('chrome')>-1){
        return "chrome";
    }
        
    return "";
}

function encodeItems(){
    const ok = getForm();
    const browser = getBrowser();
    if(!ok){
        return false;
    }
    if(browser && ok){
        const xmlstring = new XMLSerializer().serializeToString(xmlDoc);
        const http_request = new XMLHttpRequest();
        http_request.open("POST", "php/update_user.php", true);
        http_request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        http_request.onreadystatechange = function(){
            if(http_request.readyState === 4){
                if(http_request.status === 200){
                    const xml = http_request.responseXML;
                    ajaxUpdateForm(xml);
                    alert("Account Updated Successfully!")
                }else{
                    alert("Server error");
                }
            }
        };
        http_request.send("txt_xml_Account=" + encodeURIComponent(xmlstring));
        return false;
    }
}

function getForm(){
    const Form = document.getElementById("accountForm");
    const Fname = Form.elements["FirstName"].value;
    const Lname = Form.elements["LastName"].value;
    const Email = Form.elements["Email"].value;
    const ContactNumber = Form.elements["ContactNumber"].value;
    const street=Form.elements["Street"].value;
    const city = Form.elements["City"].value;
    const password = Form.elements["password"].value;
    let Xmlvalid = insertAccount(Fname,Lname,Email,ContactNumber,street,city,password);
    return Xmlvalid;

}

function insertAccount(Fname,Lname,Email,ContactNumber,street,city,password){
    UserAccountNode = xmlDoc.childNodes[0];
    UserAccountNode.textContent = "";

    FnameNode = xmlDoc.createElement("FirstName");
    LnameNode = xmlDoc.createElement("LastName");
    EmailNode = xmlDoc.createElement("Email");
    ContactNumberNode =  xmlDoc.createElement("ContactNumber");
    StreetNode =  xmlDoc.createElement("Street");
    CityNode =  xmlDoc.createElement("City");
    PasswordNode =  xmlDoc.createElement("Password");

    if(Fname===""||Fname===null){
        alert("First Name is Empty !");
        return false;
    }else{
        FnameNode.appendChild(xmlDoc.createTextNode(Fname));
        UserAccountNode.appendChild(FnameNode);
    }

    if(Lname===""||Lname===null){
        alert("Last Name is Empty !");
        return false;
    }else{
        LnameNode.appendChild(xmlDoc.createTextNode(Lname));
        UserAccountNode.appendChild(LnameNode);
    }

    
    let Emailregex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if(Email===""|| Email===null){
        alert("Email is Empty !");
        return false;

    }else if(!Emailregex.test(Email)){
        alert("Invalid Email !");
        return false;

    }else{
        EmailNode.appendChild(xmlDoc.createTextNode(Email));
        UserAccountNode.appendChild(EmailNode);  
    }
    

    if (ContactNumber !== "") {
        if (!/^[0-9]{7,15}$/.test(ContactNumber)) {
            alert("Invalid Contact Number!");
            return false;
        }
        ContactNumberNode.appendChild(xmlDoc.createTextNode(ContactNumber));
        UserAccountNode.appendChild(ContactNumberNode);
    }

    if (street !== "" && street !== null) {
        if (street.trim() === "") {
            alert("Street cannot be only spaces!");
            return false;
        }
        StreetNode.appendChild(xmlDoc.createTextNode(street));
        UserAccountNode.appendChild(StreetNode);
    }

    if (city !== "" && city !== null) {
        if (city.trim() === "") {
            alert("City cannot be only spaces!");
            return false;
        }
        CityNode.appendChild(xmlDoc.createTextNode(city));
        UserAccountNode.appendChild(CityNode);
    }

    if (password !== "" && password !== null) {
        if (password.length < 6) {
            alert("Password must be at least 6 characters!");
            return false;
        }
        PasswordNode.appendChild(xmlDoc.createTextNode(password));
        UserAccountNode.appendChild(PasswordNode);
    }

    return true;

}