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
                        'currency-iso'       => [
                            'title' => 'ISO de la monnaie',
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
            'page-title'              => 'MyFatoorah - Paiement',
            'noPaymentGateways'       => 'Il n\'y a pas de méthodes de paiement disponibles sur votre compte, veuillez contacter votre gestionnaire de compte.',
            'howWouldYouLikeToPay'    => 'Comment souhaitez-vous payer?',
            'or'                      => 'Ou',
            'payWith'                 => 'Payer avec',
            'insertCardDetails'       => 'Insérer les détails de la carte',
            'payNow'                  => 'Payer maintenant',
            'invoice-success'         => 'La facture est payée.',
            'invoice-failed'          => 'La facture n\'a pas été payée en raison de :error',
            'method-unavailable'      => 'Cette méthode de paiement est inactive, veuillez en essayer une autre',
            'invalidWebhookData'      => 'Données Webhook invalides',
            'noWebhookSignature'      => 'Signature Webhook non disponible.',
            'noWebhookSecretKey'      => 'Clé secrète Webhook non disponible.',
            'invalidWebhookSignature' => 'Signature Webhook invalide.',
            'error-occurred'          => 'Une erreur est survenue lors du traitement de votre demande.',
        ],

        'error' => [
            'page-title' => 'Erreur MyFatoorah',
        ],

        'components' => [
            'form' => [
                'holderName'           => 'Nom sur la carte',
                'cardNumber'           => 'Numéro',
                'expiryDate'           => 'MM/AA',
                'securityCode'         => 'CVV',
                'cardHolderNameLabel'  => 'Nom du titulaire de la carte',
                'cardNumberLabel'      => 'Numéro de la carte',
                'expiryDateLabel'      => 'Date d\'expiration',
                'securityCodeLabel'    => 'Code de sécurité',
                'saveCard'             => 'Enregistrer le numéro de carte pour les futurs paiements',
                'addCard'              => 'Utiliser une autre carte',
                'deleteAlert'          => [
                    'title'    => 'Supprimer la carte',
                    'message'  => 'Êtes-vous sûr de vouloir supprimer cette carte?',
                    'confirm'  => 'Oui',
                    'cancel'   => 'Non',
                ],
            ],
        ],
    ],
];
