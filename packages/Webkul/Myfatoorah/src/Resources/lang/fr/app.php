<?php

return [
    'admin' => [
        'configurations' => [
            'index' => [
                'sales' => [
                    'payment-methods' => [
                        'title' => 'MyFatoorah',
                        'description-title' => 'Description',
                        'logo' => 'Logo',
                        'description' => 'Module de paiement sécurisé avec support des méthodes de paiement, stockage des données de carte, capacités de remboursement et intégration de Webhook pour les mises à jour de statut en temps réel',
                        'api-key' => 'Clé API',
                        'test-mode' => 'Mode de test',
                        'country-iso' => [
                            'title' => 'ISO du pays',
                            'kwt' => 'Koweït',
                            'sau' => 'Arabie Saoudite',
                            'qat' => 'Qatar',
                            'bhr' => 'Bahreïn',
                            'omn' => 'Oman',
                            'jod' => 'Jordanie',
                            'egy' => 'Égypte',
                            'are' => 'Émirats Arabes Unis',
                        ],
                        'is-webhook-enabled' => 'Activer Webhook',
                        'webhook-secret-key' => 'Clé secrète Webhook',
                        'status' => 'Statut',
                    ],
                ],
            ],
        ],

        'refund-failed' => 'MyFatoorah n\'a pas pu rembourser :amount : :message',
    ],

    'shop' => [
        'checkout' => [
            'page-title' => 'MyFatoorah - Paiement',
            'error-title' => 'Erreur de Paiement',
            'back-to-cart' => 'Retour au Panier',
        ],
    ],

    'response' => [
        'provide-credentials' => 'Veuillez d\'abord configurer votre clé API MyFatoorah.',
        'cart-not-found' => 'Votre panier n\'a pas pu être trouvé.',
        'payment-failed' => 'Le paiement n\'a pas pu être finalisé. Veuillez réessayer.',
        'payment-success' => 'Votre paiement a été effectué avec succès !',
    ],
];
