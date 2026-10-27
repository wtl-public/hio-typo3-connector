# HISinOne TYPO3 Connector
Beim HISinOne TYPO3 Connector handelt es sich um eine TYPO3 Extension, die es ermöglicht, Forschungsdaten aus 
HISinOne (HIO) in TYPO3 zu importieren und anzuzeigen. 

Die Extension unterstützt aktuell die folgenden Datentypen:
* Personen 
* Projekte
* Publikationen
* Organisationseinheiten
* Promotionen
* Nominierungen
* Forschungsinfrastrukturen
* Ausgründungen
* Habilitationen
* Patente

Damit die Extension genutzt werden kann, muss die Middleware "HIO-Publisher - Publisher für HISinOne" installiert und konfiguriert sein.
Nähere Informationen dazu finden Sie hier https://hio-publisher.de.

➡️ **[Changelog](CHANGELOG.md)** – Alle Änderungen, neue Features und Breaking Changes

## Für Agenturen
Die HISinOne TYPO3 Connector Extension ist eine Open Source TYPO3 Extension, die von der WEBTEAM LEIPZIG GmbH entwickelt wurde. 
Sie ist für den Einsatz in TYPO3 Version 12.4 und höher geeignet und kann von Agenturen und TYPO3 Entwicklerinnen und Entwicklern genutzt werden,
um Forschungsdaten aus HISinOne in TYPO3 zu integrieren.

Solltet Ihr bei der Integration der HISinOne TYPO3 Connector Extension in Euer Projekt Unterstützung benötigen, 
könnt Ihr Euch gerne an uns wenden.

**WEBTEAM LEIPZIG GmbH**  
Gutenbergplatz 1  
04103 Leipzig

Email: [info+hio@wtl.de](mailto:info+hio@wtl.de)  
Web: <https://hio-publisher.de>

## Initiales Setup und Konfiguration

### 1. Extension installieren

Installieren und aktivieren Sie im TYPO3 Backend unter `Admin Tools` -> `Extensions` ->
`Extension Manager` die Extension `hio-typo3-connector`.

### 2. Speicherseiten für Importdaten anlegen

Legen Sie im Modul `Page` die benötigten Speicherseiten an. Empfohlen ist je Datentyp eine
eigene Speicherseite:

| Speicherseite | Inhalt |
| --- | --- |
| `HISinOne Personen` | importierte Personen |
| `HISinOne Projekte` | importierte Projekte |
| `HISinOne Publikationen` | importierte Publikationen |
| `HISinOne Organisationseinheiten` | importierte Organisationseinheiten |
| `HISinOne Promotionen` | importierte Promotionen |
| `HISinOne Habilitationen` | importierte Habilitationen |
| `HISinOne Patente` | importierte Patente |
| `HISinOne-Preisanerkennungen` | importierte Preisanerkennungen, fachlich auch Nominierungen |
| `HISinOne Forschungsinfrastrukturen` | importierte Forschungsinfrastrukturen |
| `HISinOne Ausgründungen` | importierte Ausgründungen |

Diese Seiten werden in Scheduler-Tasks und Reactions als `Storage page ID` verwendet. Sie
sind reine Datenablagen und nicht identisch mit den sichtbaren Frontend-Zielseiten.

### 3. Frontend-Zielseiten anlegen

Legen Sie die Seiten an, auf denen Listen- und Detailansichten im Frontend erreichbar sein
sollen. Typische Seiten sind:

| Frontend-Zielseite | Verwendung |
| --- | --- |
| `Personendetail` | Zielseite für Links zu Personen |
| `Publikationsdetail` | Zielseite für Links zu Publikationen |
| `Projektdetail` | Zielseite für Links zu Projekten |
| `Patentdetail` | Zielseite für Links zu Patenten |
| `Promotiondetail` | Zielseite für Links zu Promotionen |
| `Organisationseinheit-Detail` | Zielseite für Links zu Organisationseinheiten |

### 4. Site Set oder TypoScript einbinden

