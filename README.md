# Simple CMS for Symfony 3

## Installation

Download the necessary bundles with Composer: 
```
$ composer require fbeen/simplecmsbunlde
```
Then add the bundles to the app/config/AppKernel.php file

```
            // ...

            // Sonata
            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
            new Sonata\AdminBundle\SonataAdminBundle(),
            
            // Ivory CKEditor
            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),

            // Knp Menu
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),

            // Doctrine behaviors
            new Knp\DoctrineBehaviors\Bundle\DoctrineBehaviorsBundle,

            // a2lix Translation
            new A2lix\AutoFormBundle\A2lixAutoFormBundle(),
            new A2lix\TranslationFormBundle\A2lixTranslationFormBundle(),

            // Fbeen Simple CMS bundle
            new Fbeen\SimpleCmsBundle\FbeenSimpleCmsBundle(),
            
            new AppBundle\AppBundle(),
```
Required configuration in app/config/config.yml:
```
sonata_block:
    default_contexts: [admin]
    blocks:
        # enable the SonataAdminBundle block
        sonata.admin.block.admin_list: ~
        sonata.block.service.clear_cache: ~

sonata_admin:
    show_mosaic_button: false
    dashboard:
        groups:
            cms:
                label: 'SimpleCMS'
                items:
                    - fbeen_simple_cms.admin.route
                    - fbeen_simple_cms.admin.content
                    - fbeen_simple_cms.admin.menu
                    - fbeen_simple_cms.admin.image
                    - fbeen_simple_cms.admin.simple_block_type
        blocks:
            -
                position: left
                type: sonata.admin.block.admin_list
                settings:
                    groups: [main, docs, users, cms]
            -
                position: left
                type: sonata.block.service.clear_cache

ivory_ck_editor:
    default_config: cmf_content
    configs:
        cmf_content: { toolbar: standard }

a2lix_translation_form:
    locale_provider: default
    locales: [%locale%]
    default_locale: %locale%
    required_locales: [%locale%]
    templating: "FbeenSimpleCmsBundle:Admin:a2lix_tabs.html.twig"
```

Enable translation in app/config/config.yml:
```
framework:
    #esi:             ~
    translator:      { fallbacks: ["%locale%"] }
```
Create the database and update the schema:
```
$ bin/console doctrine:database:create
$ bin/console doctrine:schema:update --force
```
Apply routing in the app/config/routing.yml
```
# Simple CMS
fbeen_simple_cms:
    resource: .
    type: fbeen_simple_cms
    
# Sonata-admin
admin_area:
    resource: "@SonataAdminBundle/Resources/config/routing/sonata_admin.xml"
    prefix: /admin
    
_sonata_admin:
    resource: .
    type: sonata_admin
    prefix: /admin

# Application
app:
    resource: "@AppBundle/Controller/"
    type:     annotation
# ...
```
Install the assets: (don't use the symlink option on windows)
```
$ bin/console assets:install --symlink
```
## Usage

To be continued