# HISinOne TYPO3 Connector

## Initial Setup

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
      publications {
        personTargetPageUid = 9
      }
      persons {
        publicationTargetPageUid = 7
        projectTargetPageUid = 8
      }
      projects {
        personTargetPageUid = 9
      }
      patents {
        personTargetPageUid = 9
      }
      doctorates {
        personTargetPageUid = 9
      }
      habilitations {
        personTargetPageUid = 9
      }
    }
}
```

## Scheduler import commands

Im TYPO3 Backend:
* unter `Admin Tools` -> `Scheduler` -> die folgenden Import Tasks anlegen:
  * `hio:import:doctorates` - Importiert Promotionen aus HISinOne
  * `hio:import:habilitations` - Importiert Habilitationen aus HISinOne
  * `hio:import:patents` - Importiert Patente aus HISinOne
  * `hio:import:persons` - Importiert Personen aus HISinOne
  * `hio:import:projects` - Importiert Projekte aus HISinOne
  * `hio:import:publications` - Importiert Publikationen aus HISinOne
* jeder der genannten Tasks hat folgende Parameter:
  * `Storage page ID` - die Speicherseite, unter der die importierten Datensätze gespeichert werden
  * `URL` - die URL des `Publisher für HISinOne` REST API Endpoints
  * `username` - der basic authentication username zum Zugriff auf die API
  * `password` - das basic authentication password zum Zugriff auf die API

**Achtung!** Das Kommando zum Import von Personen mus nach den anderen Import Kommandos ausgeführt werden.
Dadurch werden die zur jeweiligen Person gehörenden Publikationen, Projekte und Patente verknüpft.

## Frontend plugins

Im TYPO3 Backend:

Im Module `Page` können die folgenden Frontend-Plugins eingefügt werden:

  * `HISinOne Habilitationen` - zeigt eine Liste von Habilitationen aus HISinOne an
  * `HISinOne Patente` - zeigt eine Liste von Patenten aus HISinOne an
  * `HISinOne Personen` - zeigt eine Liste von Personen aus HISinOne an
  * `HISinOne Projekte` - zeigt eine Liste von Projekten aus HISinOne an
  * `HISinOne Promotionen` - zeigt eine Liste von Promotionen aus HISinOne an
  * `HISinOne Publikationen` - zeigt eine Liste von Publikationen aus HISinOne an


  * `HISinOne Habilitationen der Person` - zeigt die Liste aller freigegebenen Habilitationen einer ausgewählten Person an
  * `HISinOne Patente der Person` - zeigt die Liste aller freigegebenen Patente einer ausgewählten Person an
  * `HISinOne Projekte der Person` - zeigt die Liste aller freigegebenen Projekte einer ausgewählten Person an
  * `HISinOne Promotionen der Person` - zeigt die Liste aller freigegebenen Promotionen einer ausgewählten Person an
  * `HISinOne Publikationen der Person` - zeigt die Liste aller freigegebenen Publikationen einer ausgewählten Person an
