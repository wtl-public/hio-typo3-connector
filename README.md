# HISinOne TYPO3 Connector

## Initial Setup

Im TYPO3 Backend:
* unter `Admin Tools` -> `Extensions` -> `Extension Manager` die Extension `hio-typo3-connector` installieren
* im Modul `Page` die Speicherseiten (Storage pages) `HISinOne Personen`, `HISinOne Projekte` und `HISinOne Publikationen` anlegen

## Scheduler import commands

Im TYPO3 Backend:
* unter `Admin Tools` -> `Scheduler` -> die folgenden Import Tasks anlegen:
  * `hio:import:persons` - Importiert Personen aus HISinOne
  * `hio:import:projects` - Importiert Projekte aus HISinOne
  * `hio:import:publications` - Importiert Publikationen aus HISinOne
* jeder der genannten Tasks hat folgende Parameter:
  * `Storage page ID` - die Speicherseite, unter der die importierten Datensätze gespeichert werden
  * `URL` - die URL des `Publisher für HISinOne` REST API Endpoints
  * `username` - der basic authentication username zum Zugriff auf die API
  * `password` - das basic authentication password zum Zugriff auf die API

## Frontend plugins

Im TYPO3 Backend:
* im Module `Page` können die folgenden Frontend-Plugins eingefügt werden:
  * `HISinOne Personen` - zeigt eine Liste von Personen aus HISinOne an
  * `HISinOne Projekte` - zeigt eine Liste von Projekten aus HISinOne an
  * `HISinOne Publikationen` - zeigt eine Liste von Publikationen aus HISinOne an
  * `HISinOne Publikationen der Person` - zeigt die Liste aller Publikationen einer ausgewählten Person an
  * `HISinOne Projekte der Person` - zeigt die Liste aller Projekte einer ausgewählten Person an
