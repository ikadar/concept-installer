<?php
/**
 * Created by PhpStorm.
 * User: istvan
 * Date: 2018. 03. 01.
 * Time: 23:48
 */

namespace Ikadar\Installer;


use Composer\Composer;
use Composer\Config;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\Installer\PackageEvent;
use Composer\Installer\PackageEvents;
use Composer\IO\IOInterface;
use Composer\Package\Package;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event;
use Composer\Script\ScriptEvents;
use Composer\Util\Filesystem;
use Symfony\Component\Finder\Finder;
/**
 * The composer ignore plugin.
 *
 * @author lichunqaing<light-li@hotmail.com>
 * @version 1.0.0
 * @license MIT
 */
class Plugin implements PluginInterface, EventSubscriberInterface
{
    /**
     * @var Composer
     */
    protected $composer;
    /**
     * @var Config
     */
    protected $config;
    /**
     * @var Filesystem
     */
    protected $fileSystem;

    /**
     * @inheritdoc
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->config = $composer->getConfig();
        $this->fileSystem = new Filesystem();
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
//            ScriptEvents::POST_AUTOLOAD_DUMP => 'onPostAutoloadDump',
//            ScriptEvents::PRE_UPDATE_CMD => 'onPreUpdate',
            PackageEvents::PRE_PACKAGE_UPDATE => 'onPrePackageUpdate',
            PackageEvents::POST_PACKAGE_UPDATE => 'onPostPackageUpdate',
        ];
    }

    public function onPrePackageUpdate(PackageEvent $event) {
        echo("\nPRE PACKAGE UDATE\n");
        /** @var Package $package */
        $package = $this->composer->getPackage();
        $repositories = $package->getRepositories();
        $extra = $package->getExtra();
        $e = $event->getOperation();
        $p = $e->getTargetPackage();


//        var_dump($package);
//        var_dump($repositories);
//        var_dump($event);
//        var_dump($p);
        var_dump($p->getName());
        $p->setName('ikadar/composertest');
        var_dump($p->getName());
        var_dump($p->getVersion());
        var_dump($extra);
        unset($extra['installer-paths']['./winelogics/']);
        $extra['installer-paths']['./winelogics/2'] = ['ikadar/composertest'];
        $package->setExtra($extra);
        $extra = $package->getExtra();
        var_dump($extra);
        echo("\nPRE PACKAGE UDATE 2\n");
    }
    public function onPostPackageUpdate(PackageEvent $event) {
        echo("\nPOST PACKAGE UDATE\n");
        /** @var Package $package */
        $package = $this->composer->getPackage();
        $repositories = $package->getRepositories();
        $extra = $package->getExtra();
        $e = $event->getOperation();
        $p = $e->getTargetPackage();


//        var_dump($package);
//        var_dump($repositories);
//        var_dump($event);
//        var_dump($p);
        var_dump($p->getName());
        var_dump($p->getVersion());
        var_dump($extra);
        unset($extra['installer-paths']['./winelogics/']);
        $extra['installer-paths']['./winelogics/2'] = ['ikadar/composertest'];
        $package->setExtra($extra);
        $extra = $package->getExtra();
        var_dump($extra);
        echo("\nPOST PACKAGE UDATE 2\n");
    }
    public function onPreUpdate(Event $event) {
        echo("\nPREUDATE\n");
        /** @var Package $package */
        $package = $this->composer->getPackage();
        $repositories = $package->getRepositories();
        $extra = $package->getExtra();

        var_dump($package);
        var_dump($repositories);
        echo("\nPREUDATE2\n");
    }

    /**
     * @param Event $event
     */
    public function onPostAutoloadDump(Event $event)
    {
        echo("\nHELLO\n");
        /** @var Package $package */
        $package = $this->composer->getPackage();
        $extra = $package->getExtra();

        var_dump($package);
        echo("\nHELLO2\n");
//
//        $ignoreList = isset($extra['light-ignore-plugin']) ? $extra['light-ignore-plugin'] : null;
//
//        if (!$ignoreList) {
//            return;
//        }
//
//        $vendor_dir = $this->config->get('vendor-dir');
//
//        foreach ($ignoreList as $vendor => $files) {
//            $root = $this->fileSystem->normalizePath("{$vendor_dir}/{$vendor}");
//            $this->ignorePath($root, $files);
//        }
    }

//    /**
//     * @param string $root
//     * @param array  $files
//     */
//    protected function ignorePath($root, array $files)
//    {
//        foreach ($files as $file) {
//            $_file = $this->fileSystem->normalizePath("{$root}/{$file}");
//            if (is_dir($_file)) {
//                $this->fileSystem->removeDirectory($_file);
//            } else {
//                $finder = Finder::create()->in($root)->ignoreVCS(false)->name($file)->files();
//
//                foreach ($finder as $item) {
//                    $this->fileSystem->remove($item->getRealPath());
//                }
//            }
//        }
//    }
}