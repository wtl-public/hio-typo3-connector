# Changelog – wtl/hio-typo3-connector

Alle relevanten Änderungen an diesem Paket werden hier dokumentiert.
Das Format orientiert sich an [Keep a Changelog](https://keepachangelog.com/de/1.0.0/).
Die Versionierung folgt [Semantic Versioning](https://semver.org/lang/de/).

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

