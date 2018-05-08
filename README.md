# 🌎 PiattaSisma 🌍 #
-----------------------------------------------------

## Progetto Piattaforme Digitali per la Gestione del Territorio ##

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

Il progetto _PiattaSisma_ si pone come obbiettivi primari:
* Raccogliere dati sismici da diverse fonti e resituirli in un formato standard
* Catalogare i danni causati da eventi sismici e dare accesso a questi dati per eventuali studi/interventi

-----------------------------------------------------

## Relazione ##

Il progetto è composto da 3 obbiettivi principali:
 * Realizzazione di un API (GET e POST) in Python (Django Framework)
 * Implementazione di una piattaforma Web (HTML, PHP, JS, CSS)
 * Implementazione di due BotTelegram (PHP e Python)
 
Altri obbiettivi secondari:
 * Sfruttare più linguaggi e tecnologie possibili
 * Condividere le conoscenze nel Team
 * HAVE FUN!

Lo scenario che abbiamo immaginato è il seguente, ma è importante notare che **questo progetto può essere ancora ampliato e arricchito con nuove funzionalità**.

<img src="img/scheme.png"/>

-----------------------------------------------------

### PiattaSisma API ###
* Realizzazione di un API (GET e POST) con Django framework e relativa [documentazione](https://app.swaggerhub.com/apis/RadeAndry9588/PiattaSismaAPI/1.0.0-oas3):
   * Acquisizione di dati sismici da alcuni siti la quale mettono a disposizione OpenData tra cui:
     * [**INGV** - Istituto Nazionale di Geofisica e Vulcanologia](http://cnt.rm.ingv.it/)
     * [**USGS** - United States Geological Survey](https://earthquake.usgs.gov/)
     * [**Data.gov** - U.S. Government’s open data](https://www.data.gov/)

   * Gli step dell'algoritmo per l'acquisizione dei dati sui terremoti, che poi verrano restituiti in formato GeoJSON, sono i seguenti:
     1. Effettuta una richiesta HTTP per accedere ai dati desiderati
     2. Effettuta il parsing dei dati ricevuti attraverso l'opportuna funziona
     3. Codifica i dati ottenuti che ci interessano in un nuovo GeoJSON
     5. Restituisce il GeoJSON

   * Gli step dell'algoritmo della POST dei danni sul sito sono i seguenti:
     1. Controlla che l'utente che ha mandato la richiesta esista nel database
     2. Decodifica la richiesta ricevuta
     3. Decodifica immagine (codificata in [Base64](https://it.wikipedia.org/wiki/Base64))
     4. Salva il nuovo oggetto danno nel database
     
I dati vengono raccolti da diversi siti attraverso dei [parser](https://it.wikipedia.org/wiki/Parsing) che estraggono i dati dal sito e li convertono in un formato standard ([GeoJSON](http://geojson.org)). I siti per cui abbiamo implementato dei parser sono tutti siti di Opendata in formato [QuakeML](https://en.wikipedia.org/wiki/QuakeML) ma pur essendo uno standard presentano ancora piccole differenze che non permettono la corretta interpretazione dei dati. Per questo abbiamo pensato di rendere i parser dei moduli che possono essere intergrati agilmente nel codice senza influire sul resto. Per questioni di dimensioni di dati richiesti tramite API abbiamo optato inserire di default un arco temporale di 30 gg poichè abbiamo notato che aumentando molto il numero di giorni le richieste comportano tempi importanti e soprattutto alcuni siti hanno un limite massimo di dati da trasmettere.

-----------------------------------------------------

### PiattaSisma (Client Web) ###

* Implementazione di una piattaforma Web (HTML, PHP, JS, CSS) che permetta di:
  * Aggiunta di nuovi danni causati da eventi sismici correlati da foto, descrizione e posizione del danno
  * Utilizzare le API descritte al punto precedente per la ricerca tra i vari OpenData e il posizionamento dei dati attraverso dei marker sulla mappa fornita da Google Maps
  * Gestire la registrazione e l'accesso degli utenti
  * Permette di amministrare dati e utenti attraverso un interfaccia admin
  
* La piattafroma è composta dai seguesti file principali:
  * **Index**: Pagina di benvenuto nella piattaforma dove si effettua il login e/o la registrazione
  * **Register**: Acquiscisce i dati richiesti dal utente che verranno verificati dalla pagina **RegisterCheck**. Se questi passano i controlli allora l'utente potrà entrare
  * **Login**: Semplice pagina che permette il login degli utenti registrati attaverso **LoginCheck** che verfica la corettezza delle credenzali immesse
  * **homePage**: Pagina principale della piattaforma dove appare una mappa che sarà popolata dai vari eventi restituiti dal API. Una serie di filtri permette di effettuare ricerche più o meno precise in base alla posizone e/o al tempo
  * **Damages**: Galleria dei danni
  * **AddDamage**: dove si può caricare nuovi danni che verranno validati attraverso **DamageCheck**
  * **AboutUs**: Si può trovare una piccola descrizione del progetto e il motivo che ci hanno portato a realizzarlo
  * **ContactUs**: Raccoglie i contatti dei creatori della piattaforma
  
-----------------------------------------------------

### PiattaSismaBot ###
<div>
<img src="img/add_damage.png" width="200px" align="left"/>

PiattaSismaBot è il bot pensato per gli utenti della piattaforma troppo ~~pigri~~ di fretta per poter usare il Client Web.
Il bot permettere di segnalare un danno in pochi semplici passi direttamente da Telegram sfruttando le API di PiattaSisma.
Questo bot è stato realizzato in PHP e si interfaccia alla API di Telegram in modo "nativo".

I comandi che il bot mette a disposizione sono i seguenti:

  * _/earthquakes_: permette di ricevere la posizione e una descrizione dei terremoti avvenuti nel raggio di 10km da una location specificata dall'utente
  * _/damage_: permette di segnalare dei danni causati da un terremoto con una foto, posizione e una breve descrizione
  * _/info_: restituisce informazioni generiche sul Bot
  * _/help_: restituisce dettagli sui comandi e come utilizzarli
</div><br>

-----------------------------------------------------

### TechSismaBot ###
<div> 
<img src="img/search_damage.png" width="200px" align="right"/>

TechSismaBot al contrario è ideato per poter consultare i danni che si sono verificati in una certa zona in un raggio di 10km. L'utente non deve far altro che mandare un comando e mandare la location desiderata per vedere tutti i dati.
 Questo bot è stato realizzato in Python e si interfaccia alla API di Telegram tramite la libreria [Telepot](https://github.com/nickoala/telepot)
 
I comandi che il bot mette a disposizione sono i seguenti:

  * _/get\_damages_: Permette di cercare danni in un raggio di 10km da una certa posizione
</div>

-----------------------------------------------------

### Links e riferimenti ###
 * Link Client web: http://piattasisma.ddns.net
 * Link API terremoti (esempio Italia): http://piattasisma.ddns.net/api/earthquakes/italy
 * Link API danni (esempio): http://piattasisma.ddns.net/api/damages
 * Link PiattaSismaBot: https://telegram.me/PDGTESbot
 * Link TechSismaBot: https://telegram.me/TechSismaBot
 * Link alla documentazione del API: https://app.swaggerhub.com/apis/RadeAndry9588/PiattaSismaAPI/1.0.0-oas3
