<!---
/* ==================================================== */
/* check date                                           */
/* 13.07.2002 Thomas Wiedmann   create                  */
/* 16.07.2002 Thomas Wiedmann   add yyyy-MM-dd          */
/* 13.08.2002 Thomas Wiedmann   parseInt(x,10) Decimal  */
/* 15.08.2002 Thomas Wiedmann   leading zero            */
/*                                                      */
/* sDate =  DateString to check                         */
/* sFormat = "dd.MM.yyyy" or "MM/dd/yyyy" or yyyy-MM-dd */
/* ==================================================== */

/**
* EL140802 = Modifications by Elpidio Latorilla 14.08.02
*/

function validDate(objDate,sFormat)
{   
   sDate=objDate.value;  /* EL140802 */

   if((sDate == "" )||(sDate==" ")) return; /* EL140802 */

   var sLang = ""; /* Language type */
   var nSize = 0;  /* size sDate */
   var sTempDate = ""; /* WorkString */

   var nDay = 0, nMonth = 0, nYear = 0;
   var sDay = "", sMonth = "", sYear = "";
   var bIsLeapYear = false;
   var bOk = true;
   var bDebug = true;
   var sErrorMsg= "Fecha invalida" + ":\n";  /* EL140802 */

   var sLangTemp=""; /* indonesian time format dd/MM/yyyy. Added 2003-11-20.  */

   /* check format */
   if ( sFormat == "dd.MM.yyyy" )  /* german */
   { sLang = "DE"; }
   else if ( sFormat == "yyyy-MM-dd" ) /* german ISO8601 */
   { sLang = "DE8601"; }
   else if ( sFormat == "MM/dd/yyyy" ) /* english */
   { sLang = "EN"; }
   else if (sFormat == "dd/mm/yyyy") /* Indonesian */
   { sLang = "ID";}
   else
   {// if (bDebug)
     { //alert("wrong sFormat");
	   sErrorMsg+= "Fecha invalida" + "\n"; /* EL140802 */
     }
     bOk = false;
   }
 
   /* ============== */
   /* I. check sDate */
   /* ============== */
   nSize = sDate.length;

   /* ================================================ */
   /* I.1 think about some leading zero    15.08.2002  */
   /* ================================================ */
   /* DE dmmyy, dmmyyyy, d.mm.yyyy       */
   /* DE8601 ymmdd, yyymmdd, yyy-mm-dd   */
   /* EN mddyy, mddyyyy, m/dd/yyyy       */
   if(nSize<5) 
   {
   	bOk = false;
   }else{

	if ((nSize == 5) || (nSize == 7) || (nSize == 9))
	{
		sDate = "0" + sDate;
		nSize = sDate.length;
	}
	 /* check DE ddmmyyyy or dd.mm.yy */
     
	if ((nSize == 8) && ( sLang == "DE"))
	{
		if (sDate.substr(2,1) == ".")
		{ nSize = nSize +1; }
	}

	/* check DE8601 yyyymmdd or yy-mm-dd */
	if ((nSize == 8) && ( sLang == "DE8601"))
	{
		if (sDate.substr(2,1) == "-")
		{ nSize = nSize +1; }
	}

   /* check EN mmddyyyy or mm/dd/yy */
   if ((nSize == 8) && (( sLang == "EN")||( sLang == "ID")))
   {
     if (sDate.substr(2,1) == "/")
       { nSize = nSize +1; }
   }

   /*
   If the sLang == ID, we save it temporarily and simulate to be sLang ==  DE
   Addition to accomodate the indonesian time format. Added 2003-11-20.
   */
   if (sLang=="ID") {
     sLangTemp="ID";
	    sLang="DE";
   }else{
     sLangTemp="";
   }
   
   /* =============== */
   /* II. check sDate */
   /* =============== */

   switch (nSize)
   {
     case 0: break;

     case 6 : /* ddMMyy, yyMMdd, MMddyy */
     { if (isNaN(sDate) == true)
       { //alert("no numeric sDate");
		 sErrorMsg+= errNotNumeric + "\n"; /* EL140802 */
       }
       else
       {
         switch (sLang)
         {
           case "DE" :
           {
             nDay = parseInt(sDate.substr(0,2),10);
             nMonth = parseInt(sDate.substr(2,2),10);
             nYear = parseInt(sDate.substr(4,2),10);

             /* check Y2K */
             if (nYear < 70)
             {
               nYear = nYear + 2000;
             }
             else
             {
               nYear = nYear + 1900;
             }

             /* alert(nDay + " " + nMonth + " " + nYear); */
             break;
           }
           case "DE8601" :
           {
             nYear = parseInt(sDate.substr(0,2),10);
             nMonth = parseInt(sDate.substr(2,2),10);
             nDay = parseInt(sDate.substr(4,2),10);


             /* check Y2K */
             if (nYear < 70)
             {
               nYear = nYear + 2000;
             }
             else
             {
               nYear = nYear + 1900;
             }

             /* alert(nDay + " " + nMonth + " " + nYear); */
             break;
           }

           case "EN" :
           {
             nMonth = parseInt(sDate.substr(0,2),10);
             nDay = parseInt(sDate.substr(2,2),10);
             nYear = parseInt(sDate.substr(4,2),10);

             /* check Y2K */
             if (nYear < 70)
             {
               nYear = nYear + 2000;
             }
             else
             {
               nYear = nYear + 1900;
             }
             break;
           }
           default:
           break;
         } /* end switch(sLang) */
       }
      break;
     }

     case 8 : /* ddMMyyyy */
     { if (isNaN(sDate) == true)
       {
         if (bDebug)
                 {
                    //alert("not numeric sDate or dd.MM.yy");
		            sErrorMsg+= errNotNumeric + "\n"; /* EL140802 */
                 }
         bOk = false;
       }
       else
       {
         switch (sLang)
         {
           case "DE" :
           {
             nDay = parseInt(sDate.substr(0,2),10);
             nMonth = parseInt(sDate.substr(2,2),10);
             nYear = parseInt(sDate.substr(4,4),10);
             break;
           }
           case "DE8601" :
           {
             nYear = parseInt(sDate.substr(0,4),10);
             nMonth = parseInt(sDate.substr(4,2),10);
             nDay = parseInt(sDate.substr(6,2),10);
             break;
           }
           case "EN" :
           {
             nMonth = parseInt(sDate.substr(0,2),10);
             nDay = parseInt(sDate.substr(2,2),10);
             nYear = parseInt(sDate.substr(4,4),10);
             break;
           }
           default:
           break;
         } /* end switch(sLang) */
       }
       break;
     }
     case 9 : /* dd.MM.yy  8+1  */
     {
         switch (sLang)
         {
           case "DE" :
           {
             nDay = parseInt(sDate.substr(0,2),10);
             nMonth = parseInt(sDate.substr(3,2),10);
             nYear = parseInt(sDate.substr(6,2),10);

             /* check Y2K */
             if (nYear < 70)
             {
               nYear = nYear + 2000;
             }
             else
             {
               nYear = nYear + 1900;
             }


             break;
           }
           case "DE8601" :
           {
             nYear = parseInt(sDate.substr(0,2),10);
             nMonth = parseInt(sDate.substr(3,2),10);
             nDay = parseInt(sDate.substr(6,2),10);

             /* check Y2K */
             if (nYear < 70)
             {
               nYear = nYear + 2000;
             }
             else
             {
               nYear = nYear + 1900;
             }
             break;
           }

           case "EN" :
           {
             nMonth = parseInt(sDate.substr(0,2),10);
             nDay = parseInt(sDate.substr(3,2),10);
             nYear = parseInt(sDate.substr(6,2),10);

             /* check Y2K */
             if (nYear < 70)
             {
               nYear = nYear + 2000;
             }
             else
             {
               nYear = nYear + 1900;
             }
             break;
           }
           default:
           break;
         } /* end switch(sLang) */
       break;
     }
     case 10 : /* dd.MM.yyyy   */
     {
         switch (sLang)
         {
           case "DE" :
           {
             nDay = parseInt(sDate.substr(0,2),10);
             nMonth = parseInt(sDate.substr(3,2),10);
             nYear = parseInt(sDate.substr(6,4),10);
             break;
           }
           case "DE8601" :    /* yyyy-MM-dd */
           {
             nYear = parseInt(sDate.substr(0,4),10);
             nMonth = parseInt(sDate.substr(5,2),10);
             nDay = parseInt(sDate.substr(8,2),10);
             break;
           }
           case "EN" :
           {
             nMonth = parseInt(sDate.substr(0,2),10);
             nDay = parseInt(sDate.substr(3,2),10);
             nYear = parseInt(sDate.substr(6,4),10);
             break;
           }
           default:
           break;
         } /* end switch(sLang) */
       break;
     }
     default :
     { if (bDebug)
           { //alert("wrong sDate size");
		     sErrorMsg+= "Fecha incorrecta" + "\n"; /* EL140802 */
           }
       bOk = false;
     }
     break;
   }  /* switch (nSize) */


   /* check LeapYear */
   if (nYear % 400 == 0)
   { bLeapYear = true; }
   else if (nYear % 100 == 0)
   { bLeapYear = false; }
   else if (nYear % 4 == 0)
   { bLeapYear = true; }
   else
   { bLeapYear = false;
   }

   /* check nYear must between 1800 and 9999 */
   /* EL140802 */
   if ((nYear < 1800) || (nYear > 9999))
   { if (bDebug)
     { //alert ("wrong year");
       sErrorMsg+= "Fecha incorrecta"+ "\n"; /* EL140802 */
     }
     bOk = false;
   }

   /* check nMonth */
   /* EL140802 */
   if ((nMonth < 1) || (nMonth > 12))
   { if (bDebug)
     { //alert ("wrong month");
       sErrorMsg+= "Fecha incorrecta" + "\n"; /* EL140802 */
     }
     bOk = false;
   }
   /* check nDay */
   if ((nDay >= 1) && (nDay <= 31))
   {
     switch(nMonth)
     {
       case 1,3,5,7,8,10,12:
        { break; }
       case 2:
        { if ((bLeapYear == true) && (nDay <= 29))
          {}
          else
          {
            if (nDay <= 28)
            {}
            else
            { if (bDebug)
              { //alert("wrong day");
                sErrorMsg+= "Fecha incorrecta" + "\n"; /* EL140802 */
              }
              bOk = false;
            }
          }
         break;
        }
       case 4,6,9,11:
        { if (nDay <= 30)
          {}
          else
          { if (bDebug)
            { //alert("wrong day");
              sErrorMsg+= "Fecha incorrecta"+ "\n"; /* EL140802 */
            }
           bOk = false;
          }
          break;
        }
       default:
       { }
     }
   }
   else
   { if (bDebug)
     { //alert ("wrong day");
       sErrorMsg+= "Fecha incorrecta"+ "\n"; /* EL140802 */
     }
     bOk = false;
   }
}

   /* -- Result of check */
   if (bOk)
   {
     /* formatting back to string to get some leading zero */
     sDay = "";
     if (nDay < 10)
     { sDay = '0' + nDay.toString(10);
     }
     else
     { sDay = nDay.toString(10);
     }

     sMonth = "";
     if (nMonth < 10)
     { sMonth = '0' + nMonth.toString(10);
     }
     else
     { sMonth = nMonth.toString(10);
     }

     sYear = nYear.toString(10);
	 
     /* Check if the real sLang format was ID 
        Addition to accomodate the indonesian time format. Added 2003-11-20.
       */
     if(sLangTemp == "ID") sLang="ID";
   
        /* Date result */
      if (sLang == "DE") { 
         objDate.value=sDay + "." + sMonth + "." + sYear ;
      } else if (sLang == "DE8601") {
         objDate.value=sYear + "-" + sMonth + "-" + sDay ;
      } else if (sLang == "EN") { 
         objDate.value=sMonth + "/" + sDay + "/" + sYear ;
      } else if (sLang == "ID") { 
         objDate.value=sDay + "/" + sMonth + "/" + sYear ;
      } else {
         objDate.value = "";
      }
      return true;
   } else {
     /* found some error */

      //alert(sErrorMsg);  /* EL140802 */
      alert("Fecha incorrecta");
      objDate.value = '';
     // objDate.select();
     // objDate.Focus();
     
      return false;

     /**
     * Die focus() & select() funktionen tun offensichtlich nicht richtig bei Mozilla.
     * Wir brauchen hier cross-programming.
     */
   }
}

