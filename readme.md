CMGbufet
========

Cílem projektu je nahrazení školního bufetu na CMG v Prostějově, který byl zrušen v důsledku "bufetové vyhlášky". Provoz bude probíhat zjednodušeně tak, že si studenti na webu budou moci předobjednávat stravu, kterou budou moci platit buďto později hotově, nebo předem pomocí PayPalu. Následující den ráno jeden z organizátorů projektu časně ráno vstane a všechny předobjednávky nakoupí v některém obchodě, pravděpodobně Billa ve Zlaté bráně na prostějovském náměstí. Následně budou studentům rozeslány notifikace, že jejich strava je připravena k odběru u daného organizátora. O školních přestávkách bude probíhat přeprodej, resp. rozebrání předobjednaných výrobků.

Dílčím cílem je, aby byl systém co nejvíce intuitivní a snadno se studentům používal.

Autoři
------

Autorem je David Indra (https://davidindra.cz) a také Jakub Szymsza (https://szymsza.cz).

Lokální instalace
-----------------

Pro instalaci eshopu na vlastní počítač z důvodu podílení se na vývoji je třeba následující:

- vytvoření a doplnění konfiguračních souborů v `app/config`
- PHP7, MySQL (a její nastavení v `app/config/config.local.neon`)
- `composer install`, `npm install`, `bower install`, `grunt`
- nastavení práv pro zápis `temp/` a `log/`
- vytvoření schématu databáze pomocí Doctrine2

Při vývoji pro kompilaci JS a SASS je třeba spustit `grunt watch`.

Schéma databáze se vytvoří/aktualizuje pomocí `php www/index.php orm:schema-tool:update --force --dump-sql`

Webový server lze spustit přibližně příkazem `php -S localhost:8000 -t www`.

Zda jsou splněny všechny podmínky, které Nette Framework vyžaduje pro svůj běh je možno otestovat pomocí přístupu na adresu `http://localhost:8000/checker`.

Je zahrnut správce databáze Adminer - použít lze skrze tuto adresu `http://localhost:8000/adminer`.

Licence
-------
- CMGbufet: zkrátka opensource (s uvedením autorů), nevyznám se v licencích
- Nette: New BSD License or GPL 2.0 or 3.0
- Adminer: Apache License 2.0 or GPL 2
