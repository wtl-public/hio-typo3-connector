# HISinOne TYPO3 Connector
Beim HISinOne TYPO3 Connector handelt es sich um eine TYPO3 Extension, die es ermöglicht, Forschungsdaten aus 
HISinOne (HIO) in TYPO3 zu importieren und anzuzeigen. 

Die Extension unterstützt aktuell die folgenden Datentypen:
* Personen 
* Projekte
* Publikationen
* Organisationseinheiten
* Promotionen
* Ausgründungen
* Habilitationen
* Patente

Damit die Extension genutzt werden kann, muss die Middleware "HIO-Publisher - Publisher für HISinOne" installiert und konfiguriert sein.
Nähere Informationen dazu finden Sie hier https://hio-publisher.de.

## Für Agenturen
Die HISinOne TYPO3 Connector Extension ist eine Open Source TYPO3 Extension, die von der WEBTEAM LEIPZIG GmbH entwickelt wurde. 
Sie ist für den Einsatz in TYPO3 Version 12.4 und höher geeignet und kann von Agenturen und TYPO3 Entwicklerinnen und Entwicklern genutzt werden,
um Forschungsdaten aus HISinOne in TYPO3 zu integrieren.

Solltet Euch bei der Integration der HISinOne TYPO3 Connector Extension in Euer Projekt Unterstützung benötigen, 
könnt Ihr Euch gerne an und wenden.

**WEBTEAM LEIPZIG GmbH**  
Gutenbergplatz 1  
04103 Leipzig

Email: <mailto:info+hio@wtl.de>  
Web: <https://hio-publisher.de>

## Initiales Setup

Im TYPO3 Backend:
* unter `Admin Tools` -> `Extensions` -> `Extension Manager` die Extension `hio-typo3-connector` installieren
* im Modul `Page` die Speicherseiten (Storage pages) `HISinOne Personen`, `HISinOne Projekte` und `HISinOne Publikationen` anlegen

## Configuration

Im TYPO3 Backend:
* Anpassung der TypoScript Konfiguration für die jeweiligen Details der einzelnen Datentypen.
* Beispielkonfiguration:

```
plugin.tx_hiotypo3connector {
    settings {
      doctoralPrograms {
        personTargetPageUid = 9
      }
      habilitations {
        personTargetPageUid = 9
      }
      orgUnits {
        personTargetPageUid = 9
      }
      patents {
        personTargetPageUid = 9
      }
      persons {
        publicationTargetPageUid = 7
        projectTargetPageUid = 8
      }
      projects {
        personTargetPageUid = 9
      }
      publications {
        personTargetPageUid = 9
      }
    }
}
```

## Konfiguration HIO-Publisher - Direktimport Kommandos (Middleware - Pull)

Im TYPO3 Backend:
* unter `Admin Tools` -> `Scheduler` -> die folgenden Import Tasks anlegen:
  * `hio:import:doctoralPrograms` - Importiert Promotionen aus HISinOne
  * `hio:import:habilitations` - Importiert Habilitationen aus HISinOne
  * `hio:import:orgUnits` - Importiert Organisationseinheiten aus HISinOne
  * `hio:import:patents` - Importiert Patente aus HISinOne
  * `hio:import:persons` - Importiert Personen aus HISinOne
  * `hio:import:projects` - Importiert Projekte aus HISinOne
  * `hio:import:publications` - Importiert Publikationen aus HISinOne
  

* jeder der genannten Tasks hat folgende Parameter:
  * `Storage page ID` - die Speicherseite, unter der die importierten Datensätze gespeichert werden
  * `URL` - die URL des `Publisher für HISinOne` REST API Endpoints
  * `username` - der basic authentication username zum Zugriff auf die API
  * `password` - das basic authentication password zum Zugriff auf die API

## Konfiguration HIO-Publisher - Asynchroner Import (Middleware - Push)

Die Middleware des "Publisher für HISinOne" ist in der Lage große Mengen an Forschungsdaten asynchron an TYPO3 zu übergeben. 
Dazu wird ein Webhook (Reaction) in TYPO3 benötigt, der die importierten Datensätze anlegt oder aktualisiert sowie ein 
TYPO3 Scheduler Tasks der Import des jeweiligen Datentyps (Projekt, Publikation, Person, ...) anstösst.
Die Middleware ermittelt die zu importierenden Datensätze und übergibt diese in frei definierbaren "Paketgrößen" an den TYPO3 Webhook.

