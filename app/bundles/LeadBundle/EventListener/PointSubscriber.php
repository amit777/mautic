<?php
/**
 * @package     Mautic
 * @copyright   2014 Mautic Contributors. All rights reserved.
 * @author      Mautic
 * @link        http://mautic.org
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Mautic\LeadBundle\EventListener;

use Mautic\CoreBundle\EventListener\CommonSubscriber;
use Mautic\PointBundle\Event\TriggerBuilderEvent;
use Mautic\PointBundle\PointEvents;

/**
 * Class PointSubscriber
 */
class PointSubscriber extends CommonSubscriber
{

    /**
     * {@inheritdoc}
     */
    static public function getSubscribedEvents()
    {
        return array(
            PointEvents::TRIGGER_ON_BUILD   => array('onTriggerBuild', 0)
        );
    }

    /**
     * @param TriggerBuilderEvent $event
     */
    public function onTriggerBuild(TriggerBuilderEvent $event)
    {
        $changeLists = array(
            'group'       => 'mautic.lead.point.trigger',
            'label'       => 'mautic.lead.point.trigger.changelists',
            'callback'    => array('\\Mautic\\LeadBundle\\Helper\\PointEventHelper', 'changeLists'),
            'formType'    => 'leadlist_action'
        );

        $event->addEvent('lead.changelists', $changeLists);

        // modify tags
        $action = array(
            'group'       => 'mautic.lead.point.trigger',
            'label'       => 'mautic.lead.lead.events.changetags',
            'formType'    => 'modify_lead_tags',
            'callback'    => '\Mautic\LeadBundle\Helper\EventHelper::updateTags'
        );
        $event->addEvent('lead.changetags', $action);
    }

}