Bei Nutzung von Site Sets binden Sie das Set `HIO TYPO3 Connector` in der Site-Konfiguration
ein. Die Datei `Configuration/Sets/HioTypo3Connector/constants.typoscript` wird dann
automatisch geladen.

Ohne Site Sets binden Sie `Configuration/TypoScript/constants.typoscript` als Grundlage in
Ihr Projekt-TypoScript ein.

### 5. Zielseiten in den Konstanten konfigurieren

Tragen Sie in den TypoScript-Konstanten die Frontend-Zielseiten ein. Die Werte der
`...TargetPageUid`-Konfigurationen zeigen immer auf sichtbare Frontend-Seiten, nicht auf
die Import-Speicherseiten.

Beispiel mit sprechenden UID-Platzhaltern. Ersetzen Sie die Werte in spitzen Klammern durch
die tatsächlichen TYPO3-Seiten-UIDs Ihrer Frontend-Zielseiten:

```
plugin.tx_hiotypo3connector {
  settings {
    publications {
      personTargetPageUid = <UID der Seite Personendetail>
    }
    persons {
      publicationTargetPageUid = <UID der Seite Publikationsdetail>
      projectTargetPageUid = <UID der Seite Projektdetail>
      patentTargetPageUid = <UID der Seite Patentdetail>
      doctoralProgramTargetPageUid = <UID der Seite Promotiondetail>
    }
    orgUnits {
      personTargetPageUid = <UID der Seite Personendetail>
      publicationTargetPageUid = <UID der Seite Publikationsdetail>
      projectTargetPageUid = <UID der Seite Projektdetail>
      patentTargetPageUid = <UID der Seite Patentdetail>
      doctoralProgramTargetPageUid = <UID der Seite Promotiondetail>
    }
    doctoralPrograms {
      personTargetPageUid = <UID der Seite Personendetail>
    }
    habilitations {
      personTargetPageUid = <UID der Seite Personendetail>
    }
    patents {
      personTargetPageUid = <UID der Seite Personendetail>
    }
    projects {
      personTargetPageUid = <UID der Seite Personendetail>
    }
    nominations {
      personTargetPageUid = <UID der Seite Personendetail>
      orgUnitTargetPageUid = <UID der Seite Organisationseinheit-Detail>
      projectTargetPageUid = <UID der Seite Projektdetail>
      publicationTargetPageUid = <UID der Seite Publikationsdetail>
    }
    spinoffs {
      personTargetPageUid = <UID der Seite Personendetail>
    }
    projectDetails {
      persons {
        filterProjectLead = Projektleiter/-in
      }
    }
    featuredProjects {
      projectTargetPageUid = <UID der Seite Projektdetail>
    }
    featuredPublications {
      publicationTargetPageUid = <UID der Seite Publikationsdetail>
    }
  }
}
```

Die Datei [ExampleConfigs/constants.typoscript](ExampleConfigs/constants.typoscript)
enthält dieselbe Konfigurationsstruktur als kopierbare Vorlage.

## Konfiguration HIO-Publisher - Direktimport Kommandos (Middleware - Pull)

Im TYPO3 Backend:
* unter `Admin Tools` -> `Scheduler` -> die folgenden Import Tasks anlegen:
  * `hio:doctoral-programs:import` - Importiert Promotionen aus HISinOne
  * `hio:habilitations:import` - Importiert Habilitationen aus HISinOne
  * `hio:nominations:import` - Importiert Preisanerkennungen aus HISinOne
  * `hio:org-units:import` - Importiert Organisationseinheiten aus HISinOne
  * `hio:patents:import` - Importiert Patente aus HISinOne
  * `hio:persons:import` - Importiert Personen aus HISinOne
  * `hio:projects:import` - Importiert Projekte aus HISinOne
  * `hio:publications:import` - Importiert Publikationen aus HISinOne
  * `hio:research-infrastructures:import` - Importiert Forschungsinfrastrukturen aus HISinOne
  * `hio:spinoffs:import` - Importiert Ausgründungen aus HISinOne
  