function setDate(elindex, date_format, lang){
  
    var make_time = 0;
	var actual = '';
   
    /* Prepare the language dependent shortcuts */
	switch(lang.toLowerCase())
	{
	   case 'de': today = 'h';  // h = heute
	              yesterday = 'g';  // g = gestern
				  break;
	   case 'it': today = 'o';       // o = oggi
	              yesterday = 'i';   // i = ieri
				  break;
	   case 'es':  today = 'h';       // h = hoy
	              yesterday = 'a';   // a = ayer
				  break;
	   case 'fr':  today = 'a';       // h = aujourd'hui
	              yesterday = 'h';   // a = hier
				  break;

	   default: today = 't';         // t = today
	            yesterday = 'y';     // y = yesterday
	}

	/* Extract the value of the input element an convert to lower case to be sure */
	buf = elindex.value;

    buf = buf.toLowerCase();
	buf = buf.charAt(buf.length - 1);
  
	/* Check whether it is a possible shortcut */
	if (((buf<".")|| (buf > "9")) && (buf!="/") && (buf!='-'))
    {   
	    /* Get the date today */
	    jetzt=new Date();
	    datum=jetzt.getDate();
	    monat=jetzt.getMonth();
	    jahr=jetzt.getFullYear();

		if(buf == today)
		{
		    make_time = 1;
		}
	    else if(buf == yesterday)  //* If yesterday, move one day backwards
		{
			datum--;

			if(datum<1)
			{
				datum = 1;
				monat--;

				if(monat<0)
				{
					monat = 0;
					jahr--;
				}
			}

			make_time =1;
		}
		else
		 {
		       actual=''; //* Set to empty to erase the input
		 }

		//* If a short cut compose date according to format
		if(make_time == 1)
		{

		    //* Adjust month to correspond to 12 = December, 1 = January, etc.
	        monat++;

			//* Adjust the day and month to show 1= '01' etc.
		    if (datum<10) datum="0" + datum;
	        if (monat<10) {monat="0" + monat;}


	        //* Now compose the date according to the format
		    switch(date_format.toLowerCase())
		    {
		        case 'yyyy-mm-dd': actual = jahr + '-' + monat + '-' + datum;
				                    break;
				case 'dd.mm.yyyy':  actual = datum + '.' + monat + '.' + jahr;
				                    break;
				case 'mm/dd/yyyy':  actual = monat + '/' + datum + '/' + jahr;
				                   break;
				case 'dd/mm/yyyy':  actual = datum + '/' + monat + '/' + jahr;
				                    break;
	            //default: actual = jahr + '-' + monat + '-' + datum; //* Default format is the standard yyyy-mm-dd
				default: actual = ""; // Return empty by default
			}

	   }

	    elindex.value=actual; //* Now set the value of the element
	    return true;
	}
	else
	{
	   return false;
	}
}

