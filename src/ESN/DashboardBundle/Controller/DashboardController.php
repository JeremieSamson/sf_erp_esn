<?php

namespace ESN\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\SimpleXMLElement;

class DashboardController extends Controller
{
    /**
     * Affiche la page dashboard
     * @return type
     */
    public function indexAction()
    {
        return $this->render('ESNDashboardBundle::index.html.twig', array(
            'title' => "Dashboard"
        ));
    }
    
    /**
     * Affiche le subnavbar
     * @return type
     */
    public function subnavbarAction()
    {
        return $this->render('ESNDashboardBundle:Dashboard:subnavbar.html.twig');
    }
    
    /**
     *
     * @return type
     */
    public function dashboardAction() {
        return $this->render('ESNDashboardBundle:Dashboard:dashboard.html.twig', array( "dashboard" => $this->getDashboard()));
    }

    private function getDashboard(){
        //Facebook
        $likes         = ($this->getFacebookPageLikes() >= 0) ? $this->getFacebookPageLikes() : 0;
        $group_members = ($this->getFacebookGroupMembers() >= 0) ? $this->getFacebookGroupMembers() : 0;

        //Members
        $em      = $this->getDoctrine()->getManager();
        $esners  = count($em->getRepository('ESNMembersBundle:Member')->findAll());
        $erasmus = count($em->getRepository('ESNMembersBundle:Erasmus')->findAll());

        //Reports
        $reports = $em->getRepository('ESNPermanenceBundle:PermanenceReport')->findBy(array(), null, 5, null);;

        //Events
        $events = $this->getEvents();

        $dashboard = array( "facebook"  => array("likes" => $likes, "group_members" => $group_members),
                            "members"   => array("esners" => $esners, "erasmus" => $erasmus),
                            "reports"   => $reports,
                            "events"    => $events
        );

        return $dashboard;
    }

    /*
     * Get Events from website
     * @param $limit
     * @return events
     */
    private function getEvents($limit = 5){
        $base_url = $this->container->getParameter('section_website');

        $content = file_get_contents($base_url . "/events/feed");
        $x = new SimpleXmlElement($content);

        $cpt = 0;
        foreach($x->channel->item as $entry) {
            if ($cpt < $limit){
                $element = array();

                //Get Image
                $description = $entry->description;
                $firstcut = explode("?itok", $description);
                if (count($firstcut) > 1){
                    $firstpart = $firstcut[0];
                    $url = explode("href=\"", $firstpart);

                    $image = $url[1];
                }

                $date = $entry->pubDate;
                $newDate = date("d-m-Y H:i:s", strtotime($date));
                $element["date"] = $newDate;
                $element["title"] = $entry->title;
                $element["description"] = substr(strip_tags($entry->description),0, 100);
                $element["link"] = $entry->link;
                $element["image"] = $image;
                $rssitem[] = $element;
            }

            $cpt++;
        }

        return $rssitem;
    }

    /*
     * Get Facebook page likes
     * @return likes
     */
    private function getFacebookPageLikes(){
        $pageID = $this->container->getParameter('facebook_page_id');
        $base_url = "http://graph.facebook.com/";
        return $this->getFromJson($base_url . $pageID, "likes");
    }

    /*
     * Get Facebook Group members number
     * @return numbers
     */
    private function getFacebookGroupMembers(){
        return "1501";
    }

    /*
     * @param $url Facebook GRAPH API url
     * @param $key JSON key
     * @return json
     */
    private function getFromJson($url, $key){
        $content = file_get_contents($url);
        $json = json_decode($content, true);
        return $json[$key];
    }
}