* jeder der genannten Tasks hat folgende Parameter:
  * `Storage page ID` - die Speicherseite, unter der die importierten Datensätze gespeichert werden
  * `URL` - die URL des `Publisher für HISinOne` REST API Endpoints
  * `username` - optionaler BasicAuth-Username zum Zugriff auf die API; leer lassen, um den Umgebungsvariablen-Fallback zu verwenden
  * `password` - optionales BasicAuth-Passwort zum Zugriff auf die API; leer lassen, um den Umgebungsvariablen-Fallback zu verwenden
  * `--no-basic-auth` - optional, deaktiviert BasicAuth für diesen Task; Scheduler- und Umgebungsvariablen-Zugangsdaten werden ignoriert
  * `--with-trashed` - optional, ruft auch die in der Middleware gelöschten Datensätze ab und verbirgt sie; setzt die beiden folgenden Optionen standardmäßig auf 7 bzw. 30 Tage
  * `--soft-delete-after-days=N` - optional, verbirgt Datensätze, deren `lastSeenAt` mehr als N Tage zurückliegt, auch solche, die die Middleware nicht mehr liefert
  * `--hard-delete-after-days=N` - optional, verschiebt vom Import verborgene Datensätze in den TYPO3-Papierkorb, sobald ihr Lösch-Zeitpunkt mehr als N Tage zurückliegt

BasicAuth kann zentral über Prozess-Umgebungsvariablen konfiguriert werden:

```dotenv
HIO_TYPO3_CONNECTOR_BASIC_AUTH_USERNAME="username"
HIO_TYPO3_CONNECTOR_BASIC_AUTH_PASSWORD="password"
```

Eine `.env`-Datei wird von dieser Extension nicht selbst geladen. Der Fallback greift nur,
wenn diese Werte bereits als Umgebungsvariablen im PHP-Prozess verfügbar sind, zum Beispiel
weil das Projekt, das Hosting oder ein Bootstrap eine `.env`-Datei lädt.

Die BasicAuth-Konfiguration wird in dieser Reihenfolge aufgelöst:

1. Wenn `--no-basic-auth` im Scheduler-Task gesetzt ist, wird kein BasicAuth verwendet.
2. Wenn `username` und `password` im Scheduler-Task gesetzt sind, werden diese Werte verwendet.
3. Wenn beide Umgebungsvariablen gesetzt sind, werden diese Werte verwendet.
4. Andernfalls wird kein BasicAuth verwendet.

### Nicht mehr gelieferte Datensätze verbergen und löschen

Ohne die drei Optionen verbirgt und löscht der Import wie bisher nichts. Sie setzen eine
Middleware mit `lastSeenAt` voraus, `--with-trashed` zusätzlich `filter[trashed]=with`.

* Verborgen wird per `hidden=1`, gelöscht per `deleted=1` (TYPO3-Papierkorb, endgültig
  leeren mit `cleanup:deletedrecords --min-age=<Tage>`).
* Die N Tage der Optionen zählen ab dem neuesten `lastSeenAt` bzw. `deletedAt` des Laufs,
  nicht ab jetzt.
* Lösch-Zeitpunkt ist `deletedAt` bzw. `lastSeenAt` plus die Soft-Delete-Tage. Liefert die
  Middleware einen vom Import verborgenen Datensatz mit einem späteren `lastSeenAt`, wird
  er wieder angezeigt.
* Betroffen sind nur Datensätze auf der Speicherseite des Tasks. Von Redakteuren
  verborgene Datensätze zeigt der Import nicht wieder an und löscht sie nicht.
* **Beim späteren Aktivieren beachten:** `last_seen_at` wird ab dem Update in jedem Lauf
  gepflegt. Der erste Lauf mit `--with-trashed` verbirgt deshalb sofort, was seit mehr als
  7 Tagen fehlt, und verschiebt, was seit mehr als 37 Tagen fehlt, in den Papierkorb.

## Konfiguration HIO-Publisher - Asynchroner Import (Middleware - Push)

