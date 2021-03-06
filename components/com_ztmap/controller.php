<?php

/**
 * @version       $Id$
 * @copyright     Copyright (C) 2007 - 2009 Joomla! Vargas. All rights reserved.
 * @license       GNU General Public License version 2 or later; see LICENSE.txt
 * @author        Guillermo Vargas (guille@vargas.co.cr)
 * 
 * @name        Zt Map
 * @version     0.0.5
 * @package     Joomla
 * @subpackage  Component
 * @author      ZooTemplate 
 * @email       support@zootemplate.com 
 * @link        http://www.zootemplate.com 
 * @copyright   Copyright (c) 2015 ZooTemplate
 * @license     GPL v2 
 * 
 */
// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * Ztmap Component Controller
 *
 * @package        Ztmap
 * @subpackage     com_ztmap
 * @since          2.0
 */
class ZtmapController extends JControllerLegacy
{

    /**
     * Method to display a view.
     *
     * @param   boolean         If true, the view output will be cached
     * @param   array           An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
     *
     * @return  JController     This object to support chaining.
     * @since   1.5
     */
    public function display($cachable = false, $urlparams = false)
    {
        $cachable = true;

        $id = JRequest::getInt('id');
        $viewName = JRequest::getCmd('view');
        $viewLayout = JRequest::getCmd('layout', 'default');

        $user = JFactory::getUser();

        if ($user->get('id') || !in_array($viewName, array('html', 'xml')) || $viewLayout == 'xsl')
        {
            $cachable = false;
        }

        if ($viewName)
        {
            $document = JFactory::getDocument();
            $viewType = $document->getType();
            $view = $this->getView($viewName, $viewType, '', array('base_path' => $this->basePath, 'layout' => $viewLayout));
            $sitemapmodel = $this->getModel('Sitemap');
            $view->setModel($sitemapmodel, true);
        }

        $safeurlparams = array('id' => 'INT', 'itemid' => 'INT', 'uid' => 'CMD', 'action' => 'CMD', 'property' => 'CMD', 'value' => 'CMD');

        parent::display($cachable, $safeurlparams);

        return $this;
    }

}
