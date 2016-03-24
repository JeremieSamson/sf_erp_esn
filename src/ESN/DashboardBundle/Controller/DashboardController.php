<?php

namespace ESN\DashboardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\SimpleXMLElement;
use Symfony\Component\Security\Core\User\User;

class DashboardController extends Controller
{
    /**
     * Affiche la page dashboard
     *
     * @return \Symfony\Component\HttpFoundation\Response
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
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function subnavbarAction()
    {
        return $this->render('ESNDashboardBundle:Dashboard:subnavbar.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboardAction() {
        return $this->render('ESNDashboardBundle:Dashboard:dashboard.html.twig', array("dashboard" => $this->getDashboard()));
    }

    private function getDashboard(){
        //Facebook
        $likes         = $this->fbLikeCount();
        $group_members = $this->fbGroupMemberCount();

        //Members
        $em      = $this->getDoctrine()->getManager();
        $esners  = count($em->getRepository('ESNUserBundle:User')->findBy(array("esner" => 1)));
        $erasmus = count($em->getRepository('ESNUserBundle:User')->findBy(array("esner" => 0)));

        //Reports
        $reports = $em->getRepository('ESNPermanenceBundle:PermanenceReport')->findBy(array(), array("date" => "DESC"), 5, null);;

        //Events
        $events = $this->getEvents();

        return array(
            "facebook"  => array("likes" => $likes, "group_members" => $group_members),
            "members"   => array("esners" => $esners, "erasmus" => $erasmus),
            "reports"   => $reports,
            "events"    => $events
        );
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

    /**
     * Get Events from website
     * @param $limit
     * @return events
     */
    private function getEvents($limit = 5){
        $base_url = $this->container->getParameter('section_website');
        $xmlDoc = new \DOMDocument();
        $items = array();

        try {
            $xmlDoc->load($base_url. "/events/feed");
            $feed   = $xmlDoc->getElementsByTagName('item');

            for ($i = 0; $i < $limit; $i++) {
                if (
                    is_object($feed)
                    && is_object($feed->item($i))
                    && is_object($feed->item($i)->getElementsByTagName('title'))
                    && is_object($feed->item($i)->getElementsByTagName('title')->item(0))
                    && is_object($feed->item($i)->getElementsByTagName('title')->item(0)->childNodes)
                    && is_object($feed->item($i)->getElementsByTagName('link'))
                    && is_object($feed->item($i)->getElementsByTagName('link')->item(0))
                    && is_object($feed->item($i)->getElementsByTagName('link')->item(0)->childNodes)
                    && is_object($feed->item($i)->getElementsByTagName('description'))
                    && is_object($feed->item($i)->getElementsByTagName('description')->item(0))
                    && is_object($feed->item($i)->getElementsByTagName('description')->item(0)->childNodes)
                ) {

                    //Get Image
                    $description = $feed->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;
                    $firstcut = explode("?itok", $description);
                    $image = "";
                    if (count($firstcut) > 1){
                        $firstpart = $firstcut[0];
                        $url = explode("href=\"", $firstpart);
                        $image = $url[1];
                    }

                    if (@file_get_contents($image))
                    {
                        $items[] = array(
                            'title' => $this->cleanDatasForRss($feed->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue),
                            'link'   => $feed->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue,
                            'image'  => $image,
                            'description' => substr(strip_tags($description),0, 250)
                        );
                    }
                }
            }
        } catch (\ErrorException $error) {}

        if (count($items) <= 0) {
            $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('error.rss'));
        }

        return $items;
    }

    /**
     * Get Facebook page likes
     *
     * @return integer
     */
    function fbLikeCount(){
        $id = $this->container->getParameter('fb_page_id');
        $appid = $this->container->getParameter('fb_appid');
        $appsecret = $this->container->getParameter('fb_secret');

        //Construct a Facebook URL
        $json_url ='https://graph.facebook.com/'.$id.'?access_token='.$appid.'|'.$appsecret;
        $json = @file_get_contents($json_url);

        if ($json != false) {
            $json_output = json_decode($json);

            if($json_output->likes){
                return $likes = $json_output->likes;
            }
        }

        return 0;
    }

    /**
     * Get Facebook Group members number
     * @return integer
     */
    private function fbGroupMemberCount(){
        $appid = $this->container->getParameter('fb_appid');
        $appsecret = $this->container->getParameter('fb_secret');
        $group_id = $this->container->getParameter('fb_group_id');

        //Construct a Facebook URL
        $json_url ='https://graph.facebook.com/'.$group_id.'/members?access_token='.$appid.'|'.$appsecret;
        $json = @file_get_contents($json_url);

        $total_members = 0;

        if ($json != false) {
            $json_output = json_decode($json);

            while (!empty($json_output->next)){
                $total_members += count($json['data']);
                $content=$this->get_fcontent($json['paging']['next']);
                $json=json_decode($content[0],true);
            }
        }

        return $total_members;
    }

    /**
     * Clean title for RSS export
     *
     * @author Vincent Chalamon <vincent@ylly.fr>
     *
     * @param string $value Item title
     *
     * @return string
     */
    protected function cleanDatasForRss($value)
    {
        $value = strip_tags(str_ireplace(array('</p>', '</div>', '</td>'), array('<br />', '<br />', '<br />'), $value), '<br />');
        if (strlen($value) > 255) {
            if (false !== ($breakpoint = strpos($value, ' ', 255))) {
                $length = $breakpoint;
            }
            $value = substr($value, 0, $length).'...';

            return $value;
        }

        return $value;
    }
}