Die Middleware des "Publisher für HISinOne" ist in der Lage große Mengen an Forschungsdaten asynchron an TYPO3 zu übergeben. 
Dazu wird ein Webhook (Reaction) in TYPO3 benötigt, der die importierten Datensätze anlegt oder aktualisiert sowie ein 
TYPO3 Scheduler Tasks der Import des jeweiligen Datentyps (Projekt, Publikation, Person, ...) anstösst.
Die Middleware ermittelt die zu importierenden Datensätze und übergibt diese in frei definierbaren "Paketgrößen" an den TYPO3 Webhook.

Voraussetzung für diesen Push-Mechanismus ist die installierte und aktive System-Extension
`reactions`.

Im TYPO3 Backend:

* unter `Admin Tools` -> `Reactions` -> die folgenden TYPO3 Webhooks (Reactions) anlegen:
  * `Receive doctoral program data from HIO Middleware` - Webhook zum Import von Promotionen
  * `Receive habilitation data from HIO Middleware` - Webhook zum Import von Habilitationen
  * `Receive nomination data from HIO Middleware` - Webhook zum Import von Preisanerkennungen
  * `Receive orgUnit data from HIO Middleware` - Webhook zum Import von Organisationseinheiten
  * `Receive patent data from HIO Middleware` - Webhook zum Import von Patenten
  * `Receive person data from HIO Middleware` - Webhook zum Import von Personen
  * `Receive project data from HIO Middleware` - Webhook zum Import von Projekten
  * `Receive publication data from HIO Middleware` - Webhook zum Import von Publikationen
  * `Receive research-infrastructure data from HIO Middleware` - Webhook zum Import von Forschungsinfrastrukturen
  * `Receive spinoff data from HIO Middleware` - Webhook zum Import von Ausgründungen

* jeder der genannten Webhooks hat folgende Parameter:
  * `Storage page ID` - die Speicherseite, unter der die importierten Datensätze gespeichert werden
  * `secret` - das generierte Token zum Zugriff auf den TYPO3 Webhook muss in dem korrespondierenden Import Requests als `x-api-key` hinterlegt werden


* unter `Admin Tools` -> `Scheduler` -> die folgenden Import Requests anlegen:
  * `hio:request:doctoralProgram:import` - Startet den Import von Promotionen aus HISinOne
  * `hio:request:habilitation:import` - Startet den Import von Habilitationen aus HISinOne
  * `hio:request:nomination:import` - Startet den Import von Preisanerkennungen aus HISinOne
  * `hio:request:orgUnit:import` - Startet den Import von Organisationseinheiten aus HISinOne
  * `hio:request:patent:import` - Startet den Import von Patente aus HISinOne
  * `hio:request:person:import` - Startet den Import von Personen aus HISinOne
  * `hio:request:project:import` - Startet den Import von Projekte aus HISinOne
  * `hio:request:publication:import` - Startet den Import von Publikationen aus HISinOne

* jeder der genannten Tasks hat folgende Parameter:
  * `API Endpoint URl` - die URL des `Publisher für HISinOne` REST API Endpoints
  * `API Basic auth username` - optionaler API-BasicAuth-Username; leer lassen, um den Umgebungsvariablen-Fallback zu verwenden
  * `API Basic auth password` - optionales API-BasicAuth-Passwort; leer lassen, um den Umgebungsvariablen-Fallback zu verwenden
  * `--api-no-basic-auth` - optional, deaktiviert API-BasicAuth für diesen Task; Scheduler- und Umgebungsvariablen-Zugangsdaten werden ignoriert
  * `TYPO3 Webhook URl` - die URl des TYPO3 Webhooks (TYPO3 Reaction), der die importierten Datensätze anlegt oder aktualisiert
  * `TYPO3 X-API-KEY` - das Autorisierungs-Token zum Zugriff auf den TYPO3 Webhook (TYPO3 Reaction)

Für BasicAuth gelten dieselben Umgebungsvariablen und dieselbe Auflösungsreihenfolge wie bei den Direktimport-Kommandos.



## Frontend plugins

Im TYPO3 Backend:

Im Modul `Page` können die folgenden Frontend-Plugins eingefügt werden:

  * `HISinOne Habilitationen` - zeigt eine Liste von Habilitationen aus HISinOne an
  * `HISinOne Forschungsinfrastrukturen` - zeigt eine Liste von Forschungsinfrastrukturen aus HISinOne an
  * `HISinOne-Preisanerkennungen` - zeigt eine Liste von Preisanerkennungen, fachlich auch Nominierungen, aus HISinOne an
  * `HISinOne Organisationseinheiten` - zeigt eine Liste von Organisationseinheiten aus HISinOne an
  * `HISinOne Patente` - zeigt eine Liste von Patenten aus HISinOne an
  * `HISinOne Personen` - zeigt eine Liste von Personen aus HISinOne an
  * `HISinOne Projekte` - zeigt eine Liste von Projekten aus HISinOne an
  * `HISinOne Promotionen` - zeigt eine Liste von Promotionen aus HISinOne an
  * `HISinOne Publikationen` - zeigt eine Liste von Publikationen aus HISinOne an
  * `HISinOne Ausgründungen` - zeigt eine Liste von Ausgründungen aus HISinOne an


  * `HISinOne Habilitationen der Person` - zeigt die Liste aller freigegebenen Habilitationen einer ausgewählten Person an
  * `HISinOne Organisationseinheiten der Person` - zeigt die Liste aller freigegebenen Organisationseinheiten einer ausgewählten Person an
  * `HISinOne Patente der Person` - zeigt die Liste aller freigegebenen Patente einer ausgewählten Person an
  * `HISinOne Projekte der Person` - zeigt die Liste aller freigegebenen Projekte einer ausgewählten Person an
  * `HISinOne Promotionen der Person` - zeigt die Liste aller freigegebenen Promotionen einer ausgewählten Person an
  * `HISinOne Publikationen der Person` - zeigt die Liste aller freigegebenen Publikationen einer ausgewählten Person an
  * `HISinOne Personen der Organisationseinheit` - zeigt die Liste aller freigegebenen Personen einer ausgewählten Organisationseinheit an
  * `HISinOne Patente der Organisationseinheit` - zeigt die Liste aller freigegebenen Patente einer ausgewählten Organisationseinheit an
  * `HISinOne Projekte der Organisationseinheit` - zeigt die Liste aller freigegebenen Projekte einer ausgewählten Organisationseinheit an
  * `HISinOne Publikationen der Organisationseinheit` - zeigt die Liste aller freigegebenen Publikationen einer ausgewählten Organisationseinheit an

## Frontend-Templates und Rendering

Die vorliegende Extension (`hio-typo3-connector`) übernimmt den Import und die Datenverwaltung.
Sie stellt TYPO3-Frontend-Plugins mit Platzhalter-Templates als Integrationspunkte für eine separate Frontend-Integration bereit.

Das **Frontend-Rendering** (die Anzeige der Daten) muss durch eine der folgenden Methoden gelöst werden:

### Option 1: Beispiel-Frontend-Extension als Basis

Die WEBTEAM LEIPZIG GmbH stellt eine Beispiel-Frontend-Extension zur Verfügung:
- **wtl/hio-typo3-connector-frontend** - Templates und Fluid-Plugins als Ausgangspunkt für die Anzeige der Datentypen

Diese kann direkt genutzt werden oder als Vorlage für eine eigene Frontend-Integration dienen.

### Option 2: Eigenes Frontend mit Template-Überschreibungen

Falls die Beispiel-Extension nicht den Anforderungen entspricht, können Sie ein eigenes Frontend aufbauen.

Ohne eine dieser Implementierungen werden die importierten Datensätze im Frontend nicht angezeigt.

## Legacy-Plugins

Die Plugins `Display selected projects` und `Display selected publications` sind
deprecated. Sie bleiben aus Kompatibilitätsgründen technisch registriert, damit
bestehende Inhaltselemente weiter funktionieren.

Für neue Inhalte sind diese beiden Legacy-Plugins im Backend jedoch bewusst ausgeblendet.
Neue Konfigurationen sollen stattdessen über die Container-Elemente `featuredProjects` und
`featuredPublications` aus `wtl/hio-typo3-connector-frontend` aufgebaut werden.

Beide Legacy-Plugins sind nur noch als Übergangslösung vorhanden und werden in `v2`
vollständig entfernt.