Im TYPO3 Backend:

* unter `Admin Tools` -> `Reactions` -> die folgenden TYPO3 Webhooks (Reactions) anlegen:
  * `Receive doctoral program data from HIO Middleware` - Webhook zum Import von Promotionen
  * `Receive habilitation data from HIO Middleware` - Webhook zum Import von Habilitationen
  * `Receive orgUnit data from HIO Middleware` - Webhook zum Import von Organisationseinheiten
  * `Receive patent data from HIO Middleware` - Webhook zum Import von Patenten
  * `Receive person data from HIO Middleware` - Webhook zum Import von Personen
  * `Receive project data from HIO Middleware` - Webhook zum Import von Projekten
  * `Receive publication data from HIO Middleware` - Webhook zum Import von Publikationen

* jeder der genannten Webhooks hat folgende Parameter:
  * `Storage page ID` - die Speicherseite, unter der die importierten Datensätze gespeichert werden
  * `secret` - das generierte Token zum Zugriff auf den TYPO3 Webhook muss in dem korrespondierenden Import Requests als `x-api-key` hinterlegt werden


* unter `Admin Tools` -> `Scheduler` -> die folgenden Import Requests anlegen:
  * `hio:request:doctoralProgram:import` - Startet den Import von Promotionen aus HISinOne
  * `hio:request:habilitation:import` - Startet den Import von Habilitationen aus HISinOne
  * `hio:request:orgUnit:import` - Startet den Import von Organisationseinheiten aus HISinOne
  * `hio:request:patent:import` - Startet den Import von Patente aus HISinOne
  * `hio:request:person:import` - Startet den Import von Personen aus HISinOne
  * `hio:request:project:import` - Startet den Import von Projekte aus HISinOne
  * `hio:request:publication:import` - Startet den Import von Publikationen aus HISinOne

* jeder der genannten Tasks hat folgende Parameter:
  * `API Endpoint URl` - die URL des `Publisher für HISinOne` REST API Endpoints
  * `API Basic auth username` - der basic authentication username zum Zugriff auf die API
  * `API Basic auth password` - das basic authentication password zum Zugriff auf die API
  * `TYPO3 Webhook URl` - die URl des TYPO3 Webhooks (TYPO3 Reaction), der die importierten Datensätze anlegt oder aktualisiert
  * `TYPO3 X-API-KEY` - das Autorisierungs-Token zum Zugriff auf den TYPO3 Webhook (TYPO3 Reaction)


## Frontend plugins

Im TYPO3 Backend:

Im Module `Page` können die folgenden Frontend-Plugins eingefügt werden:

  * `HISinOne Habilitationen` - zeigt eine Liste von Habilitationen aus HISinOne an
  * `HISinOne Organisationseinheiten` - zeigt eine Liste von Organisationseinheiten aus HISinOne an
  * `HISinOne Patente` - zeigt eine Liste von Patenten aus HISinOne an
  * `HISinOne Personen` - zeigt eine Liste von Personen aus HISinOne an
  * `HISinOne Projekte` - zeigt eine Liste von Projekten aus HISinOne an
  * `HISinOne Promotionen` - zeigt eine Liste von Promotionen aus HISinOne an
  * `HISinOne Publikationen` - zeigt eine Liste von Publikationen aus HISinOne an


  * `HISinOne Habilitationen der Person` - zeigt die Liste aller freigegebenen Habilitationen einer ausgewählten Person an
  * `HISinOne Organisationseinheiten der Person` - zeigt die Liste aller freigegebenen Organisationseinheiten einer ausgewählten Person an
  * `HISinOne Patente der Person` - zeigt die Liste aller freigegebenen Patente einer ausgewählten Person an
  * `HISinOne Projekte der Person` - zeigt die Liste aller freigegebenen Projekte einer ausgewählten Person an
  * `HISinOne Promotionen der Person` - zeigt die Liste aller freigegebenen Promotionen einer ausgewählten Person an
  * `HISinOne Publikationen der Person` - zeigt die Liste aller freigegebenen Publikationen einer ausgewählten Person an
