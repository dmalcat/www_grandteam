// obtain cookieconsent plugin
var cc = initCookieConsent();

// run plugin with config object
cc.run({
    current_lang: document.documentElement.getAttribute('lang'),
    autoclear_cookies: false,                   // default: false
    //theme_css: '../assets/cookie-consent/css/cookieconsent.css',
    cookie_name: 'cookie_consent',              // default: 'cc_cookie'
    cookie_expiration: 365,                     // default: 182
    page_scripts: true,                         // default: false
    force_consent: false,                       // default: false

    // auto_language: null,                     // default: null; could also be 'browser' or 'document'
    // autorun: true,                           // default: true
    // delay: 0,                                // default: 0
    // hide_from_bots: false,                   // default: false
    // remove_cookie_tables: false              // default: false
    // cookie_domain: location.hostname,        // default: current domain
    // cookie_path: '/',                        // default: root
    // cookie_same_site: 'Lax',
    // use_rfc_cookie: false,                   // default: false
    // revision: 0,                             // default: 0

    gui_options: {
        consent_modal: {
            layout: 'cloud',                    // box,cloud,bar
            position: 'bottom center',          // bottom,middle,top + left,right,center
            transition: 'slide'                 // zoom,slide
        },
        settings_modal: {
            layout: 'box',                      // box,bar
            position: 'center',                   // right,left (available only if bar layout selected)
            transition: 'slide'                 // zoom,slide
        }
    },

    onAccept: function (cookie) {
    },

    onChange: function (cookie, changed_preferences) {
        // If analytics category's status was changed ...
        if (changed_preferences.indexOf('analytics') > -1) {

            // If analytics category is disabled ...
            if (!cc.allowedCategory('analytics')) {

                // Disable gtag ...
                window.dataLayer = window.dataLayer || [];

                function gtag() {
                    dataLayer.push(arguments);
                }

                gtag('consent', 'default', {
                    'ad_storage': 'denied',
                    'analytics_storage': 'denied'
                });
            }
        }
    },

    languages: {
        'cs': {
            consent_modal: {
                title: 'Grand Asset Management používá cookies.',
                description: 'Jsou to malé soubory, díky kterým vám web nabídne jen takový obsah, který očekáváte, nebude vás obtěžovat věcmi, které vás nezajímají a vy tak najdete to, co hledáte. Aby to tak opravdu bylo, potřebujeme od vás souhlas s ukládáním cookies do vašeho prohlížeče.',
                primary_btn: {
                    text: 'OK, souhlasím',
                    role: 'accept_all'      //'accept_selected' or 'accept_all'
                },
                secondary_btn: {
                    text: 'Nastavení',
                    role: 'settings'       //'settings' or 'accept_necessary'
                },
                revision_message: '<br><br> Vážený uživateli, smluvní podmínky se od vaší poslední návštěvy změnily!'
            },
            settings_modal: {
                title: 'Nastavení cookies',
                save_settings_btn: 'Přijmout vybrané',
                accept_all_btn: 'Přijmout vše',
                reject_all_btn: 'Odmítnout vše',
                close_btn_label: 'Zavřít',
                blocks: [
                    {
                        title: 'K čemu jsou dobré cookies?',
                        description: 'Cookies jsou malé textové soubory, které mohou být používány webovými stránkami pro efektivnější zobrazování toho, co vás zajímá. <br><br> Některé cookies jsou používány samotnou webovou stránkou, jiné jsou umístěny třetími stranami, jejichž služby se na webu mohou objevovat. <br><br> Nově zákon nařizuje, abychom pro použití webu od od každého návštěvníka získali souhlas s používání cookies v těchto kategoriích:'
                    }, {
                        title: 'Nezbytné soubory cookie',
                        description: 'Tyto soubory neukládají žádné osobní identifikovatelné informace, web je ale ke svému fungování potřebuje. Nelze je vypnout.',
                        toggle: {
                            value: 'necessary',
                            enabled: true,
                            readonly: true  //cookie categories with readonly=true are all treated as "necessary cookies"
                        }
                    }, {
                        title: 'Statistické soubory cookies',
                        description: 'Pro zlepšování výkonu stránky, sledování zdrojů a počtu návštěvníků webu využíváme anonymizované souhrnné statistické cookie.',
                        toggle: {
                            value: 'analytics',
                            enabled: false,
                            readonly: false
                        },
                    }, {
                        title: 'Marketingové soubory cookies',
                        description: 'Kvůli přizpůsobení povahy zobrazovaných reklam a naopak zabránění zobrazování obsahu, který pro vás není relevantní a nemusel by vás zajímat, potřebujeme souhlas s marketingovými cookies. ',
                        toggle: {
                            value: 'targeting',
                            enabled: false,
                            readonly: false,
                            reload: 'on_disable'            // New option in v2.4, check readme.md
                        },
                    }
                ]
            }
        },
        'en': {
            consent_modal: {
                title: 'Grand Asset Management uses cookies.',
                description: 'They are small files that allow the site to offer you only the content you expect, not bother you with things that don\'t interest you, so you can find what you\'re looking for. For this to be true, we need your consent to store cookies in your browser.',
                primary_btn: {
                    text: 'OK, I agree',
                    role: 'accept_all'      //'accept_selected' or 'accept_all'
                },
                secondary_btn: {
                    text: 'Settings',
                    role: 'settings'       //'settings' or 'accept_necessary'
                },
                revision_message: '<br><br> Vážený uživateli, smluvní podmínky se od vaší poslední návštěvy změnily!'
            },
            settings_modal: {
                title: 'Cookie settings',
                save_settings_btn: 'Accept selected',
                accept_all_btn: 'Accept all',
                reject_all_btn: 'Reject all',
                close_btn_label: 'Zavřít',
                blocks: [
                    {
                        title: 'What are cookies good for?',
                        description: 'Cookies are small text files that can be used by websites to more effectively display what you are interested in. <br><br> Some cookies are used by the website itself, others are placed by third parties whose services may appear on the website. <br><br> The new law mandates that in order to use the site, we must obtain consent from each visitor to use cookies in these categories:'
                    }, {
                        title: 'Necessary cookies',
                        description: 'These cookies do not store any personally identifiable information, but the website needs them to function. They cannot be disabled.',
                        toggle: {
                            value: 'necessary',
                            enabled: true,
                            readonly: true  //cookie categories with readonly=true are all treated as "necessary cookies"
                        }
                    }, {
                        title: 'Statistical cookies',
                        description: 'We use anonymised aggregate statistical cookies to improve site performance, track resources and visitor numbers.',
                        toggle: {
                            value: 'analytics',
                            enabled: false,
                            readonly: false
                        },
                    }, {
                        title: 'Marketing cookies',
                        description: 'In order to tailor the nature of the advertisements you see and, conversely, to prevent the display of content that is not relevant to you and may not be of interest to you, we need consent to marketing cookies.',
                        toggle: {
                            value: 'targeting',
                            enabled: false,
                            readonly: false,
                            reload: 'on_disable'            // New option in v2.4, check readme.md
                        },
                    }
                ]
            }
        },
        'de': {
            consent_modal: {
                title: 'Golf Resort verwendet Cookies.',
                description: 'Das sind kleine Dateien, die es der Website ermöglichen, Ihnen nur die Inhalte anzubieten, die Sie erwarten, und Sie nicht mit Dingen zu belästigen, die Sie nicht interessieren, damit Sie finden können, was Sie suchen. Damit dies möglich ist, benötigen wir Ihre Zustimmung zur Speicherung von Cookies in Ihrem Browser.',
                primary_btn: {
                    text: 'OK, ich stimme zu',
                    role: 'accept_all'      //'accept_selected' or 'accept_all'
                },
                secondary_btn: {
                    text: 'Einstellungen',
                    role: 'settings'       //'settings' or 'accept_necessary'
                },
                revision_message: '<br><br> Vážený uživateli, smluvní podmínky se od vaší poslední návštěvy změnily!'
            },
            settings_modal: {
                title: 'Einstellungen für Cookies',
                save_settings_btn: 'Ausgewählte akzeptieren',
                accept_all_btn: 'Alle akzeptieren',
                reject_all_btn: 'Alle ablehnen',
                close_btn_label: 'Zavřít',
                blocks: [
                    {
                        title: 'Wozu sind Cookies gut?',
                        description: 'Cookies sind kleine Textdateien, die von Websites verwendet werden können, um Ihnen die für Sie interessanten Inhalte besser anzeigen zu können. <br><br> Einige Cookies werden von der Website selbst verwendet, andere werden von Dritten gesetzt, deren Dienste auf der Website erscheinen können. <br><br> Das neue Gesetz schreibt vor, dass wir für die Nutzung der Website von jedem Besucher die Zustimmung zur Verwendung von Cookies in diesen Kategorien einholen müssen:'
                    }, {
                        title: 'Erforderliche Cookies',
                        description: 'Diese Cookies speichern keine persönlich identifizierbaren Informationen, aber die Website benötigt sie, um zu funktionieren. Sie können nicht deaktiviert werden.',
                        toggle: {
                            value: 'necessary',
                            enabled: true,
                            readonly: true  //cookie categories with readonly=true are all treated as "necessary cookies"
                        }
                    }, {
                        title: 'Statistische Cookies',
                        description: 'Wir verwenden anonymisierte, aggregierte statistische Cookies, um die Leistung der Website zu verbessern, Ressourcen und Besucherzahlen zu verfolgen.',
                        toggle: {
                            value: 'analytics',
                            enabled: false,
                            readonly: false
                        },
                    }, {
                        title: 'Marketing-Cookies',
                        description: 'Um die Art der Werbung, die Sie sehen, auf Sie abzustimmen und umgekehrt die Anzeige von Inhalten zu verhindern, die für Sie nicht relevant sind und Sie möglicherweise nicht interessieren, benötigen wir die Zustimmung zu Marketing-Cookies.',
                        toggle: {
                            value: 'targeting',
                            enabled: false,
                            readonly: false,
                            reload: 'on_disable'            // New option in v2.4, check readme.md
                        },
                    }
                ]
            }
        }
    }
});