
# ðŸŒŽ PiattaSisma ðŸŒŽ #
-----------------------------------------------------

## Progetto Piattaforme Digitali per la gestione del territorio ##

### Appello: ###
* Primo appello sessione estiva 2017/2018

### Alunni: ###
* Andrea Mancini
  * Matricola: 276435
  * Username Github: Andrea101288
* Dawid WÃ„â„¢glarz
  * Matricola: 277268
  * Username Github: Radeox

-----------------------------------------------------

## Descrizione ##

Il progetto è composto da 3 punti principali:

* Realizzazione di API ( GET e POST ) in python 
* Implementazione di una piattaforma Web(php, js, css, bootstrap)
* Implementazione di due BotTelegram 
-----------------------------------------------------

## Relazione ##

* Realizzazione di API ( GET e POST ) in python per acquisizione di dati sismici da alcuni siti la quale mettono a disposizione OpenData tra cui:
    * INGV (Istituto Nazionale di Geofisica e Vulcanologia) --> http://cnt.rm.ingv.it/
    * USGS (United States Geological Survey) --> https://earthquake.usgs.gov/
    * Data.gov (U.S. Government’s open data) --> https://www.data.gov/
    
    * #Gli step dell'algoritmo implementato per l'acquisione dei dati che poi verrano restituiti in formato JSON sono i seguenti:#
    *  faccio la richiesta http per accedere ai dati che mi interessano
    *  Inizializzo un oggetto JSON che dovrà restituirmi la funzione che all'inizio sarà vuoto
    *  Controllo lo stato della richiesta e se è 200 vado avanti
    *  Faccio il Parse dell' XML
    *  Ora acquisisco i dati entrando in ogni sezione dell'XML prelevando quelli che mi interessano ( in ogni pagina può essere
    implementato in modo diverso)
    * Viene restituito l'oggetto in formato JSON che mi interessa
 
Gli step dell'algoritmo della post dei dati sul sito sono i seguenti:
 *// INSERIRE GLI STEP //

* Implementazione di una piattaforma Web(php, js, css, bootstrap) che utilizza le API descritte al punto precedente per la ricerca tra i vari OpenData e il posizionamento sulle mappe attravarso le API messe a disposizione da GoogleMaps
La piattafroma è stata creata in PHP ed è composta in totale da ? file :
    * Pagina di index, pagina iniziale della piattaforma dove si deve scegliere se fare il login o registrarsi
    * Pagina di registrazione dove vengono acquisiti i dati dell'utente ch voglia iscriversi al sito.
    * Pagina controlloRegistrazione dove si effettuano i controlli per verificare se le credenziali che si vogliono registrare non siano già esistenti ed in caso si restituisce errore e si viene rimandati alla pagina principale. Se tutte le verifiche vanno a buon fine, si inseriscono i dati dell'utente in un Database.
    * Pagina di login dove vengono acquisiti i dati dell'utente ch voglia entrare nel sito.
    * Pagina controlloLogin dove si effettuano i controlli per verificare se le credenziali sono corrette per accedere, in caso contrario si viene rimandati alla pagina principale.
    * Pagina Contact us dove si possono trovare i contatti dei creatori del sito per qualsiasi evenienza
    * Pagina AboutUs dove si può leggere una piccola descrizione del progetto e il motivo per la quale è stato creato
    * PaginaInziale la pagina principale della piattaforma dove appare una mappa di Google Maps, una serie di filtri per effettuare alcune ricerche di location di terremoti che poi appariranno sulla mappa con una descrizione e il menù delle varie pagine.


* Implementazione di due BotTelegram i quali usano, oltre alle API stesse di Telegram, le API implementate per l'acquisizione di dati. Possono eseguire i seguenti comandi:

SismaBot ( Bot per l'utente )
    * /info che permette di avere informazioni in generale sul Bot
    * /help che permette di ricevere in dettaglio i comandi che può eseguire e come utilizzarli
    * /earthquakes che permette di ricevere una descrizione e la posizione di terremoti avvenuti nel raggio di 10 km da una location inviata dall'utente
    * /damage che permette di inviare una foto con una descrizione e la posizione in cui un terremoto abbia creato danni in modo da salvarli nella pagina web dedicata sulla piattaforma per essere poi visionata in caso da enti pubblici.

SUSismaBot ( Bot per responsabili o dipendenti di enti pubblici che seguono le pratiche sismiche )
    * /info che permette di avere informazioni in generale sul Bot
    * /help che permette di ricevere in dettaglio i comandi che può eseguire e come utilizzarli
    * /receiveDamage che permette di ricevere in tempo reale le descrizioni e le foto di danni postati da qualche utente in modo tal da effettuare in caso un sopralluogo.
    
    
