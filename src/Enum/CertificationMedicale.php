<?php

declare(strict_types=1);

namespace FFTTApi\Enum;

enum CertificationMedicale: string
{
    case ATTESTATION_AUTO_QUESTIONNAIRE_MAJEUR = 'A';
    case ATTESTATION_AUTO_QUESTIONNAIRE_MINEUR = 'U';
    case SANS_PRATIQUE_SPORTIVE = 'N';
    case STANDARD = 'C';
    case QUADRUPLE = 'Q';
    case AUTRE = '';
}