function setTime(indexel, lang, sec_flag){

    var now = 'n';             //* n = now  , default
	var now_2 = 'n'           //* n = now  , default (in case of multiple letters)
	var separator = ':';       //* default separator

	//* Prepare the trigger input based on the current user language
    switch(lang)
	{
	   case 'de': now = 'j';         //*j = jetzt
	              now_2 = 'j';       //*j = jetzt
				  separator = '.';
				  break;
	   case 'it': now = 'a';         //* a = adesso
				  now_2 = 'a';       //* a = adesso
				  break;
	   case 'es': now = 'y';         //* y = Ya
	              now_2 = 'i';       //* i = inmediatamente
				  break;
	   case 'es': now = 'm';         //* y = maintenant
	              now_2 = 'm';       //* i = maintenant
				  break;
	}

	time=new Date();

	zeit=''; // Default is empty string to erase the input

	//* Prepare the time
	min=time.getMinutes();
	if (min<10) min="0" + min;
	stunde=time.getHours();
	if (stunde<10) stunde="0" + stunde;

	//* Extract the input value and convert to lower case to be sure
	buf = indexel.value;

	buf = buf.toLowerCase();

	//* If it is shortcut, compose the time
	if ((buf<".")||(buf>"9")||(buf=="/")){
		if((buf== now) || (buf == now_2)) {
			zeit=stunde + separator + min;

			//* if seconds flag is set, append seconds
			if(sec_flag == 1)
			{
	            sekunde=time.getSeconds();
	            if (sekunde<10) sekunde="0" + sekunde;
			    zeit = zeit + separator + sekunde;
		    }
		}

		indexel.value=zeit;  //* Set the time in the input element

		return true;
	}
	else
	{
	    return false;
	}
}
// this js file needs the setdatetime.js file
function isvalidtime(d, lang)
{
	val=d.value;
	if (isNaN(val))
	{
		xval3="";
		for(i=0;i<val.length;i++)
		{
		xval2=val.slice(i,i+1);
		//if (!isNaN(xval3 + xval2)) {xval3=xval3 + xval2;}
		if (isNaN(xval2))
		 {
			d.value=xval2;
			setTime(d, lang);
			return;
			}
		}
		d.value=xval3;

	}
	else
	{
		v3=val;
		if((v3==24)&&(v3.length==2)) v3="00";
		if (v3>24)
		{


			switch(v3.length)
			{

				case 2: v1=v3.slice(0,1); v2=v3.slice(1,2);
						if(v2<6) v3="0"+v1+"."+v2; else v3=v3.slice(0,1); break;
				case 3: v1=val.slice(0,2); v2=val.slice(2,3);

						if(v2<6) v3=v1+"."+v2;
							else v3=v3.slice(0,2);
						break;
				case 4: v3=val.slice(0,3); break;
			}


//			alert("Zeitangabe ist ungültig! (ausserhalb des 24H Zeitrahmens)");

		}
		switch(v3.length)
			{

				case 2: v1=v3.slice(0,1);v2=v3.slice(1,2);
						if(v2==".") v3="0"+v3;break;

				case 3: v1=v3.slice(0,2);v2=v3.slice(2,3);
						if(v2!=".") if(v2<6) v3=v1+"."+v2; else v3=v1; break;
				case 4: if(v3.slice(3,4)>5) v3=v3.slice(0,3); break;
			}
		if(v3.length>5) v3=v3.slice(0,v3.length-1);
		d.value=v3;
	}

}


