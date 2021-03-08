<?php

declare(strict_types=1);

namespace PackageVersions;

use Composer\InstalledVersions;
use OutOfBoundsException;

class_exists(InstalledVersions::class);

/**
 * This class is generated by composer/package-versions-deprecated, specifically by
 * @see \PackageVersions\Installer
 *
 * This file is overwritten at every run of `composer install` or `composer update`.
 *
 * @deprecated in favor of the Composer\InstalledVersions class provided by Composer 2. Require composer-runtime-api:^2 to ensure it is present.
 */
final class Versions
{
    /**
     * @deprecated please use {@see self::rootPackageName()} instead.
     *             This constant will be removed in version 2.0.0.
     */
    const ROOT_PACKAGE_NAME = 'phpbb/phpbb';

    /**
     * Array of all available composer packages.
     * Dont read this array from your calling code, but use the \PackageVersions\Versions::getVersion() method instead.
     *
     * @var array<string, string>
     * @internal
     */
    const VERSIONS          = array (
  'bantu/ini-get-wrapper' => 'v1.0.1@4770c7feab370c62e23db4f31c112b7c6d90aee2',
  'composer/package-versions-deprecated' => '1.11.99.1@7413f0b55a051e89485c5cb9f765fe24bb02a7b6',
  'google/recaptcha' => '1.2.4@614f25a9038be4f3f2da7cbfd778dc5b357d2419',
  'guzzlehttp/guzzle' => '6.5.5@9d4290de1cfd701f38099ef7e183b64b4b7b0c5e',
  'guzzlehttp/promises' => '1.4.0@60d379c243457e073cff02bc323a2a86cb355631',
  'guzzlehttp/psr7' => '1.7.0@53330f47520498c0ae1f61f7e2c90f55690c06a3',
  'lusitanian/oauth' => 'v0.8.11@fc11a53db4b66da555a6a11fce294f574a8374f9',
  'marc1706/fast-image-size' => 'v1.1.6@3a3a2b036be20f43fa06ce00dfa754df503e6684',
  'ocramius/proxy-manager' => '2.1.1@e18ac876b2e4819c76349de8f78ccc8ef1554cd7',
  'patchwork/utf8' => 'v1.3.3@e1fa4d4a57896d074c9a8d01742b688d5db4e9d5',
  'psr/container' => '1.0.0@b7ce3b176482dbbc1245ebf52b181af44c2cf55f',
  'psr/http-message' => '1.0.1@f6561bf28d520154e4b0ec72be95418abe6d9363',
  'psr/log' => '1.1.3@0f73288fd15629204f9d42b7055f72dacbe811fc',
  'ralouphie/getallheaders' => '3.0.3@120b605dfeb996808c31b6477290a714d356e822',
  's9e/regexp-builder' => '1.4.4@605b33841a766abd40ba3d07c15d0f62b5e7f033',
  's9e/sweetdom' => '2.0.0@5fc62bc1f4756650924e5cd1b429afcf34542722',
  's9e/text-formatter' => '2.8.1@2ac2ab8c28849311424a78ea21a8368423053ce3',
  'symfony/config' => 'v3.4.47@bc6b3fd3930d4b53a60b42fe2ed6fc466b75f03f',
  'symfony/console' => 'v3.4.47@a10b1da6fc93080c180bba7219b5ff5b7518fe81',
  'symfony/debug' => 'v3.4.47@ab42889de57fdfcfcc0759ab102e2fd4ea72dcae',
  'symfony/dependency-injection' => 'v3.4.47@51d2a2708c6ceadad84393f8581df1dcf9e5e84b',
  'symfony/event-dispatcher' => 'v3.4.47@31fde73757b6bad247c54597beef974919ec6860',
  'symfony/filesystem' => 'v3.4.47@e58d7841cddfed6e846829040dca2cca0ebbbbb3',
  'symfony/finder' => 'v3.4.47@b6b6ad3db3edb1b4b1c1896b1975fb684994de6e',
  'symfony/http-foundation' => 'v3.4.47@b9885fcce6fe494201da4f70a9309770e9d13dc8',
  'symfony/http-kernel' => 'v3.4.47@a98a4c30089e6a2d52a9fa236f718159b539f6f5',
  'symfony/polyfill-ctype' => 'v1.22.0@c6c942b1ac76c82448322025e084cadc56048b4e',
  'symfony/polyfill-intl-idn' => 'v1.22.0@0eb8293dbbcd6ef6bf81404c9ce7d95bcdf34f44',
  'symfony/polyfill-intl-normalizer' => 'v1.22.0@6e971c891537eb617a00bb07a43d182a6915faba',
  'symfony/polyfill-mbstring' => 'v1.22.0@f377a3dd1fde44d37b9831d68dc8dea3ffd28e13',
  'symfony/polyfill-php56' => 'v1.20.0@54b8cd7e6c1643d78d011f3be89f3ef1f9f4c675',
  'symfony/polyfill-php70' => 'v1.20.0@5f03a781d984aae42cebd18e7912fa80f02ee644',
  'symfony/polyfill-php72' => 'v1.22.0@cc6e6f9b39fe8075b3dabfbaf5b5f645ae1340c9',
  'symfony/process' => 'v3.4.47@b8648cf1d5af12a44a51d07ef9bf980921f15fca',
  'symfony/proxy-manager-bridge' => 'v3.4.47@25351bb4d5a60cfeddbaf6cf6faebd3a700e2ff4',
  'symfony/routing' => 'v3.4.47@3e522ac69cadffd8131cc2b22157fa7662331a6c',
  'symfony/twig-bridge' => 'v3.4.47@090d19d6f1ea5b9e1d79f372785aa5e5c9cd4042',
  'symfony/yaml' => 'v3.4.47@88289caa3c166321883f67fe5130188ebbb47094',
  'twig/twig' => 'v2.13.1@57e96259776ddcacf1814885fc3950460c8e18ef',
  'zendframework/zend-code' => '3.4.1@268040548f92c2bfcba164421c1add2ba43abaaa',
  'zendframework/zend-eventmanager' => '3.2.1@a5e2583a211f73604691586b8406ff7296a946dd',
  'phpbb/phpbb-core' => '3.3.x-dev@61fa45e5de203f3569c1088d83e0b0d08ae795e5',
  'phpbb/phpbb' => '3.3.x-dev@61fa45e5de203f3569c1088d83e0b0d08ae795e5',
);

    private function __construct()
    {
    }

    /**
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall we know that {@see InstalledVersions} interaction does not
     *                                  cause any side effects here.
     */
    public static function rootPackageName() : string
    {
        if (!class_exists(InstalledVersions::class, false) || !InstalledVersions::getRawData()) {
            return self::ROOT_PACKAGE_NAME;
        }

        return InstalledVersions::getRootPackage()['name'];
    }

    /**
     * @throws OutOfBoundsException If a version cannot be located.
     *
     * @psalm-param key-of<self::VERSIONS> $packageName
     * @psalm-pure
     *
     * @psalm-suppress ImpureMethodCall we know that {@see InstalledVersions} interaction does not
     *                                  cause any side effects here.
     */
    public static function getVersion(string $packageName): string
    {
        if (class_exists(InstalledVersions::class, false) && InstalledVersions::getRawData()) {
            return InstalledVersions::getPrettyVersion($packageName)
                . '@' . InstalledVersions::getReference($packageName);
        }

        if (isset(self::VERSIONS[$packageName])) {
            return self::VERSIONS[$packageName];
        }

        throw new OutOfBoundsException(
            'Required package "' . $packageName . '" is not installed: check your ./vendor/composer/installed.json and/or ./composer.lock files'
        );
    }
}
