# Changelog – wtl/hio-typo3-connector

Alle relevanten Änderungen an diesem Paket werden hier dokumentiert.
Das Format orientiert sich an [Keep a Changelog](https://keepachangelog.com/de/1.0.0/).
Die Versionierung folgt [Semantic Versioning](https://semver.org/lang/de/).

---

## [1.3.0] – 2026-05-12

### ⚠️ Breaking Change – ID-Handling für Detail-Links geändert

Bisher wurden Detail-Links (z. B. zur Personen-Detailseite) über die **HISinOne `object_id`**
aufgelöst. Ab dieser Version werden Links über die **TYPO3-interne `uid`** des Datensatzes
generiert und aufgelöst.

**Was bedeutet das konkret?**

- Bestehende URLs, die eine `object_id` als Parameter enthalten (z. B.
  `?tx_hiotypo3connector_selectedperson[objectId]=12345`), werden **nicht mehr korrekt
  aufgelöst** und liefern eine leere Detailseite oder einen 404-Fehler.
- Dies betrifft insbesondere **gespeicherte/geteilte Links** sowie
  **externe Verlinkungen** auf Detailseiten.

**Migrationsschritte:**

1. Prüfen, ob externe Systeme (z. B. CMS, Newsletter, Social Media) auf HIO-Publisher-
   Detailseiten verlinken.
2. Betroffene Links durch die neuen, sprechenden URLs ersetzen (siehe „Slugs und
   RouteEnhancer" weiter unten).
3. Ggf. `.htaccess`-Weiterleitungen oder TYPO3-Redirects für bekannte Altlinks einrichten.

> Dieses Verhalten wurde analog zum `wtl/hio-typo3-connector-frontend`-Paket umgesetzt,
> das in Version 1.3.0 dieselbe Umstellung vollzogen hat.

---

### Hinweise für Redakteure

- Die Suche nach Begriffen mit Umlauten (ä, ö, ü, ß) funktioniert nun zuverlässig. Zuvor
  konnten Suchtreffer fehlen, wenn der Suchbegriff Umlaute enthielt, die in der Datenbank
  in normalisierter Form gespeichert waren.
- Alle HIO-Datensätze (Personen, Publikationen, Projekte, Patente, Organisationseinheiten,
  Habilitationen, Promotionsprogramme, Nominierungen, Forschungsinfrastrukturen, Spin-offs)
  erhalten beim Import automatisch einen **Slug** (sprechende URL-Kennung). Dieser Slug
  wird im Backend sichtbar und kann bei Bedarf manuell angepasst werden.

### Hinweise für Agentur-Entwickler

#### BUGFIX: Umlautsuche (HIO-414)

Die Volltextsuche in `BaseRepository` wurde um einen `UmlautSearchVariantBuilder` erweitert.
Dieser erzeugt automatisch alle relevanten Schreibvarianten eines Suchbegriffs
(z. B. `ae`/`ä`, `oe`/`ö`, `ue`/`ü`, `ss`/`ß`) und kombiniert sie in der Datenbankabfrage,
sodass Suchanfragen mit Umlauten auch dann treffen, wenn der gespeicherte Wert in einer
anderen Schreibweise vorliegt.

Die neue Klasse `Classes/Search/UmlautSearchVariantBuilder.php` ist als TYPO3-Service
registriert (`Configuration/Services.yaml`) und vollständig durch Unit-Tests abgedeckt
(`Tests/Unit/Search/UmlautSearchVariantBuilderTest.php`).

#### FEATURE: Slugs und Vorbereitung auf RouteEnhancer (HIO-347)

Alle Domain-Modelle erhalten ein neues `slug`-Feld, das beim Import über den
`SlugHelperFactory`-Dienst (`Classes/DataHandling/SlugHelperFactory.php`) automatisch
befüllt wird. Das Feld ist in den TCA-Definitionen aller Modelle eingetragen und per
Datenbankmigration (`ext_tables.sql`) verfügbar.

**Neues Trait:** `HasSlugFieldTrait` (`Classes/Domain/Model/Trait/HasSlugFieldTrait.php`)
stellt Getter und Setter für das `slug`-Feld bereit und wird von allen betroffenen Modellen
eingebunden.

**Breaking Change (Detail-Links):** Der `PersonController` und der `OrgUnitController`
lösen Detailseiten-Requests nun über die **TYPO3-`uid`** statt der `object_id` auf.
Alte URLs mit `objectId`-Parameter sind nicht mehr kompatibel (siehe Abschnitt
„Breaking Change" oben).

#### Beispiel-Konfigurationen

Unter `ExampleConfigs/` liegen zwei neue Musterdateien:

| Datei | Inhalt |
|---|---|
| `ExampleConfigs/RouteEnhancer.yaml` | Vollständige RouteEnhancer-Konfiguration für alle HIO-Publisher-Detailseiten (Personen, Publikationen, Projekte, Patente, Organisationseinheiten, …). Als Ausgangsbasis für `config/sites/<site>/config.yaml` geeignet. |
| `ExampleConfigs/constants.typoscript` | Beispiel-TypoScript-Konstanten für die Seiten-PIDs aller HIO-Publisher-Plugins. Erleichtert die Erstkonfiguration neuer Projekte. |

> **Hinweis:** Die Beispieldateien sind **nicht produktiv aktiv** und müssen bewusst in die
> eigene Site-Konfiguration kopiert und angepasst werden.

#### Datenbankschema aktualisieren

Nach dem Update muss das Datenbankschema aktualisiert werden, damit die neuen `slug`-Felder
angelegt werden:

```bash
ddev exec vendor/bin/typo3 database:updateschema
```

Anschließend sollten die Slugs für bestehende Datensätze durch einen erneuten Import
oder einen manuellen DB-Update-Lauf befüllt werden.

---

## [1.2.0] – 2026-04-22

### Hinweise für Redakteure

Für Redakteure ändert sich im täglichen Umgang mit TYPO3 v12 und v13 **nichts**.
Alle Plugins des HIO Publishers sind weiterhin über den bekannten Weg
**Inhaltselement → Typ „Erweiterungen" → Listen-Typ** erreichbar.

> **Hinweis für TYPO3 v14-Nutzer:** Ab TYPO3 14 entfällt der Umweg über `list`/`list_type`
> vollständig. Die Plugins erscheinen dann direkt als eigene Inhaltstypen (CTypes) in der
> Inhaltstyp-Auswahl des Backends. Bestehende Inhaltselemente müssen nach dem Major-Upgrade
> **manuell neu konfiguriert** werden (siehe Abschnitt „Migration auf TYPO3 v14" weiter unten).

### Hinweise für Agentur-Entwickler

#### Plugin-Registrierung: Dual-Mode für v12/v13 und v14

Die Datei `Configuration/TCA/Overrides/tt_content.php` registriert alle Plugins
in einem **kompatiblen Dual-Mode**:

```
TYPO3 v12 / v13          TYPO3 v14
─────────────────        ─────────────────
list + list_type         CType (nativ)
     ↕ beide aktiv       ↕ nur CType
```

Intern steuert das die folgende Versionsprüfung:

```php
$typo3MajorVersion = (new Typo3Version())->getMajorVersion();

if ($typo3MajorVersion < 14) {
    // Gruppe im list_type-Dropdown anlegen (v12/v13-Kompatibilität)
    ExtensionManagementUtility::addTcaSelectItemGroup('tt_content', 'list_type', 'hio-publisher', …);
}
// CType-Gruppe wird immer angelegt (für v13 als Vorbereitung, für v14 produktiv)
ExtensionManagementUtility::addTcaSelectItemGroup('tt_content', 'CType', 'hio-publisher', …);
```

`ExtensionUtility::registerPlugin()` legt in TYPO3 v13 sowohl einen `list_type`-Eintrag
als auch einen eigenständigen `CType` an. In v14 entfällt der `list_type` automatisch.

#### Die Hilfsfunktion `$registerFlexForm()`

```php
$registerFlexForm(
    string $pluginSignature,   // z. B. 'hiotypo3connector_selectedpersonpublicationlist'
    string $flexForm,          // Pfad zur XML-Datei, z. B. 'FILE:EXT:hio_typo3_connector/…'
    bool   $hasListTypeFallback = false
): void
```

| Parameter | Bedeutung |
|---|---|
| `$pluginSignature` | Technischer Name des Plugins (Extension-Key + Plugin-Name, alles klein). Entspricht dem `CType`-Wert in `tt_content`. |
| `$flexForm` | Pfad zur FlexForm-XML-Datei, die die Plugin-Einstellungsfelder im Backend definiert. |
| `$hasListTypeFallback` | `true` → FlexForm wird **zusätzlich** für den Legacy-`list_type` registriert (für TYPO3 v12/v13 notwendig). `false` → nur für den CType (z. B. bei Plugins ohne eigene FlexForm-Felder). |

**Wie `$registerFlexForm()` intern arbeitet:**

```php
if ($typo3MajorVersion < 14) {
    // FlexForm für den CType (neues Verhalten in v13)
    $GLOBALS['TCA']['tt_content']['columns']['pi_flexform']['config']['ds'][',' . $pluginSignature] = $flexForm;

    if ($hasListTypeFallback) {
        // FlexForm auch für den alten list_type registrieren
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
        ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, $flexForm);
    }
} else {
    // v14+: FlexForm direkt am CType hängen (sauberere TCA-Struktur)
    $GLOBALS['TCA']['tt_content']['types'][$pluginSignature]['columnsOverrides']['pi_flexform']['config']['ds'] = $flexForm;
}

// Plugin-Tab im Backend-Formular einrichten (gilt für alle TYPO3-Versionen)
ExtensionManagementUtility::addToAllTCAtypes(
    'tt_content',
    '--div--;…tabs.plugin, pi_flexform, pages, recursive',
    $pluginSignature,
    'after:palette:headers'
);
```

> **Warum ist `addToAllTCAtypes` nach `$registerFlexForm()` notwendig?**
> `registerPlugin()` legt den CType-Eintrag an, definiert aber keine Tab-Struktur im
> Backend-Formular. Erst `addToAllTCAtypes` sorgt dafür, dass der Tab „Plugin" mit dem
> FlexForm-Feld und den Seiten-/Rekursions-Einstellungen sichtbar wird.
> Plugins **ohne** FlexForm (z. B. `hiotypo3connector_projectlist`) rufen
> `addToAllTCAtypes` direkt auf – ohne den Umweg über `$registerFlexForm()`.

#### TypoScript: Sets vs. klassisches TypoScript

Ab TYPO3 v12 können **TypoScript Sets** verwendet werden. Die Extension bietet beides an:

| Methode | Datei / Pfad | Verwendung |
|---|---|---|
| **Site Set** (empfohlen) | `Configuration/Sets/HioTypo3Connector/` | TYPO3 v12+: im Site-Modul als Abhängigkeit einbinden |
| **Klassisches TypoScript** | `Configuration/TypoScript/` | TYPO3 v12/v13 über Statische Templates oder `addTypoScriptSetup()` |

Das Set `wtl/hio-typo3-connector` (Label: *HIO TYPO3 Connector*) enthält die Basis-Konfiguration
und wird über `Configuration/Sets/HioTypo3Connector/config.yaml` deklariert.

**Empfehlung für neue Projekte:** Site Sets verwenden.
**Bestehende Projekte:** klassisches TypoScript weiterhin unterstützt, kein Handlungsbedarf.

#### Versionierungsstrategie (ext_emconf.php / composer.json)

Die Versions-Constraints sind so gesetzt, dass das Paket auf allen unterstützten
TYPO3-Versionen installierbar ist:

```php
// ext_emconf.php
'constraints' => [
    'depends' => [
        'typo3' => '12.4.0-14.3.99',   // konkrete Max-Version bei letztem Test
    ],
],
```

```json
// composer.json
"require": {
    "typo3/cms-core": "^12.4 || ^13.0 || ^14.3"
}
```

> **Konvention:** In `ext_emconf.php` wird die konkrete getestete Max-Version eingetragen
> (z. B. `14.3.99`). In `composer.json` wird `^14.3` verwendet, damit Composer automatisch
> neue Patch-/Minor-Releases auflöst. Beide Dateien müssen bei einem Major-Upgrade
> synchron aktualisiert werden.

---

## Migration auf TYPO3 v14

> ⚠️ **Achtung für Redakteure und Entwickler**

Ab TYPO3 v14 entfällt der Inhaltstyp `list` mit `list_type` vollständig.
Alle HIO-Publisher-Plugins werden dann **ausschließlich als eigenständige CTypes** geführt.

**Was bedeutet das konkret?**

- Bestehende Inhaltselemente, die als `list`/`list_type` gespeichert wurden, werden im
  Backend nach dem Upgrade **nicht mehr korrekt dargestellt** und müssen migriert werden.
- Eine TYPO3-Core-Migration (`ext:install` Upgrade Wizards) kann diesen Schritt
  **nicht automatisch** übernehmen, da die Zuordnung Plugin-spezifisch ist.

**Migrationsschritte für Redakteure (nach dem v14-Upgrade):**

1. Betroffenes Inhaltselement öffnen.
2. Inhaltstyp von „Erweiterungen" auf den neuen nativen Typ (z. B. „Publikationsliste")
   umstellen.
3. FlexForm-Einstellungen (Filter, Seiten-Bezug etc.) neu konfigurieren.
4. Speichern und Vorschau prüfen.

**Migrationsschritte für Entwickler:**

1. `ext_emconf.php` Constraint auf `14.x.x` anheben.
2. `composer.json` auf `^14.3` aktualisieren (bereits gesetzt).
3. `tt_content.php`: `$hasListTypeFallback`-Parameter aller `$registerFlexForm()`-Aufrufe
   kann auf `false` gesetzt werden (Legacy-Code wird durch die Versionsabfrage ohnehin
   nicht mehr ausgeführt).
4. SQL-Migration für bestehende `tt_content`-Datensätze (CType + list_type korrigieren)
   als eigener Upgrade-Wizard oder DB-Script bereitstellen.

---


## [1.1.2] – 2025-xx-xx

*(Interne Bugfixes und Erweiterungen – Details folgen)*

## [1.1.1] – 2025-xx-xx

*(Erste stabile Multi-Version-Unterstützung v12/v13/v14)*

## [1.1.0] – 2025-xx-xx

- Neue Plugins: `SelectedOrgUnit*` (Personen, Publikationen, Projekte, Patente einer Org-Einheit)
- Neue Plugins: `ProjectHighlights`, `PublicationHighlights`
- Einführung des Site-Set `wtl/hio-typo3-connector`

## [1.0.x] – 2024-xx-xx

- Initiale stabile Version mit Unterstützung für TYPO3 v12
- Plugins: Publikationen, Projekte, Personen, Patente, Nominierungen, Promotionsprogramme,
  Habilitationen, Organisationseinheiten, Forschungsinfrastrukturen, Spin-offs
- `SelectedPerson*`-Plugins für personenbezogene Detailseiten