/**
*  setTime will set the time according to the trigger input
*  the trigger input (a single letter) is language dependent
*  It is possible to enter one of two possible letters to generate the "now" time
*  param indexel = form object of the text type
*  param lang = the ISO language code
*  param sec_flag = optional flag for outputting the seconds
*  return true = the time is created and the time is inserted in the form element
*        else false = no time created and the input is erased
*  The output time separator char is also language dependent
*    e.g. german = '.' = 12.30
*    e.g. english or default = ':' = 12:30
*
*/
function setTime(indexel, lang, sec_flag){

    var now = 'n';             //* n = now  , default
	var now_2 = 'n'           //* n = now  , default (in case of multiple letters)
	var separator = ':';       //* default separator

	//* Prepare the trigger input based on the current user language
    switch(lang)
	{
	   case 'de': now = 'j';         //*j = jetzt
	              now_2 = 'j';       //*j = jetzt
				  separator = '.';
				  break;
	   case 'it': now = 'a';         //* a = adesso
				  now_2 = 'a';       //* a = adesso
				  break;
	   case 'es': now = 'y';         //* y = Ya
	              now_2 = 'i';       //* i = inmediatamente
				  break;
	   case 'es': now = 'm';         //* y = maintenant
	              now_2 = 'm';       //* i = maintenant
				  break;
	}

	time=new Date();

	zeit=''; // Default is empty string to erase the input

	//* Prepare the time
	min=time.getMinutes();
	if (min<10) min="0" + min;
	stunde=time.getHours();
	if (stunde<10) stunde="0" + stunde;

	//* Extract the input value and convert to lower case to be sure
	buf = indexel.value;

	buf = buf.toLowerCase();

	//* If it is shortcut, compose the time
	if ((buf<".")||(buf>"9")||(buf=="/")){
		if((buf== now) || (buf == now_2)) {
			zeit=stunde + separator + min;

			//* if seconds flag is set, append seconds
			if(sec_flag == 1)
			{
	            sekunde=time.getSeconds();
	            if (sekunde<10) sekunde="0" + sekunde;
			    zeit = zeit + separator + sekunde;
		    }
		}

		indexel.value=zeit;  //* Set the time in the input element

		return true;
	}
	else
	{
	    return false;
	}

}

function mktime() {
//mktime(start_hour,start_minute,0,start_month,start_day,start_year)
    var no, ma = 0, mb = 0, i = 0, d = new Date(), argv = arguments, argc = argv.length;
    d.setHours(0,0,0); d.setDate(1); d.setMonth(1); d.setYear(1972);
    var dateManip = {
    0: function(tt){ return d.setHours(tt); },
    1: function(tt){ return d.setMinutes(tt); },
    2: function(tt){ set = d.setSeconds(tt); mb = d.getDate() - 1; return set; },
    3: function(tt){ set = d.setMonth(parseInt(tt)-1); ma = d.getFullYear() - 1972; return set; },
    4: function(tt){ return d.setDate(tt+mb); },
    5: function(tt){ return d.setYear(tt+ma); }
    };

    for( i = 0; i < argc; i++ ){
        no = parseInt(argv[i]*1);

        if (isNaN(no)) {
        return false;
        } else {
        // arg is number, lets manipulate date object
            if(!dateManip[i](no)){
            // failed
            return false;
            }
        }
    }
return Math.floor(d.getTime()/1000);
}
-->
