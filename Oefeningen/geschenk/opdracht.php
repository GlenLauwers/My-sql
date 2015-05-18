<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Opdracht CRUD: CMS</title>
        <link rel="stylesheet" href="http://web-backend.local/css/global.css">
        <link rel="stylesheet" href="http://web-backend.local/css/facade.css">
        <link rel="stylesheet" href="http://web-backend.local/css/directory.css">
    </head>
    <body class="web-backend-opdracht">

    <style>

    form textarea, form input[type="text"]
    {
        padding:6px;
        width: 50%;
        font-size:16px;
    }
        
        article
        {
            padding:16px;
            margin-bottom: 16px;
        }

        article > h3
        {
            margin-top:0;
        }

        .non-active
        {
            background-color:#EEEEEE;
        }

    </style>
        
        <section class="body">
            
            <h1>Opdracht CRUD: CMS</h1>

            <ul>

                <li>De bedoeling van deze oefening is om het dashboard uit te breiden tot een bescheiden maar volwaardig Content Management System (CMS), denk aan WordPress of Drupal. Dit gebeurt door een toevoeging van een blog-module.</li>

                <li>Moest je dit nog niet gedaan hebben, maak dan een aparte map aan voor deze oefening.</li>

                <li>
                    Deze oefening bouwt verder op de opdracht-security-login
                    <ul>
                        <li>Maak een kopie van deze opdracht</li>

                        <li>Kopieer de database van opdracht-security-login naar een nieuwe opdracht-crud-cms, zo komen beide opdrachten niet met elkaar in conflict.</li>

                        <li>Controleer nadat je de bestanden en database hebt gekopiëerd dat opdracht-crud-cms werkt zoals het hoort en beginnen dan pas met verder te bouwen</li>
                    </ul>
                </li>

                <li>Je zal veel code kunnen hergebruiken van voorgaande oefeningen. Dit mag (en is zelfs aan te raden), op voorwaarde dat je er zeker van bent dat je de gekopiëerde code 100% begrijpt.</li>
            </ul>

            <h1>Opdracht CRUD: CMS - Stap 1: dashboard</h1>

            <ul>
                <li>dashboard.php moet er nu ongeveer als volgt uitzien:
                    
                     <div class="facade-minimal" data-url="http://www.app.local/dashboard.php">

                        <p><a href="">Terug naar dashboard</a> | Ingelogd als test@test.be | <a href="">uitloggen</a></p>   
                        
                        <h1>Dashboard</h1>
                        
                        <ul>
                            <li><a href="">Artikels</a></li>
                        </ul>
                    </div>
                </li>

                <li>Bovenaan moet vermeld worden wie er is ingelogd. Doe dit op basis van het e-mailadres in de cookie</li>

                <li>Artikels is een link die verwijst naar artikel-overzicht.php</li>
            </ul>

            <h1>Opdracht CRUD: CMS - Stap 2: artikels overzicht</h1>

            <ul>
                <li>
                    Maak de pagina artikel-overzicht.php aan. Deze ziet er als volgt uit:

                    <div class="facade-minimal" data-url="http://www.app.local/artikel-overzicht.php">
                        
                        <p><a href="">Terug naar dashboard</a> | Ingelogd als test@test.be | <a href="">uitloggen</a></p>   
                        
                        <h1>Overzicht van de artikels</h1>
                        
                        <p>Geen artikels gevonden</p>

                        <p><a href="">Voeg een artikel toe</a></p>

                    </div>
                </li>

                <li>'Terug naar overzicht' is een link die verwijst naar dashboard.php</li>

                <li>'Voeg een artikel toe' is een link die verwijst naar artikel-toevoegen-form.php</li>

                <li>De functionaliteit van deze pagina, een overzicht van alle artikels, komt pas aan bod in <a href="#stap-3">stap 3</a>, van zodra we artikels kunnen toevoegen.</li>
            </ul>

            <h1 id="">Opdracht CRUD: CMS - Stap 3: artikels toevoegen</h1>

            <ul>
                <li>
                    
                    <div class="facade-minimal" data-url="http://www.app.local/artikel-toevoegen-form.php">
                        
                        <p><a href="">Terug naar dashboard</a> | Ingelogd als test@test.be | <a href="">uitloggen</a></p>   
                 
                        <p><a href="">Terug naar overzicht</a></p>    

                        <h1>Artikel toevoegen</h1>

                        <form>
                            
                            <ul>
                                <li>
                                    <label for="titel">Titel</label>
                                    <input type="text" id="titel" name="titel">
                                </li>

                                <li>
                                    <label for="artikel">Artikel</label>
                                    <textarea id="artikel" name="artikel"></textarea>
                                </li>

                                <li>
                                    <label for="kernwoorden">Kernwoorden</label>
                                    <input type="text" id="kernwoorden" name="kernwoorden">
                                </li>

                                <li>
                                    <label for="datum">Datum (dd-mm-jjjj)</label>
                                    <input type="text" id="datum" name="datum">
                                </li>

                                <input type="submit" value="Artikel toevoegen">
                            </ul>

                        </form>

                    </div>

                </li>

                <li>Maak dus een tabel artikels aan, hierin komen de volgende velden:
                    <ul>
                        <li>id (pk)</li>
                        <li>titel (text)</li>
                        <li>artikel (text)</li>
                        <li>kernwoorden (text)</li>
                        <li>datum (date)</li>
                        <li>is_active (int) (default value: 0)</li>
                        <li>is_archived (int) (default value: 0)</li>
                    </ul>
                </li>

                <li>De <code>action</code> van het <code>&lt;form&gt;</code> verwijst naar artikel-toevoegen-process.php</li>

                <li>Wanneer er op 'Artikel toevoegen' wordt geklikt, moet er een artikel aan de database toegevoegd worden.</li>

                <li>Wanneer het artikel succesvol aan de database werd toegevoegd, redirect dan naar de artikel-overzicht.php pagina en toon de gepaste boodschap (bv. "Het artikel werd succesvol toegevoegd")</li>

                <li>Wanneer het artikel niet toegevoegd kon worden, blijf dan op de huidige pagina en toon de gepaste boodschap (bv. "Het artikel kon niet toegevoegd worden."</li>
            </ul>

            <h1>Opdracht CRUD: CMS - Stap 4: artikel overzicht uitbreiden</h1>

            <ul>
                <li>Breid de pagina artikel-overzicht.php uit zodat er nu een overzicht wordt getoond van alle artikels die in de database zitten. Dat ziet er ongeveer als volgt uit:

                    <div class="facade-minimal" data-url="http://www.app.local/artikel-overzicht.php">
                        
                        <p><a href="">Terug naar dashboard</a> | Ingelogd als test@test.be | <a href="">uitloggen</a></p>   
                        
                        <h1>Overzicht van de artikels</h1>

                        <p><a href="">Voeg een artikel toe</a></p>

                        <article class="non-active">
                            
                            <h3>CMS-test</h3>

                            <ul>
                                <li>Artikel: Inhoud van het artikel CMS-test</li>
                                <li>Kernwoorden: CMS, PHP</li>
                                <li>Datum: 13-11-2016</li>
                            </ul>

                            <a href="">artikel wijzigen</a> | <a href="">artikel activeren</a> | <a href="">artikel verwijderen</a>
                            
                        </article>

                        <article class="non-active">
                            
                            <h3>PHP is awesome!</h3>

                            <ul>
                                <li>Artikel: Zeker weten.</li>
                                <li>Kernwoorden: PHP</li>
                                <li>Datum: 29-12-2016</li>
                            </ul>

                            <a href="">artikel wijzigen</a> | <a href="">artikel activeren</a> | <a href="">artikel verwijderen</a>

                        </article>

                        <article>
                            
                            <h3>Rosetta landt op komeet Comet 67P/Churyumov-Gerasimenko</h3>

                            <ul>
                                <li>Artikel: De missie werd in 2004 opgestart en de reis heeft in totaal meer dan 10 jaar geduurd.</li>
                                <li>Kernwoorden: ESA, komeet, Space Travel</li>
                                <li>Datum: 12-11-2014</li>
                            </ul>

                            <a href="">artikel wijzigen</a> | <a href="">artikel deactiveren</a> | <a href="">artikel verwijderen</a>

                        </article>

                    </div>

                    <li>Artikels die gearchiveerd zijn (= artikel verwijderen), worden niet in het overzicht getoond.</li>

                    <li>
                        Standaard zijn alle artikels niet geactiveerd.
                        <ul>
                            <li>Wanneer een artikel niet geactiveerd is, pas dan een klasse toe op het <code>&lt;article&gt;</code> element die het artikel grijs kleurt.</li>

                            <li>Als het artikel actief is ( is_active = 1 ) moet er in de linktekst 'artikel deactiveren' staan, wanneer het artikel niet actief is ( is_active = 0 ) moet er 'artikel activeren' staan. <span class="tip">Je kan dit makkelijk met een shorthand if-statement oplossen.</span></li>
                        </ul>
                    </li>

                    <li>De link 'artikel wijzigen' verwijst naar artikel-wijzigen-form.php (zie <a href="#stap-5">stap 5</a>)
    
                        <ul>
                            <li>Deze link bevat een get-variabele met als key <code>artikel</code> en als value de primary key (=ID) van het artikel. Dat ziet er bv. als volgt uit: artikel-wijzigen-form.php?artikel=2</li>
                        </ul>
                        

                    </li>

                    <li>
                        De link 'artikel activeren' verwijst naar artikel-activeren.php

                        <ul>
                            <li>Deze link bevat een get-variabele met als key <code>artikel</code> en als value de primary key (=ID) van het artikel. Dat ziet er bv. als volgt uit: artikel-activeren.php?artikel=2</li>

                            <li>De artikel-activeren.php pagina 'toggled' de is_active waarde van het artikel met een bepaald ID. <span class="tip">Je kan een toggle waarbij 0 naar 1 moet omgezet worden en 1 naar 0 verwoorden via een makkelijke wiskundige formule die je ook naar MySQL syntax kan vertalen. Even Googlen? </span></li>

                            <li>Als de is_active waarde getoggled is, redirect dan naar artikel-wijzigen.php en toon een gepaste boodschap (bv. "Het artikel werd succesvol geactiveerd").</li>
                        </ul>
                    </li>

                    <li>
                        De link 'artikel verwijderen' verwijst naar artikel-verwijderen.php

                        <ul>
                            <li>Deze link is gelijkaardig aan de link van 'artikel (de)activeren'.</li>

                            <li>Deze link bevat een get-variabele met als key <code>artikel</code> en als value de primary key (=ID) van het artikel. Dat ziet er bv. als volgt uit: artikel-verwijderen.php?artikel=2</li>

                            <li>De artikel-verwijderen.php pagina is geen 'toggler', maar zet de is_archived waarde van dat bepaalde artikel op 1.</li>
                        </ul>
                    </li>

                </li>
            </ul>

            <h1 id="stap-5">Opdracht CRUD: CMS - Stap 5: artikel wijzigen</h1>

            <ul>

                <li>
                    Deze pagina is het formulier waarop je een bestaand artikel kan wijzigen
                    
                    <div class="facade-minimal" data-url="http://www.app.local/artikel-wijzigen-form.php?artikel=2">
                            
                        <p><a href="">Terug naar dashboard</a> | Ingelogd als test@test.be | <a href="">uitloggen</a></p>   
                 
                        <p><a href="">Terug naar overzicht</a></p>    

                        <h1>Artikel wijzigen</h1>

                        <form>
                            
                            <ul>
                                <li>
                                    <label for="titel">Titel</label>
                                    <input type="text" id="titel" name="titel" value="Rosetta landt op komeet Comet 67P/Churyumov-Gerasimenko">
                                </li>

                                <li>
                                    <label for="artikel">Artikel</label>
                                    <textarea id="artikel" name="artikel">De missie werd in 2004 opgestart en de reis heeft in totaal meer dan 10 jaar geduurd.</textarea>
                                </li>

                                <li>
                                    <label for="kernwoorden">Kernwoorden</label>
                                    <input type="text" id="kernwoorden" name="kernwoorden" value="ESA, komeet, Space Travel">
                                </li>

                                <li>
                                    <label for="datum">Datum (dd-mm-jjjj)</label>
                                    <input type="text" id="datum" name="datum" value="12-11-2014">
                                </li>

                                <input type="submit" value="Artikel wijzigen">
                            </ul>

                        </form>

                    </div>

                </li>
                
                <li>Deze pagina controleert of de get-variabele geset is.

                    <ul>
                        <li>De gegevens van het artikel dat overeenstemt met het id dat in de get-variabele terug te vinden is worden opgehaald.</li>

                        <li>Deze gegevens worden vervolgens ingevuld in het formulier.</li>

                        <li>Vergeet niet gebruik te maken van een manier om het ID in het formulier te verwerken. Een input type hidden is de ideale manier. De gebruiker mag dit ID uiteraard niet zelf aanpassen, maar het is wel nodig om een verwijzing te behouden naar het artikel wanneer alle gegevens gewijzigd worden.</li>
                    </ul>

                </li>

                <li>
                    Het formulier heeft als action artikel-wijzigen.php en werkt uiteraard met een <code>POST</code> method
    
                    <ul>
                        <li>Deze pagina staat in voor het wijzigen van het artikel in de database</li>

                        <li>Voer een update-query uit op basis van de inputvelden die je uit de <code>$_POST</code>-array haalt</li>

                        <li>Redirect naar de juiste pagina wanneer een update al dan niet kon uitgevoerd worden en toon een gepaste boodschap.
                            
                            <ul>
                                <li>Als er iets mis ging: redirect naar artikel-wijzigen-form.php</li>

                                <li>Als de wijziging succesvol was: redirect naar artikel-overzicht.php</li>
                            </ul>

                        </li>
                    </ul>
                </li>

            </ul>

            <h1>Uitbreiding: Tracking Details</h1>

            <ul>
                
                <li>Maak een aparte tabel 'tracking_details' aan. De kolommenstructuur vind je terug in het voorbeeld security-tracking-details.</li>

                <li>Voeg in de artikel-tabel een kolom 'tracking_details_id' toe om de tracking_details-tabel aan de artikel-tabel te kunnen linken</li>

                <li>Per keer dat er een artikel wordt aangemaakt, gewijzigd (inclusief (de)activeren) of verwijderd, moet de overeenstemmende tracking_details-rij geüpdated worden, inclusief het id van de persoon die de handeling heeft uitgevoerd en de datum waarop dit gebeurde.</li>

            </ul>
            
        </section>
        
    </body>
</html>
