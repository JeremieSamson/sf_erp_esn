<?php

namespace ESN\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\SimpleXMLElement;
use Symfony\Component\Security\Core\User\User;

class DashboardController extends Controller
{
    /**
     * Affiche la page dashboard
     * @return type
     */
    public function indexAction()
    {
        $dashboard = $this->getDashboard();

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
        return $this->render('ESNDashboardBundle:Dashboard:dashboard.html.twig', array("dashboard" => $this->getDashboard()));
    }

    private function getDashboard(){
        //Facebook
        //$likes         = ($this->getFacebookPageLikes() >= 0) ? $this->getFacebookPageLikes() : 0;
        //$group_members = ($this->getFacebookGroupMembers() >= 0) ? $this->getFacebookGroupMembers() : 0;

        //Members
        $em      = $this->getDoctrine()->getManager();
        $esners  = count($em->getRepository('ESNUserBundle:User')->findBy(array("esner" => 1)));
        $erasmus = count($em->getRepository('ESNUserBundle:User')->findBy(array("esner" => 0)));

        //Reports
        $reports = $em->getRepository('ESNPermanenceBundle:PermanenceReport')->findBy(array(), null, 5, null);;

        //Events
        $events = $this->getEvents();

        $dashboard = array( "facebook"  => array("likes" => 0, "group_members" => 0),
                            "members"   => array("esners" => $esners, "erasmus" => $erasmus),
                            "reports"   => $reports,
                            "events"    => $events
        );

        return $dashboard;
    }

    /**
     * @param     $url
     * @param int $javascript_loop
     * @param int $timeout
     *
     * @return array
     */
    function get_fcontent( $url,  $javascript_loop = 0, $timeout = 5 ) {
        $url = str_replace( "&amp;", "&", urldecode(trim($url)) );

        $cookie = tempnam ("/tmp", "CURLCOOKIE");
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_COOKIEJAR, $cookie );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt( $ch, CURLOPT_ENCODING, "" );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );    # required for https urls
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
        curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
        curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
        $content = curl_exec( $ch );
        $response = curl_getinfo( $ch );
        curl_close ( $ch );

        if ($response['http_code'] == 301 || $response['http_code'] == 302) {
            ini_set("user_agent", "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1");

            if ( $headers = get_headers($response['url']) ) {
                foreach( $headers as $value ) {
                    if ( substr( strtolower($value), 0, 9 ) == "location:" )
                        return get_url( trim( substr( $value, 9, strlen($value) ) ) );
                }
            }
        }

        if (    ( preg_match("/>[[:space:]]+window\.location\.replace\('(.*)'\)/i", $content, $value) || preg_match("/>[[:space:]]+window\.location\=\"(.*)\"/i", $content, $value) ) && $javascript_loop < 5) {
            return get_url( $value[1], $javascript_loop+1 );
        } else {
            return array( $content, $response );
        }
    }

    /*
     * Get Events from website
     * @param $limit
     * @return events
     */
    private function getEvents($limit = 5){
        $base_url = $this->container->getParameter('section_website');

        $content = $this->get_fcontent($base_url . "/events/feed/");
        $rssitem = null;

        $x = new SimpleXmlElement($content[0]);

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
        $base_url = "https://graph.facebook.com/";
        $access_token = "CAACEdEose0cBAPjsvVz4m7woCUaePQczZCswNhIC4yHGUZCnMG6Pxu9ZAcPHnVQHPEx2WnntUPxqlgFfGHhKFQMBPY7keej5bVHcARbsY8KIXrSM7cJstbZA4NROLNDjcQ1A0ceombbSEJRDklYssZBw7MERMYhGpPBMxFD93fBxcDqZA92KBEAI60eKl8SSBzW1ZCpCRoetRVMAz8KVCu9";
        $url = $base_url . $pageID . '?access_token=' . $access_token;
        return $this->getFromJson($url, "likes");
    }

    /*
     * Get Facebook Group members number
     * @return numbers
     */
    private function getFacebookGroupMembers(){
        $group_id = $this->container->getParameter('facebook_group_id');

        $access_token = "CAACEdEose0cBAPjsvVz4m7woCUaePQczZCswNhIC4yHGUZCnMG6Pxu9ZAcPHnVQHPEx2WnntUPxqlgFfGHhKFQMBPY7keej5bVHcARbsY8KIXrSM7cJstbZA4NROLNDjcQ1A0ceombbSEJRDklYssZBw7MERMYhGpPBMxFD93fBxcDqZA92KBEAI60eKl8SSBzW1ZCpCRoetRVMAz8KVCu9";
        $base_url = "https://graph.facebook.com/";
        $url = $base_url . $group_id . '/members?access_token=' . $access_token;

        $total_members = 0;
        $content = $this->get_fcontent($url);
        $json = json_decode($content[0],true);
        while (!empty($json['paging']['next'])){
            $total_members += count($json['data']);
            $content=$this->get_fcontent($json['paging']['next']);
            $json=json_decode($content[0],true);
        }
        return $total_members;
    }

    /*
     * @param $url Facebook GRAPH API url
     * @param $key JSON key
     * @return json
     */
    private function getFromJson($url, $key){
        $content = $this->get_fcontent($url);
        $json = json_decode($content[0], true);

        return (array_key_exists($key, $json)) ? $json[$key] : null;
    }
}
