# Intrattenere conversazioni

## Introduzione

Ora che il nostro bot è capace di intrattenere delle conversazioni di base con un utente (rispondendo in maniera più o meno intelligente), è il caso di introdurre un altro elemento importante nel gestire conversazioni: la **memoria** del bot.

Dare un’occhiata al codice d’esempio in `get-updates.php`, che riceve un aggiornamento da parte del bot e ne estrae l’eventuale testo e l’ID della conversazione.
Questo ID è un numero univoco (per ogni bot) che identifica una particolare sessione di conversazione: ogni conversazione con un singolo utente avrà un proprio ID univoco, così come ogni conversazione di gruppo con più utenti ed il bot.

In particolare, è possibile osservare la struttura JSON dei dati di Telegram per notare che effettivamente is ha accesso a 3&nbsp;tipologie di ID univoci:

* **ID dell’update:** identifica in maniera il singolo aggiornamento, è univoco all’interno dell’interazione con un particolare bot. Ci permette di scorrere nella lista degli aggiornamenti disponibili per il bot grazie al parametro `offset`.
* **ID dell’utente:** ogni utente Telegram ha un ID&nbsp;univoco che lo identifica. È possibile leggere l’ID nel campo `ID` dell’oggetto `from` di ogni messaggio ottenuto tramite l’API, dove `from` contiene altri campi come ad esempio il nome ed il *nickname* dell’utente. Nel caso sia necessario distinguere tra più utenti (ad esempio in una conversazione di gruppo), sarebbe necessario sfruttare questo ID.
* **ID della conversazione:** ogni “chat” attiva in Telegram ha un proprio ID univoco, che la identifica agli occhi del bot. In particolare, ogni conversazione privata tra un singolo utente ed un bot ha un ID uguale all’ID dell’utente (ossia, se l’utente con ID `123` conversa con un bot, la conversazione con quell’utente dal punto di vista del bot avrà ID `123`). Le conversazioni di gruppo invece ottengono un ID unico diverso da quello dei partecipanti.

Nel caso più comune è sufficiente distinguere in base all’ultimo ID, il cosiddetto “Chat ID”.
Questo ID è lo stesso che va utilizzato per inviare dei messaggi da parte del bot (come è stato fatto nell’esercitazione precedente).

## Consegna

Sfruttando le nozioni apprese nelle precedenti esercitazioni, utilizzare la scrittura su file per memorizzare dei dati sulla conversazione passata con gli utenti.
Ad esempio, come indicato nel codice di esempio, per ottenere il seguente comportamento:

1. Se l’utente non ha mai scritto al bot, inviare un messaggio di benvenuto.
2. Ad ogni messaggio ricevuto, memorizzare il testo inviato dall’utente.
3. Se l’utente aveva già scritto in precedenza, inviare il messaggio precedente all’utente.

In questo modo si otterrà un semplice bot con una “memoria” di un singolo messaggio.

### Bonus&nbsp;1: dati strutturati

Il file che viene scritto dal bot può contenere qualsiasi dato, in qualsiasi formato.
Ad esempio, anche dei dati in formato&nbsp;JSON, che permetterebbe di strutturare più informazioni in un singolo file.

Utilizzare le funzioni `json_encode` e `json_decode` per formattare dati strutturati, memorizzarli nel file di conversazione e caricarli nuovamente.

### Bonus&nbsp;2: multi-utente

Generalmente un bot conversa con un numero arbitrario di utenti, anche se durante i test converserà solamente con il proprio utente Telegram.

Come si comporta il bot sviluppato nel caso di più utenti?
Eseguire delle prove ed osservare il comportamento del bot, eventualmente chiedendo ad un collega di inviare dei messaggi al bot.

Come si può evitare che la memoria di conversazione con un utente vada ad interagire con la conversazione di un secondo utente?
