<?php

namespace Fbeen\SimpleCmsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Yaml\Parser;
use Fbeen\SimpleCmsBundle\Entity\Route;
use Fbeen\SimpleCmsBundle\Entity\Content;
use Fbeen\SimpleCmsBundle\Entity\Menu;
use Fbeen\SimpleCmsBundle\Entity\Menuitem;
use Fbeen\SimpleCmsBundle\Entity\BlockContainer;
use Fbeen\SimpleCmsBundle\Entity\Block;

/**
 * @author Frank Beentjes <frankbeen@gmail.com>
 */
class LoadDemoDataCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->addOption('force', null, InputOption::VALUE_NONE)
            ->setName('fbeen:cms:loaddemodata')
            ->setDescription('Fills the database with demo content')
            ->setHelp(<<<EOT
The <info>fbeen:cms:loaddemodata</info> command loads demo data in the database. ALL EXISTING DATA WILL BE DELETED!:

  <info>php %command.full_name% --force</info>
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if(!$input->getOption('force'))
        {
            $output->writeln('<error>WARNING: All data will be erased! Run the command with the --force option to proceed.</error>');
            return;
        }
        
        $this->eraseTables();
        $this->loadContent();
        $this->loadMenus();
    }

    private function eraseTables()
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        
        $routes = $em->getRepository('FbeenSimpleCmsBundle:Route')->findAll();
        
        if(NULL !== $routes)
        {
            foreach ($routes as $route)
            {
                $em->remove($route);
            }

            $em->flush();
        }
        
        $pages = $em->getRepository('FbeenSimpleCmsBundle:Content')->findAll();
        
        if(NULL !== $pages)
        {
            foreach ($pages as $page)
            {
                $em->remove($page);
            }

            $em->flush();
        }
        
        $menus = $em->getRepository('FbeenSimpleCmsBundle:Menu')->findAll();
        
        if(NULL !== $menus)
        {
            foreach ($menus as $menu)
            {
                $em->remove($menu);
            }

            $em->flush();
        }
    }
    
    private function loadContent()
    {
        $yaml = new Parser();
        $data = $yaml->parse(
            file_get_contents(
                __DIR__.'/../Resources/data/content.yml'
            )
        );
        
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $defaultLocale = $this->getContainer()->getParameter('locale');
                
        foreach ($data['content'] as $content)
        {
            $newContent = new Content();
            
            $newContent->setName($content['name']);
            
            if(is_array($content['title']))
            {
                foreach($content['title'] as $locale => $title)
                {
                    $newContent->setTitle($title, $locale);
                }
            } else {
                $newContent->setTitle($content['title'], $defaultLocale);
            }
            
            if(is_array($content['body']))
            {
                foreach($content['body'] as $locale => $body)
                {
                    $newContent->setBody($body, $locale);
                }
            } else {
                $newContent->setBody($content['body'], $defaultLocale);
            }
            $newContent->mergeNewTranslations();
            
            $newRoute = new Route();
            $newRoute
                ->setName('/cms' . $content['route'])
                ->setPath($content['route'])
                ->setContent($newContent)
            ;
            
            $em->persist($newRoute);
            $em->persist($newContent);
            
            if(isset($content['containers'])) {
                $this->loadBlocks($newContent, $content['containers']);
            }
        }


        $em->flush();
    }
    
    private function loadBlocks(Content $content, $containers)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $defaultLocale = $this->getContainer()->getParameter('locale');

        foreach($containers as $container)
        {
            $newContainer = new BlockContainer();
            
            $newContainer->setName($container['name']);
            $newContainer->setContent($content);
            $em->persist($newContainer);
            
            if(isset($container['blocks']))
            {
                foreach($container['blocks'] as $block)
                {
                    $newBlock = new Block();
                    
                    $newBlock->setIdentifier($block['name']);
                    $newBlock->setType($block['type']);
                    $newBlock->setBlockContainer($newContainer);
                    
                    $em->persist($newBlock);
                }
            }
        }
    }
    
    private function loadMenus()
    {
        $yaml = new Parser();
        $data = $yaml->parse(
            file_get_contents(
                __DIR__.'/../Resources/data/menu.yml'
            )
        );
        
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $defaultLocale = $this->getContainer()->getParameter('locale');
                
        foreach ($data['menu'] as $menu)
        {
            $newMenu = new Menu();
            
            $newMenu->setName($menu['name']);
            if(isset($menu['class'])) $newMenu->setClass($menu['class']);
            
            $em->persist($newMenu);
            
            foreach($menu['menuitems'] as $menuitem)
            {
                $newMenuitem = new Menuitem();
                
                $newMenuitem->setName($menuitem['name']);
                
                if(is_array($menuitem['label']))
                {
                    foreach($menuitem['label'] as $locale => $label)
                    {
                        $newMenuitem->setLabel($label, $locale);
                    }
                } else {
                    $newMenuitem->setLabel($menuitem['label'], $defaultLocale);
                }
                
                if(isset($menuitem['liclass'])) $newMenuitem->setLiClass($menuitem['liclass']);
                if(isset($menuitem['aclass']))  $newMenuitem->setAClass($menuitem['aclass']);
                
                $type = isset($menuitem['type']) ? $menuitem['type'] : 'route';
                $newMenuitem->setType($type);
                
                $value = isset($menuitem['route']) ? $menuitem['route'] : $menuitem['value'];
                $newMenuitem->setValue($value);
                
                $newMenuitem->setMenu($newMenu);
            
                $em->persist($newMenuitem);
            }
        }

        $em->flush();
    }
}
