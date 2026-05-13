<?php

declare(strict_types=1);

namespace Wtl\HioTypo3Connector\Search;

/**
 * Generates search variants for a term, accounting for
 * umlaut/ASCII spellings and ß↔ss substitutions.
 *
 * Two configurable mappings:
 *
 * $charMap   – bidirectional: ae↔ä, oe↔ö, ue↔ü
 *              Suitable for multi-character equivalents that rarely appear by coincidence.
 *
 * $oneWayMap – special character→ASCII only (not the reverse): ñ→n
 *              Suitable for single characters where the reverse (n→ñ) would produce
 *              too many false positives (e.g. "berlin" → "berlñ").
 */
final class UmlautSearchVariantBuilder
{
    /** @var array<string, string> */
    private array $charMap;

    /** @var array<string, string> */
    private array $oneWayMap;

    /**
     * @param array<string, string>|null $charMap    Bidirectional mappings (default: German umlauts)
     * @param array<string, string>|null $oneWayMap  Special character→ASCII only, e.g. ['ñ' => 'n']
     */
    public function __construct(?array $charMap = null, ?array $oneWayMap = null)
    {
        $this->charMap   = $charMap ?? ['ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue'];
        $this->oneWayMap = $oneWayMap ?? [];
    }

    /**
     * Returns all relevant search variants for the given search term.
     * Duplicates are removed automatically.
     *
     * @return list<string>
     */
    public function buildVariants(string $searchTerm): array
    {
        $term = trim(mb_strtolower($searchTerm));

        $special = array_keys($this->charMap);
        $ascii   = array_values($this->charMap);

        // Apply oneWayMap to a string (special character→ASCII only)
        $applyOneWay = fn(string $s): string => str_replace(
            array_keys($this->oneWayMap),
            array_values($this->oneWayMap),
            $s
        );

        // ASCII→special character: ae→ä, oe→ö, ue→ü
        $umlautVariant = str_replace($ascii, $special, $term);

        // Special character→ASCII incl. ß: ä→ae, ö→oe, ü→ue, ß→ss
        $asciiVariant = str_replace([...$special, 'ß'], [...$ascii, 'ss'], $term);

        // Special character→ASCII excl. ß: ä→ae, ö→oe, ü→ue (ß unchanged, e.g. "vößler" → "voeßler")
        $asciiUmlautOnlyVariant = str_replace($special, $ascii, $term);

        // ß↔ss as separate, unidirectional variants to avoid self-cancellation
        $ssToSzVariant = str_replace('ss', 'ß', $term);
        $szToSsVariant = str_replace('ß', 'ss', $term);

        // Umlaut conversion + ß↔ss combined
        $umlautPlusSsToSz = str_replace('ss', 'ß', $umlautVariant);
        $umlautPlusSzToSs = str_replace('ß', 'ss', $umlautVariant);

        // ASCII excl. ß + ss→ß (e.g. "vössler" → "voeßler")
        $asciiUmlautOnlyPlusSsToSz = str_replace($special, $ascii, $ssToSzVariant);

        $baseVariants = [
            $term,
            $umlautVariant,
            $asciiVariant,
            $asciiUmlautOnlyVariant,
            $ssToSzVariant,
            $szToSsVariant,
            $umlautPlusSsToSz,
            $umlautPlusSzToSs,
            $asciiUmlautOnlyPlusSsToSz,
        ];

        if ($this->oneWayMap) {
            // Apply oneWayMap to each base variant and merge the results
            $oneWayVariants = array_map($applyOneWay, $baseVariants);
            $baseVariants   = array_merge($baseVariants, $oneWayVariants);
        }

        return array_values(array_unique($baseVariants));
    }
}
