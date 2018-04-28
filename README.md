# ðŸŒŽ PiattaSisma ðŸŒ #

-----------------------------------------------------

## Progetto Piattaforme Digitali per la gestione del territorio ##

### Appello: ###
* Primo appello sessione estiva 2017/2018

### Alunni: ###
* Andrea Mancini
  * Matricola: 276435
  * Username Github: Andrea101288
* Dawid WÄ™glarz
  * Matricola: 277268
  * Username Github: Radeox

-----------------------------------------------------

## Descrizione ##
#Il progetto è composto da 3 punti principali:#
* Realizzazione di API ( GET e POST ) in python 
* Implementazione di una piattaforma Web(php, js, css, bootstrap)
* Implementazione di due BotTelegram 
-----------------------------------------------------

## Relazione ##
#Il progetto è composto da 3 punti principali:#
* Realizzazione di API ( GET e POST ) in python per acquisizione di dati sismici da alcuni siti la quale mettono a disposizione OpenData
** INGV (Istituto Nazionale di Geofisica e Vulcanologia) --> http://cnt.rm.ingv.it/
** USGS (United States Geological Survey) --> https://earthquake.usgs.gov/
** Data.gov (U.S. Government’s open data) --> https://www.data.gov/

* Implementazione di una piattaforma Web(php, js, css, bootstrap) che utilizza le API descritte al punto precedente per la ricerca tra i vari OpenData e il posizionamento sulle mappe attravarso le API messe a disposizione da GoogleMaps

* Implementazione di due BotTelegram anch'essi che fanno uso delle API per l'acquisizione di dati i quali possono eseguire i seguenti comandi:
* ##SismaBot## ( Bot per l'utente )
** /info che permette di avere informazioni in generale sul Bot
** /help che permette di ricevere in dettaglio i comandi che può eseguire e come utilizzarli
** /earthquakes che permette di ricevere una descrizione e la posizione di terremoti avvenuti nel raggio di 10 km da una location inviata dall'utente
** /damage che permette di inviare una foto con una descrizione e la posizione in cui un terremoto abbia creato danni in modo da salvarli nella pagina web dedicata sulla piattaforma

* ##SUSismaBot## ( Bot per responsabili o dipendenti di enti pubblici che seguono le pratoche sismiche )
** /info che permette di avere informazioni in generale sul Bot
** /help che permette di ricevere in dettaglio i comandi che può eseguire e come utilizzarli
** /receiveDamage che permette di ricevere in tempo reale le descrizioni e le foto di danni postati da qualche utente in modo tal da ffettuare in caso un sopralluogo