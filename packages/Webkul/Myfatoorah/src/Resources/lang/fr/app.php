<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title'              => 'MyFatoorah',
                        'description-title'  => 'Description',
                        'logo'               => 'Logo',
                        'description'        => 'Module de paiement sécurisé avec support des méthodes de paiement, stockage des données de carte, capacités de remboursement et intégration de Webhook pour les mises à jour de statut en temps réel',
                        'api-key'            => 'Clé API',
                        'test-mode'          => 'Mode de test',
                        'country-iso'        => [
                            'title' => 'ISO du pays',
                            'kwt'   => 'Koweït',
                            'sau'   => 'Arabie Saoudite',
                            'qat'   => 'Qatar',
                            'bhr'   => 'Bahreïn',
                            'omn'   => 'Oman',
                            'jod'   => 'Jordanie',
                            'egy'   => 'Égypte',
                            'are'   => 'Émirats Arabes Unis',
                        ],
                        'is-webhook-enabled' => 'Activer Webhook',
                        'save-card'          => 'Enregistrer la carte',
                        'webhook-secret-key' => 'Clé secrète Webhook',
                        'register-apple-pay' => 'Enregistrer Apple Pay',
                        'status'             => 'Statut',
                    ],
                ],
            ],
        ],
    ],

    'shop' => [
        'checkout' => [
            'page-title'                => 'MyFatoorah - Paiement',
            'no-payment-gateways'       => 'Il n\'y a pas de méthodes de paiement disponibles sur votre compte, veuillez contacter votre gestionnaire de compte.',
            'how-would-you-like-to-pay' => 'Comment souhaitez-vous payer?',
            'or'                        => 'Ou',
            'pay-with'                  => 'Payer avec',
            'insert-card-details'       => 'Insérer les détails de la carte',
            'pay-now'                   => 'Payer maintenant',
            'invoice-success'           => 'La facture est payée.',
            'invoice-failed'            => 'La facture n\'a pas été payée en raison de :error',
            'method-unavailable'        => 'Cette méthode de paiement est inactive, veuillez en essayer une autre',
            'invalid-webhook-data'      => 'Données Webhook invalides',
            'no-webhook-signature'      => 'Signature Webhook non disponible.',
            'no-webhook-secretKey'      => 'Clé secrète Webhook non disponible.',
            'invalid-webhook-signature' => 'Signature Webhook invalide.',
            'error-occurred'            => 'Une erreur est survenue lors du traitement de votre demande.',
        ],

        'error' => [
            'page-title' => 'Erreur MyFatoorah',
        ],

        'components' => [
            'form' => [
                'holder-name'             => 'Nom sur la carte',
                'card-number'             => 'Numéro',
                'expiry-date'             => 'MM/AA',
                'security-code'           => 'CVV',
                'card-holder-name-label'  => 'Nom du titulaire de la carte',
                'card-number-label'       => 'Numéro de la carte',
                'expiry-date-label'       => 'Date d\'expiration',
                'security-code-label'     => 'Code de sécurité',
                'save-card'               => 'Enregistrer le numéro de carte pour les futurs paiements',
                'add-card'                => 'Utiliser une autre carte',
                'deleteAlert'             => [
                    'title'    => 'Supprimer la carte',
                    'message'  => 'Êtes-vous sûr de vouloir supprimer cette carte?',
                    'confirm'  => 'Oui',
                    'cancel'   => 'Non',
                ],
            ],
        ],
    ],
];
