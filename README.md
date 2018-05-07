# 🌎 PiattaSisma 🌍 #
-----------------------------------------------------

## Progetto Piattaforme Digitali per la gestione del territorio ##

### Appello: ###
* Primo appello sessione estiva 2017/2018

### Alunni: ###
* Andrea Mancini
  * Matricola: 276435
  * Username Github: Andrea101288
* Dawid Węglarz
  * Matricola: 277268
  * Username Github: Radeox

-----------------------------------------------------

## Descrizione ##

Il progetto _PiattaSisma_ si pone come obbiettivo:
* Raccogliere dati sismici da diverse fonti e resituirli in un formato standard.
* Catalogare i danni causati da eventi sismici e dare accesso a questi dati per eventuali studi/interventi.

-----------------------------------------------------

## Relazione ##

Il progetto è composto da 3 punti principali:

    * Realizzazione di un API (GET e POST) in Python (Django Framework)
    * Implementazione di una piattaforma Web (HTML, PHP, JS, CSS)
    * Implementazione di due BotTelegram (PHP e Python)

* Realizzazione di un API (GET e POST) con Django framework:
    * Acquisizione di dati sismici da alcuni siti la quale mettono a disposizione OpenData tra cui:
      * **INGV** (Istituto Nazionale di Geofisica e Vulcanologia) --> http://cnt.rm.ingv.it/
      * **USGS** (United States Geological Survey) --> https://earthquake.usgs.gov/
      * **Data.gov** (U.S. Government’s open data) --> https://www.data.gov/

    * Gli step dell'algoritmo per l'acquisione dei dati che poi verrano restituiti in formato JSON sono i seguenti:
        1. Effettuto una richiesta HTTP per accedere ai dati desiderati
        2. Controllo lo stato della richiesta, in caso sia andata a buon fine (codice 200) continuo
        3. Inizializzo un oggetto JSON che sarà resituito dalla funzione
        4. Effettuto il parsing dei dati forniti dal sito e li codifico nel nuovo JSON
        5. Restituisco il JSON

    * Gli step dell'algoritmo della post dei dati sul sito sono i seguenti:
        1. Decodifica la richiesta ricevuta
        2. Decodifica immagine in Base_64 e store
        3. Inizializzo un oggetto damage con i dati ottenuti dalla richiesta
        4. Store oggetto nel database 

* Implementazione di una piattaforma Web (HTML, PHP, JS, CSS) che utilizza le API descritte al punto precedente per la ricerca tra i vari OpenData e il posizionamento dei dati geografici sulla mappa fornita da Google Maps. La piattafroma è stata realizzata in PHP ed è composta dai seguesti file principali:
    * **Index**: pagina di benvenuto nella piattaforma dove si effettua il login o la registrazione
    * **Register**: acquiscisce i dati richiesti dal utente che verranno verificati dalla pagina "**RegisterCheck**". Se questi passano i controlli allora l'utente potrà entrare.
    * **Login**: semplice pagina che permette il login degli utenti registrati attaverso **LoginCheck** che verfica la corettezza delle credenzali immesse.
    * **homePage** la pagina principale della piattaforma dove appare una mappa che sarà popolata dai vari eventi restituiti dal API. Una serie di filtri permette di effettuare ricerche più o meno precise in base alla posizone o al tempo.
    * **ContactUs**: raccoglie i contatti dei creatori della piattaforma.
    * **AboutUs**: dove si può leggere una piccola descrizione del progetto e il motivo che ci hanno portato a realizarlo.
    * **Damages**: galleria dei danni  
    * **AddDamage**: dove si può caricare nuovi danni che verranno validati attraverso **DamageCheck**

* Implementazione di due BotTelegram i quali usano, oltre alle API di Telegram, le API implementate per l'acquisizione di dati. Possono eseguire i seguenti comandi:

  * **PiattaSismaBot** (Bot per l'utente)
    * _/earthquakes_ permette di ricevere la posizione e una descrizione dei terremoti avvenuti nel raggio di 10 km da una location specificata dall'utente.
    * _/damage_ permette di segnalare dei danni, causati da un certo terremoto, con una foto con posizione e eventuale descrizione.
    * _/info_ restituisce informazioni generiche sul Bot
    * _/help_ restituisce dettagli sui comandi e come utilizzarli

  * **TechSismaBot** (Bot per responsabili o dipendenti di enti pubblici che seguono le pratiche sismiche)
    * _/requestNotification_ che permette di ricevere in tempo reale le descrizioni e le foto di danni postati da qualche utente in modo tal da effettuare in caso un sopralluogo.
   
