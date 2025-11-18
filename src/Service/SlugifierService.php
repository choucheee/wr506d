<?php

namespace App\Service;

use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\String\UnicodeString;

class SlugifierService
{
    public function __construct(
        private readonly ?SluggerInterface $slugger = null
    ) {
    }

    /**
     * Convertit une phrase en version slugifiée
     * 
     * @param string $text Le texte à slugifier
     * @param string $separator Le séparateur à utiliser (par défaut: '-')
     * @return string Le texte slugifié
     */
    public function slugify(string $text, string $separator = '-'): string
    {
        // Si un SluggerInterface est disponible (via autowiring), on l'utilise
        // C'est la méthode recommandée car elle gère mieux les caractères accentués
        if ($this->slugger !== null) {
            return $this->slugger->slug($text, $separator)->lower()->toString();
        }

        // Sinon, on utilise directement UnicodeString de Symfony
        // Conversion en ASCII, minuscules, remplacement des espaces et caractères spéciaux
        $slug = (new UnicodeString($text))
            ->ascii()
            ->lower()
            ->replace(' ', $separator)
            ->replaceMatches('/[^a-z0-9' . preg_quote($separator, '/') . ']/', '')
            ->replaceMatches('/' . preg_quote($separator, '/') . '+/', $separator)
            ->trim($separator)
            ->toString();

        return $slug;
    }
}

