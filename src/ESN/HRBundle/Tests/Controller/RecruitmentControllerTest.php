<?php

namespace ESN\HRBundle\Tests;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class RecruitmentControllerTest extends WebTestCase
{
    public function testRecruitmentCreateFormAction()
    {
        $client = static::createClient();
        $crawler = $client->request(Request::METHOD_GET, '/human-ressources/recruitment/create');
        $this->isSuccessful($client->getResponse());

        $this->assertSame("Formulaire de recrutement", $crawler->filter("div.widget-content h2")->text());
        $this->assertContains(
            "Pour nous envoyer votre candidature, merci de remplir ce formulaire avec un maximum d'information.",
            $crawler->filter("div.widget-content div.alert-info")->text()
        );

        $this->assertCount(15, $crawler->filter("div.widget-content form fieldset div.control-group input"));
        $this->assertCount(21, $formElements = $crawler->filter("div.widget-content form fieldset div.control-group label"));
        $this->assertEquals("Prénom", $formElements->getNode(0)->textContent);
        $this->assertEquals("Nom", $formElements->getNode(1)->textContent);
        $this->assertEquals("Email", $formElements->getNode(2)->textContent);
        $this->assertEquals("Téléphone", $formElements->getNode(3)->textContent);
        $this->assertEquals("Facebook url", $formElements->getNode(4)->textContent);
        $this->assertEquals("Birthday", $formElements->getNode(5)->textContent);
        $this->assertEquals("Nationality", $formElements->getNode(6)->textContent);
        $this->assertEquals("Êtes-vous étudiant ?", $formElements->getNode(7)->textContent);
        $this->assertEquals("Êtes-vous partie en Erasmus ?", $formElements->getNode(8)->textContent);
        $this->assertEquals("Temps disponible ?", $formElements->getNode(9)->textContent);
        $this->assertEquals("Moins de 4 heures", $formElements->getNode(10)->textContent);
        $this->assertEquals("4 heures", $formElements->getNode(11)->textContent);
        $this->assertEquals("6 heures", $formElements->getNode(12)->textContent);
        $this->assertEquals("8 heures", $formElements->getNode(13)->textContent);
        $this->assertEquals("10 heures", $formElements->getNode(14)->textContent);
        $this->assertEquals("12 heures", $formElements->getNode(15)->textContent);
        $this->assertEquals("Plus de 12 heures", $formElements->getNode(16)->textContent);
        $this->assertEquals("Première langue", $formElements->getNode(17)->textContent);
        $this->assertEquals("Motivations ?", $formElements->getNode(18)->textContent);
        $this->assertEquals("Compétences ?", $formElements->getNode(19)->textContent);
        $this->assertEquals("Comment avez-vous connu ESN ?", $formElements->getNode(20)->textContent);
        $this->assertCount(1, $crawler->filter("div.widget-content form fieldset div.form-actions"));
    }
}
