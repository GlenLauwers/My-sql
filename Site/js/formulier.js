function valideren(){
    	//alert('start met valideren');
    	
    	//Naam is leeg
    		if( document.formulier.f_naam.value=="" )
    		{
    			document.formulier.f_naam.focus();
    			document.getElementById("fbpersoon").style.display = "block";
    			document.getElementById("fbpersoon").innerHTML="Naam is leeg.";
    			return false;
    		}

    	//Postcode is leeg
    		if( document.formulier.f_postcode.value=="" )
    		{
    			document.formulier.f_postcode.focus();
    			document.getElementById("fbpersoon").style.display = "block";
    			document.getElementById("fbpersoon").innerHTML="Postcode is leeg.";
    			return false;
    		}

    	//Postcode is niet gelijk aan 4 karakters
    		if( document.formulier.f_postcode.value.length!= 4 )
    		{
    			document.formulier.f_postcode.focus();
    			document.getElementById("fbpersoon").style.display = "block";
    			document.getElementById("fbpersoon").innerHTML="Postcode is niet correct.";
    			return false;
    		}

   		//Er staat een letter in
    		if ( isNaN ( document.formulier.f_postcode.value ))
    		{
    			document.formulier.f_postcode.focus();
    			document.getElementById("fbpersoon").style.display = "block";
    			document.getElementById("fbpersoon").innerHTML="Postcode is niet correct.";
    			return false;
    		}

    	//email is leeg
    		if( document.formulier.f_email.value=="" )
    		{
    			document.formulier.f_email.focus();
    			document.getElementById("fbpersoon").style.display = "block";
    			document.getElementById("fbpersoon").innerHTML="E-mailadres is leeg.";
    			return false;
    		}

    		else //controle op e-mailformaat
    		{
    			var emailOk = email_controleren();
    			if(emailOk == false)
    			{
    				return false;
    			}
    		}

    	//Naam van het dier is leeg
    		if( document.formulier.f_naam_dier.value=="" )
    		{
    			document.formulier.f_naam_dier.focus();
    			document.getElementById("fbpersoon").style.display = "block";
    			document.getElementById("fbpersoon").innerHTML="Naam van het dier is leeg.";
    			return false;
    		}

    	//Ras is leeg
    		if( document.formulier.f_ras.value=="" )
    		{
    			document.formulier.f_ras.focus();
    			document.getElementById("fbpersoon").innerHTML="Ras is leeg.";
    			return false;
    		}

    	//leeftijd is leeg
    		if( document.formulier.f_leeftijd.value=="" )
    		{
    			document.formulier.f_leeftijd.focus();
    			document.getElementById("fbpersoon").style.display = "block";
    			document.getElementById("fbpersoon").innerHTML="Leeftijd is leeg.";
    			return false;
    		}

    	//leeftijd is geen nummer
    		if ( isNaN ( document.formulier.f_leeftijd.value ))
    		{
    			document.formulier.f_leeftijd.focus();
    			document.getElementById("fbpersoon").style.display = "block";
    			document.getElementById("fbpersoon").innerHTML="Leeftijd is geen getal.";
    			return false;
    		}
    	}

    	function email_controleren()
    	{
    		var mailControle = document.formulier.f_email.value; // inhoud van mijn veld in var steken
    		//Zoekt naar het eerste karakter
    		var aapWaar = mailControle.indexOf("@"); //waar staat mijn @

    		//zoekt naar het laatste karakter
    		var puntWaar = mailControle.lastIndexOf("."); //waar staat punt

    		//positie van @ moet min. 1 zijn. (tweede plaats)

    		if(aapWaar <1 || (puntWaar - aapWaar <3) || (puntWaar+2>=mailControle.length))
    		{
    			document.formulier.f_email.focus();
    			document.getElementById("fbpersoon").style.display = "block";
    			document.getElementById("fbpersoon").innerHTML="E-mailadres is niet juist";
    			return false;
    		}
			
			return true;
    		
    	}